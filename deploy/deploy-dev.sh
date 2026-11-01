#!/usr/bin/env bash
# Deploys the 3alemny_web repo as a demo site at https://3alemny.net/dev.
#
# Run as root on the server:   bash /root/deploy-dev.sh
# Re-running it updates the code and upgrades the demo database; it only re-copies the
# live database when you run it with RESET_DB=1.
#
# It never changes the live site's code, config.php, database or moodledata.
set -euo pipefail

REPO_URL="https://github.com/NITGg/3alemny_web.git"
BRANCH="main"
SRC_DIR="/var/www/3alemny-dev-src"                       # git checkout, outside the web root
LIVE_WEB="/var/www/html/3alemny.net/public_html"
WEB_DIR="$LIVE_WEB/dev"
DATA_DIR="/var/www/moodledata-3alemny-dev"               # outside the web root
DEV_URL="https://3alemny.net/dev"
LIVE_DB="3alemny"
DEV_DB="3alemny_dev"
DEV_DB_USER="3alemny_dev"
DB_PASS_FILE="/root/.3alemny-dev-db-pass"
SECRETS_UPLOAD="/root/local_secrets.php"                  # uploaded from your PC with scp
WEB_USER="www-data"
RESET_DB="${RESET_DB:-0}"

step() { echo; echo "==> $*"; }
die() { echo; echo "ERROR: $*" >&2; exit 1; }

[ "$(id -u)" = 0 ] || die "Run this script as root."

step "1/8 Checking server requirements"
for cmd in php git rsync mysql mysqldump; do
    command -v "$cmd" >/dev/null || die "'$cmd' is not installed (apt install $cmd)."
done

PHPV=$(php -r 'echo PHP_MAJOR_VERSION . "." . PHP_MINOR_VERSION;')
PHPFULL=$(php -r 'echo PHP_VERSION;')
echo "PHP (command line): $PHPFULL"
case "$PHPV" in
    8.1|8.2|8.3) ;;
    *) die "Moodle 4.5 needs PHP 8.1, 8.2 or 8.3 (found $PHPFULL)." ;;
esac
echo "PHP used by Apache: $(ls /etc/apache2/mods-enabled/ 2>/dev/null | grep -oE '^php[0-9.]+' | sort -u | tr '\n' ' ')$(ls /run/php/ 2>/dev/null | grep -oE 'php[0-9.]+-fpm' | sort -u | tr '\n' ' ')"
echo "Installed PHP packages:"
{ dpkg -l "php$PHPV-cli" "php$PHPV-fpm" "libapache2-mod-php$PHPV" 2>/dev/null || true; } | awk '/^ii/ {print "  " $2, $3}'

missing=""
phpmods=$(php -m)
for ext in sodium intl zip gd mbstring xml curl soap mysqli exif; do
    grep -qix "$ext" <<< "$phpmods" || missing="$missing $ext"
done
[ -z "$missing" ] || die "Missing PHP extensions:$missing  (install with: apt install$(for e in $missing; do printf ' php%s-%s' "$PHPV" "$e"; done))"

miv=$(php -r 'echo ini_get("max_input_vars");')
[ "$miv" -ge 5000 ] || die "max_input_vars is $miv; Moodle 4.5 needs 5000 or more (set it in /etc/php/$PHPV/cli/php.ini and the Apache/FPM php.ini)."
for ini in /etc/php/$PHPV/apache2/php.ini /etc/php/$PHPV/fpm/php.ini; do
    [ -f "$ini" ] && echo "max_input_vars in $ini: $(grep -E '^\s*max_input_vars' "$ini" | tail -1 || echo 'not set (default 1000)')"
done

dbver=$(mysql -N -e "SELECT VERSION();")
echo "Database: $dbver"
dbnum=$(grep -oE '^[0-9]+\.[0-9]+\.[0-9]+' <<< "$dbver")
[ "$(printf '%s\n' 10.6.7 "$dbnum" | sort -V | head -1)" = 10.6.7 ] || die "Moodle 4.5 needs MariaDB 10.6.7 or newer."

if [ -d "$WEB_DIR" ] && [ -n "$(ls -A "$WEB_DIR")" ] && [ ! -f "$WEB_DIR/.3alemny-dev" ]; then
    die "$WEB_DIR already exists and was not created by this script. Move it away first."
fi

step "2/8 Getting the code from GitHub"
if [ -d "$SRC_DIR/.git" ]; then
    git -C "$SRC_DIR" fetch --quiet origin "$BRANCH"
    git -C "$SRC_DIR" reset --quiet --hard "origin/$BRANCH"
else
    git clone --quiet --branch "$BRANCH" "$REPO_URL" "$SRC_DIR"
fi
echo "Commit: $(git -C "$SRC_DIR" log -1 --format='%h %s')"

step "3/8 Copying the code to $WEB_DIR"
mkdir -p "$WEB_DIR"
rsync -a --delete \
    --exclude=/config.php --exclude=/local_secrets.php --exclude=/.3alemny-dev \
    "$SRC_DIR/moodle/" "$WEB_DIR/"
touch "$WEB_DIR/.3alemny-dev"
chown -R root:"$WEB_USER" "$WEB_DIR"
find "$WEB_DIR" -type d -exec chmod 755 {} + && find "$WEB_DIR" -type f -exec chmod 644 {} +

step "4/8 Secrets for the custom scripts"
if [ -f "$SECRETS_UPLOAD" ]; then
    cp "$SECRETS_UPLOAD" "$WEB_DIR/local_secrets.php"
    # The demo must never send real e-mails: blank the SMTP login used by login/forgot_password.php.
    php -r '$f = $argv[1]; $s = require $f; $s["brevo_smtp_username"] = ""; $s["brevo_smtp_password"] = "";
            file_put_contents($f, "<?php\nreturn " . var_export($s, true) . ";\n");' "$WEB_DIR/local_secrets.php"
    echo "Copied from $SECRETS_UPLOAD (SMTP login removed for the demo)."
elif [ ! -f "$WEB_DIR/local_secrets.php" ]; then
    cp "$WEB_DIR/local_secrets.example.php" "$WEB_DIR/local_secrets.php"
    echo "WARNING: $SECRETS_UPLOAD not found, created empty secrets. Payment and the old custom pages won't work."
fi
chown root:"$WEB_USER" "$WEB_DIR/local_secrets.php" && chmod 640 "$WEB_DIR/local_secrets.php"
echo "The Firebase key is not copied, so the demo cannot send push notifications."

step "5/8 Demo database ($DEV_DB)"
if [ ! -f "$DB_PASS_FILE" ]; then
    (umask 077; openssl rand -hex 16 > "$DB_PASS_FILE")
fi
DEV_DB_PASS=$(cat "$DB_PASS_FILE")
dbexists=$(mysql -N -e "SELECT COUNT(*) FROM information_schema.schemata WHERE schema_name='$DEV_DB';")
if [ "$dbexists" = 0 ] || [ "$RESET_DB" = 1 ]; then
    echo "Copying the live database '$LIVE_DB' into '$DEV_DB' (the live database is only read)..."
    mysql -e "DROP DATABASE IF EXISTS \`$DEV_DB\`; CREATE DATABASE \`$DEV_DB\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
    mysqldump --single-transaction --quick "$LIVE_DB" | mysql "$DEV_DB"
    # Stop the demo copy from e-mailing or pushing notifications to real users.
    mysql "$DEV_DB" -e "UPDATE mo_message_processors SET enabled = 0 WHERE name IN ('email', 'airnotifier');"
    rm -rf "$DATA_DIR"
else
    echo "Already exists, keeping it (run with RESET_DB=1 to copy the live database again)."
fi
mysql -e "CREATE USER IF NOT EXISTS '$DEV_DB_USER'@'localhost' IDENTIFIED BY '$DEV_DB_PASS';
          ALTER USER '$DEV_DB_USER'@'localhost' IDENTIFIED BY '$DEV_DB_PASS';
          GRANT ALL PRIVILEGES ON \`$DEV_DB\`.* TO '$DEV_DB_USER'@'localhost'; FLUSH PRIVILEGES;"

step "6/8 Demo moodledata ($DATA_DIR)"
mkdir -p "$DATA_DIR"
chown -R "$WEB_USER":"$WEB_USER" "$DATA_DIR"
chmod 2770 "$DATA_DIR"
echo "Empty data folder: uploaded files and images from the live site will show as missing."

step "7/8 Demo config.php"
cat > "$WEB_DIR/config.php" <<PHP
<?php  // Moodle configuration file for the /dev demo (written by deploy-dev.sh).

unset(\$CFG);
global \$CFG;
\$CFG = new stdClass();

\$CFG->dbtype    = 'mariadb';
\$CFG->dblibrary = 'native';
\$CFG->dbhost    = 'localhost';
\$CFG->dbname    = '$DEV_DB';
\$CFG->dbuser    = '$DEV_DB_USER';
\$CFG->dbpass    = '$DEV_DB_PASS';
\$CFG->prefix    = 'mo_';
\$CFG->dboptions = [
    'dbpersist' => 0,
    'dbport' => 3306,
    'dbsocket' => '',
    'dbcollation' => 'utf8mb4_unicode_ci',
];

\$CFG->wwwroot   = '$DEV_URL';
\$CFG->dataroot  = '$DATA_DIR';
\$CFG->admin     = 'admin';

\$CFG->directorypermissions = 02777;

// The demo holds a copy of real users: never e-mail them.
\$CFG->noemailever = true;

// Keep the demo login separate from the live site on the same domain.
\$CFG->sessioncookie     = 'dev';
\$CFG->sessioncookiepath = '/dev/';

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
PHP
chown root:"$WEB_USER" "$WEB_DIR/config.php" && chmod 640 "$WEB_DIR/config.php"

step "8/8 Upgrading the demo database to Moodle 4.5"
cd "$WEB_DIR"
sudo -u "$WEB_USER" php admin/cli/upgrade.php --non-interactive
sudo -u "$WEB_USER" php admin/cli/purge_caches.php

echo
echo "Done. Demo: $DEV_URL"
echo "Log in with the same accounts as the live site. Cron is not set up for the demo on purpose."

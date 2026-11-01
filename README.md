# 3alemny web

Moodle 4.5.15 LTS site for 3alemny.net, with the Edumy theme, the custom 3alemny pages and the site's own core changes.

## Layout

- `moodle/` – the Moodle code (web root).
- `docker/`, `docker-compose.yml` – local environment: PHP 8.3 + Apache on http://localhost:8081, MariaDB 10.6 on port 3311.
- `deploy/deploy-dev.sh` – deploys this repo as the demo at https://3alemny.net/dev.

## Files that are not in git

| File | What it holds | Start from |
|---|---|---|
| `moodle/config.php` | Database and site URL | `moodle/config-dist.php` |
| `moodle/local_secrets.php` | Keys used by the custom pages (Tap, Vimeo, BigBlueButton, SMTP, web service tokens) | `moodle/local_secrets.example.php` |
| `moodle/**/*firebase-adminsdk*.json` | Firebase service account for push notifications | Firebase console |
| `moodledata/` | Uploaded files and caches | – |

## Run locally

```bash
docker compose up -d --build
```

Import a database dump into the `3alemny` database (`docker exec -i 3alemny_db mariadb -uroot -proot 3alemny < dump.sql`), then run `docker exec 3alemny_app php admin/cli/upgrade.php --non-interactive`.

## Upgrade notes (4.1.5 → 4.5.15)

- The site's edits to Moodle core files were carried over to 4.5.15.
- The legacy course rendering used by Edumy (`print_single_section_page` and the `course_section_cm*` methods) was restored in `course/renderer.php` and `course/format/classes/output/section_renderer.php`, because the week-code popup and the Edumy topics renderer depend on it.
- PDF Annotator, Multitopic format and Course size were updated to versions that support 4.5.
- Hardcoded credentials were moved from the custom pages into `local_secrets.php`.

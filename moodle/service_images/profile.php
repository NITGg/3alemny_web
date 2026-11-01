<?php
require_once('../config.php');
global $DB, $CFG;

$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('site');

$userid         = optional_param('id', 0, PARAM_INT);
$edit           = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off.
$reset          = optional_param('reset', null, PARAM_BOOL);

$PAGE->set_url('/user/profile.php', array('id' => $userid));
$PAGE->set_title('Profile');
$PAGE->set_heading('Profile');

// Start output to browser
echo $OUTPUT->header();

echo '<style>
#page {
   background-image: linear-gradient(to right, #183041 0%, #183041 100%) !important;
}
</style>';

?>
<div class="container">
    <div class="content">
        <h1>Under Construction</h1>
        <p>We are currently working on this part of the project. Stay tuned for updates!</p>
        <img src="https://3alemny.net/service_images/worker-character.webp" alt="Under Construction">
    </div>
</div>
<?php

// End output to browser
echo $OUTPUT->footer();

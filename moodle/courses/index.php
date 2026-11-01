<?php
require_once('../config.php');
global $DB, $CFG;

$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('site');
$PAGE->set_url('/courses/index.php');
$PAGE->set_title('All courses');
$PAGE->set_heading('All courses');

// Start output to browser
echo $OUTPUT->header();

echo '<style>
#page {
   background-image: linear-gradient(to right, #183041 0%, #183041 100%) !important;
}
</style>';

// End output to browser
echo $OUTPUT->footer();
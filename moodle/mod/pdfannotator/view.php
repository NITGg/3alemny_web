<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package   mod_pdfannotator
 * @copyright 2018 RWTH Aachen (see README.md)
 * @author    Ahmad Obeid, Anna Heynkes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../../config.php');
require_once($CFG->dirroot . '/mod/pdfannotator/locallib.php'); // Requires lib.php in turn.
require_once($CFG->libdir . '/completionlib.php');
require_once($CFG->dirroot . '/mod/pdfannotator/model/pdfannotator.php');
require_once('renderable.php');

$id = optional_param('id', 0, PARAM_INT); // Course Module ID.
$r = optional_param('r', 0, PARAM_INT);  // Pdfannotator instance ID.
$redirect = optional_param('redirect', 0, PARAM_BOOL);

$page = optional_param('page', 1, PARAM_INT);
$annoid = optional_param('annoid', null, PARAM_INT);
$commid = optional_param('commid', null, PARAM_INT);

?>
<style>
#ccn-main-region {
  padding-top: 0px !important;
}
#jump-to-activity {
  display: none;
}
.activity-navigation .row {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    border-top: 1px solid #C9C9C9;
    padding-top: 10px;
}
.activity-navigation .row .col-md-4:last-child,
.activity-navigation .row .col-md-4:first-child {
    width: fit-content !important;
}
.activity-navigation .row .col-md-4:nth-child(2) {
    display: none;
}
#ccn-main-region .container .row {
    margin-left: -15px !important;
}
.nav-link.active:not(:disabled):not(.disabled).active {
    background-color: #92251E !important;
    border-color: #92251E !important;
    color: white !important;
}
</style>
<script>
    // Ensure the script runs after the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Select the element using querySelector
        var nextActivityLink = document.querySelector('.activity-navigation #next-activity-link');
        var prevActivityLink = document.querySelector('.activity-navigation #prev-activity-link');
        // Check if the element exists
        if (nextActivityLink) {
            // Change the text content of the element
            nextActivityLink.innerHTML = 'Next <i class="fa fa-angle-double-right"></i>';
        }
        // Check if the element exists
        if (prevActivityLink) {
            // Change the text content of the element
            prevActivityLink.innerHTML = '<i class="fa fa-angle-double-left"></i> Prev';
        }
    });
</script>
<?php

if ($r) {
    if (!$pdfannotator = $DB->get_record('pdfannotator', array('id' => $r))) {
        throw new moodle_exception('invalidaccessparameter');
    }
    $cm = get_coursemodule_from_instance('pdfannotator', $pdfannotator->id, $pdfannotator->course, false, MUST_EXIST);
} else {
    if (!$cm = get_coursemodule_from_id('pdfannotator', $id)) {
        throw new moodle_exception('invalidcoursemodule');
    }
    $pdfannotator = $DB->get_record('pdfannotator', array('id' => $cm->instance), '*', MUST_EXIST);
}

$course = get_course($cm->course); // Get course by id.
require_course_login($course, true, $cm);

$context = context_module::instance($cm->id);
require_capability('mod/pdfannotator:view', $context);

// Apply filters, e.g. multilang.
$pdfannotator->name = format_text($pdfannotator->name, FORMAT_MOODLE, ['para' => false, 'filter' => true]);

// Completion and trigger events.
pdfannotator_view($pdfannotator, $course, $cm, $context);

$PAGE->set_url('/mod/pdfannotator/view.php', array('id' => $cm->id));

$fs = get_file_storage();
$files = $fs->get_area_files($context->id, 'mod_pdfannotator', 'content', 0, 'sortorder DESC, id ASC', false);// TODO Not efficient!
if (count($files) < 1) {
    pdfannotator_print_filenotfound($pdfannotator, $cm, $course);
    die;
} else {
    $file = reset($files);
    unset($files);
}

$pdfannotator->mainfile = $file->get_filename();

// Set course name for display.
$PAGE->set_heading($course->fullname);

// Display course name, navigation bar at the very top and "Dashboard->...->..." bar.
echo $OUTPUT->header();

// Render the activity information.
if ($CFG->version < 2022041900) {
    $modinfo = get_fast_modinfo($course);
    $cminfo = $modinfo->get_cm($cm->id);
    $completiondetails = \core_completion\cm_completion_details::get_instance($cminfo, $USER->id);
    $activitydates = \core\activity_dates::get_dates_for_module($cminfo, $USER->id);
    echo $OUTPUT->activity_information($cminfo, $completiondetails, $activitydates);
}

require_once($CFG->dirroot . '/mod/pdfannotator/controller.php');

// Display navigation and settings bars on the left as well as the footer.
echo $OUTPUT->footer();

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
 * Display the course home page.
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package core_course
 */

require_once('../config.php');
require_once('lib.php');
require_once($CFG->libdir.'/completionlib.php');
//require $CFG->dirroot . '/createuser/PHPExcel/Classes/PHPExcel.php';
require $CFG->dirroot . '/createuser/fpdf/fpdf.php';

?>
<style>
    .activityiconcontainer.communication .activityicon:not(.nofilter),
    .activityiconcontainer.communication .icon:not(.nofilter),
    .activityiconcontainer.assessment .activityicon:not(.nofilter),
    .activityiconcontainer.assessment .icon:not(.nofilter) {
        filter: brightness(1) invert(0) !important;
    }

    .activityiconcontainer.communication,
    .activityiconcontainer.assessment {
        background-color: #f8f9fa !important;
    }

    .modchoosercontainer .optionscontainer .option[aria-label="Forum"] {
        display: none !important;
    }

    #course-header-banner {
        background-image: none !important;
    }
    #course-header-banner-text {
        padding: 0px !important;
    }
</style>
<?php

redirect_if_major_upgrade_required();

$id = optional_param('id', 0, PARAM_INT);
$name = optional_param('name', '', PARAM_TEXT);
$edit = optional_param('edit', -1, PARAM_BOOL);
$hide = optional_param('hide', 0, PARAM_INT);
$show = optional_param('show', 0, PARAM_INT);
$duplicatesection = optional_param('duplicatesection', 0, PARAM_INT);
$idnumber = optional_param('idnumber', '', PARAM_RAW);
$sectionid = optional_param('sectionid', 0, PARAM_INT);
$section = optional_param('section', null, PARAM_INT);
$expandsection = optional_param('expandsection', -1, PARAM_INT);
$move = optional_param('move', 0, PARAM_INT);
$marker = optional_param('marker', -1 , PARAM_INT);
$switchrole = optional_param('switchrole', -1, PARAM_INT); // Deprecated, use course/switchrole.php instead.
$return = optional_param('return', 0, PARAM_LOCALURL);

$params = [];
if (!empty($name)) {
    $params = ['shortname' => $name];
} else if (!empty($idnumber)) {
    $params = ['idnumber' => $idnumber];
} else if (!empty($id)) {
    $params = ['id' => $id];
} else {
    throw new \moodle_exception('unspecifycourseid', 'error');
}

$course = $DB->get_record('course', $params, '*', MUST_EXIST);

$urlparams = ['id' => $course->id];

// Sectionid should get priority over section number.
if ($sectionid) {
    $section = $DB->get_field('course_sections', 'section', ['id' => $sectionid, 'course' => $course->id], MUST_EXIST);
}
if (!is_null($section)) {
    $urlparams['section'] = $section;
}
if ($expandsection !== -1) {
    $urlparams['expandsection'] = $expandsection;
}

$PAGE->set_url('/course/view.php', $urlparams); // Defined here to avoid notices on errors etc.

// Prevent caching of this page to stop confusion when changing page after making AJAX changes.
$PAGE->set_cacheable(false);

context_helper::preload_course($course->id);
$context = context_course::instance($course->id, MUST_EXIST);

// Remove any switched roles before checking login.
if ($switchrole == 0 && confirm_sesskey()) {
    role_switch($switchrole, $context);
}

require_login($course);

// Switchrole - sanity check in cost-order...
$resetuserallowedediting = false;
if ($switchrole > 0 && confirm_sesskey() &&
    has_capability('moodle/role:switchroles', $context)) {
    // Is this role assignable in this context?
    // Inquiring minds want to know.
    $aroles = get_switchable_roles($context);
    if (is_array($aroles) && isset($aroles[$switchrole])) {
        role_switch($switchrole, $context);
        // Double check that this role is allowed here.
        require_login($course);
    }
    // Reset course page state. This prevents some weird problems.
    $USER->activitycopy = false;
    $USER->activitycopycourse = null;
    unset($USER->activitycopyname);
    unset($SESSION->modform);
    $USER->editing = 0;
    $resetuserallowedediting = true;
}

// If course is hosted on an external server, redirect to corresponding
// url with appropriate authentication attached as parameter.
if (file_exists($CFG->dirroot . '/course/externservercourse.php')) {
    include($CFG->dirroot . '/course/externservercourse.php');
    if (function_exists('extern_server_course')) {
        if ($externurl = extern_server_course($course)) {
            redirect($externurl);
        }
    }
}

require_once($CFG->dirroot.'/calendar/lib.php'); // This is after login because it needs $USER.

// Must set layout before gettting section info. See MDL-47555.
$PAGE->set_pagelayout('course');
$PAGE->add_body_class('limitedwidth');

if ($section && $section > 0) {

    // Get section details and check it exists.
    $modinfo = get_fast_modinfo($course);
    $coursesections = $modinfo->get_section_info($section, MUST_EXIST);

    // Check user is allowed to see it.
    if (!$coursesections->uservisible) {
        // Check if coursesection has conditions affecting availability and if
        // so, output availability info.
        if ($coursesections->visible && $coursesections->availableinfo) {
            $sectionname = get_section_name($course, $coursesections);
            $message = get_string('notavailablecourse', '', $sectionname);
            redirect(course_get_url($course), $message, null, \core\output\notification::NOTIFY_ERROR);
        } else {
            // Note: We actually already know they don't have this capability
            // or uservisible would have been true; this is just to get the
            // correct error message shown.
            require_capability('moodle/course:viewhiddensections', $context);
        }
    }
}

// Fix course format if it is no longer installed.
$format = course_get_format($course);
$course->format = $format->get_format();

$PAGE->set_pagetype('course-view-' . $course->format);
$PAGE->set_other_editing_capability('moodle/course:update');
$PAGE->set_other_editing_capability('moodle/course:manageactivities');
$PAGE->set_other_editing_capability('moodle/course:activityvisibility');
if (course_format_uses_sections($course->format)) {
    $PAGE->set_other_editing_capability('moodle/course:sectionvisibility');
    $PAGE->set_other_editing_capability('moodle/course:movesections');
}

// Preload course format renderer before output starts.
// This is a little hacky but necessary since
// format.php is not included until after output starts.
$renderer = $format->get_renderer($PAGE);

if ($resetuserallowedediting) {
    // Ugly hack.
    unset($PAGE->_user_allowed_editing);
}

if (!isset($USER->editing)) {
    $USER->editing = 0;
}
if ($PAGE->user_allowed_editing()) {
    if (($edit == 1) && confirm_sesskey()) {
        $USER->editing = 1;
        // Redirect to site root if Editing is toggled on frontpage.
        if ($course->id == SITEID) {
            redirect($CFG->wwwroot .'/?redirect=0');
        } else if (!empty($return)) {
            redirect($CFG->wwwroot . $return);
        } else {
            $url = new moodle_url($PAGE->url, ['notifyeditingon' => 1]);
            redirect($url);
        }
    } else if (($edit == 0) && confirm_sesskey()) {
        $USER->editing = 0;
        if (!empty($USER->activitycopy) && $USER->activitycopycourse == $course->id) {
            $USER->activitycopy = false;
            $USER->activitycopycourse = null;
        }
        // Redirect to site root if Editing is toggled on frontpage.
        if ($course->id == SITEID) {
            redirect($CFG->wwwroot .'/?redirect=0');
        } else if (!empty($return)) {
            redirect($CFG->wwwroot . $return);
        } else {
            redirect($PAGE->url);
        }
    }

    if (has_capability('moodle/course:sectionvisibility', $context)) {
        if ($hide && confirm_sesskey()) {
            set_section_visible($course->id, $hide, '0');
            if ($sectionid) {
                redirect(course_get_url($course, $section, ['navigation' => true]));
            } else {
                redirect($PAGE->url);
            }
        }

        if ($show && confirm_sesskey()) {
            set_section_visible($course->id, $show, '1');
            if ($sectionid) {
                redirect(course_get_url($course, $section, ['navigation' => true]));
            } else {
                redirect($PAGE->url);
            }
        }
    }

    if ($marker >= 0 && confirm_sesskey()) {
        course_set_marker($course->id, $marker);
        if ($sectionid) {
            redirect(course_get_url($course, $section, ['navigation' => true]));
        } else {
            redirect($PAGE->url);
        }
    }

    if (
        !empty($section) && !empty($coursesections) && !empty($duplicatesection)
        && has_capability('moodle/course:update', $context) && confirm_sesskey()
    ) {
        $newsection = $format->duplicate_section($coursesections);
        redirect(course_get_url($course, $newsection->section));
    }

    if (!empty($section) && !empty($move) &&
            has_capability('moodle/course:movesections', $context) && confirm_sesskey()) {
        $destsection = $section + $move;
        if (move_section_to($course, $section, $destsection)) {
            if ($course->id == SITEID) {
                redirect($CFG->wwwroot . '/?redirect=0');
            } else {
                if ($format->get_course_display() == COURSE_DISPLAY_MULTIPAGE) {
                    redirect(course_get_url($course));
                } else {
                    redirect(course_get_url($course, $destsection));
                }
            }
        } else {
            echo $OUTPUT->notification('An error occurred while moving a section');
        }
    }
} else {
    $USER->editing = 0;
}

$SESSION->fromdiscussion = $PAGE->url->out(false);


if ($course->id == SITEID) {
    // This course is not a real course.
    redirect($CFG->wwwroot .'/?redirect=0');
}

// Determine whether the user has permission to download course content.
$candownloadcourse = \core\content::can_export_context($context, $USER);

// We are currently keeping the button here from 1.x to help new teachers figure out
// what to do, even though the link also appears in the course admin block.  It also
// means you can back out of a situation where you removed the admin block.
if ($PAGE->user_allowed_editing()) {
    $buttons = $OUTPUT->edit_button($PAGE->url);
    $PAGE->set_button($buttons);
}

$editingtitle = '';
if ($PAGE->user_is_editing()) {
    // Append this to the page title's lang string to get its equivalent when editing mode is turned on.
    $editingtitle = 'editing';
}

// If viewing a section, make the title more specific.
if ($section && $section > 0 && course_format_uses_sections($course->format)) {
    $sectionname = get_string('sectionname', "format_$course->format");
    $sectiontitle = get_section_name($course, $section);
    $PAGE->set_title(
        get_string(
            'coursesectiontitle' . $editingtitle,
            'moodle',
            ['course' => $course->fullname, 'sectiontitle' => $sectiontitle, 'sectionname' => $sectionname]
        )
    );
} else {
    $PAGE->set_title(get_string('coursetitle' . $editingtitle, 'moodle', ['course' => $course->fullname]));
}

// Add bulk editing control.
$bulkbutton = $renderer->bulk_editing_button($format);
if (!empty($bulkbutton)) {
    $PAGE->add_header_action($bulkbutton);
}

$PAGE->set_heading($course->fullname);
echo $OUTPUT->header();

echo '
<style>
#section-0 {
display: none !important;
}
</style>';

$admins = get_admins();
$isadmin = false;
foreach ($admins as $admin) {
    if ($USER->id == $admin->id) {
        $isadmin = true;
        break;
    }
}

/* promo video */
$video = $DB->get_record('course_promo_videos', array('course_id' => $id));

$inputDateString = $video->datetime_field;

// Create a DateTime object from the input string
$dateTime = new DateTime($inputDateString);

// Format the DateTime object to the desired format
$formattedDate = $dateTime->format("M j, g:i A");


if ($video) {

    if (is_enrolled($context, $USER->id)) {
        $url = $video->url_name;
    } else {
        $url = $CFG->wwwroot . '/login';
    }
    echo '
<style>
#section-0 {
display: none !important;
}
#accordion .panel-heading .accordion-toggle::before,
#accordion .panel-heading .accordion-toggle.collapsed::before {
    color: #fff !important;
}
.automatic-completion-conditions {
    float: right !important;
}
.section.main:not(.course-section) .activity .availabilityinfo, 
.section.main:not(.course-section) .activity .contentafterlink {
    font-size: small;
}
.meeting_desc p {
    color: #5b5b5b;
}
.meeting_desc h2 {
    color: #212121;
}
#ccn-main-region {
    padding-top: 0px !important;
}
.video-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    height: 35vh;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;
    border-radius: 5px;
    margin-bottom: 20px;
    transition: transform 0.3s;
}
.video-container:hover .fa-video-camera {
    animation: rotateIn 1s;
}
.fa-bell {
    animation: swing 2s infinite ease-in-out;
    transform-origin: center top;
    color: gold;
    filter: drop-shadow(1px 1px 1px #ccc);
    font-size: large;
}

@keyframes swing {
    0%, 100% {
        transform: rotate(0deg); /* Starting and ending position */
    }
    20% {
        transform: rotate(15deg); /* Rotate to 15 degrees */
    }
    40% {
        transform: rotate(-10deg); /* Rotate to -10 degrees */
    }
    60% {
        transform: rotate(5deg); /* Rotate to 5 degrees */
    }
    80% {
        transform: rotate(-5deg); /* Rotate to -5 degrees */
    }
}

</style>
<a href="' . $url . '" target="_blank">
<div class="video-container">
<i class="fa fa-video-camera" style="font-size: 150px;"></i>
</div>
<div class="meeting_desc">
<h2>' . $video->v_name . '</h2>
<p><i class="fa fa-bell" aria-hidden="true"></i> Reminded ' . $formattedDate . '</p>

</div>
</a>
<script>
        document.addEventListener(\'contextmenu\', function (event) {
            if (event.target.tagName.toLowerCase() === \'video\') {
                event.preventDefault();
            }
        });
    </script>
';
    echo '<br>';
}


$teacherRoleID = $DB->get_field('role', 'id', array('shortname' => 'editingteacher'));
$teacherRole = $DB->record_exists('role_assignments', ['userid' => $USER->id, 'roleid' => $teacherRoleID]);
$assisstantRoleID = $DB->get_field('role', 'id', array('shortname' => 'teacher'));
$assisstantRole = $DB->record_exists('role_assignments', ['userid' => $USER->id, 'roleid' => $assisstantRoleID]);

if ($isadmin) {

    echo '<a class="btn btn-primary" href="' . $CFG->wwwroot . '/Codes/dashboard.php"><i class="fa fa-code" aria-hidden="true"></i> Codes</a>';
}

/* echo '
<style>
        .video-container {
            width: 100%;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .video-container iframe {
            pointer-events: none;
        }

        .video-container iframe {
            position: absolute;
            top: -60px;
            left: 0;
            width: 100%;
            height: calc(100% + 120px);
        }

        .video-foreground {
            pointer-events: none;
        }

        .play-button,
        .pause-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            cursor: pointer;
            z-index: 999;
            font-size: 24px;
            color: white;
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            border-radius: 50%;
            padding: 16px;
        }

        .pause-button {
            display: none;
        }
</style>
<div class="video-container">
<div class="video-foreground">
    <iframe width="560" height="315"
    src="https://www.youtube.com/embed/p2zMXSXhZ9M?controls=1&showinfo=0&rel=0&autoplay=1&loop=1&mute=1"
    title="YouTube video player" frameborder="0"
    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;"
    allowfullscreen></iframe>
</div>
</div>
'; */

echo '<style>
.instancename:hover {
    cursor: pointer !important;
}
</style>';
echo "
    <script>
    $( document ).ready(function() {
        $('.section-modchooser-link').removeClass('btn-link');

    });
    </script>
    ";



$teacherRole = $DB->get_field('role', 'id', array('shortname' => 'editingteacher'));
$teacherRole = $DB->record_exists('role_assignments', ['userid' => $USER->id, 'roleid' => $teacherRole]);
$assisstantRole = $DB->get_field('role', 'id', array('shortname' => 'teacher'));
$assisstantRole = $DB->record_exists('role_assignments', ['userid' => $USER->id, 'roleid' => $assisstantRole]);
$control = $DB->get_record('control_activities', array('course' => $course->id));
/* if (($isadmin || $teacherRole || $assisstantRole)) {
    echo "<a href='" . $CFG->wwwroot . "/parentManagement/?id=" . $course->id . "'>Parent Management</a>";
} */
if (($isadmin || $teacherRole || $assisstantRole) && $control->bulk == 1) {
    $role = $DB->get_record('role', array('shortname' => 'editingteacher'));
    $context = context_course::instance($course->id);
    $teachers = get_role_users($role->id, $context);
    $teachId = 0;
    foreach ($teachers as $teach) {
        $teachId = $teach->id;
    }
    //<h3>' . get_string('bulk', "theme_edumy") . '</h3>
    //<button name="submit" class="btn btn-success">' . get_string('add', "theme_edumy") . '</button>
    /* echo '
    <h3 style="color: #142052;">اضافة مجموعه من الطلاب / اولياء الامور</h3>
    <a href="sample.csv"download>Sample</a>
    <form  id="files" method="POST" enctype="multipart/form-data">
    <div class="row">
    <input type="file" name="excel" id="excel" accept=".csv" >
    <input type="hidden" value="' . $course->id . '" id="course">
<button name="submit" class="btn btn-success">أضف</button>
</div>
</form>
<div id="tab" style="display:none;">

<table class="table" id="codes"></table>
</div>

'; */

    // echo "key".$key;
    echo '
<script>
$( document ).ready(function() {
    $("form#files").submit(function(e){

// var formData = new FormData($(this)[0]);
e.preventDefault();    
var formData = new FormData($(this)[0]);
// console.log(formData)
formData.append("excel", $("#excel").val());
formData.append("course", $("#course").val());
formData.append("teacherID", ' . $teachId . ');

$.ajax({
url: "ajax.php",
type: "POST",
data: formData,
dataType:"json",
cache: false,
success: function (data) {
if(data["state"]==1){
    var out = "<div id=' . "tab" . ' ><table class=' . "table" . '><tr><th>email</th><th>Student</th><th>Parent</th><tr>";
                    $.each(data["failure"], function(key, value) {
                        out +="<tr><td>"+value["name"]+" , "+value["parent"]+"</td><td>"+value["reasonS"]+"</td><td>"+value["reasonP"]+"</td></tr>" ;

                    });
                    $.each(data["success"], function(key, value) {
                                        out +="<tr><td>"+value["name"]+"</td><td>"+value["reason"]+"</td></tr>" ;
              });
                    out += "</table ></div>";
                                            $("#codes").html(out);
    let mywindow = window.open("", "PRINT", "height=650,width=900,top=100,left=150");
            var style = "<style>";
            style = style + "#codes {text-align: center;} table { border-collapse: collapse;  width: 100%;} table tr { border-bottom: 1px solid black;}table tr:last-child {border: 0;}";
            
            style = style + "</style>";

            mywindow.document.write("<html><head>" + style);
            mywindow.document.write("</head><body >");
            mywindow.document.write(document.getElementById("tab").innerHTML);
            mywindow.document.write("</body></html>");

            mywindow.document.close(); // necessary for IE >= 10
            mywindow.focus(); // necessary for IE >= 10*/
            window.open(mywindow.print(), "_self");
}
else{
console.log(data);
}


},
processData: false,    
 contentType: false,  
  
});

return false;
});
 
});
</script>';
}

// Show communication room status notification.
if (has_capability('moodle/course:update', $context)) {
    core_communication\helper::get_course_communication_status_notification($course);
}

$containerattributes = ['class' => 'course-content'];
if ($PAGE->user_is_editing()) {
    // MDL-65321 The backup libraries are quite heavy, only require the bare minimum.
    require_once($CFG->dirroot . '/backup/util/helper/async_helper.class.php');

    if (async_helper::is_async_pending($id, 'course', 'backup')) {
        echo $OUTPUT->notification(get_string('pendingasyncedit', 'backup'), 'warning');
    }

    // Allow drag and drop in the course index.
    $containerattributes['data-courseindexdndallowed'] = 'true';
} else {
    echo '<style>
    .ccn-4-navigation {
        display: none !important;
    }
    </style>';
}

/* hide collapse all and expand all buttons */
echo '<style>
.section-collapsemenu.collapsed .expandall,
.section-collapsemenu .collapseall {
    display: none !important;
}
</style>';

/* center section text */
echo '<style>
/* .course-section-header {
    justify-content: center !important;
} */
.btn.btn-icon:hover, .btn.btn-icon:focus {
    background-color: #e9ecef00 !important;
}
.btn.btn-icon {
    color: #183041 !important;
}
.sections.topics li.section:not(:first-child) .course-section-header .sectionname {
    color: #fff !important;
}
.sections.topics li.section:not(:first-child) .course-section-header .position-relative {
    width: 100%;
}
.sections.topics li.section:not(:first-child) .course-section-header {
    background-color: #92251E;
    color: #fff; 
    padding: 5px 15px;
    border-radius: 5px;
}
/* .course-section-header {
    border-radius: 10px !important;
    padding: 5px !important;
    background: #142052 !important;
} */
.cs_row_three .course_content {
    border-color: #ffffff03 !important;
}
/* .flex-fill {
    width: 0px;
    display: none !important;
} */
.cs_row_three .course_content h4.title {
    display: none !important;
}
.course_schdule {
    display: none !important;
}
.course-section {
    border-bottom: 1px solid #dee2e600 !important;
}
.cs_row_three .course_content {
    padding: 20px !important;
}
#files {
    margin-left: 2px !important;
    background-color: #142052 !important;
    padding: 10px !important;
    border-radius: 10px !important;
}
#files .row {
    padding: 10px 20px !important;
}
#files .row .btn {
    background-color: #FEB62E !important;
    padding: 8px 20px !important;
    color: #fff !important;
}
#files .row .btn:hover {
    background-color: #142052 !important;
    border: 3px solid #FEB62E !important;
    color: #FEB62E !important;
}
</style>';

echo '<style>
#accordion .panel-heading {
    text-align: center !important;
}
.details .cc_tab h4.panel-title {
    background-color: #92251E !important;
}
#accordion .panel-title a {
    color: #fff !important;
    font-size: 20px !important;
    font-weight: bold !important;
}
#accordion .panel-title a:active,
#accordion .panel-title a:hover {
    color: #fff !important;
}
</style>';





// Course wrapper start.
echo html_writer::start_tag('div', $containerattributes);

// Make sure that section 0 exists (this function will create one if it is missing).
course_create_sections_if_missing($course, 0);

// Get information about course modules and existing module types.
// format.php in course formats may rely on presence of these variables.
$modinfo = get_fast_modinfo($course);
$modnames = get_module_types_names();
$modnamesplural = get_module_types_names(true);
$modnamesused = $modinfo->get_used_module_names();
$mods = $modinfo->get_cms();
$sections = $modinfo->get_section_info_all();

// CAUTION, hacky fundamental variable defintion to follow!
// Note that because of the way course fromats are constructed though
// inclusion we pass parameters around this way.
$displaysection = $section;

// Include course AJAX.
include_course_ajax($course, $modnamesused);

// Include the actual course format.
require($CFG->dirroot .'/course/format/'. $course->format .'/format.php');
// Content wrapper end.

echo html_writer::end_tag('div');

// Trigger course viewed event.
// We don't trust $context here. Course format inclusion above executes in the global space. We can't assume
// anything after that point.
course_view(context_course::instance($course->id), $section);

// If available, include the JS to prepare the download course content modal.
if ($candownloadcourse) {
    $PAGE->requires->js_call_amd('core_course/downloadcontent', 'init');
}

// Load the view JS module if completion tracking is enabled for this course.
$completion = new completion_info($course);
if ($completion->is_enabled()) {
    $PAGE->requires->js_call_amd('core_course/view', 'init');
}

echo $OUTPUT->footer();

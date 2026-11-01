<?php
require_once('../config.php');
global $DB, $CFG, $USER;

// تحديد السياق وتحديد الخصائص الرئيسية للصفحة
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_url('/parent-dashboard/index.php');
$PAGE->set_title('Parent Dashboard');
$PAGE->set_heading('Parent Dashboard');

// بدء الإخراج إلى المستعرض
echo $OUTPUT->header();

// تنسيق الصفحة بشكل عام باستخدام Bootstrap
echo '<link rel="stylesheet" href="styles.css">';

// تعريف وظيفة لتحميل صور المستخدمين
function upload_user_image($id)
{
  global $DB, $CFG;
  $user = $DB->get_record('user', array('id' => $id));
  $user_context = $DB->get_record('context', array('instanceid' => $id, 'contextlevel' => 30));
  $fs = get_file_storage();
  $files = $fs->get_area_files($user_context->id, 'user', 'icon', 0, 'sortorder DESC, id ASC', false);
  if (count($files) < 1) {
    $image = '' . $CFG->wwwroot . '/pluginfile.php/' . $user_context->id . '/user/icon/0/f1.jpg?rev=0';
  } else {
    $file = reset($files);
    unset($files);
    $path = '/' . $user_context->id . '/user/icon/0' . $file->get_filepath() . $file->get_filename();
    $image = $CFG->wwwroot . '/pluginfile.php' . $path . "?rev=" . $user->picture;
  }
  return $image;
}

// استرجاع نوع المستخدم من جدول بيانات معلومات المستخدم
$userTypeFieldId = 8;
$userType = $DB->get_field('user_info_data', 'data', array('userid' => $USER->id, 'fieldid' => $userTypeFieldId));


if ($userType == 'parent') {
  // عرض قائمة الطلاب في حالة كون المستخدم نوعه والدي
  echo '<div class="container">';
  echo '<div class="row">';
  echo '<div class="col-md-4 students-list">';

  // Query to retrieve student emails with fieldid equal to 5 or greater than 8
  $sql = "SELECT * FROM {user_info_data} WHERE userid = :userid AND (fieldid = 5 OR fieldid > 8)";
  $params = array('userid' => $USER->id);
  // Execute the query
  $studentEmails = $DB->get_records_sql($sql, $params);

  echo '<h2>Students</h2>';
  echo '<ul class="list-group">';
  foreach ($studentEmails as $emailRecord) {
    $student = $DB->get_record('user', array('email' => $emailRecord->data));
    if ($student) {
      $url = upload_user_image($student->id);
      echo '<li class="list-group-item student-link" id="stu_' . $student->id . '" data-userid="' . $student->id . '">';
      echo '<img class="stu_img me-2" src="' . $url . '">';
      echo $student->firstname;
      echo '</li>';
    }
  }
  echo '</ul>';

  require('./form_modal.php');

  echo '</div>';

  echo '<div class="col-md-8 student-info"></div>';

  echo '</div>';
  echo '</div>';
} else {
  \core\notification::add('User is not a parent.', \core\output\notification::NOTIFY_ERROR);
  redirect(new moodle_url('/'));
}

echo $OUTPUT->footer();

?>
<script src="scripts.js"></script>

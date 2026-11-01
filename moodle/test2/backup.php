<?php
require_once('../config.php');
global $DB, $USER, $CFG;

// Validate and sanitize input
$fromModuleId = isset($_POST['from_module_id']) ? intval($_POST['from_module_id']) : null;
$toResourceId = isset($_GET['to_resource_id']) ? intval($_GET['to_resource_id']) : null;

if (!$fromModuleId || !$toResourceId) {
    \core\notification::add('Invalid resource IDs.', \core\output\notification::NOTIFY_ERROR);
    redirect(new moodle_url('/test2/submit1.php', ['resource_id' => $toResourceId, 'update' => 0]));
    exit;
}

try {
    // Get the course module record
    $fromModule = $DB->get_record('course_modules', ['id' => $fromModuleId], '*', MUST_EXIST);
    $fromResourceId = $fromModule->instance;

    // Get the vimeo_files2 record
    $main_record = $DB->get_record('vimeo_files2', ['resource2_id' => $fromResourceId]);

    if ($main_record) {
        $new_record = (object) [
            'resource2_id' => $toResourceId,
            'name' => $main_record->name,
            'description' => $main_record->description,
            'url' => $main_record->url
        ];

        // Insert the new record into the database
        $DB->insert_record('vimeo_files2', $new_record);

        $toModule = $DB->get_record('course_modules', ['instance' => $toResourceId], '*', MUST_EXIST);
        $toModuleId = $toModule->id;

        \core\notification::add('Backup successful.', \core\output\notification::NOTIFY_SUCCESS);
        redirect(new moodle_url('/mod/resource2/view.php', ['id' => $toModuleId]));
    } else {
        \core\notification::add('No record found for the provided Resource ID.', \core\output\notification::NOTIFY_ERROR);
        redirect(new moodle_url('/test2/submit1.php', ['resource_id' => $toResourceId, 'update' => 0]));
    }
} catch (dml_exception $e) {
    \core\notification::add('Database error: ' . $e->getMessage(), \core\output\notification::NOTIFY_ERROR);
    redirect(new moodle_url('/test2/submit1.php', ['resource_id' => $toResourceId, 'update' => 0]));
} catch (Exception $e) {
    \core\notification::add('Unexpected error: ' . $e->getMessage(), \core\output\notification::NOTIFY_ERROR);
    redirect(new moodle_url('/test2/submit1.php', ['resource_id' => $toResourceId, 'update' => 0]));
}

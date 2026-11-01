<?php
require_once('../config.php');
require_once($CFG->dirroot . '/theme/edumy/ccn/block_handler/ccn_block_handler.php');

global $DB, $CFG, $PAGE;

$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('site');
$PAGE->set_title('About');
$PAGE->set_heading('About');

// Specify the name of the block containing the desired content
$blockName = 'cocoon_about_1';

// Query to retrieve the block instance configuration data from the database
$sql = "SELECT configdata FROM {block_instances} WHERE blockname = :blockname";
$params = array('blockname' => $blockName);
$htmlContent = $DB->get_field_sql($sql, $params);

// Deserialize the configuration data to access the image URL
$decoded_data = unserialize(base64_decode($htmlContent));

// Retrieve the image URL dynamically
$fs = get_file_storage();
$block = $DB->get_record('block_instances', array('blockname' => $blockName));
$context = $DB->get_record('context', array('instanceid' => $block->id, 'contextlevel' => 80));
$component = 'block_cocoon_about_1';
$file_area = 'content';
$files = $fs->get_area_files($context->id, $component, $file_area);


foreach ($files as $file) {
    $filename = $file->get_filename();
    if ($filename <> '.') {
        $url = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(), null, $file->get_filepath(), $filename);
        $image_url = $url->out(false); // Get the URL as a string without encoding
    }
}
//print_r($decoded_data);
// Format the data as a JSON response
$response = [
    'text1' => $decoded_data->body['text'],
    'text2' => $decoded_data->body_2['text'],
    'image' => $image_url,
];

// Set the response headers and encode the response as JSON
header('Content-Type: application/json; charset=utf-8');
return json_encode(["state" => 'success', "data" => $response, "error" => '']);
?>
<?php
require_once('../config.php'); // Make sure to replace it with the correct path to your Moodle configuration file

// Make sure the user is logged in
require_login();

$targetDirectory = "activity_videos/";
$videoFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

// Check if the form was submitted
if (isset($_POST["submit"])) {
    $resource2_id = $_GET["resource2_id"];
    $video_name = $_POST["video_name"];



    // Generate a unique file name based on current date and time
    $currentDateTime = date("Ymd_His");
    $newFileName = $currentDateTime . '.' . $videoFileType;
    $uploadFile = $targetDirectory . $newFileName;

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 50000000) { // Change this value to your desired maximum file size
      echo "Sorry, your file is too large.";
  } else {
      // Allow only specific video file formats
      $allowedFormats = array("mp4", "avi", "mov");
      if (!in_array($videoFileType, $allowedFormats)) {
          echo "Sorry, only MP4, AVI, and MOV files are allowed.";
      } else {
          // Attempt to move the uploaded file to the target directory with the new file name
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploadFile)) {

              global $DB;

              /* add video name and course_id to course_promo_videos */
              $data = new stdClass();
              $data->resource2_id = $resource2_id;
              $data->user_id = $USER->id;
              $data->video_name = $newFileName;
              $success = $DB->insert_record('drive_videos', $data);

              // Handle the response and return success or failure
              if ($success) {
                echo 'success'. $resource2_id;
                  // Redirect to the edit page with the course_id parameter
                  //header('Location: edit.php?id=' . $course_id);
              } else {
                  echo 'Error!';
              }

              //echo "The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
              exit(); // Exit to prevent further code execution
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }
  }
}
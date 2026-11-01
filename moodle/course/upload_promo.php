<?php
require_once('../config.php');

// Check if form is submitted and required data is provided
if (isset($_POST["submit"]) && isset($_POST["URL"])) {
    // Retrieve data from POST
    $course_id = $_POST["course_id"];
    $URL = $_POST["URL"];
    $dateTime = $_POST["DateTime"];
    $v_name = $_POST["v_name"];

    // Check if required data is not empty
    if (!empty($course_id) && !empty($URL) && !empty($dateTime) && !empty($v_name)) {
        global $DB;

        // Define the SQL query to insert into mo_course_promo_videos
        $sql_insert_promo_videos = "INSERT INTO mo_course_promo_videos (course_id, url_name, datetime_field, v_name) 
        VALUES (?, ?, ?, ?)";

        // Define the parameters for the insertion query
        $params_insert_promo_videos = array($course_id, $URL, $dateTime, $v_name);

        // Execute the SQL query to insert into mo_course_promo_videos
        $success_insert_promo_videos = $DB->execute($sql_insert_promo_videos, $params_insert_promo_videos);

        // Check if insertion into mo_course_promo_videos was successful
        if ($success_insert_promo_videos) {
            // Fetch course details
            $course = $DB->get_record('course', array('id' => $course_id), '*', MUST_EXIST);

            // Fetch enrolled users
            $context = context_course::instance($course_id);
            $enrolled_users = get_enrolled_users($context, '', 0, 'u.id, u.username, u.firstname, u.lastname');

            foreach ($enrolled_users as $user) {
                // Define the SQL query to insert into mo_notifications
                $sql_insert_notifications = "INSERT INTO mo_notifications (useridfrom, useridto, subject, fullmessage, fullmessageformat, fullmessagehtml, smallmessage, component, eventtype, contexturl, contexturlname, timecreated)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $subject = 'A new virtual class has been added to the -['.$course->fullname.'] course...';

                $timestamp = strtotime($dateTime);
                $formatted_datetime = date('F j, Y, h:i A', $timestamp);

                $fullmessage = '
                <div class="container">
                <h3>Dear: '.$user->firstname.',</h3>
                <p>A new virtual class has been added to the <strong>' . $course->fullname . '</strong> course.</p>
                <p>The class is in the <strong>' . $v_name . '</strong> section and starts on <strong>' . $formatted_datetime . '</strong>.</p>
                <p>Please check the course page for details.</p>
                <a href="'.$URL.'" style="display:inline-block;border-radius: 5px;background-color:#92251E;color:white;padding:8px 20px;text-align:center;text-decoration:none;display:inline-block;font-size:16px;margin-top:10px;">Go to Class</a>
                </div>';
                
                $contexturl = ''.$CFG->wwwroot . '/course/view.php?id=' . $course_id.'';
                

                // Define the parameters for the notification insertion query
                $params_insert_notifications = array(-10, $user->id, $subject, $fullmessage, 2, $fullmessage, $subject, 'online_session', 'newsession', $contexturl, 'Context name', time());

                // Execute the SQL query to insert into mo_notifications
                $success_insert_notifications = $DB->execute($sql_insert_notifications, $params_insert_notifications);

                if ($success_insert_notifications) {
                    // Fetch the ID of the last inserted record
                    $last_insert_id = $DB->get_field_sql('SELECT LAST_INSERT_ID()');

                    if ($last_insert_id !== false) {
                        // Define the SQL query to insert into mo_message_popup_notifications
                        $sql_insert_message_popup = "INSERT INTO mo_message_popup_notifications (notificationid) 
                        VALUES (?)";

                        // Execute the SQL query to insert into mo_message_popup_notifications
                        $success_insert_message_popup = $DB->execute($sql_insert_message_popup, array($last_insert_id));

                        if ($success_insert_message_popup) {
                            // Redirect to the edit page with the course_id parameter
                            echo "Notifications sent successfully.";
                        } else {
                            echo 'Error inserting into mo_message_popup_notifications!';
                            break; // Exit the loop if an error occurs
                        }
                    } else {
                        echo 'Error retrieving last insert ID!';
                        break; // Exit the loop if an error occurs
                    }
                } else {
                    echo 'Error inserting into mo_notifications!';
                    break; // Exit the loop if an error occurs
                }
            }
            header('Location: edit.php?id=' . $course_id);
        } else {
            echo 'Error inserting into mo_course_promo_videos!';
        }
    } else {
        echo 'Required data is missing or empty!';
    }
} else {
    echo "Form submission failed or required parameters are missing!";
}
?>

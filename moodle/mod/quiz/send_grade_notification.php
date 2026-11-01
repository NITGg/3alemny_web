<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');

/**
 * Function to send grade notification to the user and their parents.
 *
 * @param int $attemptid The attempt ID.
 */
function send_grade_notification($attemptid)
{
    global $DB, $CFG;

    // Attempt abandoned or finished.
    $attempt = $DB->get_record('quiz_attempts', array('id' => $attemptid));

    // Check if the attempt exists
    if ($attempt) {
        // Get the quiz details
        $quiz = $DB->get_record('quiz', array('id' => $attempt->quiz));

        // Get the student details
        $student = $DB->get_record('user', array('id' => $attempt->userid));

        // Get the quiz grades
        $quiz_grade = $DB->get_record('quiz_grades', array('quiz' => $quiz->id));

        // Calculate percentage
        $max_grade = $quiz->sumgrades;
        $percentage = ($attempt->sumgrades / $max_grade) * 100;

        // Calculate time taken and format it
        $time_taken = $attempt->timefinish - $attempt->timestart;
        $time_taken_formatted = format_time($time_taken);

        // Format dates for display
        $completed_on = userdate($attempt->timefinish);
        $started_on = userdate($attempt->timestart);

        // Get attempt state
        $state = $attempt->state;

        // Check if quiz and student data exist
        if ($quiz && $student) {

            // Define the URL for the context
            $contexturl = $CFG->wwwroot . '/mod/quiz/review.php?attempt=' . $attemptid;

            // Define the subject and full message for the notification
            $subject = 'Quiz Completion Notification';
            $fullmessage = '
            <div class="container">
                <h3 class="mb-4">Quiz Results</h3>
                <p>Dear Parent,</p>
                <p>We would like to inform you about the completion of a recent quiz by your child <strong>' . $student->firstname . '</strong>.</p>
                <p>Here are the details of the quiz results:</p>
                
                <dl class="row details">
                    <dt class="col-sm-3">Quiz Name: ' . $quiz->name . '</dt>
                    <dt class="col-sm-3">Grade: ' . number_format($percentage, 0) . '%</dt>
                    <dt class="col-sm-3">Time Taken: ' . $time_taken_formatted . '</dt>
                    <dt class="col-sm-3">Started On: ' . $started_on . '</dt>
                    <dt class="col-sm-3">Completed On: ' . $completed_on . '</dt>
                    <dt class="col-sm-3">Attempt State: ' . $state . '</dt>
                </dl>
            
                <p>We are pleased with the progress and look forward to more achievements in the future.</p>
                <p>Best regards, <a href="' . $CFG->wwwroot . '">3alemny</a></p>
            </div>
            ';

            // Define the component and event type
            $component = 'Quiz';
            $eventtype = 'newQuiz';

            // Send notification to student
            $success_student = send_notification($student->id, $subject, $fullmessage, $contexturl, $component, $eventtype);

            // Get parent IDs based on student's email
            $parentIDs = $DB->get_records_sql("SELECT userid FROM {user_info_data} WHERE data = ? AND fieldid = ?", array($student->email, 5));

            // Send notification to parents
            $success_parents = true; // Assume success unless a failure occurs
            foreach ($parentIDs as $parentID) {
                $userId = $parentID->userid;
                $success_parents = send_notification($userId, $subject, $fullmessage, $contexturl, $component, $eventtype);
                if (!$success_parents) {
                    break; // Break loop if any parent notification fails
                }
            }

            // Return true if both notifications were successful, false otherwise
            return $success_student && $success_parents;
        } else {
            return false; // Quiz or student record not found
        }
    } else {
        return false; // Attempt not found
    }
}


/**
 * Function to send a notification.
 *
 * @param int $userId The user ID.
 * @param string $subject The subject of the notification.
 * @param string $fullmessage The full message of the notification.
 * @param string $contexturl The URL of the context.
 * @param string $component The component.
 * @param string $eventtype The event type.
 */
function send_notification($userId, $subject, $fullmessage, $contexturl, $component, $eventtype)
{
    global $DB, $CFG, $PAGE;

    // Insert notification into the database
    $sql_insert_notifications = "INSERT INTO {notifications} (useridfrom, useridto, subject, fullmessage, fullmessageformat, fullmessagehtml, smallmessage, component, eventtype, contexturl, contexturlname, timecreated)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Define parameters for the notification insertion query
    $params_insert_notifications = array(-10, $userId, $subject, $fullmessage, 2, $fullmessage, $subject, $component, $eventtype, $contexturl, 'Context name', time());

    // Execute the SQL query to insert into notifications
    $success_insert_notifications = $DB->execute($sql_insert_notifications, $params_insert_notifications);

    if ($success_insert_notifications) {
        // Fetch the ID of the last inserted record
        $last_insert_id = $DB->get_field_sql('SELECT LAST_INSERT_ID()');

        if ($last_insert_id !== false) {
            // Insert into message popup notifications
            $sql_insert_message_popup = "INSERT INTO {message_popup_notifications} (notificationid) 
            VALUES (?)";

            // Execute the SQL query to insert into message popup notifications
            $success_insert_message_popup = $DB->execute($sql_insert_message_popup, array($last_insert_id));

            if ($success_insert_message_popup) {
                // Send push notification using Push.js
                $js_code = "
                <script>
                Push.create('{$subject}', {
                    body: '{$fullmessage}',
                    icon: '{$CFG->wwwroot}/path/to/icon.png',
                    timeout: 5000,
                    onClick: function () {
                        window.location.href = '{$contexturl}';
                    }
                });
                </script>
                ";
                echo $js_code;

                return true; // Notification sent successfully
            } else {
                return false; // Error inserting into message_popup_notifications
            }
        } else {
            return false; // Error retrieving last insert ID
        }
    } else {
        return false; // Error inserting into notifications
    }
}

<?php
require_once('../config.php');
global $DB;

// تحقق من وجود معلمات الطالب
if (isset($_GET['userid'])) {
    $userId = $_GET['userid'];

    // جلب معلومات الطالب
    $student = $DB->get_record('user', array('id' => $userId));

    if ($student) {
        // بناء النموذج لعرض معلومات الطالب
        $output = '<div class="container" data-id-value="'.$userId.'">';
        $output .= '<div class="row">';
        $output .= '<div class="col">';
        $output .= '<div class="card">';
        $output .= '<div class="card-header bg-primary text-white">';
        $output .= '<h3 class="card-title">Student Information</h3>';
        $output .= '</div>';
        $output .= '<div class="card-body">';
        $output .= '<h4>Student: ' . $student->firstname . '</h4>';
        $output .= '<p>Email: ' . $student->email . '</p>';
        $output .= '<p>Phone: ' . $student->phone1 . '</p>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        // Fetch and display the student's grades
        $courses = enrol_get_users_courses($student->id, true);
        foreach ($courses as $course) {
            $output .= '<div class="row mt-5">';
            $output .= '<div class="col">';
            $output .= '<div class="card">';
            $output .= '<div class="card-header bg-primary text-white">';
            $output .= '<h3 class="card-title">Course: ' . $course->fullname . '</h3>';

            // احتسب إجمالي عدد الوحدات في الدورة
            $courseModules = $DB->get_records('course_modules', array('course' => $course->id));
            $totalModulesCount = count($courseModules);
            // احتسب إجمالي عدد الوحدات المكتملة في الدورة
            $completionviewModules = $DB->get_records('course_modules', array('course' => $course->id, 'completionview' => 1));
            $totalCompletionviewModules = count($completionviewModules);
            // احتسب نسبة التقدم
            $progressPercentage = ( $totalCompletionviewModules / $totalModulesCount) * 100;
            // عرض شريط التقدم
            $output .= '<div class="progress">';
            $output .= '<div class="progress_full_count">'.number_format($progressPercentage, 1).'%</div>';
            $output .= '<div class="progress-bar" role="progressbar" style="width: ' . $progressPercentage . '%;" aria-valuenow="' . $progressPercentage . '" aria-valuemin="0" aria-valuemax="100"></div>';
            $output .= '</div>';

            $output .= '</div>';

            $output .= '<div class="card-body" style="overflow-x: auto;">';

            // Fetch and display the student's quiz grades
            $quiz_grades = $DB->get_records('quiz_grades', array('userid' => $student->id));
            if (!empty($quiz_grades)) {
                $output .= '<table class="table table-bordered">';
                $output .= '<thead>';
                $output .= '<tr><th>Quiz Name</th><th>Percentage</th><th>Time taken</th><th>Completed on</th><th>State</th><th>Started on</th></tr>';
                $output .= '</thead>';
                $output .= '<tbody>';
                foreach ($quiz_grades as $quiz_grade) {
                    // Fetch quiz details
                    $quiz = $DB->get_record('quiz', array('id' => $quiz_grade->quiz));
                    $courseid = $quiz->course;

                    // Check if the quiz belongs to the current course
                    if ($courseid == $course->id) {
                        // Fetch quiz attempts
                        $attempts = $DB->get_records('quiz_attempts', array('quiz' => $quiz_grade->quiz, 'userid' => $student->id));

                        foreach ($attempts as $attempt) {
                            $max_grade = $quiz->grade;
                            $percentage = ($quiz_grade->grade / $max_grade) * 100;

                            $time_taken = $attempt->timefinish - $attempt->timestart;
                            $time_taken_formatted = format_time($time_taken);
                            $completed_on = userdate($attempt->timefinish);
                            $started_on = userdate($attempt->timestart);
                            $state = $attempt->state;

                            $output .= '<tr>';
                            $output .= '<td>' . $quiz->name . '</td>';
                            $output .= '<td>' . number_format($percentage, 0) . '%</td>';
                            $output .= '<td>' . $time_taken_formatted . '</td>';
                            $output .= '<td>' . $completed_on . '</td>';
                            $output .= '<td>' . $state . '</td>';
                            $output .= '<td>' . $started_on . '</td>';
                            $output .= '</tr>';

                            // توقف بعد عرض أعلى درجة واحدة
                            break;
                        }
                    }
                }
                $output .= '</tbody>';
                $output .= '</table>';

                // Add canvas for chart
            } else {
                $output .= '<p>No quiz grades available.</p>';
            }

            // Fetch and display the student's paper exam grades
            $sql = "SELECT gg.finalgrade, gi.itemname, gi.grademax, gi.timemodified
                    FROM mo_grade_grades AS gg
                    JOIN mo_grade_items AS gi ON gg.itemid = gi.id
                    WHERE gi.courseid = ? AND gg.userid = ? AND gi.itemtype = 'manual'";
            $params = array($course->id, $student->id);
            $paper_exam_grades = $DB->get_records_sql($sql, $params);

            if ($paper_exam_grades) {
                $output .= '<h4>Paper Exam Grades</h4>';
                $output .= '<table class="table table-bordered">';
                $output .= '<thead>';
                $output .= '<tr><th>Exam Name</th><th>Grade</th><th>Max Grade</th><th>Percentage</th><th>Date</th></tr>';
                $output .= '</thead>';
                $output .= '<tbody>';
                foreach ($paper_exam_grades as $grade) {
                    $percentage = ($grade->finalgrade / $grade->grademax) * 100;
                    $exam_date = userdate($grade->timemodified);
                    $output .= '<tr>';
                    $output .= '<td>' . $grade->itemname . '</td>';
                    $output .= '<td>' . number_format($grade->finalgrade, 0) . '</td>';
                    $output .= '<td>' . number_format($grade->grademax, 0) . '</td>';
                    $output .= '<td>' . number_format($percentage, 0) . '%</td>';
                    $output .= '<td>' . $exam_date . '</td>';
                    $output .= '</tr>';
                }
                $output .= '</tbody>';
                $output .= '</table>';
            } else {
                $output .= '<p>No paper exam grades available.</p>';
            }

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';
        }

        // إرجاع النموذج كإجابة
        echo $output;
    } else {
        echo "<div class='container'><div class='row'><div class='col-md-6 mx-auto mt-5'><div class='alert alert-danger' role='alert'>Student not found.</div></div></div></div>";
    }
} else {
    echo "<div class='container'><div class='row'><div class='col-md-6 mx-auto mt-5'><div class='alert alert-danger' role='alert'>Student ID not provided.</div></div></div></div>";
}


<?php

// $json=$DB->get_records_sql("SELECT * from mo_user ");
// require_once('../../config.php');
require_once(__DIR__ . '/../../config.php');

$PAGE->set_url($CFG->wwwroot . '/json/json.php');
require_once($CFG->libdir . '/externallib.php');
require_once($CFG->dirroot . '/course/externallib.php');
require_once($CFG->dirroot . '/user/externallib.php');
require_once($CFG->dirroot . '/webservice/lib.php');
require_once($CFG->dirroot . '/enrol/externallib.php');
require_once($CFG->dirroot . '/group/lib.php');
require_once($CFG->dirroot . '/group/externallib.php');
require_once($CFG->dirroot . '/lib/grouplib.php');
require_once($CFG->dirroot . '/lib/enrollib.php');
require_once($CFG->dirroot . '/message/externallib.php');
require_once($CFG->dirroot . '/mod/resource/lib.php');
require_once($CFG->dirroot . '/mod/resource/locallib.php');
require_once($CFG->libdir . "/weblib.php");
// require '../vimeo/vendor/autoload.php';

// use Vimeo\Vimeo;
// require_once('lib.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('PHPMailer/src/Exception.php');
require_once('PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/src/SMTP.php');

define('PARAM_STRING', 'string');
header('Content-Type: application/json');

// echo PARAM_STRING;
$function = optional_param('function', '', PARAM_RAW);
$id = optional_param('id', -1, PARAM_INT);
$token = optional_param('token',  0, PARAM_TEXT);
$username = optional_param('username',  0, PARAM_TEXT);
$subject = optional_param('subject',  0, PARAM_TEXT);
$fullmessage = optional_param('fullmessage',  0, PARAM_TEXT);
$year  = optional_param('year',  0, PARAM_INT);
$teacherRating  = optional_param('rating',  0, PARAM_INT);
$feedBackText = optional_param('feedback', 0, PARAM_TEXT);
$courseId = optional_param('courseID', -1, PARAM_INT);
$conversationId = optional_param('conversationId', -1, PARAM_INT);
$categoryId = optional_param('categoryId', -1, PARAM_INT);
$badgeId = optional_param('badgeId', -1, PARAM_INT);
$teacherId = optional_param('teacherId', -1, PARAM_INT);
$userids = optional_param('userids', array(), PARAM_INT);
$members = optional_param('members', array(), PARAM_INT);
$courseIDs = optional_param('courseIDs', array(), PARAM_INT);
$feedBackId = optional_param('feedbackId', -1, PARAM_INT);
$userFirstName = optional_param('firstname', 0, PARAM_TEXT);
$userlastName = optional_param('lastname', 0, PARAM_TEXT);
$imageId = optional_param('imageID', -1, PARAM_INT);
$videoID = optional_param('videoID', -1, PARAM_INT);
$groupID = optional_param('groupID', -1, PARAM_INT);
$requestedid = optional_param('requestedid', -1, PARAM_INT);
$phone1 = optional_param('phone1', 0, PARAM_TEXT);
$phone = optional_param('phone', 0, PARAM_TEXT);
$phone2 = optional_param('phone2', 0, PARAM_TEXT);
$secret = optional_param('secret', 0, PARAM_TEXT);
$code = optional_param('code', 0, PARAM_TEXT);
$name = optional_param('name', 0, PARAM_TEXT);
$courseModuleId = optional_param('cm', -1, PARAM_INT);
$rate = optional_param('rate', -1, PARAM_INT);
$fname = optional_param('fname', 0, PARAM_TEXT);
$lname = optional_param('lname', 0, PARAM_TEXT);
$role = optional_param('role', 0, PARAM_TEXT);
$password = optional_param('password', 0, PARAM_TEXT);
$city = optional_param('city', '', PARAM_RAW);
$school = optional_param('school', '', PARAM_RAW);
$knownfrom = optional_param('knownfrom', '', PARAM_RAW);
$center = optional_param('center', '', PARAM_RAW);
$language = optional_param('language', '', PARAM_RAW);
$deviceid = optional_param('deviceid', '', PARAM_RAW);
$device = optional_param('device', '', PARAM_RAW);
$activityid = optional_param('activityid', '', PARAM_RAW);
$code = optional_param('code', '', PARAM_RAW);
$quiz = optional_param('quiz', 0, PARAM_TEXT);
$option = optional_param('option', ' ', PARAM_RAW);
$moduleid = optional_param('moduleid', 0, PARAM_RAW);
$email = optional_param('email',  0, PARAM_TEXT);
$new_password = optional_param('new_password', 0, PARAM_TEXT);
$confirm_password = optional_param('confirm_password', 0, PARAM_TEXT);
$user_id = optional_param('user_id', 0, PARAM_INT);
$search_term = optional_param('search_term', '', PARAM_TEXT);
$role_name = optional_param('role_name', 0, PARAM_TEXT);

$blockName = optional_param('block_name',  0, PARAM_TEXT);

if ($function == 'termsInfo') {
    echo termsInfo();
}
if ($function == 'privacyPolicy') {
    echo privacyPolicy();
}
if ($function == 'aboutInfo') {
    echo aboutInfo();
}
// Token
if ($function == 'check') {
    //echo check_mail();
}
// if($function=='check'){
//     echo login();
// }
//forget password api 
if ($function == 'forget_password') {
    echo forget_password($username);
} //end

//get teacher profile image 
if ($function == 'get_teacher_image') {
    echo get_teacher_image($id);
}

if ($function == 'sign_up') {
    echo signUp();
}
if ($function == 'sign_up_new') {
    echo signUpNew($fname, $lname, $email, $email, $password, $phone1, $phone2, $role, $year, $city, $school, $center);
}
if ($function == 'signUpParent') {
    echo signUpParent();
}

if ($function == 'get_teacher_years') {
    echo get_teacher_years($teacherId);
}
if ($function == 'get_all_categories') {
    echo get_all_categories();
}
if ($function == 'getCategoryWithSubcategories') {
    echo getCategoriesWithSubcategories();
}
if ($function == 'geOurTrainingCourses') {
    echo getCategoriesWithSubcategories2();
}
if ($function == 'geOurTeachers') {
    echo get_users_with_role($role_name);
}
if ($function == 'get_all_news') {
    echo get_all_news();
}
if ($function == 'course_view_data') {
    echo course_view_data($courseId);
}
if ($function == 'get_promo_video') {
    echo get_promo_video($courseId);
}
if ($function == 'course_content') {
    echo course_content($courseId);
}
if ($function == 'get_course_contents_data') {
    echo get_course_contents_data($courseId, array());
}
if ($function == 'check_quiz_reviews') {
    echo check_quiz_reviews($quiz);
}
if ($function == 'get_enrolled_users_members') {
    echo get_enrolled_users_members($courseId, $option);
}
if ($function == 'all_courses') {
    echo all_courses();
}
//get all teachers in database api 
if ($function == 'teachers') {
    echo teachers();
}

if ($function == 'teacher_data') {
    echo get_teacher_profile_data($id);
}
if ($function == 'is_admin') {
    echo is_admin($id);
}

if ($function == 'changeUserPassword') {
    echo changeUserPassword($user_id, $new_password);
}
if ($function == 'get_last_accessed_courses') {
    echo get_last_accessed_courses($user_id);
}
if ($function == 'searchCoursesByShortname') {
    echo searchCoursesByShortname($search_term);
}
if ($function == 'partners') {
    echo partners();
}
if ($function == 'minister_speech') {
    echo Minister_speech();
}
if ($function == 'course_average_rating') {
    echo calculate_course_average_rating($courseId);
}
if ($function == 'teacher_average_rating') {
    echo calculate_teacher_average_rating($teacherId);
}
if ($function == 'training_centers') {
    echo training_centers($courseId);
}
if ($function == 'get_all_categories_with_courses') {
    echo get_all_categories_with_courses();
}
if ($function == 'add_course_rate') {
    echo add_course_rate($id, $courseId, $rate);
}
if ($function == 'policies') {
    echo policy();
}
if ($function == 'policies_data') {
    echo policy_data($language);
}
if ($function == 'forgot_password') {
    echo forgot_password();
}
if ($function == 'about') {
    echo about();
}
if ($function == 'contact_us') {
    echo contact_us();
}
if ($function == 'about_block') {
    header('Content-Type: application/json; charset=utf-8');
    echo getBlockData($blockName);
}
if ($function == 'getGalleryBlockData') {
    header('Content-Type: application/json; charset=utf-8');
    echo getGalleryBlockData($blockName, $id);
}
if ($function == 'get_children_reports') {
    echo get_children_reports($id);
}
if ($function == 'send_notification') {
    echo send_notification($id, $subject, $fullmessage);
}
if ($function == 'reset_password') {
    echo reset_password($email, $new_password, $confirm_password);
}



//check if token is valide or not 
if (!empty($token)) {

    $api = new webservice();
    $array = array();

    try {
        if (!empty($courseId) && ($function == "course_content_mobile") || ($function == "check_availability")) {
            $courseData = $DB->get_record('course', array('id' => $courseId));
            if (!empty($courseData->lang)) {
                $userCheck = $DB->get_record('external_tokens', array('token' => $token));
                $user = $DB->get_record('user', array('id' => $userCheck->userid));
                $upd = new stdClass();
                $upd->id = $user->id;
                $upd->lang = $courseData->lang;
                $DB->update_record('user', $upd);
            }
        }
        if ($DB->get_record('external_tokens', array('token' => $token))) {
            $array = $api->authenticate_user($token);
            if (!empty($array)) {
                $array = json_encode($api->authenticate_user($token));
                //echo $array;
                $arr = json_decode($array, true);
                $userID = $arr['user']['id'];

                //check user is student or teacher
                if ($function == 'check_isStudent') {
                    echo check_isStudent($userID);
                }

                if ($function == 'add_module_completion') {
                    echo add_module_completion($userID, $moduleid);
                }

                //get all related courses by student year levele 
                if ($function == 'get_all_related_courses') {
                    echo get_related_courses($year, $userID);
                }
                //get all student feedbacks 
                if ($function == 'get_user_feedbacks') {
                    echo get_user_feedbacks($userID);
                }

                if ($function == 'new_get_enroll_users') {
                    echo new_get_enroll_users($userID, $courseId);
                }

                if ($function == 'course_content_mobile') {

                    echo course_content_mobile($userID, $courseId);
                }

                if ($function == 'get_user_enrolled_courses') {
                    echo get_user_enrolled_courses($userID);
                }

                if ($function == 'get_enrol_courses') {
                    echo get_enrol_courses($userID);
                }

                if ($function == 'get_chats') {
                    echo get_chats($userID);
                }

                if ($function == 'send_message') {
                    echo send_message($conversationId, $userID, $subject, $fullmessage);
                }

                if ($function == 'delete_user_account') {
                    echo delete_user_account($userID);
                }

                if ($function == "add_teacher_rating") {
                    echo add_teacher_rating($userID, $id, $teacherRating);
                }
                if ($function == 'add_student_feedback') {
                    echo add_student_feedback($userID, $teacherId, $courseId, $feedBackText);
                }
                if ($function == 'delete_student_feedback') {
                    echo delete_student_feedback($feedBackId);
                }
                if ($function == 'upload_image') {
                    echo upload_image($userID);
                }
                if ($function == 'create_group') {
                    echo create_group($courseId, $name);
                }
                if ($function == 'add_group_members') {
                    echo add_group_members($members, $groupID);
                }
                if ($function == 'delete_group') {
                    echo delete_group($groupID);
                }
                if ($function == 'get_members') {
                    echo get_members($groupID);
                }
                if ($function == "add_group_chat_member") {
                    echo add_group_chat_member($userids, $name);
                }
                if ($function == 'remove_member') {
                    echo remove_member($groupID, $members);
                }
                if ($function == 'remove_group_chat_member') {
                    echo  remove_group_chat_member($userids, $name);
                }
                if ($function == 'add_teacher_images') {
                    echo add_teacher_images($userID);
                }
                if ($function == 'delete_teacher_images') {
                    echo delete_teacher_images($imageId);
                }
                if ($function == 'edit_user_data') {
                    echo edit_user_data($userID, $userFirstName, $userlastName, $phone1, $phone2);
                }
                if ($function == 'add_teacher_videos') {
                    echo add_teacher_videos($userID);
                }
                if ($function == 'delete_teacher_videos') {
                    echo delete_teacher_videos($videoID);
                }
                if ($function == 'get_course_descriptions') {
                    echo get_course_descriptions($courseId);
                }
                if ($function == 'get_user_name') {
                    echo get_user_name($userID);
                }
                if ($function == 'search_user_by_course') {
                    echo  search_user_by_course($email, $courseId);
                }
                if ($function == 'search_user') {
                    echo search_user($email, $courseId);
                }
                if ($function == 'get_contact_requests_sent') {
                    echo get_contact_requests_sent($userID, $requestedid);
                }
                if ($function == 'delete_contact_request') {
                    echo delete_contact_request($userID, $requestedid);
                }
                if ($function == 'change_password') {
                    echo change_password($userID);
                }
                if ($function == 'get_user_by_id') {
                    echo get_user_by_id($userID);
                }
                if ($function == 'get_user_data') {
                    echo get_user_data($userID);
                }
                if ($function == 'create_conversation') {
                    echo create_conversation($userids);
                }
                if ($function == 'create_group_conversation') {
                    echo create_group_conversation($userids, $name);
                }
                if ($function == 'remove_conversation') {
                    echo remove_conversation($id);
                }

                if ($function == 'get_h5p_result') {
                    echo get_h5p_result($courseId);
                }
                if ($function == 'insert_course_reservation') {
                    $userid = intval($userID);
                    echo insert_course_reservation($userid, $courseId);
                }
                if ($function == 'is_course_reserved') {
                    $userid = intval($userID);
                    echo is_course_reserved($userid, $courseId);
                }
                if ($function == 'delete_course_reservation') {
                    $userid = intval($userID);
                    echo delete_course_reservation($userid, $courseId);
                }

                if ($function == 'all_course_reservations') {

                    echo all_course_reservations();
                }
                if ($function == 'all_accept_course_reservations') {

                    echo all_accept_course_reservations();
                }
                if ($function == 'accept_user_reservation') {

                    echo accept_user_reservation($id, $courseId);
                }
                if ($function == 'get_courses_by_category') {

                    echo get_courses_by_category($categoryId);
                }
                if ($function == 'create_child') {

                    echo create_child($email, $userID, $phone1, 1);
                }
                if ($function == 'get_parent_data') {

                    echo get_parent_data($userID);
                }
                if ($function == 'get_child_courses') {
                    echo get_child_courses($id);
                }
                if ($function == 'add_to_cart') {
                    echo add_to_cart($userID, $courseId);
                }
                if ($function == 'get_user_cart') {
                    echo get_user_cart($userID, $token);
                }
                if ($function == 'remove_from_cart') {
                    echo remove_from_cart($userID, $courseId);
                }
                if ($function == 'get_user_wallet_data') {
                    echo get_user_wallet_data($userID);
                }
                if ($function == 'check_wallet_secret_key') {
                    echo check_wallet_secret_key($userID, $secret);
                }
                if ($function == 'forget_wallet_secret') {
                    echo forget_wallet_secret($userID, 0);
                }
                if ($function == 'check_course_in_the_cart_of_the_user') {
                    echo check_course_in_the_cart_of_the_user($userID, $courseId);
                }
                if ($function == 'generate_new_secret') {
                    echo generate_new_secret($userID, $code);
                }
                if ($function == 'get_total_price') {
                    echo get_total_price($userID);
                }
                if ($function == 'enrol_student') {
                    echo enrol_student($courseId, $userID, 5);
                }
                if ($function == 'enrol_student_courses') {
                    echo enrol_student_courses($courseIDs, $userID);
                }
                if ($function == 'get_notifications') {
                    echo get_user_notifications($userID);
                }
                if ($function == 'mark_notifications_as_read') {
                    echo mark_notifications_as_read($userID, $id);
                }

                /* if ($function == 'course_content_mobile') {

                echo course_content_mobile($courseId, $userID);
                } */
                if ($function == 'all_courses_by_category') {
                    echo all_courses_by_category($userID, $categoryId);
                }
                if ($function == 'get_all_user_enrolled_courses') {
                    echo get_all_user_enrolled_courses($userID);
                }
                if ($function == 'get_course_badges') {
                    echo get_course_badges($courseId);
                }
                if ($function == 'get_badge_users') {
                    echo get_badge_users($badgeId);
                }
                if ($function == 'get_session') {
                    echo get_session($userID);
                }
                if ($function == 'unenroll_user') {
                    echo unenroll_user($courseId, $userID);
                }
                if ($function == 'get_all_courses') {
                    echo get_all_courses($userID, $id, $language);
                }
                if ($function == 'user_language_update') {
                    echo user_language_update($userID, $language);
                }
                if ($function == 'check_device_code') {
                    echo check_device_code($userID, $code, $activityid, $device, $deviceid);
                }
                if ($function == 'check_availability') {
                    echo check_availability($courseId, $activityid, $userID);
                }
                if ($function == 'get_children') {
                    echo get_children($userID);
                }
                if ($function == 'add_children') {
                    echo add_children($userID, $email, $phone);
                }
            } else
                echo json_encode(['message' => 'invalide token']);
        } else {
            echo json_encode(['status' => 'fail', 'message' => 'invalide token', 'error' => 'User not login']);
        }
    } catch (Exception $e) {
        echo json_encode(['message' => 'invalide token', "exception" => $e]);
    }
}

function get_chats($authUserId)
{
    global $DB;

    // Find conversation IDs where the authenticated user is a member
    $sql = "
        SELECT mc.conversationid
        FROM {message_conversation_members} mc
        WHERE mc.userid = ?
    ";

    $conversationIds = $DB->get_records_sql($sql, array($authUserId));

    if (empty($conversationIds)) {
        return json_encode(['data' => []]);
    }

    $chats = [];

    foreach ($conversationIds as $conversationId) {
        // Fetch all messages in the conversation
        $sql = "
            SELECT m.*
            FROM {messages} m
            WHERE m.conversationid = ? 
            ORDER BY m.timecreated
        ";

        $messages = $DB->get_records_sql($sql, array($conversationId->conversationid));
        $chatData = [];

        foreach ($messages as $message) {
            $messageSender = $DB->get_record('user', array('id' => $message->useridfrom), '*', MUST_EXIST);
            $chatData[] = [
                "id" => $message->id,
                "useridfrom" => $message->useridfrom,
                "userfrom_name" => $messageSender->firstname . " " . $messageSender->lastname,
                "userfrom_image" => upload_user_image($message->useridfrom),
                "subject" => $message->subject,
                "fullmessage" => $message->fullmessage,
                "timecreated" => date('Y-m-d H:i:s', $message->timecreated),
            ];
        }

        // Fetch all members in the conversation
        $sql = "
            SELECT u.id, u.firstname, u.lastname
            FROM {message_conversation_members} mcm
            JOIN {user} u ON mcm.userid = u.id
            WHERE mcm.conversationid = ?
        ";

        $members = $DB->get_records_sql($sql, array($conversationId->conversationid));
        $useridtoo = [];

        foreach ($members as $member) {
            if ($member->id != $authUserId) {
                $useridtoo[] = [
                    'userid' => $member->id,
                    'username' => $member->firstname . " " . $member->lastname,
                    'conversationImage' => upload_user_image($member->id),
                ];
            }
        }

        $chats[] = [
            "conversationId" => $conversationId->conversationid,
            "useridto" => $useridtoo,
            "messages" => $chatData,
        ];
    }

    return json_encode(['data' => $chats]);
}




function aboutInfo()
{
    $string = "
    
    <p style='color:black;'> 
    طلابي الأعزاء كل عام وأنتم بخير .... 
    التطبيق محاولة جادة ومتخصصة لتفعيل النظام الجديد بكل تفاصيله بمعنى أنك ستتدرب في كل حصة على الامتحانات والأسئلة وطرق الحل الصحيحة والتي تحقق لك التفوق بإذن الله في النظام التعليمي الجديد .
    التطبيق ليس بنكا لتخزين الأسئلة والتدريبات ، ولكنه موقع تعليمي متكامل ( سنتر الكتروني ) يحقق كل أهداف العملية التعليمية وعلى رأسها التعود على المسائل بأشكالها المختلفة ، والمتابعة الجادة مني شخصيا ومن فريق العمل بشكل عام لكل إجاباتكم وحلولكم في جميع التقويمات 
    والهدف الأكبر للتطبيق أنه يجعلك على تواصل معي ومع فريق العمل على مدار 24 ساعة من خلال الأسئلة والاستفسارات المختلفة .
    سيكون بمقدورك أيضا من خلال التطبيق أن تقيم نفسك وتعرف مستواك الحقيقي من خلال الواجبات والاختبارات الجزئية والاختبارات العامة .
    طبعا سيكون الهاتف المحمول ( الموبايل ) والتاب الوسيلة التي نستخدمها في الاختبار الاسبوعي الذي سيكون في بداية كل حصة أو في المنزل في الموعد المحدد لكل الطلاب في نفس الوقت .
    تستطيع أيضا معرفة كل المعلومات المتعلقة بالمواعيد  ، وأماكن الحصص ، والحصص التعويضية ،  والدروس التي سيتم شرحها في كل حصة ، ومواعيد الاختبارات  الجزئية والعامة ، والواجبات الخاصة بكل حصة ، والتعرف على الملاحظات والتنبيهات المستجدة لأي سبب من الأسباب  .
    سيقوم التطبيق أيضا بعرض كل الأخبار والتعليمات الرسمية الخاصة بالنظام التعليمي الجديد والتي تقوم بإصدارها وزارة التربية والتعليم للصفين الأول الثانوي والثاني الثانوي.
    تستطيع أيضا عرض أي مشكلة خاصة بعدم قدرتك على التحصيل والفهم لأي نوع من أنواع المسائل وسوف أقوم شخصيا بمتابعة هذه الحالات ووضعها على الطريق الصحيح .
    أيضا يحقق التطبيق التواصل الفعال بين ولي الأمر وبيننا لتحقيق الصالح العام للطالب في المقام الأول . من خلال متابعة درجات الطالب ومتابعة الحضور والغياب . 
    سيقوم التطبيق أيضا بتصنيف الطلاب حسب المستوى ويمكنك من خلاله معرفة مستواك الحقيقي والعمل على الانتقال إلى مستوى أعلى .
    كما نقوم أيضا بعمل خطط لرفع مستوى الضعاف من خلال واجبات خاصة وتدريبات متميزة لتحسين المستوى .
    مع ملاحظة أن غياب ثلاث حصص يعرضك لغلق التطبيق والحرمان من خدماته بشكل كامل .
    على كل حال ... أهلا بكم  في هذا الملتقى التعليمي المتميز  لنتعاون جميعا من خلال منظومة إلكترونية متخصصة للوصول إلى أعلى الدرجات في مادة الرياضيات  مع مستر رضا القصاص
    </p>
    
    ";

    return json_encode(['about' => $string]);
}


function privacyPolicy()
{
    $arabicText = '<p style="color:white;font-size:18px;">  Privacy Policy
    Ahmed Ibrahim built Alaaby as a Free game. This SERVICE is provided by N.I.T Group at no cost and is intended for use as is.
    
    This page is used to inform visitors regarding my policies with the collection, use, and disclosure of Personal Information if anyone decided to use my Service.
    
    If you choose to use my Service, then you agree to the collection and use of information in relation to this policy. The Personal Information that I collect is used for providing and improving the Service. I will not use or share your information with anyone except as described in this Privacy Policy.
    
    The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible at N.I.T Group unless otherwise defined in this Privacy Policy.
    
    Information Collection and Use
    
    For a better experience, while using our Service, I may require you to provide us with certain personally identifiable information. The information that I request will be retained on your device and is not collected by me in any way.
    
    Log Data
    
    I want to inform you that whenever you use my Service, in a case of an error in the game I collect data and information (through third party products) on your phone called Log Data. This Log Data may include information such as your device Internet Protocol address, device name, operating system version, the configuration of the game when utilizing my Service, the time and date of your use of the Service, and other statistics.
    
    Cookies
    
    Our game doesn\'t use any cookies.
    
    Service Providers
    
    I may employ third-party companies and individuals due to the following reasons:
    
    To facilitate our Service;
    To provide the Service on our behalf;
    To perform Service-related services; or
    To assist us in analyzing how our Service is used.
    I want to inform users of this Service that these third parties have access to your Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they are obligated not to disclose or use the information for any other purpose.
    
    Security
    
    I value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and I cannot guarantee its absolute security.
    
    Links to Other Sites
    
    This Service may contain links to other sites. If you click on a third-party link, you will be directed to that site. Note that these external sites are not operated by me. Therefore, I strongly advise you to review the Privacy Policy of these websites. I have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.
    
    Children Privacy
    
    These Services do not address anyone under the age of 13. I do not knowingly collect personally identifiable information from children under 13. In the case I discover that a child under 13 has provided me with personal information, I immediately delete this from our servers. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact me so that I will be able to do necessary actions.
    
    Changes to This Privacy Policy
    
    I may update our Privacy Policy from time to time. Thus, you are advised to review this page periodically for any changes. I will notify you of any changes by posting the new Privacy Policy on this page. These changes are effective immediately after they are posted on this page.
    
    Contact Us
    
    If you have any questions or suggestions about my Privacy Policy, do not hesitate to contact me at ahmed.ncit@gmail.com.      
    </p>';
    $englishText  = '<p style="color:white;font-size:18px; "> Privacy Policy
        Ahmed Ibrahim built Alaaby as a Free game. This SERVICE is provided by N.I.T Group at no cost and is intended for use as is.
        
        This page is used to inform visitors regarding my policies with the collection, use, and disclosure of Personal Information if anyone decided to use my Service.
        
        If you choose to use my Service, then you agree to the collection and use of information in relation to this policy. The Personal Information that I collect is used for providing and improving the Service. I will not use or share your information with anyone except as described in this Privacy Policy.
        
        The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible at N.I.T Group unless otherwise defined in this Privacy Policy.
        
        Information Collection and Use
        
        For a better experience, while using our Service, I may require you to provide us with certain personally identifiable information. The information that I request will be retained on your device and is not collected by me in any way.
        
        Log Data
        
        I want to inform you that whenever you use my Service, in a case of an error in the game I collect data and information (through third party products) on your phone called Log Data. This Log Data may include information such as your device Internet Protocol address, device name, operating system version, the configuration of the game when utilizing my Service, the time and date of your use of the Service, and other statistics.
        
        Cookies
        
        Our game doesn\'t use any cookies.
        
        Service Providers
        
        I may employ third-party companies and individuals due to the following reasons:
        
        To facilitate our Service;
        To provide the Service on our behalf;
        To perform Service-related services; or
        To assist us in analyzing how our Service is used.
        I want to inform users of this Service that these third parties have access to your Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they are obligated not to disclose or use the information for any other purpose.
        
        Security
        
        I value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and I cannot guarantee its absolute security.
        
        Links to Other Sites
        
        This Service may contain links to other sites. If you click on a third-party link, you will be directed to that site. Note that these external sites are not operated by me. Therefore, I strongly advise you to review the Privacy Policy of these websites. I have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.
        
        Children Privacy
        
        These Services do not address anyone under the age of 13. I do not knowingly collect personally identifiable information from children under 13. In the case I discover that a child under 13 has provided me with personal information, I immediately delete this from our servers. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact me so that I will be able to do necessary actions.
        
        Changes to This Privacy Policy
        
        I may update our Privacy Policy from time to time. Thus, you are advised to review this page periodically for any changes. I will notify you of any changes by posting the new Privacy Policy on this page. These changes are effective immediately after they are posted on this page.
        
        Contact Us
        
        If you have any questions or suggestions about my Privacy Policy, do not hesitate to contact me at ahmed.ncit@gmail.com.      
        </p>';
    return json_encode(['arabic' => $arabicText, 'english' => $englishText]);
}

function change_password($userID)
{
    global $DB;
    $user = $DB->get_record('user', array("id" => $userID));
    if (!empty($user)) {
        $userPassword = $user->password;
        $oldPassword = $_GET["oldpassword"];
        $newPassword = $_GET["newpassword"];
        if (!empty($oldPassword) && !empty($newPassword)) {
            $reason = null;
            $usercheck = authenticate_user_login($user->username, $oldPassword, false, $reason, false);
            $userupdate = new stdClass();
            if (!empty($usercheck)) {
                $hashnewPassword = hash_internal_user_password($newPassword);
                $userupdate->id = $user->id;
                $userupdate->password = $hashnewPassword;
                $userupdate->id = $DB->update_record('user', $userupdate);
                if (!empty($userupdate->id)) {
                    return json_encode(['message' => 'passwordchanged']);
                }
            } else {
                return json_encode(['message' => 'incorrectpassword']);
            }
        }
    }
    return json_encode(['message' => 'passworderror']);
}

function signUp()
{
    global $DB;
    $userInfo = new stdClass();

    $yearInfo = new stdClass();
    $context = new stdClass();

    $yearMap = array("primary 1" => 1, "primary 2" => 2, "primary 3" => 3, "primary 4" => 4, "primary 5" => 5, "primary 6" => 6, "preparatory 1" => 7, "preparatory 2" => 8, "preparatory 3" => 9, "Secondary 1" => 10, "Secondary 2" => 11, "Secondary 3" => 12);

    try {

        $firstname = $_GET["firstname"];
        $lastname = $_GET["lastname"];
        $username = $_GET["username"];
        $email = $_GET["email"];
        $password = $_GET["password"];
        $uYear = $_GET["year"];
        $Phone = $_GET["studentPhone"];
        $parentPhone = $_GET["parentPhone"];
        //return json_encode([$firstname,$lastname,$username,$email,$uYear,$Phone,$parentPhone]);

    } catch (Exception $e) {
        echo json_encode(['message' => $e]);
    }

    if (!empty($firstname) && !empty($lastname) && !empty($username) && !empty($email) && !empty($password) && !empty($uYear) && !empty($Phone) && !empty($parentPhone)) {

        try {

            $getuserbyusername = $DB->get_record('user', array('username' => $username));
            if ($getuserbyusername != null) {
                return json_encode(["message" => "error usernameisused"]);
            }

            $getuserbyemail = $DB->get_record('user', array('email' => $email));
            if ($getuserbyemail != null) {
                return json_encode(["message" => "error emailisused"]);
            }


            $hashPass = hash_internal_user_password($password);

            $userInfo->firstname = $firstname;
            $userInfo->lastname = $lastname;
            $userInfo->username = $username;
            $userInfo->email = $email;
            $userInfo->password = $hashPass;
            $userInfo->phone1 = $Phone;
            $userInfo->phone2 = $parentPhone;
            $userInfo->confirmed = 1;
            $userInfo->mnethostid = 1;


            $userInfo->id = $DB->insert_record('user', $userInfo);

            $key = array_search(intval($uYear), $yearMap);

            $yearInfo->userid = $userInfo->id;
            $yearInfo->fieldid = 1;
            $yearInfo->data = $key;
            $yearInfo->dataformat = 0;


            $yearInfo->id = $DB->insert_record('user_info_data', $yearInfo);

            $context->contextlevel = 30;

            $context->instanceid = $userInfo->id;
            $context->depth = 2;
            $context->locked = 0;
            $context->id = $DB->insert_record('context', $context);
            $context->path = '/1/' . $context->id;
            $context->id = $DB->update_record('context', $context);

            $getContextid = $DB->get_record("context", array("instanceid" => $userInfo->id));

            $createSudent = new stdClass();
            $createSudent->roleid =  5;
            $createSudent->contextid = $getContextid->id;
            $createSudent->userid = $userInfo->id;
            $createSudent->modifierid = $userInfo->id;

            $createSudent->id = $DB->insert_record('role_assignments', $createSudent);


            return json_encode(["message" => "successful"]);
        } catch (Exception $e) {
            echo json_encode(['message' => $e]);
        }
    } else {
        return json_encode(["message" => "error empty"]);
    }
}

//signUp parant 

function signUpParent()
{
    global $DB;
    $userInfo = new stdClass();
    $context = new stdClass();
    try {

        $firstname = $_GET["firstname"];
        $lastname = $_GET["lastname"];
        $username = $_GET["username"];
        $email = $_GET["email"];
        $password = $_GET["password"];
        //$studentEmail = $_GET["studentEmail"];
        $parentPhone = $_GET["parentPhone"];
    } catch (Exception $e) {
        echo json_encode(['message' => $e]);
    }

    if (!empty($firstname) && !empty($lastname) && !empty($username) && !empty($email) && !empty($password) /*&& !empty($studentEmail)*/ && !empty($parentPhone)) {

        try {

            $getuserbyusername = $DB->get_record('user', array('username' => $username));
            if ($getuserbyusername != null) {
                return json_encode(["message" => "error usernameisused"]);
            }

            $getuserbyemail = $DB->get_record('user', array('email' => $email));
            if ($getuserbyemail != null) {
                return json_encode(["message" => "error emailisused"]);
            }

            //$selectStudent = $DB->get_record("user",array("email"=>$studentEmail));

            //if($selectStudent){

            //$selectStudent->id));

            //if($getContextid->id !== null){
            $hashPass = hash_internal_user_password($password);

            $userInfo->firstname = $firstname;
            $userInfo->lastname = $lastname;
            $userInfo->username = $username;
            $userInfo->email = $email;
            $userInfo->password = $hashPass;
            $userInfo->phone1 = $parentPhone;
            $userInfo->confirmed = 1;
            $userInfo->mnethostid = 1;


            $userInfo->id = $DB->insert_record('user', $userInfo);
            $get_user = $DB->get_record('user', array('username' => $userInfo->username));
            $context->contextlevel = 30;
            $context->instanceid = $get_user->id;
            $context->depth = 2;
            $context->locked = 0;
            $context->id = $DB->insert_record('context', $context);
            $context->path = '/1/' . $context->id;
            $context->id = $DB->update_record('context', $context);
            //$selectParentid = $DB->get_field('user', 'MAX(id)', array());
            $getContextid = $DB->get_record("context", array("instanceid" => $get_user->id));
            $createParent = new stdClass();
            $createParent->roleid =  9;
            $createParent->contextid = $getContextid->id;
            $createParent->userid = $get_user->id; //$selectParentid;
            $createParent->modifierid = $get_user->id; //$selectStudent->id;

            $create_result = $DB->insert_record('role_assignments', $createParent);

            if ($create_result) {
                //$get_user=$DB->get_record('user',array('username'=>$userInfo->username));
                //$res=create_child($studentEmail,$get_user->id,0);

                //if($res!='Error'){
                return json_encode(["message" => "successful"]);
                //}
            }
            //var_dump($createParent);
            //redirect($CFG->wwwroot."/login/index.php");


            /*}else{
                        return json_encode(["message"=> "error empty"]);
                    }
                
            /*}else{
                return json_encode(["message"=> "error empty"]);
            }*/
        } catch (Exception $e) {
            echo json_encode(['message' => $e]);
        }
    } else {

        return json_encode(["message" => "error empty"]);
    }
    return json_encode(["message" => "error empty"]);
}

//check if the user is a teacher or is a student

function check_isStudent($id)
{
    global $DB;
    $studentRole = $DB->get_field('role', 'id', array('shortname' => 'student'));
    $isStudent = $DB->record_exists('role_assignments', ['userid' => $id, 'roleid' => $studentRole]);
    $teacherRole = $DB->get_field('role', 'id', array('shortname' => 'editingteacher'));
    $isTeacher = $DB->record_exists('role_assignments', ['userid' => $id, 'roleid' => $teacherRole]);
    $parentRole = $DB->get_field('role', 'id', array('shortname' => 'parent'));
    $isParent = $DB->record_exists('role_assignments', ['userid' => $id, 'roleid' => $parentRole]);
    $admins = get_admins();
    $isadmin = false;
    foreach ($admins as $admin) {
        if ($id == $admin->id) {
            $isadmin = true;
            break;
        }
    }
    $roleassignments = $DB->get_records('role_assignments', ['userid' => $id]);
    $manager = false;
    foreach ($roleassignments as $role) {
        if ($role->roleid == 1) {
            $manager = true;
            break;
        }
    }

    if ($isadmin || $manager) {
        return json_encode(["message" => 'admin', 'id' => $id], 200);
    } elseif ($isStudent) {
        return json_encode(["message" => 'student', 'id' => $id], 200);
    } elseif ($isTeacher) {
        return json_encode(["message" => 'teacher', 'id' => $id], 200);
    } elseif ($isParent) {
        return json_encode(["message" => 'parent', 'id' => $id], 200);
    } else {
        return json_encode(["message" => 'Not Teacher Or a Student'], 200);
    }
}

function get_students_by_teacher_id($teacherId)
{
    global $DB;

    try {
        $sql = "SELECT DISTINCT u.id AS student_id, u.username AS student_username,
                       u.firstname AS student_firstname, u.lastname AS student_lastname
                FROM {user} AS u
                JOIN {role_assignments} AS ra ON u.id = ra.userid
                JOIN {context} AS ctx ON ra.contextid = ctx.id
                JOIN {role} AS r ON ra.roleid = r.id
                WHERE r.shortname = 'student' AND ctx.instanceid IN (
                    SELECT DISTINCT c.id
                    FROM {course} AS c
                    JOIN {context} AS ctx_course ON c.id = ctx_course.instanceid
                    JOIN {role_assignments} AS ra_course ON ctx_course.id = ra_course.contextid
                    JOIN {user} AS teacher ON ra_course.userid = teacher.id
                    WHERE teacher.id = :teacherid
                )
                ORDER BY u.id";

        $params = ['teacherid' => $teacherId];
        $students = $DB->get_records_sql($sql, $params);

        $studentData = [];
        foreach ($students as $student) {
            $studentData[] = [
                "student_id" => $student->student_id,
                "student_username" => $student->student_username,
                "student_firstname" => $student->student_firstname,
                "student_lastname" => $student->student_lastname,
            ];
        }

        $result = [
            "count" => count($studentData),
            "students" => $studentData,
        ];

        // Return the data as JSON
        return json_encode(["status" => 'success', "data" => $result], JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        // Handle exceptions or errors here
        return json_encode(["status" => 'error', "message" => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
}

//get all teachers in the site
function teachers()
{

    global $DB;

    $sql = "SELECT u.*, MAX(ra.roleid) AS max_roleid
        FROM mo_user AS u
        JOIN mo_role_assignments AS ra ON u.id = ra.userid
        WHERE ra.roleid = 3
        GROUP BY u.id
        ORDER BY u.id";

    $teachers = $DB->get_records_sql($sql);


    $roles = $DB->get_records('role_assignments', array('roleid' => 3));


    $teacherData = [];
    // Loop through the teachers and populate the data array
    foreach ($teachers as $teacher) {

        $imgUrl = upload_user_image($teacher->id);
        if (!empty($teacher->job)) {
            $my_jop = $teacher->job;
        } else {
            $my_jop = null;
        }
        $students = json_decode(get_students_by_teacher_id($teacher->id), true);

        // Check if students data is available
        $studentsCount = isset($students['data']['count']) ? $students['data']['count'] : 0;

        $rate = calculate_teacher_average_rating($teacher->id);
        $teacherData[] = [
            "id" => $teacher->id,
            "username" => $teacher->username,
            "firstname" => $teacher->firstname,
            "lastname" => $teacher->lastname,
            'job' => $my_jop,
            "img_url" => $imgUrl,
            "students" => $studentsCount,
            "rate" => $rate,
            // Add more fields as needed
        ];
    }

    $result = [
        "count" => count($teacherData),
        "teachers" => $teacherData
    ];

    // Return the teacher data as JSON
    return json_encode(["status" => 'success', "data" => $result]);
}

/* function getTeacherImage($teacherId) {
    require_once($CFG->dirroot . '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
    require_once($CFG->dirroot . '/course/renderer.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/user_handler/ccn_user_handler.php');

    $ccnUserHandler = new ccnUserHandler();
    $ccnUser = $ccnUserHandler->ccnGetUserDetails($teacherId);

    // Assuming $ccnUser has a property named 'rawAvatar' that contains the image URL
    $imgUrl = $ccnUser->rawAvatar;

    return $imgUrl;
} */

function generate_random_code($username)
{
    global $DB, $OUTPUT, $CFG;

    $ins = new stdClass();
    $code = "";
    $record = $DB->get_record('random_code', array('username' => $username));
    if (empty($record)) {
        $ins->user = $record->id;
        $ins->code = random_string(10);
        $code = $ins->code;
        $ins->id = $DB->insert_record('random_code', $ins);
    } else {
        $ins->id = $record->id;
        $ins->user = $USER->id;
        $ins->code = random_string(10);
        $code = $ins->code;
        $ins->id = $DB->update_record('random_code', $ins);
    }
    return $code;
}

//forget password function 
function forget_password($username)
{
    global $DB, $OUTPUT, $CFG;
    $user = "";
    $userData = $DB->get_records_sql("SELECT * FROM mo_user WHERE username='$username' or email='$username'");
    foreach ($userData as $userd) {
        $user = $userd;
    }

    // $user= $userData[0];

    // $code=generate_random_code($username);
    if (!empty($user)) {
        $phpmailer = new PHPMailer();
        $phpmailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.nitg-eg.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 26;
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->Username = 'noreply@nitg-eg.com';
        $phpmailer->Password = 'N.IT@202106';
        $phpmailer->setFrom('noreply@nitg-eg.com', 'Success Academy');
        $phpmailer->addAddress($user->email, $username);
        $phpmailer->Subject = 'Reset Password';
        $message = 'You should go to these link to change password <a href= ' . $CFG->wwwroot . '/academy/academyApi/confirm.php>Confirm Password</a>';
        $phpmailer->Body = $message;
        $phpmailer->IsHTML(true);
        if (!$phpmailer->send()) {
            return json_encode(["status" => "fail", "message" => "", 'error' => "Error: " . $phpmailer->ErrorInfo]);

            // echo "Mailer Error: " . $phpmailer->ErrorInfo;
        } else {
            echo json_encode(["status" => "success", "message" => "Sent", 'error' => ""], true);
        }
    } else {
        echo json_encode(["status" => "fail", "message" => "", 'error' => "username is not exist"]);
    }
}
function generate_random_string($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }

    return $randomString;
}



function login()
{
    echo  \core\session\manager::get_login_token();
}

//get related courses 
function get_related_courses($year, $id)
{
    global $DB, $OUTPUT, $CFG;
    $all_related_courses = $DB->get_records_sql("SELECT instanceid from mo_customfield_data where value='$year' ");
    $array = array();
    foreach ($all_related_courses as $courses) {

        array_push($array, $courses->instanceid);
    }
    $arrayImploded = implode(", ", $array);

    $courses = core_course_external::get_courses_by_field('ids', $arrayImploded);
    return json_encode(["relatedCourses" => array_values($courses["courses"]), "warning_course" => array_values($courses["warnings"])]);
}

//get all user feedback 
function get_user_feedbacks($userID)
{
    global $DB, $OUTPUT, $CFG;
    $checkfeedback = $DB->get_records_sql("SELECT * FROM mo_feedbacks WHERE user ='$userID'  ");
    $feedbacks = array();
    if (!empty($checkfeedback)) {
        foreach ($checkfeedback as $feedback) {
            $returnedusers = core_user_external::get_users_by_field(
                'id',
                array($feedback->teacher_id)
            );
            $feedback->teacher = $returnedusers[0];
            array_push($feedbacks, $feedback);
        }
        return json_encode(["feedbacks" => $feedbacks]);
    } else {
        return json_encode(["feedbacks" => "no feedbacks"]);
    }
}
function edit_description($text)
{
    $cleaner_input = strip_tags($text);
    return $cleaner_input;
}
function get_teacher_profile_data($teacherID)
{
    //teacher image link https://academy.nitg-eg.com/theme/edumy/images/teachers/656_f3.jpg
    global $DB, $OUTPUT, $CFG;
    //$userData = get_complete_user_data('id', $teacherID);
    //$getTeacher = $DB->get_records_sql('SELECT * FROM mo_user WHERE id=' . $teacherID . ' ');

    $getTeacher = [];
    $Teachers = $DB->get_records('user', array('id' => $teacherID));
    $t_array = [];
    foreach ($Teachers as $Teacher) {

        $imgUrl = upload_user_image($teacherID);
        $data = [
            'id' => $Teacher->id,
            'username' => $Teacher->username,
            'image' => $imgUrl,
            'firstname' => $Teacher->firstname,
            'secondname' => $Teacher->secondname,
            'thirdname' => $Teacher->thirdname,
            'lastname' => $Teacher->lastname,
            'readandwrite' => $Teacher->readandwrite,
            'academicqualification' => $Teacher->academicqualification,
            'scientificdegree' => $Teacher->scientificdegree,
            'job' => $Teacher->job,
            'email' => $Teacher->email,
            'phone1' => $Teacher->phone1,
            'phone2' => $Teacher->phone2,
            'coursetype' => $Teacher->coursetype,
            'city' => $Teacher->city,
            'address' => $Teacher->address,
            'description' => $Teacher->description,
        ];
        $t_array[] = $data;
    }
    $getTeacher[0]->teacher = $t_array;

    $userEnroledCourses = enrol_get_users_courses($teacherID);

    //$userEnroledCourses = core_enrol_external::get_users_courses($teacherID,true);
    //$rating=$DB->get_records_sql("SELECT ceil(AVG(rating)) as rating FROM `mo_teacher_rating` WHERE teacher_id=$teacherID");
    $check_enrolled_user = 0;
    $totalStudentsCountarray = [];
    $teacherCourses = array();
    foreach ($userEnroledCourses as $course) {
        if ($check_enrolled_user != 1) {
            $context = context_course::instance($course->id, MUST_EXIST);
            $enrol = is_enrolled($context, $userid, '', true);
            if ($enrol) {
                $check_enrolled_user = 1;
            }
        }
        $courselist = new core_course_list_element($course);
        $overviewfiles = array();
        foreach ($courselist->get_course_overviewfiles() as $file) {
            $fileurl = moodle_url::make_webservice_pluginfile_url(
                $file->get_contextid(),
                $file->get_component(),
                $file->get_filearea(),
                null,
                $file->get_filepath(),
                $file->get_filename()
            )->out(false);
            $overviewfiles[] = array(
                'filename' => $file->get_filename(),
                'fileurl' => $fileurl,
                'filesize' => $file->get_filesize(),
                'filepath' => $file->get_filepath(),
                'mimetype' => $file->get_mimetype(),
                'timemodified' => $file->get_timemodified(),
            );
        }

        require_once($CFG->dirroot . '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
        require_once($CFG->dirroot . '/course/renderer.php');
        require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
        require_once($CFG->dirroot . '/theme/edumy/ccn/user_handler/ccn_user_handler.php');
        // Initialize course handler
        $ccnCourseHandler = new ccnCourseHandler();
        // Retrieve course details
        $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($course->id);

        $view = $DB->get_record('course_views', array('courseid' => $ccnCourse->courseId));

        $course->image_url = $ccnCourse->imageUrl;

        $course->overviewfiles = $overviewfiles;

        $course->view = $view->visit;

        $coursecontacts = array();
        foreach ($courselist->get_course_contacts() as $contact) {
            $coursecontacts[] = array(
                'id' => $contact['user']->id,
                'fullname' => $contact['username'],
                'roles' => array_map(function ($role) {
                    return array('id' => $role->id, 'name' => $role->displayname);
                }, $contact['roles']),
                'role' => array('id' => $contact['role']->id, 'name' => $contact['role']->displayname),
                'rolename' => $contact['rolename']
            );
        }

        // Check if the teacher is among the contacts for this course
        $teacherFoundInContacts = false;
        foreach ($courselist->get_course_contacts() as $contact) {
            if ($contact['user']->id == $teacherID) {
                $teacherFoundInContacts = true;
                break;
            }
        }

        if ($teacherFoundInContacts) {
            // Query the database to count the students enrolled in this course
            $sql = "SELECT COUNT(DISTINCT ue.userid) AS student_count
        FROM {user_enrolments} ue
        INNER JOIN {enrol} e ON ue.enrolid = e.id
        WHERE e.courseid = :courseid
        AND e.enrol = 'manual'";
            $params = ['courseid' => $course->id];
            $studentCount = $DB->get_field_sql($sql, $params);

            // Add the student count for this course to the total count
            $totalStudentsCount += $studentCount;

            //$course->students = $studentCount;

            $course->contacts = $coursecontacts;
            $teacherCourses[] = $course;
            $totalStudentsCountarray[] = $studentCount;
        }
    }

    foreach ($totalStudentsCountarray as $count) {
        $total_students += $count;
    }

    //$userData->courses = array_values($userEnroledCourses);

    $getTeacher = array_values($getTeacher);
    $teachrerbio = $DB->get_record('user_info_data', array('userid' => $teacherID, 'fieldid' => 2));
    //$getTeacher[0]->bio = edit_description($teachrerbio->data);
    if ($check_enrolled_user == 1) {

        $getTeacher[0]->enrolled = 'yes';
    } else {

        $getTeacher[0]->enrolled = 'no';
    }
    $getTeacher[0]->courses = $teacherCourses; //concatinate course with teacher data

    //attach feedbacks to teacher data
    $feedBacks = array();
    $checkfeedback = $DB->get_records_sql("SELECT * FROM mo_feedbacks WHERE teacher_id ='$teacherID'  ");
    $checkfeedback = array_values($checkfeedback);
    foreach ($checkfeedback as $feedback) {
        $userData = get_complete_user_data('id', $feedback->user);
        $feedback->username = $userData->firstname;
        $feedback->userimage = $userData->url;
        $feedBacks[] = $feedback;
    }
    $getTeacher[0]->feedbacks = $feedBacks;

    // //attach photos
    $getTeacherPhotos = $DB->get_records_sql("SELECT * FROM mo_teachersphotos WHERE teacher_id= '$teacherID'");
    $getTeacher[0]->photos = array_values($getTeacherPhotos);

    // //attach videos
    // // get videos for a teacher
    $getVideos = $DB->get_records_sql("SELECT* FROM mo_vimeovedios WHERE teacher_id='$teacherID'");
    $getTeacher[0]->videos = array_values($getVideos);

    // //attach rating
    $rating = $DB->get_records_sql("SELECT ceil(AVG(rating)) as rating FROM `mo_teacher_rating` WHERE teacher_id=$teacherID");
    $rating = array_values($rating);
    $getTeacher[0]->rating = $rating[0]->rating;

    if (empty($getTeacher[0]->rating)) {
        $getTeacher[0]->rating = "0";
    }

    // teacher workshops
    $workshops = $DB->get_records('teacher_workshops', array('teacher_id' => $teacherID));

    $w_array = [];
    foreach ($workshops as $workshop) {
        $data = [
            'id' => $workshop->id,
            'teacher_id' => $workshop->teacher_id,
            'workshop' => $workshop->workshop,
        ];

        $w_array[] = $data;
    }
    $getTeacher[0]->workshops = $w_array;
    // teacher experience
    $experiences = $DB->get_records('teacher_exp', array('teacher_id' => $teacherID));

    $ex_array = [];
    foreach ($experiences as $experience) {
        $data = [
            'id' => $experience->id,
            'teacher_id' => $experience->teacher_id,
            'experience' => $experience->experience,
        ];

        $ex_array[] = $data;
    }
    $getTeacher[0]->experiences = $ex_array;
    // teacher obtained
    $obtaineds = $DB->get_records('teacher_courses_obtained', array('teacher_id' => $teacherID));

    $o_array = [];
    foreach ($obtaineds as $obtained) {
        $data = [
            'id' => $obtained->id,
            'teacher_id' => $obtained->teacher_id,
            'course' => $obtained->course,
        ];

        $o_array[] = $data;
    }
    $getTeacher[0]->obtained = $o_array;
    // teacher certificates
    $certificates = $DB->get_records('teacher_certificates', array('teacher_id' => $teacherID));

    $c_array = [];
    foreach ($certificates as $certificate) {
        $data = [
            'id' => $certificate->id,
            'teacher_id' => $certificate->teacher_id,
            'certificate' => $certificate->certificate,
        ];

        $c_array[] = $data;
    }
    $getTeacher[0]->certificates = $c_array;

    $getTeacher[0]->students_count = $total_students;

    return json_encode(['status' => 'success', 'data' => $getTeacher[0]]);
}


function search_user_by_course($email, $courseId)
{
    global $DB, $OUTPUT, $CFG;

    //$user = $DB->get_records_sql("SELECT * FROM `mo_user`WHERE `firstname` LIKE '%$email%' OR lastname LIKE '%$email%' ");

    $user = $DB->get_record('user', array('email' => $email));

    $userEnroledCourses = array();
    $userEnroledCourses = enrol_get_users_courses($user->id);
    $userEnroledCourses = array_values($userEnroledCourses);

    foreach ($userEnroledCourses as $course) {
        if ($course->id == $courseId) {
            return json_encode(["user" => $user]);
        }
    }
    return json_encode(["error" => 'no user found']);

    //return json_encode(["user" => array_values($user)]);

}

function get_user_by_id($userId)
{
    global $DB, $OUTPUT, $CFG;

    $user = $DB->get_record('user', array('id' => $userId));

    if (!empty($user)) {
        return json_encode(["user" => $user->firstname . " " . $user->lastname]);
    }
    return json_encode(["error" => 'no user found']);
}

function delete_contact_request($id, $requestedid)
{
    global $DB, $OUTPUT, $CFG;
    $data = $DB->delete_records('message_contact_requests', array('userid' => $id, 'requesteduserid' => $requestedid));
    if ($data == "true") {
        return json_encode(["message" => 'deleted']);
    } else {
        return json_encode(["message" => 'error']);
    }
    // $user=$DB->get_records_sql("SELECT * FROM mo_message_contact_requests WHERE userid= '$id' and requesteduserid='$requestedid' ");
    // if(empty($user) ){
    //     return json_encode(["message"=> 'deleted']);
    // }
    // else{
    //     return json_encode(["message"=> 'error']);
    // }

}

function get_contact_requests_sent($id, $requestedid)
{
    global $DB, $OUTPUT, $CFG;
    $user = $DB->get_records_sql("SELECT * FROM mo_message_contact_requests WHERE userid= '$id' and requesteduserid='$requestedid' ");

    if (empty($user)) {
        return json_encode(["message" => 'no']);
    } else {
        return json_encode(["message" => 'yes']);
    }
}

function get_enrol_courses($id)
{
    global $DB, $OUTPUT, $CFG;
    require_once($CFG->dirroot . '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
    require_once($CFG->dirroot . '/course/renderer.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/user_handler/ccn_user_handler.php');
    $i = 0;
    $userEnroledCourses = core_enrol_external::get_users_courses($id, true);
    //return json_encode(['teacher'=>$userEnroledCourses]);
    $EnroledCourses = enrol_get_users_courses($id);
    //return json_encode(["courses"=>$EnroledCourses]);
    $enrolCourses = array();
    foreach ($EnroledCourses as $course) {
        // Initialize course handler
        $ccnCourseHandler = new ccnCourseHandler();
        // Retrieve course details
        $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($course->id);



        $userEnroledCourses[$i]['image_url'] = $ccnCourse->imageUrl;



        $courselist = new core_course_list_element($course);
        /*$overviewfiles = array();
            foreach ($courselist->get_course_overviewfiles() as $file) {
                $fileurl = moodle_url::make_webservice_pluginfile_url($file->get_contextid(), $file->get_component(),
                                                                        $file->get_filearea(), null, $file->get_filepath(),
                                                                        $file->get_filename())->out(false);
                $overviewfiles[] = array(
                    'filename' => $file->get_filename(),
                    'fileurl' => $fileurl,
                    'filesize' => $file->get_filesize(),
                    'filepath' => $file->get_filepath(),
                    'mimetype' => $file->get_mimetype(),
                    'timemodified' => $file->get_timemodified(),
                );
            }
			$course->overviewfiles = $overviewfiles;*/

        $coursecontacts = array();
        foreach ($courselist->get_course_contacts() as $contact) {
            $coursecontacts[] = array(
                'id' => $contact['user']->id,
                'fullname' => $contact['username'],
                'roles' => array_map(function ($role) {
                    return array('id' => $role->id, 'name' => $role->displayname);
                }, $contact['roles']),
                'role' => array('id' => $contact['role']->id, 'name' => $contact['role']->displayname),
                'rolename' => $contact['rolename']
            );
        }
        //$course->contacts = $coursecontacts;
        $userEnroledCourses[$i]['contacts'] = $coursecontacts;
        $i++;

        //$enrolCourses[] = $course;
    }


    return json_encode(["status" => 'success', "courses" => $userEnroledCourses]);
    //return json_encode(["courses"=>$enrolCourses]);
}

function add_module_completion($userid, $moduleid)
{
    global $DB, $OUTPUT, $CFG;

    $checkexists = $DB->record_exists('course_modules_completion', array('coursemoduleid' => $moduleid, 'userid' => $userid));
    if (!$checkexists) {
        $data = new stdClass();
        $data->coursemoduleid = $moduleid;
        $data->userid = $userid;
        $data->completionstate = 1;
        $data->timemodified = time();

        $success = $DB->insert_record('course_modules_completion', $data);
        if ($success) {
            return json_encode(['status' => 'success', 'data' => $success]);
        } else {
            return json_encode(['staus' => 'fail', 'data' => null]);
        }
    }
}

function get_child_courses($id)
{
    global $DB, $OUTPUT, $CFG;
    $i = 0;
    //$userEnroledCourses = core_enrol_external::get_users_courses($id,true);
    //return json_encode(['teacher'=>$userEnroledCourses]);
    $EnroledCourses = enrol_get_users_courses($id);
    //return json_encode(["courses"=>$EnroledCourses]);
    $enrolCourses = array();
    foreach ($EnroledCourses as $course) {

        $courselist = new core_course_list_element($course);
        $overviewfiles = array();
        foreach ($courselist->get_course_overviewfiles() as $file) {
            $fileurl = moodle_url::make_webservice_pluginfile_url(
                $file->get_contextid(),
                $file->get_component(),
                $file->get_filearea(),
                null,
                $file->get_filepath(),
                $file->get_filename()
            )->out(false);
            $overviewfiles[] = array(
                'filename' => $file->get_filename(),
                'fileurl' => $fileurl,
                'filesize' => $file->get_filesize(),
                'filepath' => $file->get_filepath(),
                'mimetype' => $file->get_mimetype(),
                'timemodified' => $file->get_timemodified(),
            );
        }
        $course->overviewfiles = $overviewfiles;

        $coursecontacts = array();
        foreach ($courselist->get_course_contacts() as $contact) {
            $coursecontacts[] = array(
                'id' => $contact['user']->id,
                'fullname' => $contact['username'],
                'roles' => array_map(function ($role) {
                    return array('id' => $role->id, 'name' => $role->displayname);
                }, $contact['roles']),
                'role' => array('id' => $contact['role']->id, 'name' => $contact['role']->displayname),
                'rolename' => $contact['rolename']
            );
        }
        $course->contacts = $coursecontacts;
        $enrolCourses[] = $course;
        //$enrolCourses[$i]['contacts'] = $coursecontacts;
        $i++;
        //$enrolCourses[] = $course;
    }

    //return json_encode(["courses"=>$userEnroledCourses]);
    return json_encode(["courses" => $enrolCourses]);
}

function add_teacher_rating($studentID, $teacherID, $rating)
{
    global $DB, $OUTPUT, $CFG;
    $ins = new stdClass();

    $ins->rating = $rating;

    $ins->teacher_id = $teacherID;
    $ins->user = $studentID;
    $record = $DB->get_record('teacher_rating', array('user' => $studentID, 'teacher_id' => $teacherID));
    if (empty($record)) {
        $ins->id = $DB->insert_record('teacher_rating', $ins);
        //return json_encode(['message'=>$ins]);
    } else {
        $ins->id = $record->id;
        $ins->id = $DB->update_record('teacher_rating', $ins);
    }

    return json_encode(['message' => 'ratingadded']);
}

function add_student_feedback($studentID, $teacherID, $courseID, $feedBack)
{
    global $DB, $OUTPUT, $CFG;

    $ins = new stdClass();
    $ins->feedback = $feedBack;
    $ins->title = 'feedBack';
    $ins->course = $courseID;
    $ins->teacher_id = $teacherID;
    $ins->user = $studentID;
    $ins->id = $DB->insert_record('feedbacks', $ins);

    return json_encode(['message' => 'feedbackadded']);
}

function delete_student_feedback($feedBackID)
{
    global $DB, $OUTPUT, $CFG;

    $ins = new stdClass();

    $ins->id = $DB->delete_records('feedbacks', array('id' => $feedBackID));

    return json_encode(['message' => 'feedbackdeleted']);
}

function add_teacher_images($id)
{
    global $DB, $OUTPUT, $CFG;
    $postImageName = $_FILES['image']['name'];
    $postImageTemp = $_FILES['image']['tmp_name'];
    $postImage = rand(0, 1000) . "_" . $postImageName;
    $uploadFiles = move_uploaded_file($postImageTemp, $CFG->dirroot . "/theme/edumy/images/teachers/" . $postImage);
    if ($uploadFiles) {
        $insertData = $DB->execute("INSERT INTO mo_teachersphotos(teacher_id,photos) VALUE('$id', '$postImage')   ");

        return json_encode(['message' => 'image added']);
    } else {
        return json_encode(['message' => 'error']);
    }
}

function add_teacher_videos($id)
{
    global $DB, $OUTPUT, $CFG;
    $video = $_POST['videoLink'];
    $tag = '<div style="padding:55% 0 0 0;position:relative;">';
    $closingTag = "</div>";
    if (strpos($video, $closingTag) == true) {
        $video = str_replace($closingTag, " ", $video);
        $video = str_replace($tag, " ", $video);
    }
    $ins = new stdClass();
    $ins->videos =  $video;
    $ins->teacher_id = $id;
    $ins->id = $DB->insert_record('teachervideos', $ins);
    if ($ins) {
        return json_encode(['message' => 'video uploaded']);
    } else {
        return json_encode(['message' => 'error']);
    }
}

function delete_teacher_videos($id)
{
    global $DB, $OUTPUT, $CFG;
    $sql = "DELETE FROM mo_vimeovedios WHERE id=$id";
    $DB->execute($sql);
    return json_encode(['message' => 'video deleted']);
}

function delete_teacher_images($id)
{
    global $DB, $OUTPUT, $CFG;
    $sql = "DELETE FROM mo_teachersphotos WHERE id=$id";
    $DB->execute($sql);
    return json_encode(['message' => 'image deleted']);
}

function upload_image($id)
{
    global $DB, $OUTPUT, $CFG;
    $postImageName = $_FILES['image']['name'];
    $postImageTemp = $_FILES['image']['tmp_name'];
    $postImage = rand(0, 1000) . "_" . $postImageName;
    $uploadFiles = move_uploaded_file($postImageTemp, $CFG->dirroot . "/theme/edumy/images/teachers/" . $postImage);
    $checkUser = $DB->get_records_sql("SELECT * FROM mo_user WHERE id = '$id'");
    if ($uploadFiles) {
        $DB->execute(" UPDATE mo_user SET url= '$postImage' WHERE id = '$id' ");
        return json_encode(['message' => 'image uploaded']);
    } else {
        return json_encode(['message' => 'error']);
    }
}

function get_teacher_image($teacherid)
{
    global $DB, $OUTPUT, $CFG;
    $getTeacher = $DB->get_records_sql('SELECT firstname,lastname FROM mo_user WHERE id=' . $teacherid . ' ');
    $getTeacher = array_values($getTeacher);

    $url = upload_user_image($teacherid);

    return json_encode(['image' => $url, 'fullname' => $getTeacher[0]->firstname . " " . $getTeacher[0]->lastname]);
}

function edit_user_data($userid, $firstname, $lastname, $phone1, $phone2)
{
    global $DB, $OUTPUT, $CFG;
    try {

        if (!empty($firstname)) {
            $DB->execute(" UPDATE mo_user SET firstname= '$firstname' WHERE id = '$userid' ");
        }
        if (!empty($lastname)) {
            $DB->execute(" UPDATE mo_user SET lastname= '$lastname' WHERE id = '$userid' ");
        }
        if (!empty($phone1)) {
            $DB->execute(" UPDATE mo_user SET phone1= '$phone1' WHERE id = '$userid' ");
        }
        if (!empty($phone2)) {
            $DB->execute(" UPDATE mo_user SET phone2= '$phone2' WHERE id = '$userid' ");
        }
    } catch (Exception $e) {
        return json_encode(['message' => 'error']);
    }

    return json_encode(['message' => 'done']);
}

function get_course_descriptions($coursId)
{
    global $DB, $OUTPUT, $CFG;
    $ins = new stdClass();

    $cDesc = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 15));
    $ins->courseDesc = $cDesc->value;

    $obj = array();
    $obj[0] = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 2));
    $obj[1] = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 3));
    $obj[2] = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 4));
    $obj[3] = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 5));
    $obj[4] = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 6));
    $obj[5] = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 7));
    $obj[6] = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 8));
    $obj[7] = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 9));
    $obj[8] = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 10));
    $obj[9] = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 11));

    $coursePrice = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 12));
    $CourseDuration = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 13));
    $ins->coursePrice = $coursePrice->value;
    $ins->CourseDuration = $CourseDuration->value;

    $Allenrolusers = $DB->get_records_sql("SELECT count(*)as c From mo_user_enrolments x,mo_enrol y where x.enrolid=y.id and y.courseid='$coursId'");
    $Allenrolusers = array_values($Allenrolusers);
    $ins->allenrolusers = $Allenrolusers[0]->c;


    $objects = array();

    foreach ($obj as $element) {
        if ($element->value != null) {
            $ins_obj = new stdClass();
            $ins_obj->value = $element->value;
            array_push($objects, $ins_obj);
        }
    }
    $ins->objectives = $objects;

    $promo = $DB->get_record('customfield_data', array('instanceid' => $coursId, 'fieldid' => 22));
    if ($promo != null) {
        $ins->promo = 'true';
    } else {
        $ins->promo = 'false';
    }


    return json_encode(['message' => $ins]);
}

function get_user_name($userId)
{
    global $DB, $OUTPUT, $CFG;
    //$userData = get_complete_user_data('id', $teacherID);
    $getUser = $DB->get_records_sql('SELECT firstname,lastname,username,phone1,phone2 FROM mo_user WHERE id=' . $userId . ' ');
    $center = $DB->get_record('optional_data_aibrahim', array('userid' => $userId));
    $getUser = array_values($getUser);
    $userData = $getUser[0];
    $userData->centername = $center->empty; //center name
    $userData->schooname = $center->school;
    //return json_encode(['data' => $getUser[0]]);
    return json_encode(['data' => $userData]);
}


function create_conversation($userids)
{
    global $DB, $OUTPUT, $CFG;
    //return \core_message\api::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL;
    sort($userids);
    $conversation = new stdClass();
    $conversation->convhash = null;
    $conversation->convhash = sha1(implode('-', $userids));
    if ($record = $DB->get_record('message_conversations', ['convhash' => $conversation->convhash])) {
        return json_encode([$record->id]);
    }
    $conversation->type = 1;
    $conversation->enabled = 1;
    $conversation->timecreated = time();
    $conversation->timemodified = $conversation->timecreated;
    $conversation->id = $DB->insert_record('message_conversations', $conversation);
    $arrmembers = [];
    foreach ($userids as $userid) {
        $member = new stdClass();
        $member->conversationid = $conversation->id;
        $member->userid = $userid;
        $member->timecreated = time();
        $member = $DB->insert_record('message_conversation_members', $member);

        $arrmembers[] = $member;
    }

    $conversation->members = $arrmembers;

    return json_encode([$conversation->id]);
}
function remove_conversation($conversationId)
{
    global $DB;
    $data = $DB->delete_records('message_conversations', array('id' => $conversationId));
    if ($data) {
        return 'deleted';
    } else {
        return 'error';
    }
}

function get_teacher_years($teacherId)
{
    global $DB, $OUTPUT, $CFG;
    $years = $DB->get_records_sql("SELECT * FROM mo_teacher_years WHERE teacherID= '$teacherId' ");
    $years = array_values($years);
    return json_encode($years);
}

function get_h5p_result($courseId)
{
    global $DB, $OUTPUT, $CFG;
    $h5p = new stdClass();
    $h5p = $DB->get_records_sql("SELECT * FROM mo_hvp WHERE course= '$courseId' ");
    $h5p = array_values($h5p);
    $id = $h5p[0]->id;
    $result = new stdClass();
    $result = $DB->get_records_sql("SELECT * FROM mo_hvp_xapi_results WHERE content_id= '$id' ");
    return json_encode($result);
}

function insert_course_reservation($userId, $courseId)
{
    global $DB;

    $ins = new stdClass();
    $ins->userid = $userId;
    $ins->course = $courseId;
    //$ins->timecreated=date('Y-d-m H:i:s',time());
    // $yearMap=array("primary 1"=>1, "primary 2"=>2, "primary 3"=>3, "primary 4"=>4,"primary 5"=>5,"primary 6"=>6,"preparatory 1"=>7,"preparatory 2"=>8,"preparatory 3"=>9,"Secondary 1"=>10,"Secondary 2"=>11,"Secondary 3"=>12);
    $yearMap = array(1 => "primary 1", 2 => "primary 2", 3 => "primary 3", 4 => "primary 4", 5 => "primary 5", 6 => "primary 6", 7 => "preparatory 1", 8 => "preparatory 2", 9 => "preparatory 3", 10 => "Secondary 1", 11 => "Secondary 2", 12 => "Secondary 3");
    $userYear = $DB->get_record('user_info_data', array('userid' => $userId, 'fieldid' => 1));
    $key = array_search($userYear->data, $yearMap);
    // return $key;
    $courseYear = $DB->get_record('customfield_data', array('instanceid' => $courseId, 'fieldid' => 1));
    // return $courseYear;
    if ($key == $courseYear->value) {
        $res = $DB->insert_record('course_reservation', $ins);
        if ($res) {
            return json_encode(["data" => 'Successfully']);
        }
    } else {
        return json_encode(["data" => 'NotAllowed']);
    }




    return json_encode(["data" => 'Error']);
}

function delete_course_reservation($userId, $courseId)
{
    global $DB;

    $res = $DB->delete_records('course_reservation', array('userid' => $userId, 'course' => $courseId));

    if ($res) {
        return json_encode(["data" => 'deleted']);
    }

    return json_encode(["data" => 'Error']);
}

function is_course_reserved($userId, $courseId)
{
    global $DB;

    $record = $DB->get_record('course_reservation', array('userid' => $userId, 'course' => $courseId, 'accept' => 0));

    if (!empty($record)) {
        return json_encode(["data" => 'true']);
    }

    return json_encode(["data" => 'false']);
}

function all_course_reservations()
{
    global $DB;
    //  $usersReserve = $DB->get_records_sql("SELECT courser.id,
    //                         user.id as userid,concat(user.firstname , ' ', user.lastname)as fullname ,user.url as image,user.phone1 as phone ,user.email,courser.course
    //                         FROM mo_course_reservation courser
    //                         JOIN mo_user user ON courser.userid = user.id
    //                         WHERE courser.accept=0 and user.deleted = 0

    //     ");
    $usersReserve = $DB->get_records_sql("SELECT courser.id,
    user.id as userid,concat(user.firstname , ' ', user.lastname)as fullname ,user.phone1 as phone ,user.email,courser.course
    FROM mo_course_reservation courser
    JOIN mo_user user ON courser.userid = user.id
    WHERE courser.accept=0 and user.deleted = 0

 ");

    $usersReserve = array_values($usersReserve);
    $final_data = array();

    foreach ($usersReserve as $user) {

        $teachers = $DB->get_records_sql("SELECT u.id As id,concat(u.firstname , ' ', u.lastname)as teachername, c.fullname As coursename
                            FROM   mo_course c
                            LEFT OUTER JOIN   mo_context cx ON c.id = cx.instanceid
                            LEFT OUTER JOIN   mo_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '3'
                            LEFT OUTER JOIN   mo_user u ON ra.userid = u.id 
                            WHERE cx.contextlevel = '50' AND c.id= '$user->course'");
        $teachers = array_values($teachers);
        $teacher = $teachers[0];

        $user->teachername = $teacher->teachername;
        $user->coursename = $teacher->coursename;

        array_push($final_data, $user);
    }


    return json_encode(['data' => $final_data]);
}

function all_accept_course_reservations()
{
    global $DB;

    //  $usersReserve = $DB->get_records_sql("SELECT courser.id,
    //                         user.id as userid,concat(user.firstname , ' ', user.lastname)as fullname ,user.url as image,user.phone1 as phone ,user.email,courser.course
    //                         FROM mo_course_reservation courser
    //                         JOIN mo_user user ON courser.userid = user.id
    //                         WHERE courser.accept=1 and user.deleted = 0

    //     ");
    $usersReserve = $DB->get_records_sql("SELECT courser.id,
    user.id as userid,concat(user.firstname , ' ', user.lastname)as fullname ,user.phone1 as phone ,user.email,courser.course
    FROM mo_course_reservation courser
    JOIN mo_user user ON courser.userid = user.id
    WHERE courser.accept=1 and user.deleted = 0

 ");
    $usersReserve = array_values($usersReserve);
    $final_data = array();

    foreach ($usersReserve as $user) {

        $teachers = $DB->get_records_sql("SELECT u.id As id,concat(u.firstname , ' ', u.lastname)as teachername, c.fullname As coursename
                           FROM   mo_course c
                           LEFT OUTER JOIN   mo_context cx ON c.id = cx.instanceid
                           LEFT OUTER JOIN   mo_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '3'
                           LEFT OUTER JOIN   mo_user u ON ra.userid = u.id 
						   WHERE cx.contextlevel = '50' AND c.id= '$user->course'");
        $teachers = array_values($teachers);
        $teacher = $teachers[0];

        $user->teachername = $teacher->teachername;
        $user->coursename = $teacher->coursename;

        array_push($final_data, $user);
    }


    return json_encode(['data' => $final_data]);
}

function accept_user_reservation($userId, $courseId)
{
    global $DB;

    $record = $DB->get_record('course_reservation', array('userid' => $userId, 'course' => $courseId, 'accept' => 0));
    if (!empty($record)) {
        $res = new stdClass();
        $res->id = $record->id;
        $res->accept = 1;
        $state = $DB->update_record('course_reservation', $res);
        // return $response_end;
        if ($state) {
            return json_encode(["data" => 'Successfully']);
        }
    }

    return json_encode(["data" => 'error']);
}

function get_courses_by_category($categoryid)
{
    global $DB;
    $courses = $DB->get_records_sql("SELECT * FROM mo_course WHERE category= $categoryid");
    $courses = array_values($courses);
    $final_data = array();
    $teacherCourses = array();
    foreach ($courses as $course) {

        $courselist = new core_course_list_element($course);
        $overviewfiles = array();
        foreach ($courselist->get_course_overviewfiles() as $file) {
            $fileurl = moodle_url::make_webservice_pluginfile_url(
                $file->get_contextid(),
                $file->get_component(),
                $file->get_filearea(),
                null,
                $file->get_filepath(),
                $file->get_filename()
            )->out(false);
            $overviewfiles[] = array(
                'filename' => $file->get_filename(),
                'fileurl' => $fileurl,
                'filesize' => $file->get_filesize(),
                'filepath' => $file->get_filepath(),
                'mimetype' => $file->get_mimetype(),
                'timemodified' => $file->get_timemodified(),
            );
        }
        $course->overviewfiles = $overviewfiles;

        $coursecontacts = array();
        /*foreach ($courselist->get_course_contacts() as $contact) {
            $coursecontacts[] = array(
                'id' => $contact['user']->id,
                'fullname' => $contact['username'],
                'roles' => array_map(function($role){
                    return array('id' => $role->id, 'name' => $role->displayname);
                }, $contact['roles']),
                'role' => array('id' => $contact['role']->id, 'name' => $contact['role']->displayname),
                'rolename' => $contact['rolename']
            );
        }*/
        $teachers = $DB->get_records_sql("SELECT u.id As id,concat(u.firstname , ' ', u.lastname)as fullname, c.fullname As coursename
                           FROM   mo_course c
                           LEFT OUTER JOIN   mo_context cx ON c.id = cx.instanceid
                           LEFT OUTER JOIN   mo_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '3'
                           LEFT OUTER JOIN   mo_user u ON ra.userid = u.id 
						   WHERE cx.contextlevel = '50' AND c.id= '$course->id'");
        $teachers = array_values($teachers);
        $teacher = $teachers[0];
        if (!empty($teacher->id)) {
            $coursecontacts[] = $teacher;
        }
        $course->contacts = $coursecontacts;
        $teacherCourses[] = $course;
    }
    return json_encode(['data' => $teacherCourses]);
}
function get_count_students($course)
{
    global $DB;
    $Allenrolusers = $DB->get_records_sql("SELECT u.id  from mo_enrol as enroll join mo_user_enrolments as ue on enroll.id=ue.enrolid
    join mo_user as u on u.id=ue.userid join mo_role_assignments as ra on u.id=ra.userid
    where ra.roleid=5 and enroll.courseid=" . $course . "
    GROUP by u.id");
    return count($Allenrolusers);
}
function create_child($email, $parentid, $phone1, $check = 0)
{
    global $DB;
    $parent = $DB->get_record('user', array('id' => $parentid));
    $user = $DB->get_record('user', array('email' => $email, 'phone1' => $phone1));
    $studentRole = $DB->get_field('role', 'id', array('shortname' => 'student'));
    $isStudent = $DB->record_exists('role_assignments', ['userid' => $user->id, 'roleid' => $studentRole]);
    if ($isStudent) {
        $check_id = $DB->get_record('parent_child', array('parentid' => $parentid, 'childid' => $user->id));
        if (!$check_id) {
            if ($parent->phone1 == $user->phone2) {
                $ins = new stdClass();
                $ins->parentid = $parentid;
                $ins->childid = $user->id;
                $res = $DB->insert_record('parent_child', $ins);
                $getContextid = $DB->get_record("context", array("instanceid" => $user->id));
                $createParent = new stdClass();
                $createParent->roleid =  9;
                $createParent->contextid = $getContextid->id;
                $createParent->userid = $parentid; //$selectParentid;
                $createParent->modifierid = $user->id; //$selectStudent->id;
                $create_result = $DB->insert_record('role_assignments', $createParent);
                if ($create_result) {
                    if ($check == 0) {
                        return 'Successfully created';
                    } else {
                        return json_encode(['data' => 'Successfully']);
                    }
                }
            } else {
                return json_encode(['data' => 'Not your child']);
            }
        } else {
            return json_encode(['data' => 'Already exist']);
        }
    } else {
        return json_encode(['data' => 'Error the user is not a student']);
    }
}

function get_parent_data($parent)
{
    global $DB;
    $childs = $DB->get_records_sql('SELECT  p.childid,u.firstname,u.lastname from mo_parent_child as p join mo_user as u on u.id=p.childid where parentid=' . $parent . '');
    foreach ($childs as $child) {
        $child->url = upload_user_image($child->childid);
    }
    return json_encode(['status' => 'success', 'childs' => array_values($childs)]);
}

//carts
function add_to_cart($user, $course)
{
    global $DB;
    $data = new stdClass();
    $data->user = $user;
    $data->course = $course;
    $data->id = $DB->insert_record('cart', $data);
    if (empty($data->id)) {
        return json_encode(['data' => 'error']);
    } else {
        $ins = new stdClass();
        $ins->user = $user;
        $ins->course = $course;
        $ins->status = "user added the course to his cart";
        $DB->insert_record('history_cart_data', $ins);
        return json_encode(['status' => 'success', 'data' => 'added']);
    }
}
function get_user_cart($user, $token = 0)
{
    global $DB, $CFG;
    $carts = $DB->get_records_sql("SELECT cart.id as id ,concat(u.firstname , ' ', u.lastname) As teachername , c.fullname as coursename ,cart.course as courseid ,u.id as teacherid ,cd.value as price
	FROM mo_course as c 
    JOIN mo_cart as cart ON cart.course=c.id 
    LEFT OUTER JOIN   mo_context cx ON c.id = cx.instanceid
    LEFT OUTER JOIN   mo_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '3'
    LEFT OUTER JOIN   mo_user u ON ra.userid = u.id 
    LEFT OUTER JOIN mo_customfield_data cd ON c.id=cd.instanceid
    WHERE cx.contextlevel = '50'  AND cd.fieldid=10 AND cart.user=" . $user . "");
    // $final_data=array();
    $total = 0;
    foreach ($carts as $cart) {
        $course = $DB->get_record("course", array('id' => $cart->courseid));
        $courselist = new core_course_list_element($course);
        $overviewfiles = array();

        if ($token != 0) {
            foreach ($courselist->get_course_overviewfiles() as $file) {
                $fileurl = moodle_url::make_webservice_pluginfile_url(
                    $file->get_contextid(),
                    $file->get_component(),
                    $file->get_filearea(),
                    null,
                    $file->get_filepath(),
                    $file->get_filename()
                )->out(false);
                $overviewfiles[] = array(
                    'filename' => $file->get_filename(),
                    'fileurl' => $fileurl,
                    'filesize' => $file->get_filesize(),
                    'filepath' => $file->get_filepath(),
                    'mimetype' => $file->get_mimetype(),
                    'timemodified' => $file->get_timemodified(),
                );
            }
            $cart->overviewfiles = $overviewfiles[0]['fileurl'] . "?token=" . $token;
            $total += $cart->price;
        } else {
            $url = "";
            foreach ($courselist->get_course_overviewfiles() as $file) {
                $isimage = $file->is_valid_image();
                $url = file_encode_url("{$CFG->wwwroot}/pluginfile.php", '/' . $file->get_contextid() . '/' . $file->get_component() . '/' . $file->get_filearea() . $file->get_filepath() . $file->get_filename(), !$isimage);
            }
            $cart->overviewfiles = $url;
            $total += $cart->price;
        }
    }
    return json_encode(array('status' => 'success', 'user_cart' => array_values($carts), 'items' => sizeof($carts), 'total' => $total));
}
function remove_from_cart($user, $course)
{
    global $DB;
    $data = $DB->delete_records('cart', array('user' => $user, 'course' => $course));
    if ($data) {
        $ins = new stdClass();
        $ins->user = $user;
        $ins->course = $course;
        $ins->status = "user removed the course to his cart";
        $DB->insert_record('history_cart_data', $ins);
        return json_encode(['status' => 'success', 'data' => 'deleted']);
    } else {

        return json_encode(['status' => 'fail', 'data' => 'error']);
    }
}
function check_course_in_the_cart_of_the_user($user, $course)
{
    global $DB;
    $record = $DB->get_record('cart', array('user' => $user, 'course' => $course));
    if (!empty($record)) {
        return json_encode(['status' => 'success', 'data' => 'true']);
    } else {
        return json_encode(['status' => 'fail', 'data' => 'false']);
    }
}
function get_user_wallet_data($user)
{
    global $DB;
    $wallet = $DB->get_record("wallet", array('user' => $user));
    if (empty($wallet)) {
        return json_encode(['data' => 'error:empty']);
    } else {
        return json_encode(['data' => $wallet]);
    }
}
function check_wallet_secret_key($user, $secret)
{
    global $DB;
    $wallet = $DB->get_record("wallet", array('user' => $user, 'secret' => $secret));
    if (empty($wallet)) {
        return json_encode(['error' => 'error:wrongSecret']);
    } else {
        return json_encode(['data' => $wallet]);
    }
}
function forget_wallet_secret($id, $confirm)
{
    global $DB;
    $user = $DB->get_record('user', array("id" => $id));
    // $code=generate_random_code($username);
    if (!empty($user)) {
        $phpmailer = new PHPMailer();
        $phpmailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.nitg-eg.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 26;
        $phpmailer->SMTPSecure = 'tls';
        $phpmailer->Username = 'noreply@nitg-eg.com';
        $phpmailer->Password = 'N.IT@202106';
        $phpmailer->setFrom('noreply@nitg-eg.com', 'Success Academy');
        $phpmailer->addAddress($user->email, $user->username);
        $phpmailer->Subject = 'Reset Password';
        // $message = 'You should go to these link to change password <a href= ' . $CFG->wwwroot . '/json/confirm.php>Confirm Password</a>';
        $code = '';
        if ($confirm == 0) {
            $code = generate_random_string(5);
            $message = "Your code is : " . $code . " you can go again to the form and write the code then the new secret key will be generated";
        } else {
            $data = $DB->get_record('wallet', array('user' => $id));
            $message = "Your new Secret is : " . $data->secret . " . Now,you can go open your wallet";
        }
        $phpmailer->Body = $message;
        $phpmailer->IsHTML(true);
        if (!$phpmailer->send()) {
            echo "Mailer Error: " . $phpmailer->ErrorInfo;
        } else {
            if ($confirm == 0) {
                $record = $DB->get_record('secret_user_wallet_code', array('user' => $user->id));
                if (empty($record)) {
                    $ins = new stdClass();

                    $ins->user = $user->id;
                    $ins->code = $code;
                    $ins->id = $DB->insert_record('secret_user_wallet_code', $ins);
                } else {
                    $ins = new stdClass();
                    $ins->id = $record->id;
                    $ins->code = $code;
                    $data = $DB->update_record('secret_user_wallet_code', $ins);
                }
            }


            return json_encode(["message" => 'sent'], true);
        }
    } else {


        return json_encode(["message" => "username is not exist"]);
    }
}
function generate_new_secret($user, $code)
{
    global $DB;
    $check_code = $DB->get_record('secret_user_wallet_code', array('user' => $user, 'code' => $code));
    if (empty($check_code)) {
        return json_encode(["data" => "error:wrongcode"]);
    } else {
        $newSecret = generate_random_string(50);
        $data = json_decode(forget_wallet_secret($user, 1));
        if ($data->message == "sent") {
            $secret = $DB->get_record('wallet', array('user' => $user));
            $ins = new stdClass();
            $ins->id = $secret->id;
            $ins->secret = $newSecret;
            $DB->update_record('wallet', $ins);
            return json_encode(["message" => 'done'], true);
        }
    }
}
function get_total_price($id)
{
    global $DB;
    $carts = $DB->get_records_sql("SELECT SUM(cd.value) as price
	FROM mo_course as c 
  JOIN mo_cart as cart ON cart.course=c.id 
  LEFT OUTER JOIN   mo_context cx ON c.id = cx.instanceid
  LEFT OUTER JOIN   mo_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '3'
  LEFT OUTER JOIN   mo_user u ON ra.userid = u.id 
 LEFT OUTER JOIN mo_customfield_data cd ON c.id=cd.instanceid
    WHERE cx.contextlevel = '50'  AND cd.fieldid=17 AND cart.user=" . $id . "");
    $price = 0;
    foreach ($carts as $cart) {
        $price = $cart->price;
    }
    return json_encode(["data" => $price], true);
}
function create_group($courseId, $name)
{
    global $DB;

    $groupdata = new stdClass();
    $groupdata->courseid = $courseId;
    $groupdata->name = $name;

    $id = groups_create_group($groupdata);

    $group = $DB->get_record('groups', array('id' => $id), '*', MUST_EXIST);
    $group->enablemessaging = 1;
    $group->enrolmentkey = "";
    return json_encode(["data" => $group]);
}
function add_group_members($members, $groupID)
{

    foreach ($members as $member) {
        groups_add_member($groupID, $member);
    }
    return "added";
}
function delete_group($groupID)
{

    groups_delete_group($groupID);

    return "done";
}
function get_members($groupID)
{
    global $DB;
    $members = array();
    /*
    SELECT $fields
                                   FROM {user} u
                                     INNER JOIN {groups_members} gm ON u.id = gm.userid
                                     INNER JOIN {groupings_groups} gg ON gm.groupid = gg.groupid
                                  WHERE  gg.groupingid = ?
                               ORDER BY $sort", array($groupingid));
    */

    $members = $DB->get_records_sql("SELECT u.*
  FROM mo_user u
    INNER JOIN mo_groups_members gm ON u.id = gm.userid WHERE  gm.groupid =   $groupID ORDER BY u.id ASC");
    $members = array_values($members);
    return json_encode(["data" => $members]);
}
function remove_member($groupID, $members)
{
    foreach ($members as $member) {
        groups_remove_member($groupID, $member);
    }

    return "done";
}

function create_group_conversation($userids, $name)
{
    global $DB, $OUTPUT, $CFG;
    //return \core_message\api::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL;
    sort($userids);
    $conversation = new stdClass();
    $conversation->convhash = null;
    $conversation->convhash = sha1(implode('-', $userids));
    $conversation->name = $name;
    if ($record = $DB->get_record('message_conversations', ['name' => $conversation->name])) {
        $message = [
            [
                'text' => "Welcome",
                'textformat' => FORMAT_MOODLE
            ],
        ];
        core_message_external::send_messages_to_conversation($record->id, $message);
        return json_encode([$record->id]);
    }
    $conversation->type = 2;
    $conversation->enabled = 1;
    $conversation->timecreated = time();
    $conversation->timemodified = $conversation->timecreated;
    $conversation->id = $DB->insert_record('message_conversations', $conversation);
    $arrmembers = [];
    foreach ($userids as $userid) {
        $member = new stdClass();
        $member->conversationid = $conversation->id;
        $member->userid = $userid;
        $member->timecreated = time();
        $member = $DB->insert_record('message_conversation_members', $member);

        $arrmembers[] = $member;
    }

    $conversation->members = $arrmembers;
    $message = [
        [
            'text' => "Welcome",
            'textformat' => FORMAT_MOODLE
        ],
    ];
    core_message_external::send_messages_to_conversation($conversation->id, $message);
    return json_encode([$conversation->id]);
}
function add_group_chat_member($userids, $name)
{
    global $DB;
    sort($userids);
    $conversation = new stdClass();
    $conversation->name = $name;
    $conversation = $DB->get_record('message_conversations', ['name' => $conversation->name]);
    $arrmembers = [];
    foreach ($userids as $userid) {
        $member = new stdClass();
        $member->conversationid = $conversation->id;
        $member->userid = $userid;
        $member->timecreated = time();
        $member = $DB->insert_record('message_conversation_members', $member);

        $arrmembers[] = $member;
    }
    $conversation->members = $arrmembers;
    return "added";
}
function remove_group_chat_member($userids, $name)
{
    global $DB;
    sort($userids);
    $conversation = new stdClass();
    $conversation->name = $name;
    $conversation = $DB->get_record('message_conversations', ['name' => $conversation->name]);
    $arrmembers = [];
    foreach ($userids as $userid) {
        $member = new stdClass();
        $member->conversationid = $conversation->id;
        $member->userid = $userid;
        $record = $DB->get_record('message_conversation_members', ['userid' => $userid, 'conversationid' => $conversation->id]);
        if (!empty($record)) {
            $DB->delete_records('message_conversation_members', array('id' => $record->id));
        }
    }

    return "deleted";
}


// core_group_external::add_group_members([
//     'members' => [
//         'groupid' => $groupID,
//         'userid' => $member,
//     ]
// ]);
function  enrol_student_courses($courseIDs, $userid)
{
    global $DB;
    $finalResult = 'false';
    foreach ($courseIDs as $item) {
        $result = enrol_student($item, $userid, 5);
        if ($result == 'true') {
            $data = $DB->delete_records('cart', array('user' => $userid, 'course' => $item));
            $finalResult = 'true';
        }
    }
    return json_encode(['status' => 'success', "data" => $finalResult]);
}

function enrol_student($id, $userid, $roleid, $enrolmethod = 'manual')
{
    global $DB;
    $user = $DB->get_record('user', array('id' => $userid, 'deleted' => 0), '*', MUST_EXIST);
    $studentRole = $DB->get_field('role', 'id', array('shortname' => 'student'));
    $isStudent = $DB->record_exists('role_assignments', ['userid' => $user->id, 'roleid' => $studentRole]);
    try {
        if ($isStudent) {
            $course = $DB->get_record('course', array('id' => $id), '*', MUST_EXIST);
            $context = context_course::instance($course->id);
            if (!is_enrolled($context, $user)) {
                $enrol = enrol_get_plugin($enrolmethod);
                if ($enrol === null) {
                    return 'false';
                }
                $instances = enrol_get_instances($course->id, true);
                $manualinstance = null;
                foreach ($instances as $instance) {
                    if ($instance->enrol == $enrolmethod) {
                        $manualinstance = $instance;
                        break;
                    }
                }
                if ($manualinstance == null) {
                    $instanceid = $enrol->add_default_instance($course);
                    if ($instanceid === null) {
                        $instanceid = $enrol->add_instance($course);
                    }
                    $instance = $DB->get_record('enrol', array('id' => $instanceid));
                }
                $enrol->enrol_user($instance, $userid, $roleid);
            }
            return json_encode(['status' => 'success', 'data' => 'true']);
        }
    } catch (Exception $e) {
        return json_encode(['status' => 'success', 'data' => 'false']);
    }
}

function get_user_notifications($userid)
{
    global $DB;

    // تحقق من صحة معرف المستخدم
    if (!is_numeric($userid)) {
        return json_encode([
            'status' => 'error',
            'message' => 'Invalid user ID'
        ]);
    }

    // استعلام SQL للحصول على جميع الإشعارات للمستخدم المحدد
    $sql = "SELECT * FROM {notifications} WHERE useridto = :userid";
    $params = ['userid' => $userid];

    $notifications = $DB->get_records_sql($sql, $params);

    if (empty($notifications)) {
        return json_encode([
            'status' => 'error',
            'message' => 'No notifications found for this user',
            'count' => 0,
            'data' => []
        ]);
    }

    // تحويل الإشعارات إلى مصفوفة مرتبة
    $notificationData = [];
    $unreadCount = 0;
    foreach ($notifications as $notification) {

        // إزالة تنسيق HTML وتنظيف النص
        $fullmessage = strip_tags($notification->fullmessage);
        $fullmessage = trim(preg_replace('/\s+/', ' ', $fullmessage));

        if (is_null($notification->timeread)) {
            $unreadCount++;
        }

        $notificationData[] = [
            'id' => $notification->id,
            'useridto' => $notification->useridto,
            'subject' => $notification->subject,
            'fullmessage' => $fullmessage,
            'timecreated' => date('Y-m-d H:i:s', $notification->timecreated),
            'timeread' => $notification->timeread ? date('Y-m-d H:i:s', $notification->timeread) : null
        ];
    }

    return json_encode([
        'status' => 'success',
        'message' => 'Notifications retrieved successfully',
        'count' => $unreadCount,
        'data' => $notificationData
    ]);
}


function send_notification($useridto, $subject, $fullmessage)
{
    global $DB;

    // تحقق من صحة المدخلات
    if (!is_numeric($useridto) || empty($subject) || empty($fullmessage)) {
        return json_encode([
            'status' => 'error',
            'message' => 'Invalid user ID, subject, or full message'
        ]);
    }

    // تحقق من وجود معرف المستخدم المستهدف في قاعدة البيانات
    if (!$DB->record_exists('user', ['id' => $useridto])) {
        return json_encode([
            'status' => 'error',
            'message' => 'User does not exist'
        ]);
    }

    // بدء معاملة قاعدة البيانات
    $transaction = $DB->start_delegated_transaction();

    try {
        // إدخال الإشعار في جدول mo_notifications
        $notificationData = new stdClass();
        $notificationData->useridfrom = -10; // معرف النظام أو أي معرف مناسب
        $notificationData->useridto = $useridto;
        $notificationData->subject = $subject;
        $notificationData->fullmessage = $fullmessage;
        $notificationData->fullmessageformat = 2; // تنسيق HTML
        $notificationData->fullmessagehtml = $fullmessage;
        $notificationData->smallmessage = $subject;
        $notificationData->component = 'mobile_message';
        $notificationData->eventtype = 'mobile';
        $notificationData->contexturl = '';
        $notificationData->contexturlname = 'Context name';
        $notificationData->timecreated = time();

        $notificationid = $DB->insert_record('notifications', $notificationData);

        // إدخال الإشعار في جدول mo_message_popup_notifications
        $popupNotificationData = new stdClass();
        $popupNotificationData->notificationid = $notificationid;

        $DB->insert_record('message_popup_notifications', $popupNotificationData);

        // التزام المعاملة
        $transaction->allow_commit();

        return json_encode([
            'status' => 'success',
            'message' => 'Notification sent successfully'
        ]);
    } catch (Exception $e) {
        // إلغاء المعاملة في حالة حدوث خطأ
        $transaction->rollback($e);

        return json_encode([
            'status' => 'error',
            'message' => 'Failed to send notification: ' . $e->getMessage()
        ]);
    }
}

function mark_notifications_as_read($userid, $notificationid) 
{
    global $DB;

    // تحقق من صحة معرف المستخدم
    if (!is_numeric($userid)) {
        return json_encode([
            'status' => 'error',
            'message' => 'Invalid user ID'
        ]);
    }

    // تحقق من صحة معرف الإشعار
    if (!is_numeric($notificationid)) {
        return json_encode([
            'status' => 'error',
            'message' => 'Invalid notification ID'
        ]);
    }

    // الحصول على الطابع الزمني الحالي
    $currentTime = time();

    // استعلام SQL لتحديث الإشعار المحدد
    $sql = "UPDATE {notifications} SET timeread = :timeread WHERE id = :notificationid AND useridto = :userid AND timeread IS NULL";
    $params = [
        'timeread' => $currentTime,
        'notificationid' => $notificationid,
        'userid' => $userid
    ];

    // تنفيذ الاستعلام وتحقق من النجاح
    $result = $DB->execute($sql, $params);

    if ($result) {
        return json_encode([
            'status' => 'success',
            'message' => 'Notification marked as read successfully'
        ]);
    } else {
        return json_encode([
            'status' => 'error',
            'message' => 'Failed to mark notification as read'
        ]);
    }
}



// function get_all_categories()
// {
//     global $DB;

//     $data = $DB->get_records_sql("SELECT * FROM `mo_course_categories` where visible=1 and coursecount>0" );

//     $categories = array_values($data);
//     return json_encode(["data" => $categories]);
// }


function get_all_news()
{
    global $DB, $CFG;
    $data = $DB->get_records_sql("SELECT * FROM `mo_newsslider`");
    $news = array_values($data);

    $dataarray = [];
    foreach ($news as $object) {

        $news_data = [
            'id' => $object->id,
            'user' => $object->user,
            'news' => $object->news,
            'description' => $object->description,
            'image' => '' . $CFG->wwwroot . '/theme/edumy/images/news/' . $object->image . '',
        ];

        $dataarray[] = $news_data;
    }

    return json_encode(["status" => 'success', "data" => $dataarray]);
}

//MANPOWER APIS
// function edit_description($text)
// {
//     $cleaner_input = strip_tags($text);
//     return $cleaner_input;
// }
function getBetween($string, $start = "", $end = "")
{
    if (strpos($string, $start)) { // required if $start not exist in $string
        $startCharCount = strpos($string, $start) + strlen($start);
        $firstSubStr = substr($string, $startCharCount, strlen($string));
        $endCharCount = strpos($firstSubStr, $end);
        if ($endCharCount == 0) {
            $endCharCount = strlen($firstSubStr);
        }
        return substr($firstSubStr, 0, $endCharCount);
    } else {
        return '';
    }
}
function get_all_categories()
{
    global $DB;

    $data = $DB->get_records_sql("SELECT name,id,description FROM `mo_course_categories` where visible=1 and coursecount>0");
    $categories = array();
    foreach ($data as $cat) {
        // $deletecat = core_course_category::get($cat->id, MUST_EXIST);
        // $deletecat = core_course_category::;
        // $name='';
        // if (preg_match('/{malng ar} (.*?) {mlang}/', $cat->name, $match) == 1) {
        //     $name= $match[1];
        // }
        // $name=getBetween($cat->name,'{malng ar}','{mlang}');
        $name = format_string($cat->name);
        $desc = edit_description($cat->description);
        $categories[] = array('id' => $cat->id, 'name' => $name, 'description' => $desc);
    }
    // $categories = array_values($data);
    return json_encode(["status" => 'success', "data" => $categories]);
}
/* function getCoursesInCategory($categoryId)
{
    global $DB, $CFG;

    require_once($CFG->dirroot . '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
    require_once($CFG->dirroot . '/course/renderer.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/user_handler/ccn_user_handler.php');

    // Fetch courses in a specific category
    $courses = $DB->get_records_sql("SELECT *
        FROM {course} c
        JOIN {course_categories} cc ON cc.id = c.category
        WHERE cc.id = :categoryid
    ", array('categoryid' => $categoryId));

    $courses_arr = [];
    foreach ($courses as $course) {
        // Initialize course handler
        $ccnCourseHandler = new ccnCourseHandler();
        // Retrieve course details
        $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($course->id);
        // check course free
        $course_price = $DB->get_field('customfield_data', 'value', array('instanceid' => $course->id, 'fieldid' => 10));
        $free = '';
        if (empty($course_price)) {
            $free = "yes";
            $price = null;
        } else {
            $free = "no";
            $price = $course_price;
        }

        $courseTeachersData = get_teachers_by_course_id($ccnCourse->courseId);

        $rate = calculate_course_average_rating($ccnCourse->courseId);

        $view = $DB->get_record('course_views', array('courseid' => $ccnCourse->courseId));
        $data = [
            'id' => $ccnCourse->courseId,
            'enrolments' => $ccnCourse->enrolments,
            'numberOfSections' => $ccnCourse->numberOfSections,
            'format' => $ccnCourse->format,
            'categoryid' => $ccnCourse->categoryId,
            'categoryname' => $ccnCourse->categoryName,
            'shortname' => $ccnCourse->shortName,
            'fullname' => $ccnCourse->fullName,
            'imageUrl' => $ccnCourse->imageUrl,
            'description' => $course->summary,
            'free' => $free,
            'price' => $price,
            'rate' => $rate,
            'view' => $view->visit,
            'teachers' => $courseTeachersData
        ];
        $courses_arr[] = $data;
    }


    return $courses_arr;
} */
function get_all_categories_with_courses()
{
    global $DB, $CFG;

    require_once($CFG->dirroot . '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
    require_once($CFG->dirroot . '/course/renderer.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/user_handler/ccn_user_handler.php');

    // Get all visible categories with a non-zero course count
    $categoriesData = $DB->get_records_sql("SELECT * FROM `mo_course_categories` WHERE visible=1 AND coursecount>0");

    $categories = array();

    foreach ($categoriesData as $cat) {
        $name = format_string($cat->name);
        $desc = edit_description($cat->description);

        // Fetch courses in the current category
        $coursesData = $DB->get_records_sql("SELECT * FROM `mo_course` WHERE category=?", array($cat->id));

        $courses = array();
        foreach ($coursesData as $course) {
            // Initialize course handler
            $ccnCourseHandler = new ccnCourseHandler();
            // Retrieve course details
            $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($course->id);
            $course_price = $DB->get_field('customfield_data', 'value', array('instanceid' => $ccnCourse->id, 'fieldid' => 10));
            $free = '';
            if (empty($course_price)) {
                $free = "yes";
                $price = null;
            } else {
                $free = "no";
                $price = $course_price;
            }

            $courseTeachersData = get_teachers_by_course_id($course->id);

            $rate = calculate_course_average_rating($course->id);

            $view = $DB->get_record('course_views', array('courseid' => $course->id));
            $courses[] = array(
                'id' => $ccnCourse->courseId,
                'enrolments' => $ccnCourse->enrolments,
                'numberOfSections' => $ccnCourse->numberOfSections,
                'format' => $ccnCourse->format,
                'categoryid' => $ccnCourse->categoryId,
                'categoryname' => $ccnCourse->categoryName,
                'shortname' => $ccnCourse->shortName,
                'fullname' => $ccnCourse->fullName,
                'imageUrl' => $ccnCourse->imageUrl,
                'description' => $course->summary,
                'free' => $free,
                'price' => $price,
                'rate' => $rate,
                'view' => $view->visit,
                'teachers' => $courseTeachersData

            );
        }

        // Add category and associated courses to the result array
        $categories[] = array('category' => $cat, 'courses' => $courses);
    }

    return json_encode(["status" => 'success', "data" => $categories]);
}

function getCategoriesWithSubcategories()
{
    global $DB, $CFG;

    // Fetch all top-level categories
    $excludedCategoryIds = array(28, 29);
    $topLevelCategories = $DB->get_records_select('course_categories', 'parent = 0 AND id NOT IN (' . implode(',', $excludedCategoryIds) . ')');


    $categoriesWithSubcategories = [];

    foreach ($topLevelCategories as $category) {
        $img_name = $DB->get_field('my_cat_background', 'filename', array('category_id' => $category->id));
        if ($img_name) {
            $cat_img = $CFG->wwwroot . "/course/" . $img_name;
        } else {
            $cat_img = "defult.png";
        }
        $category->img_url = $cat_img;
        $categoryWithSubcategories = [
            'category' => $category,
            'curriculum' => getSubcategoriesRecursively($category->id),
        ];

        $categoriesWithSubcategories[] = $categoryWithSubcategories;
    }

    return json_encode(["status" => 'success', 'data' => $categoriesWithSubcategories]);
}

function getCategoriesWithSubcategories2()
{
    global $DB, $CFG;

    // Fetch all top-level categories
    $categoryIds = array(28, 29);
    $topLevelCategories = $DB->get_records_select('course_categories', 'parent = 0 AND id IN (' . implode(',', $categoryIds) . ')');

    $categoriesWithSubcategories = [];

    foreach ($topLevelCategories as $category) {
        $img_name = $DB->get_field('my_cat_background', 'filename', array('category_id' => $category->id));
        if ($img_name) {
            $cat_img = $CFG->wwwroot . "/course/" . $img_name;
        } else {
            $cat_img = "defult.png";
        }
        $category->img_url = $cat_img;
        $categoryWithSubcategories = [
            'category' => $category,
            'curriculum' => getSubcategoriesRecursively($category->id),
        ];

        $categoriesWithSubcategories[] = $categoryWithSubcategories;
    }

    return json_encode(["status" => 'success', 'data' => $categoriesWithSubcategories]);
}

function getSubcategoriesRecursively($categoryId)
{
    global $DB, $CFG;

    $subcategories = $DB->get_records('course_categories', array('parent' => $categoryId));

    $result = [];

    foreach ($subcategories as $subcategory) {
        $img_name = $DB->get_field('my_cat_background', 'filename', array('category_id' => $subcategory->id));
        if ($img_name) {
            $cat_img = $CFG->wwwroot . "/course/" . $img_name;
        } else {
            $cat_img = "defult.png";
        }
        $subcategory->img_url = $cat_img;
        $subcategoryWithSubcategories = [
            'category' => $subcategory,
            'stage' => getSubcategoriesRecursively2($subcategory->id),
        ];

        $result[] = $subcategoryWithSubcategories;
    }

    return $result;
}

function getSubcategoriesRecursively2($categoryId)
{
    global $DB, $CFG;

    $subcategories = $DB->get_records('course_categories', array('parent' => $categoryId));

    $result = [];

    foreach ($subcategories as $subcategory) {
        $courses = getCoursesInCategory($subcategory->id);
        $img_name = $DB->get_field('my_cat_background', 'filename', array('category_id' => $subcategory->id));
        if ($img_name) {
            $cat_img = $CFG->wwwroot . "/course/" . $img_name;
        } else {
            $cat_img = "defult.png";
        }
        $category = $DB->get_record('category_prices', array('category_id' => $subcategory->id));
        if (!$category) {
            $price1 = $price2 = $price3 = $price4 = '0';
            $currency = '';
        } else {
            if (empty($category->price1)) {
                $price1 = '0';
            } else {
                $price1 = intval($category->price1);
            }
            if (empty($category->price2)) {
                $price2 = '0';
            } else {
                $price2 = intval($category->price2);
            }
            if (empty($category->price3)) {
                $price3 = '0';
            } else {
                $price3 = intval($category->price3);
            }
            if (empty($category->price4)) {
                $price4 = '0';
            } else {
                $price4 = intval($category->price4);
            }
            if (empty($category->currency)) {
                $currency = '';
            } else {
                $currency = $category->currency;
            }
        }
        $subcategory->offers = [
            'month' => $price1,
            'two_months' => $price2,
            'semster' => $price3,
            'session' => $price4,
            'currency' => $currency
        ];
        $subcategory->img_url = $cat_img;
        $subcategoryWithSubcategories = [
            'category' => $subcategory,
            'courses' => $courses,
        ];

        $result[] = $subcategoryWithSubcategories;
    }

    return $result;
}

function getCoursesInCategory($categoryId)
{
    global $DB, $CFG;

    require_once($CFG->dirroot . '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
    require_once($CFG->dirroot . '/course/renderer.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/user_handler/ccn_user_handler.php');

    // Assuming you have a 'courses' table with a 'category_id' column
    $courses = $DB->get_records('course', array('category' => $categoryId));

    $my_arr = [];
    foreach ($courses as $course) {
        $ccnCourseHandler = new ccnCourseHandler();
        // Retrieve course details
        $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($course->id);
        $customfield1 = $DB->get_field('customfield_data', 'value', array('instanceid' => $course->id, 'fieldid' => 1));
        if (empty($customfield1)) {
            $custom1 = "0";
        } else {
            $custom1 = $customfield1;
        }
        $customfield2 = $DB->get_field('customfield_data', 'value', array('instanceid' => $course->id, 'fieldid' => 2));
        if (empty($customfield2)) {
            $custom2 = "0";
        } else {
            $custom2 = $customfield2;
        }
        $customfield3 = $DB->get_field('customfield_data', 'value', array('instanceid' => $course->id, 'fieldid' => 3));
        if (empty($customfield3)) {
            $custom3 = "0";
        } else {
            $custom3 = $customfield3;
        }
        $customfield3 = $DB->get_field('customfield_data', 'value', array('instanceid' => $course->id, 'fieldid' => 4));
        if (empty($customfield4)) {
            $custom4 = "0";
        } else {
            $custom4 = $customfield4;
        }
        $category = $DB->get_record('category_prices', array('category_id' => $course->category));
        if (empty($category->currency)) {
            $currency = "";
        } else {
            $currency = $category->currency;
        }
        $rates = get_course_ratings($course->id);
        $data = [
            'id' => $course->id,
            'category' => $course->category,
            'fullname' => $course->fullname,
            'shortname' => $course->shortname,
            'format' => $course->format,
            'visible' => $course->visible,
            'enrolments' => $ccnCourse->enrolments,
            'image_url' => $ccnCourse->imageUrl,
            'rating' => $rates,
            'offers' => [
                'month' => $custom1,
                'two_months' => $custom2,
                'semster' => $custom3,
                'session' => $custom4,
                'currency' => $currency
            ]


        ];
        $my_arr[] = $data;
    }

    return $my_arr;
}


function searchCoursesByShortname($searchTerm)
{
    global $DB;

    // Sanitize the search term
    $searchTerm = trim($searchTerm);

    // SQL query to search for courses by shortname
    $sql = "SELECT * FROM {course} WHERE shortname LIKE :shortname OR fullname LIKE :fullname";

    // Prepare query parameters
    $params = array('shortname' => '%' . $searchTerm . '%', 'fullname' => '%' . $searchTerm . '%');

    // Execute the SQL query
    $courses = $DB->get_records_sql($sql, $params);

    // Prepare the result as an array
    $courseData = array();

    foreach ($courses as $course) {
        $courseData[] = array(
            'id' => $course->id,
            'fullname' => $course->fullname,
            'shortname' => $course->shortname,
        );
    }

    return json_encode(['data' => $courseData]);
}


/* function all_courses($user)
{
    global $DB, $CFG;
    $courses = $DB->get_records_sql("SELECT co.id as courseId ,co.visible as visible ,co.fullname as courseName,co.summary as courseDesc,co.category as catId,cat.name as catName FROM `mo_course` as co join mo_course_categories as cat ON co.category=cat.id ");
    $data_courses = array_values($courses);
    $coursesData = array();
    $coursecontacts = array();
    $teacherId = -1;
    $teacherName = "";

    foreach ($data_courses as $course) {
        if ($course->visible) {
            //$price = $DB->get_record('customfield_data', array('fieldid' => 12, 'instanceid' => $course->courseid));
            if (empty($price)) {
                $price = 'free';
            }
            //$courseDescription = $DB->get_record('customfield_data', array('fieldid' => 15, 'instanceid' => $course->courseid));
            $rating = $DB->get_records_sql("SELECT ceil(AVG(rate)) as rate FROM `mo_course_rates` WHERE courseid=$course->courseid");
            $rating = array_values($rating);

            // $inCart = 'false';
            // $record = $DB->get_record('cart', array('user' => $user, 'course' => $course->courseid));
            // if (!empty($record)) {
            //    $inCart='true';
            // } 

            $view = $DB->get_record('course_views', array('courseid' => $course->courseid));
            $imges = $DB->get_record("course", array('id' => $course->courseid));
            $courselist = new core_course_list_element($imges);
            $context = context_course::instance($course->courseid, MUST_EXIST);
            $enrol = is_enrolled($context, $user, '', true);
            if ($enrol) {
                $enrol = 'true';
            } else {
                $enrol = 'false';
            }
            $url = "";
            // foreach ($courselist->get_course_overviewfiles() as $file) {
            //     $isimage = $file->is_valid_image();
            //     $url = file_encode_url("{$CFG->wwwroot}/pluginfile.php", '/' . $file->get_contextid() . '/' . $file->get_component() . '/' . $file->get_filearea() . $file->get_filepath() . $file->get_filename(), !$isimage);
            // }
            $overviewfiles = array();
            foreach ($courselist->get_course_overviewfiles() as $file) {
                $fileurl = moodle_url::make_webservice_pluginfile_url(
                    $file->get_contextid(),
                    $file->get_component(),
                    $file->get_filearea(),
                    null,
                    $file->get_filepath(),
                    $file->get_filename()
                )->out(false);
                $overviewfiles[] = array(
                    'filename' => $file->get_filename(),
                    'fileurl' => $fileurl,
                    'filesize' => $file->get_filesize(),
                    'filepath' => $file->get_filepath(),
                    'mimetype' => $file->get_mimetype(),
                    'timemodified' => $file->get_timemodified(),
                );
            }
            $overviewfiles = $overviewfiles[0]['fileurl'];
            $teachers = $DB->get_records_sql("SELECT u.firstname AS name,u.lastname AS lastname, u.url as picture,u.description,u.email,ra.contextid,u.id As id, c.fullname as coursename
            FROM   mo_course c
           LEFT OUTER JOIN   mo_context cx ON c.id = cx.instanceid
           LEFT OUTER JOIN   mo_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '3'
           LEFT OUTER JOIN   mo_user u ON ra.userid = u.id WHERE cx.contextlevel = '50' AND c.id= '$course->courseid';");
            foreach ($teachers as $teacher) {
                $teacherId = $teacher->id;
                $teacherName = $teacher->name . ' ' . $teacher->lastname;
            }
            $course->coursedesc = edit_description($course->coursedesc);
            if (empty($teacherId)) {
                $teacherId = -1;
                $teacherName = null;
            }
            // $coursesData[] = array('course_id' => $course->courseid, 'course_name' => $course->coursename,
            //  'enrol' => $enrol, 'course_desc' => $courseDescription->value,
            //   'views' => $view->visit, 'teacherId' => $teacherId,
            //    'teacherName' => $teacherName, 'price' => $price->value, 'image' => $url,
            //    'rate' => $rating[0]->rate, 'cat_id' => $course->catid, 'cat_name' => $course->catname
            //    );


            $coursesData[] = array(
                'course_id' => $course->courseid, 'course_name' => $course->coursename,
                'enrol' => $enrol, 'course_desc' => $courseDescription->value,
                'views' => $view->visit, 'teacherId' => $teacherId,
                'teacherName' => $teacherName, 'image' => $overviewfiles, 'price' => $price->value,
                'rate' => $rating[0]->rate, 'cat_id' => $course->catid, 'cat_name' => $course->catname
            );
        }
    }

    return json_encode(["data" => $coursesData]);
} */

function get_teachers_by_course_id($courseId)
{
    global $DB;

    try {
        $sql = "SELECT u.id AS teacher_id, u.username AS teacher_username,
                       u.firstname AS teacher_firstname, u.lastname AS teacher_lastname,
                       u.email AS teacher_email, u.job AS teacher_job
                FROM {user} AS u
                JOIN {role_assignments} AS ra ON u.id = ra.userid
                JOIN {context} AS ctx ON ra.contextid = ctx.id
                JOIN {role} AS r ON ra.roleid = r.id
                JOIN {course} AS c ON ctx.instanceid = c.id
                WHERE r.shortname = 'editingteacher' AND c.id = :courseid
                ORDER BY u.id";

        $params = ['courseid' => $courseId];
        $teachers = $DB->get_records_sql($sql, $params);

        $teacherData = [];
        foreach ($teachers as $teacher) {
            $teacherData[] = [
                "teacher_id" => $teacher->teacher_id,
                "teacher_username" => $teacher->teacher_username,
                "teacher_firstname" => $teacher->teacher_firstname,
                "teacher_lastname" => $teacher->teacher_lastname,
                "teacher_email" => $teacher->teacher_email,
                "teacher_job" => $teacher->teacher_job,
            ];
        }

        $result = [
            "count" => count($teacherData),
            "teachers" => $teacherData,
        ];

        // Return the data as JSON
        return $result;
    } catch (Exception $e) {
        // Handle exceptions or errors here
        return json_encode(["status" => 'error', "message" => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
}


function all_courses()
{
    global $DB, $CFG;

    require_once($CFG->dirroot . '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
    require_once($CFG->dirroot . '/course/renderer.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/user_handler/ccn_user_handler.php');

    //$courses = $DB->get_records_sql("SELECT co.id as courseId ,co.visible as visible ,co.fullname as courseName,co.summary as courseDesc,co.category as catId,cat.name as catName FROM `mo_course` as co join mo_course_categories as cat ON co.category=cat.id ");
    //$data_courses = array_values($courses);

    $courses = $DB->get_records('course', array('visible' => 1));

    $courses_dd = [];
    foreach ($courses as $course) {
        if ($course->id == 1) {
            continue;
        }
        // Initialize course handler
        $ccnCourseHandler = new ccnCourseHandler();
        // Retrieve course details
        $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($course->id);

        // check course free
        /* $course_price = $DB->get_field('customfield_data', 'value', array('instanceid' => $course->id, 'fieldid' => 10));
        $free = '';
        if (empty($course_price)) {
            $free = "yes";
            $price = null;
        } else {
            $free = "no";
            $price = $course_price;
        } */

        /* $courseTeachersData = get_teachers_by_course_id($ccnCourse->courseId);

        $rate = calculate_course_average_rating($ccnCourse->courseId);

        $view = $DB->get_record('course_views', array('courseid' => $ccnCourse->courseId)); */

        $data = [
            'id' => $ccnCourse->courseId,
            'fullname' => $ccnCourse->fullName,
            'imageUrl' => $ccnCourse->imageUrl,
            'description' => $course->summary,
            'enrolments' => $ccnCourse->enrolments,
            'numberOfSections' => $ccnCourse->numberOfSections,
            /* 'format' => $ccnCourse->format,
            'categoryid' => $ccnCourse->categoryId,
            'categoryname' => $ccnCourse->categoryName, */
            /* 'shortname' => $ccnCourse->shortName, */
            /* 'free' => $free,
            'price' => $price,
            'rate' => $rate,
            'view' => $view->visit,
            'teachers' => $courseTeachersData */
        ];

        if ($ccnCourse->courseId == 13) {
            continue;
        }

        $courses_dd[] = $data;
    }


    return json_encode(["status" => 'success', "data" => $courses_dd]);
}

// function all_courses($user)
// {
//     global $DB, $CFG;
//     $courses = $DB->get_records_sql("  ");
//     $data_courses = array_values($courses);
//     $coursesData = array();
//     $coursecontacts = array();
//     $teacherId = -1;
//     $teacherName = "";
//     var_dump($courses);

//     foreach ($data_courses as $course) {

//         $price = $DB->get_record('customfield_data', array('fieldid' => 12, 'instanceid' => $course->courseid));
//         if (empty($price)) {
//             $price = 'free';
//         }
//         return $price;
//         $courseDescription=$DB->get_record('customfield_data',array('fieldid' => 15, 'instanceid' => $course->courseid));
//         $rating = $DB->get_records_sql("SELECT ceil(AVG(rate)) as rate FROM `mo_course_rates` WHERE courseid=$course->courseid");
//         $rating = array_values($rating);

//         // $inCart = 'false';
//         // $record = $DB->get_record('cart', array('user' => $user, 'course' => $course->courseid));
//         // if (!empty($record)) {
//         //    $inCart='true';
//         // } 

//         $view = $DB->get_record('course_views', array('courseid' => $course->courseid));
//         $imges = $DB->get_record("course", array('id' => $course->courseid));
//         $courselist = new core_course_list_element($imges);
//         $context = context_course::instance($course->courseid, MUST_EXIST);
//         $enrol = is_enrolled($context, $user, '', true);
//         if ($enrol) {
//             $enrol = 'true';
//         } else {
//             $enrol = 'false';
//         }
//         $url = "";
//         foreach ($courselist->get_course_overviewfiles() as $file) {
//             $isimage = $file->is_valid_image();
//             $url = file_encode_url("{$CFG->wwwroot}/pluginfile.php", '/' . $file->get_contextid() . '/' . $file->get_component() . '/' . $file->get_filearea() . $file->get_filepath() . $file->get_filename(), !$isimage);
//         }

//         foreach ($courselist->get_course_contacts() as $contact) {
//             $teacherId = $contact['user']->id;
//             $teacherName = $contact['username'];

//             break;
//         }
//         $course->coursedesc = edit_description($course->coursedesc);

//         $coursesData[] = array('course_id' => $course->courseid, 'course_name' => $course->coursename, 'enrol' => $enrol, 'course_desc' => $courseDescription->value,'rate'=>$rating[0]->rate,'views'=>$view->visit,'teacherId' => $teacherId, 'teacherName' => $teacherName, 'price' => $price->value, 'image' => $url, 'cat_id' => $course->catid, 'cat_name' => $course->catname);
//     }

//     return json_encode(["data" => $coursesData]);
// }

function get_course_contents_data($courseid, $options = array())
{
    global $CFG, $DB;
    require_once($CFG->dirroot . "/course/lib.php");
    require_once($CFG->libdir . '/completionlib.php');

    //validate parameter


    $filters = array();


    //retrieve the course
    $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);

    if ($course->id != SITEID) {
        // Check course format exist.
        if (!file_exists($CFG->dirroot . '/course/format/' . $course->format . '/lib.php')) {
            throw new moodle_exception(
                'cannotgetcoursecontents',
                'webservice',
                '',
                null,
                get_string('courseformatnotfound', 'error', $course->format)
            );
        } else {
            require_once($CFG->dirroot . '/course/format/' . $course->format . '/lib.php');
        }
    }

    // now security checks
    $context = context_course::instance($course->id, IGNORE_MISSING);




    // $canupdatecourse = has_capability('moodle/course:update', $context);

    //create return value
    $coursecontents = array();

    if ($course->visible) {

        //retrieve sections
        $modinfo = get_fast_modinfo($course);
        $sections = $modinfo->get_section_info_all();
        $courseformat = course_get_format($course);
        $coursenumsections = $courseformat->get_last_section_number();
        $stealthmodules = array();   // Array to keep all the modules available but not visible in a course section/topic.

        $completioninfo = new completion_info($course);

        //for each sections (first displayed to last displayed)
        $modinfosections = $modinfo->get_sections();
        foreach ($sections as $key => $section) {

            // This becomes true when we are filtering and we found the value to filter with.
            $sectionfound = false;

            // Filter by section id.
            if (!empty($filters['sectionid'])) {
                if ($section->id != $filters['sectionid']) {
                    continue;
                } else {
                    $sectionfound = true;
                }
            }

            // Filter by section number. Note that 0 is a valid section number.
            if (isset($filters['sectionnumber'])) {
                if ($key != $filters['sectionnumber']) {
                    continue;
                } else {
                    $sectionfound = true;
                }
            }

            // reset $sectioncontents
            $sectionvalues = array();
            $sectionvalues['id'] = $section->id;
            $sectionvalues['name'] = get_section_name($course, $section);
            $sectionvalues['visible'] = $section->visible;

            $options = (object) array('noclean' => true);
            list($sectionvalues['summary'], $sectionvalues['summaryformat']) =
                external_format_text(
                    $section->summary,
                    $section->summaryformat,
                    $context->id,
                    'course',
                    'section',
                    $section->id,
                    $options
                );
            $sectionvalues['section'] = $section->section;
            $sectionvalues['hiddenbynumsections'] = $section->section > $coursenumsections ? 1 : 0;
            $sectionvalues['uservisible'] = $section->uservisible;
            if (!empty($section->availableinfo)) {
                $sectionvalues['availabilityinfo'] = \core_availability\info::format_info($section->availableinfo, $course);
            }

            $sectioncontents = array();

            // For each module of the section.
            if (empty($filters['excludemodules']) and !empty($modinfosections[$section->section])) {
                foreach ($modinfosections[$section->section] as $cmid) {
                    $cm = $modinfo->cms[$cmid];

                    // Stop here if the module is not visible to the user on the course main page:
                    // The user can't access the module and the user can't view the module on the course page.
                    if (!$cm->uservisible && !$cm->is_visible_on_course_page()) {
                        continue;
                    }

                    // This becomes true when we are filtering and we found the value to filter with.
                    $modfound = false;

                    // Filter by cmid.
                    if (!empty($filters['cmid'])) {
                        if ($cmid != $filters['cmid']) {
                            continue;
                        } else {
                            $modfound = true;
                        }
                    }

                    // Filter by module name and id.
                    if (!empty($filters['modname'])) {
                        if ($cm->modname != $filters['modname']) {
                            continue;
                        } else if (!empty($filters['modid'])) {
                            if ($cm->instance != $filters['modid']) {
                                continue;
                            } else {
                                // Note that if we are only filtering by modname we don't break the loop.
                                $modfound = true;
                            }
                        }
                    }

                    $module = array();

                    $modcontext = context_module::instance($cm->id);

                    //common info (for people being able to see the module or availability dates)
                    $module['id'] = $cm->id;
                    $module['name'] = $cm->name;
                    $module['instance'] = $cm->instance;
                    $module['modname'] = (string) $cm->modname;
                    $module['modplural'] = (string) $cm->modplural;
                    $module['modicon'] = $cm->get_icon_url()->out(false);
                    $module['indent'] = 0;
                    $module['onclick'] = $cm->onclick;
                    $module['afterlink'] = $cm->afterlink;
                    $module['customdata'] = json_encode($cm->customdata);
                    $module['completion'] = $cm->completion;
                    $module['noviewlink'] = plugin_supports('mod', $cm->modname, FEATURE_NO_VIEW_LINK, false);
                    // $free_activity = $DB->get_record('local_metadata', array('fieldid' => 1, 'instanceid' => $cm->id));
                    // $paid = "";
                    // if ($free_activity->data == "Yes") {
                    //     $paid = "No";
                    // } else if ($free_activity->data == "No" || empty($free_activity)) {
                    //     $paid = "Yes";
                    // }
                    $module['paid'] = "";
                    $avail = $modinfo->get_cm($cm->id);
                    $module['avail'] = $avail->available;
                    if ($module['avail'] == false) {
                        // $module['avail_message'] = strip_tags(\core_availability\info::format_info($cm->availableinfo, $course));
                        // if (!empty($cm->availableinfo)) {
                        //     $module['availabilityinfo'] = \core_availability\info::format_info($cm->availableinfo, $course);
                        // }

                        // // Availability date (also send to user who can see hidden module).
                        // if ($CFG->enableavailability && ($canviewhidden || $canupdatecourse)) {
                        //     $module['availability'] = $cm->availability;
                        // }
                        $reason1 = json_encode($avail->availableinfo);
                        $reason = json_decode($reason1);
                        $string = '';
                        // $module['avail_message'] =\core_availability\info::format_info($cm->availableinfo, $course);
                        if (gettype($reason) == 'string') {

                            $module['avail_message'] = strip_tags(\core_availability\info::format_info($cm->availableinfo, $course));
                        } else {
                            $string = get_string('list_root_and', 'theme_edumy');
                            for ($i = 0; $i < count($reason->items); $i++) {
                                // array_push($module['avail_message'], $reason->items[$i]->text." <br>");
                                $string .= strip_tags(\core_availability\info::format_info($reason->items[$i], $course)) . ",";
                            }
                            $string = substr($string, 0, -1);

                            $module['avail_message'] = $string;
                        }



                        // if (gettype($reason) == 'string') {
                        //     if (strpos(strip_tags($reason), 'Enrolled') !== false || strpos(strip_tags($reason), 'انضم') !== false) {
                        //         $module['avail_message'][0] = "enrollerror";
                        //     }
                        //    elseif  (strpos(strip_tags($reason), 'week') !== false || strpos(strip_tags($reason), 'اسبوع') !== false) {
                        //         $module['avail_message'][0] = "codeerror";
                        //     } else {
                        //     $module['avail_message'][0] = strip_tags($reason);
                        //     }
                        // } else {
                        //     for ($i = 0; $i < count($reason->items); $i++) {
                        //         if (strpos(strip_tags($reason->items[$i]), 'Enrolled') !== false || strpos(strip_tags($reason), 'انضم') !== false) {
                        //             $module['avail_message'][$i] = "enrollerror";
                        //         }
                        //         elseif (strpos(strip_tags($reason->items[$i]), 'week') !== false || strpos(strip_tags($reason), 'اسبوع') !== false) {
                        //             $module['avail_message'][$i] = "codeerror";
                        //         } else {
                        //             $module['avail_message'][$i] = strip_tags($reason->items[$i]);
                        //         }
                        //     }
                        // }
                    }
                    $module['quiz_type'] = '';

                    if ($cm->modname == "quiz") {
                        $quizData = $DB->get_record('quiz', array('id' => $cm->instance));
                        if ($quizData->reviewspecificfeedback == 0 && $quizData->reviewoverallfeedback == 0 && $quizData->reviewgeneralfeedback == 0 && $quizData->reviewcorrectness == 0 && $quizData->reviewrightanswer == 0) {
                            $module['quiz_type'] = 'exam';
                        } else {
                            $module['quiz_type'] = 'quiz';
                        }
                    }
                    $module['resource_type'] = "";
                    if ($cm->modname == "resource") {
                        $video_type = $DB->get_record('reda_video_type', array('resource_id' => $cm->instance));
                        if ($video_type->type == "2") {
                            $module['resource_type'] = "lesson";
                        } elseif ($video_type->type == "1") {
                            $module['resource_type'] = "quiz";
                        } elseif ($video_type->type == "3") {
                            $module['resource_type'] = "homework";
                        } elseif ($video_type->type == "4") {
                            $module['resource_type'] = "summary";
                        } elseif ($video_type->type == "5") {
                            $module['resource_type'] = "revision";
                        }
                    }
                    if ($cm->modname == "resource2") {
                        $module['modname'] = "resource";
                        $video_type = $DB->get_record('reda_video_type2', array('resource2_id' => $cm->instance));
                        if ($video_type->type == "2") {
                            $module['resource_type'] = "lesson";
                        } elseif ($video_type->type == "1") {
                            $module['resource_type'] = "quiz";
                        } elseif ($video_type->type == "3") {
                            $module['resource_type'] = "homework";
                        } elseif ($video_type->type == "4") {
                            $module['resource_type'] = "summary";
                        } elseif ($video_type->type == "5") {
                            $module['resource_type'] = "revision";
                        }
                    }
                    $module['page_url'] = "";

                    if ($cm->modname == "page") {
                        $pageData = $DB->get_record('page', array('id' => $cm->instance));
                        //    preg_match('~"(.*?)"~', $pageData->content, $output);
                        //      $module['page_url'] = $output[1];
                        preg_match_all('/(src|value)="([^"]+)"/', $pageData->content, $matches);
                        //    preg_match('~"(.*?)"~', $pageData->content, $output);
                        $module['page_url'] = $matches[2][0];
                    }



                    // Check module completion.
                    $completion = $completioninfo->is_enabled($cm);
                    if ($completion != COMPLETION_DISABLED) {
                        $completiondata = $completioninfo->get_data($cm, true);
                        $module['completiondata'] = array(
                            'state'         => $completiondata->completionstate,
                            'timecompleted' => $completiondata->timemodified,
                            'overrideby'    => $completiondata->overrideby,
                            'valueused'     => core_availability\info::completion_value_used($course, $cm->id)
                        );
                    }

                    if (!empty($cm->showdescription) or $module['noviewlink']) {
                        // We want to use the external format. However from reading get_formatted_content(), $cm->content format is always FORMAT_HTML.
                        $options = array('noclean' => true);
                        list($module['description'], $descriptionformat) = external_format_text(
                            $cm->content,
                            FORMAT_HTML,
                            $modcontext->id,
                            $cm->modname,
                            'intro',
                            $cm->id,
                            $options
                        );
                    }

                    //url of the module
                    $url = $cm->url;
                    if ($url) { //labels don't have url
                        $module['url'] = $url->out(false);
                    }

                    $canviewhidden = has_capability(
                        'moodle/course:viewhiddenactivities',
                        context_module::instance($cm->id)
                    );
                    //user that can view hidden module should know about the visibility
                    $module['visible'] = $cm->visible;
                    $module['visibleoncoursepage'] = $cm->visibleoncoursepage;
                    $module['uservisible'] = $cm->uservisible;
                    // if (!empty($cm->availableinfo)) {
                    //     $module['availabilityinfo'] = \core_availability\info::format_info($cm->availableinfo, $course);
                    // }

                    // Availability date (also send to user who can see hidden module).
                    if ($CFG->enableavailability && ($canviewhidden)) {
                        $module['availability'] = $cm->availability;
                    }

                    // Return contents only if the user can access to the module.
                    if ($cm->uservisible) {
                        $baseurl = 'webservice/pluginfile.php';

                        // Call $modulename_export_contents (each module callback take care about checking the capabilities).
                        require_once($CFG->dirroot . '/mod/' . $cm->modname . '/lib.php');
                        $getcontentfunction = $cm->modname . '_export_contents';
                        if (function_exists($getcontentfunction)) {
                            $contents = $getcontentfunction($cm, $baseurl);
                            $module['contentsinfo'] = array(
                                'filescount' => count($contents),
                                'filessize' => 0,
                                'lastmodified' => 0,
                                'mimetypes' => array(),
                            );
                            foreach ($contents as $content) {
                                // Check repository file (only main file).
                                if (!isset($module['contentsinfo']['repositorytype'])) {
                                    $module['contentsinfo']['repositorytype'] =
                                        isset($content['repositorytype']) ? $content['repositorytype'] : '';
                                }
                                if (isset($content['filesize'])) {
                                    $module['contentsinfo']['filessize'] += $content['filesize'];
                                }
                                if (
                                    isset($content['timemodified']) &&
                                    ($content['timemodified'] > $module['contentsinfo']['lastmodified'])
                                ) {

                                    $module['contentsinfo']['lastmodified'] = $content['timemodified'];
                                }
                                if (isset($content['mimetype'])) {
                                    $module['contentsinfo']['mimetypes'][$content['mimetype']] = $content['mimetype'];
                                }
                            }

                            if (empty($filters['excludecontents']) and !empty($contents)) {
                                $module['contents'] = $contents;
                            } else {
                                $module['contents'] = array();
                            }
                        }
                    }

                    // Assign result to $sectioncontents, there is an exception,
                    // stealth activities in non-visible sections for students go to a special section.
                    if (!empty($filters['includestealthmodules']) && !$section->uservisible && $cm->is_stealth()) {
                        $stealthmodules[] = $module;
                    } else {
                        $sectioncontents[] = $module;
                    }

                    // If we just did a filtering, break the loop.
                    if ($modfound) {
                        break;
                    }
                }
            }
            $sectionvalues['modules'] = $sectioncontents;

            // assign result to $coursecontents
            $coursecontents[$key] = $sectionvalues;

            // Break the loop if we are filtering.
            if ($sectionfound) {
                break;
            }
        }

        // Now that we have iterated over all the sections and activities, check the visibility.
        // We didn't this before to be able to retrieve stealth activities.
        foreach ($coursecontents as $sectionnumber => $sectioncontents) {
            $section = $sections[$sectionnumber];
            // Show the section if the user is permitted to access it OR
            // if it's not available but there is some available info text which explains the reason & should display OR
            // the course is configured to show hidden sections name.
            $showsection = $section->uservisible ||
                ($section->visible && !$section->available && !empty($section->availableinfo)) ||
                (!$section->visible && empty($courseformat->get_course()->hiddensections));

            if (!$showsection) {
                unset($coursecontents[$sectionnumber]);
                continue;
            }

            // Remove section and modules information if the section is not visible for the user.
            if (!$section->uservisible) {
                $coursecontents[$sectionnumber]['modules'] = array();
                // Remove summary information if the section is completely hidden only,
                // even if the section is not user visible, the summary is always displayed among the availability information.
                if (!$section->visible) {
                    $coursecontents[$sectionnumber]['summary'] = '';
                }
            }
        }

        // Include stealth modules in special section (without any info).
        if (!empty($stealthmodules)) {
            $coursecontents[] = array(
                'id' => -1,
                'name' => '',
                'summary' => '',
                'summaryformat' => FORMAT_MOODLE,
                'modules' => $stealthmodules
            );
        }
    }
    return $coursecontents;
}
/* function course_content($course)
{
    global $DB, $CFG;
    $free = '';
    $activitiesCount = 0;
    $teacherId = -1;
    $teacherName = '';
    $teacherBio = '';
    $promo = 'no';
    $promoId = '0';
    $courseRate = '0';
    $coursesObj = array();
    $courseData = $DB->get_record('course', array('id' => $course));
    $courseDescription = $DB->get_record('customfield_data', array('fieldid' => 15, 'instanceid' => $course));
    $check_type = $DB->get_record('customfield_data', array('fieldid' => 28, 'instanceid' => $course));
    $requirements = $DB->get_record('customfield_data', array('fieldid' => 23, 'instanceid' => $course));
    $forwhom = $DB->get_record('customfield_data', array('fieldid' => 24, 'instanceid' => $course));
    $benefits = $DB->get_record('customfield_data', array('fieldid' => 25, 'instanceid' => $course));
    $language = $DB->get_record('customfield_data', array('fieldid' => 26, 'instanceid' => $course));
    $certificate = $DB->get_record('customfield_data', array('fieldid' => 27, 'instanceid' => $course));
    $objectives = $DB->get_records_sql('SELECT * FROM `mo_customfield_data`WHERE `instanceid`=' . $course . ' and (`fieldid`=2 or `fieldid`=3 or `fieldid`=4 or `fieldid`=5 or `fieldid`=6 or `fieldid`=7 or `fieldid`=8 or `fieldid`=9 or `fieldid`=10)');
    $price = $DB->get_record('customfield_data', array('fieldid' => 12, 'instanceid' => $course));
    $view = $DB->get_record('course_views', array('courseid' => $course));
    $Allenrolusers = $DB->get_records_sql("SELECT count(*)as c From mo_user_enrolments x,mo_enrol y where x.enrolid=y.id and y.courseid='$course'");
    $Allenrolusers = array_values($Allenrolusers);
    $allenrolusers = $Allenrolusers[0]->c;
    $numberOfModules = $DB->get_records_sql("SELECT count(*)as c From mo_course_modules where course='$course'");
    $numberOfModules = array_values($numberOfModules);
    $numberOfModules = $numberOfModules[0]->c;
    $contents = get_course_contents_data($course, array());
    // $course_content = json_decode($contents, true);

    foreach ($contents as $content) {
        $modules = $content['modules'];

        $activitiesCount += count($modules);
    }
    if (empty($price)) {
        $price = '';
    }
    if (empty($check_type) || $check_type->value == 0) {
        $free = "no";
    } else {
        $free = "yes";
    }

    if (empty($certificate) || $check_type->value == 0) {
        $certificate = "no";
    } else {
        $certificate = "yes";
    }
    if ($view->visit == null) {
        $view->visit = '0';
    }
    $objectives = array_values($objectives);
    foreach ($objectives as $obj) {
        if (!empty($obj->value)) {
            $coursesObj[] = array('value' => $obj->value);
        }
    }
    $courselist = new core_course_list_element($courseData);
    foreach ($courselist->get_course_contacts() as $contact) {
        $teacherId = $contact['user']->id;
        $teacherName = $contact['username'];
        break;
    }
    if ($teacherId != -1) {
        $teacherBio = $DB->get_record('user_info_data', array('userid' => $teacherId, 'fieldid' => 3));
    }
    $enddate = date("Y-m-d", $courseData->enddate);
    $startdate = date("Y-m-d", $courseData->startdate);
    $duration = ($enddate - $startdate) * 365;
    if ($duration < 0) {
        $duration = '';
    }
    // $get_cms = $DB->get_records_sql("SELECT id from mo_course_modules where course=" . $course . " and module=18 and deletioninprogress=0 ");
    // foreach ($get_cms as $gcm) {
    //     $promo_check = $DB->get_record('local_metadata', array('instanceid' => $gcm->id, 'fieldid' => 3));

    //     if ($promo_check->data == "Yes") {
    //         $promo = 'yes';
    //         $activitiesCount--;
    //         $promoId = $gcm->id;
    //         break;
    //     }
    // }
    $rating = $DB->get_records_sql("SELECT ceil(AVG(rate)) as rate FROM `mo_course_rates` WHERE courseid=$course");
    $rating = array_values($rating);
    $context = context_course::instance($course, MUST_EXIST);
    $user_context = context_user::instance($teacherId, MUST_EXIST);
    $fs = get_file_storage();
    $files = $fs->get_area_files($user_context->id, 'user', 'icon', 0, 'sortorder DESC, id ASC', false);
    $image = '';
    if (count($files) < 1) {
        $image = 'not_set';
    } else {
        $file = reset($files);
        unset($files);
        $path = '/' . $user_context->id . '/user/icon/0' . $file->get_filepath() . $file->get_filename();
        $image = $CFG->wwwroot . '/pluginfile.php' . $path;
    }
    // $user=$DB->get_record('user',array('id'=>$teacherId));
    if (empty($teacherId)) {
        $teacherId = null;
        $teacherName = null;
    }
    $customFields = array(
        'courseid' => $course, 'coursename' => $courseData->fullname,
        'free' => $free, 'requirements' => $requirements->value,
        'forwhom' => $forwhom->value, 'benefits' => $benefits->value, 'language' => $language->value,
        'certificate' => $certificate, 'objectives' => $coursesObj, 'description' => $courseDescription->value,
        'price' => $price->value, 'views' => $view->visit, 'allenrolusers' => $allenrolusers,
        'activitiesCount' => $activitiesCount, 'teacherId' => $teacherId, 'teacherName' => $teacherName,
        'teacherBio' => $teacherBio->data, 'duration' => $duration,
        'courseRate' => $rating[0]->rate, 'teacherImage' => $image,
        'contents' => $contents
    );
    // $customFields = array(
    //     'free' => $free,

    //     'objectives' => $coursesObj, 'description' => $courseDescription->value,
    //     'price' => $price->value, 'allenrolusers' => $allenrolusers,
    //     'activitiesCount' => $activitiesCount, 'teacherId' => $teacherId, 'teacherName' => $teacherName,
    //      'duration' => $duration, 'promo' => $promo,
    //      'image' => $image,
    //     'contents' => $contents
    // );


    return json_encode(["data" => $customFields], true);
} */
function course_content($course)
{
    global $DB, $CFG;
    $free = '';
    $activitiesCount = 0;
    $teacherId = 31;
    $teacherName = '';
    $teacherBio = '';
    $promo = 'no';
    $promoId = '0';
    $courseRate = '0';
    $coursesObj = array();
    $courseData = $DB->get_record('course', array('id' => $course));
    //$courseDescription = $DB->get_record('customfield_data', array('fieldid' => 15, 'instanceid' => $course));
    //$check_type = $DB->get_record('customfield_data', array('fieldid' => 28, 'instanceid' => $course));
    //$requirements = $DB->get_record('customfield_data', array('fieldid' => 23, 'instanceid' => $course));
    //$forwhom = $DB->get_record('customfield_data', array('fieldid' => 24, 'instanceid' => $course));
    //$benefits = $DB->get_record('customfield_data', array('fieldid' => 25, 'instanceid' => $course));
    //$language = $DB->get_record('customfield_data', array('fieldid' => 26, 'instanceid' => $course));
    //$certificate = $DB->get_record('customfield_data', array('fieldid' => 27, 'instanceid' => $course));
    //$objectives = $DB->get_records_sql('SELECT * FROM `mo_customfield_data`WHERE `instanceid`=' . $course . ' and (`fieldid`=2 or `fieldid`=3 or `fieldid`=4 or `fieldid`=5 or `fieldid`=6 or `fieldid`=7 or `fieldid`=8 or `fieldid`=9 or `fieldid`=10)');
    //$price = $DB->get_record('customfield_data', array('fieldid' => 12, 'instanceid' => $course));
    $view = $DB->get_record('course_views', array('courseid' => $course));
    $Allenrolusers = $DB->get_records_sql("SELECT count(*)as c From mo_user_enrolments x,mo_enrol y where x.enrolid=y.id and y.courseid='$course'");
    $Allenrolusers = array_values($Allenrolusers);
    $allenrolusers = $Allenrolusers[0]->c;
    $numberOfModules = $DB->get_records_sql("SELECT count(*)as c From mo_course_modules where course='$course'");
    $numberOfModules = array_values($numberOfModules);
    $numberOfModules = $numberOfModules[0]->c;
    $contents = get_course_contents_data($course, array());
    // $course_content = json_decode($contents, true);

    foreach ($contents as $content) {
        $modules = $content['modules'];

        $activitiesCount += count($modules);
    }
    if (empty($price)) {
        $price = '';
    }
    if (empty($check_type) || $check_type->value == 0) {
        $free = "no";
    } else {
        $free = "yes";
    }

    if (empty($certificate) || $check_type->value == 0) {
        $certificate = "no";
    } else {
        $certificate = "yes";
    }
    if ($view->visit == null) {
        $view->visit = '0';
    }
    $objectives = array_values($objectives);
    foreach ($objectives as $obj) {
        if (!empty($obj->value)) {
            $coursesObj[] = array('value' => $obj->value);
        }
    }
    $courselist = new core_course_list_element($courseData);
    foreach ($courselist->get_course_contacts() as $contact) {
        $teacherId = $contact['user']->id;
        $teacherName = $contact['username'];
        break;
    }
    if ($teacherId != -1) {
        $teacherBio = $DB->get_record('user_info_data', array('userid' => $teacherId, 'fieldid' => 3));
    }
    $enddate = date("Y-m-d", $courseData->enddate);
    $startdate = date("Y-m-d", $courseData->startdate);
    $duration = ($enddate - $startdate) * 365;
    if ($duration < 0) {
        $duration = '';
    }
    // $get_cms = $DB->get_records_sql("SELECT id from mo_course_modules where course=" . $course . " and module=18 and deletioninprogress=0 ");
    // foreach ($get_cms as $gcm) {
    //     $promo_check = $DB->get_record('local_metadata', array('instanceid' => $gcm->id, 'fieldid' => 3));

    //     if ($promo_check->data == "Yes") {
    //         $promo = 'yes';
    //         $activitiesCount--;
    //         $promoId = $gcm->id;
    //         break;
    //     }
    // }
    $rating = $DB->get_records_sql("SELECT ceil(AVG(rate)) as rate FROM `mo_course_rates` WHERE courseid=$course");
    $rating = array_values($rating);
    $context = context_course::instance($course, MUST_EXIST);
    $user_context = context_user::instance($teacherId, MUST_EXIST);
    $fs = get_file_storage();
    $files = $fs->get_area_files($user_context->id, 'user', 'icon', 0, 'sortorder DESC, id ASC', false);
    $image = '';
    if (count($files) < 1) {
        $image = 'not_set';
    } else {
        $file = reset($files);
        unset($files);
        $path = '/' . $user_context->id . '/user/icon/0' . $file->get_filepath() . $file->get_filename();
        $image = $CFG->wwwroot . '/pluginfile.php' . $path;
    }
    // $user=$DB->get_record('user',array('id'=>$teacherId));
    if (empty($teacherId)) {
        $teacherId = null;
        $teacherName = null;
    }
    $customFields = array(
        'courseid' => $course, 'coursename' => $courseData->fullname,
        'free' => $free, 'requirements' => $requirements->value,
        'forwhom' => $forwhom->value, 'benefits' => $benefits->value, 'language' => $language->value,
        'certificate' => $certificate, 'objectives' => $coursesObj, 'description' => $courseDescription->value,
        'price' => $price->value, 'views' => $view->visit, 'allenrolusers' => $allenrolusers,
        'activitiesCount' => $activitiesCount, 'teacherId' => $teacherId, 'teacherName' => $teacherName,
        'teacherBio' => $teacherBio->data, 'duration' => $duration,
        'courseRate' => $rating[0]->rate, 'teacherImage' => $image,
        'contents' => $contents
    );
    // $customFields = array(
    //     'free' => $free,

    //     'objectives' => $coursesObj, 'description' => $courseDescription->value,
    //     'price' => $price->value, 'allenrolusers' => $allenrolusers,
    //     'activitiesCount' => $activitiesCount, 'teacherId' => $teacherId, 'teacherName' => $teacherName,
    //      'duration' => $duration, 'promo' => $promo,
    //      'image' => $image,
    //     'contents' => $contents
    // );


    return json_encode(["data" => $customFields], true);
}

function get_enrolled_users_count_in_category($categoryId)
{
    global $DB;

    // Get all courses in the specified category
    $courses = $DB->get_records('course', array('category' => $categoryId), 'sortorder', 'id, fullname');

    $totalEnrolledUsers = 0;

    foreach ($courses as $course) {
        // Get the context of the course
        $context = context_course::instance($course->id);

        // Get enrolled users in the course
        $enrolledUsers = get_enrolled_users($context);

        // Add the count to the total
        $totalEnrolledUsers += count($enrolledUsers);
    }

    return $totalEnrolledUsers;
}

function course_content_mobile($userID, $course)
{
    global $DB, $CFG;
    require_once($CFG->dirroot . '/mod/pdfannotator/locallib.php');
    require_once($CFG->libdir . '/filelib.php');
    require_once($CFG->libdir . '/completionlib.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
    require_once($CFG->dirroot . '/course/renderer.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/user_handler/ccn_user_handler.php');

    $courseData = $DB->get_record('course', array('id' => $course));

    // Initialize course handler and retrieve course details
    $ccnCourseHandler = new ccnCourseHandler();
    $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($courseData->id);

    // Retrieve teachers' details
    $course_teacher = [];
    foreach ($ccnCourse->teachers as $teacher) {
        $ccnUserHandler = new ccnUserHandler();
        $ccnUser = $ccnUserHandler->ccnGetUserDetails($teacher->userId);
        $course_teacher[] = [
            'teacherid' => $teacher->userId,
            'username' => $teacher->username,
            'name' => $teacher->name,
            'img_url' => $ccnUser->rawAvatar,
            'role' => $teacher->role,
        ];
    }

    // Retrieve course contents
    $contents = get_course_contents_data($course, []);
    $filteredContents = array_values(array_filter($contents, function ($section) {
        return $section['name'] !== 'General';
    }));

    // Retrieve user enrolments
    $enrolid = $DB->get_field('enrol', 'id', array('enrol' => 'manual', 'courseid' => $course));
    $userEnrolments = $DB->get_records('user_enrolments', array('enrolid' => $enrolid));

    $enrolment_users = [];
    foreach ($userEnrolments as $enrolment) {
        $userId = $enrolment->userid;
        $userdata = $DB->get_record('user', array('id' => $userId));
        $ccnUserHandler = new ccnUserHandler();
        $ccnUser = $ccnUserHandler->ccnGetUserDetails($userId);

        $enrolment_users[] = [
            'id' => $userdata->id,
            'name' => $ccnUser->fullname,
            'email' => $userdata->email,
            'image_url' => $ccnUser->rawAvatar,
            'phone1' => $userdata->phone1,
            'phone2' => $userdata->phone2,
            'city' => $userdata->city,
            'last_login' => $ccnUser->ccnPretty->lastLogin,
        ];
    }

    // Retrieve promo video details
    $video = $DB->get_record('course_promo_videos', array('course_id' => $course));
    $promo = $video ? 'yes' : 'no';
    $promo_video = $video ? $video->url_name : null;

    $other_fields = [
        'have_online' => $promo,
        'secession_name' => $video->v_name ?? '',
        'secession_url' => $promo_video,
        'reminded' => $video->datetime_field ?? ''
    ];

    // Retrieve reviews
    $reviews = $DB->get_records('theme_edumy_courserate', array('course' => $ccnCourse->courseId));
    $reviews_arr = [];
    foreach ($reviews as $review) {
        $user = $DB->get_record('user', array('id' => $review->user), '*', MUST_EXIST);
        $userName = fullname($user);
        $user_image = get_user_profile_image($review->user);

        $reviews_arr[] = [
            'id' => $review->id,
            'rate' => $review->rating,
            'owner' => $userName,
            'owner_image' => $user_image,
            'review' => $review->review,
        ];
    }

    // Construct custom fields array
    $customFields = [
        'id' => $ccnCourse->courseId,
        'enrolments' => $ccnCourse->enrolments,
        'categoryId' => $ccnCourse->categoryId,
        'categoryName' => $ccnCourse->categoryName,
        'category_enrolments' => get_enrolled_users_count_in_category($ccnCourse->categoryId),
        'categoryUrl' => $ccnCourse->categoryUrl,
        'shortName' => $ccnCourse->shortName,
        'fullName' => $ccnCourse->fullName,
        'description' => $ccnCourse->summary,
        'image_url' => $ccnCourse->imageUrl,
        'format' => $ccnCourse->format,
        'activities_count' => $ccnCourse->announcements,
        'numberOfSections' => $ccnCourse->numberOfSections,
        'visible' => $ccnCourse->visible,
        'teachers' => $course_teacher,
        'other_fields' => $other_fields,
        'contents' => $filteredContents,
        'reviews' => $reviews_arr,
    ];

    // Add PDF annotator content if available
    if ($pdfAnnotatorContent) {
        $customFields["pdfannotator_content"] = $pdfAnnotatorContent;
    }

    return json_encode(["status" => 'success', "data" => $customFields], JSON_PRETTY_PRINT);
}


/* function course_content_mobile($course, $userid)
{
    global $DB, $CFG;
    $free = '';
    $activitiesCount = 0;
    $teacherId = -1;
    $teacherName = '';
    $teacherBio = '';
    $promo = 'no';
    $promoId = '0';
    $courseRate = '0';
    $coursesObj = array();
    $courseData = $DB->get_record('course', array('id' => $course));

    $courseDescription = $DB->get_record('customfield_data', array('fieldid' => 15, 'instanceid' => $course));

    $check_type = $DB->get_record('customfield_data', array('fieldid' => 28, 'instanceid' => $course));
    $requirements = $DB->get_record('customfield_data', array('fieldid' => 13, 'instanceid' => $course));
    $forwhom = $DB->get_record('customfield_data', array('fieldid' => 14, 'instanceid' => $course));
    $benefits = $DB->get_record('customfield_data', array('fieldid' => 15, 'instanceid' => $course));
    $language = $DB->get_record('customfield_data', array('fieldid' => 16, 'instanceid' => $course));
    $certificate = $DB->get_record('customfield_data', array('fieldid' => 17, 'instanceid' => $course));
    $objectives = $DB->get_records_sql('SELECT * FROM `mo_customfield_data`WHERE `instanceid`=' . $course . ' and (`fieldid`=2 or `fieldid`=3 or `fieldid`=4 or `fieldid`=5 or `fieldid`=6 or `fieldid`=7 or `fieldid`=8 or `fieldid`=9 or `fieldid`=10)');
    $price = $DB->get_record('customfield_data', array('fieldid' => 12, 'instanceid' => $course));
    $view = $DB->get_record('course_views', array('courseid' => $course));
    $Allenrolusers = $DB->get_records_sql("SELECT count(*)as c From mo_user_enrolments x,mo_enrol y where x.enrolid=y.id and y.courseid='$course'");
    $Allenrolusers = array_values($Allenrolusers);
    $allenrolusers = $Allenrolusers[0]->c;
    $numberOfModules = $DB->get_records_sql("SELECT count(*)as c From mo_course_modules where course='$course'");
    $numberOfModules = array_values($numberOfModules);
    $numberOfModules = $numberOfModules[0]->c;

    $contents = get_course_contents_data($course, array());

    // $course_content = json_decode($contents, true);

    foreach ($contents as $content) {
        $modules = $content['modules'];

        $activitiesCount += count($modules);
    }
    if (empty($price)) {
        $price = '';
    }
    if (empty($check_type) || $check_type->value == 0) {
        $free = "no";
    } else {
        $free = "yes";
    }

    if (empty($certificate) || $check_type->value == 0) {
        $certificate = "no";
    } else {
        $certificate = "yes";
    }
    if ($view->visit == null) {
        $view->visit = '0';
    }

    $objectives = array_values($objectives);
    foreach ($objectives as $obj) {
        if (!empty($obj->value)) {
            $coursesObj[] = array('value' => $obj->value);
        }
    }
    $courselist = new core_course_list_element($courseData);
    foreach ($courselist->get_course_contacts() as $contact) {
        $teacherId = $contact['user']->id;
        $teacherName = $contact['username'];
        break;
    }
    if ($teacherId != -1) {
        // $teacherBio = $DB->get_record('user_info_data', array('userid' => $teacherId, 'fieldid' => 2));
    }
    $enddate = date("Y-m-d", $courseData->enddate);
    $startdate = date("Y-m-d", $courseData->startdate);
    $duration = ($enddate - $startdate) * 365;
    if ($duration < 0) {
        $duration = '';
    }
    $video = $DB->get_record('promo', array('course' => $course));
    if (!empty($video)) {
        $promo = 'yes';
    }
    $rating = $DB->get_records_sql("SELECT ceil(AVG(rate)) as rate FROM `mo_course_rates` WHERE courseid=$course");
    $rating = array_values($rating);
    $context = context_course::instance($course, MUST_EXIST);
    $enrol = is_enrolled($context, $userid, '', true);
    if ($enrol) {
        $enrol = "enrolled";
    } else {
        $enrol = "not_enrolled";
    }
    $user = $DB->get_record('user', array('id' => $teacherId));

    $user_context = $DB->get_record('context', array('instanceid' => $teacherId, 'contextlevel' => 30));

    $fs = get_file_storage();
    $files = $fs->get_area_files($user_context->id, 'user', 'icon', 0, 'sortorder DESC, id ASC', false);
    $image = '';

    if (count($files) < 1) {
        $image = '' . $CFG->wwwroot . '/pluginfile.php/' . $user_context->id . '/user/icon/0/f1.jpg?rev=0';
    } else {
        $file = reset($files);
        unset($files);
        $path = '/' . $user_context->id . '/user/icon/0' . $file->get_filepath() . $file->get_filename();
        $image = $CFG->wwwroot . '/pluginfile.php' . $path . "?rev=" . $user->picture;
    }
    if (empty($teacherId)) {
        $teacherId = null;
        $teacherName = null;
    }
    $assisstantRole = $DB->get_field('role', 'id', array('shortname' => 'teacher'));
    $isAssisstant = $DB->record_exists('role_assignments', ['userid' => $userid, 'roleid' => $assisstantRole]);
    $assistant = "false";
    if ($isAssisstant) {
        $assistant = "true";
    }

    if (empty($rating[0]->rate)) {
        $rating[0]->rate = "0";
    }
    $customFields = array(
        'courseid' => $course, 'coursename' => $courseData->fullname,
        'free' => $free, 'requirements' => $requirements->value,
        'forwhom' => $forwhom->value, 'benefits' => $benefits->value, 'language' => $language->value,
        'certificate' => $certificate, 'objectives' => $coursesObj, 'description' => $courseDescription->value,
        'price' => $price->value, 'views' => $view->visit, 'allenrolusers' => $allenrolusers,
        'activitiesCount' => $activitiesCount, 'teacherId' => $teacherId, 'teacherName' => $teacherName,
        'teacherBio' => '', 'duration' => "", 'promo' => $promo,
        'courseRate' =>  $rating[0]->rate, 'teacherImage' => $image, 'enrol' => $enrol, "assistant" => $assistant,
        'contents' => $contents
    );
    //     $customFields = array(
    //         'courseid'=>$course,'coursename'=>$courseData->fullname,
    //         'free' => $free, 
    //          'objectives' => $coursesObj, 'description' => $courseDescription->value,
    //         'price' => $price->value, 'allenrolusers' => $allenrolusers,
    //         'activitiesCount' => $activitiesCount, 'teacherId' => $teacherId, 'teacherName' => $teacherName,
    //        'duration' => $duration, 'promo' => $promo,
    //  'teacherImage' => $image, 'enrol' => $enrol,
    //         'contents' => $contents
    //     );


    return json_encode(["data" => $customFields], true);
} */
function course_view_data($course)
{
    global $DB;
    try {
        $isIt = $DB->record_exists('course_views', array('courseid' => $course));

        if ($isIt) {
            $visits = $DB->get_record('course_views', array('courseid' => $course), $fields = '*');

            $newvisit = $visits->visit + 1;


            $upduser = new stdClass();
            $upduser->id = $visits->id;
            $upduser->visit = $newvisit;
            $DB->update_record('course_views', $upduser);
            return json_encode(["status" => 'success', "data" => 'done']);
        } else {
            $ins = new stdClass();
            $ins->courseid = $course;
            $ins->visit = 1;
            $ins->id = $DB->insert_record('course_views', $ins);
            return json_encode(["status" => 'success', "data" => 'done']);
        }
    } catch (Exception $e) {
        return json_encode(["data" => $e]);
    }
}

function add_course_rate($userid, $course, $rate)
{
    global $DB;
    try {
        $context = context_course::instance($course, MUST_EXIST);
        $enrol = is_enrolled($context, $userid, '', true);
        if ($enrol) {
            $userExist = $DB->record_exists('theme_edumy_courserate', array('user' => $userid,  'course' => $course));
            if ($userExist) {
                $userRate = $DB->get_record('theme_edumy_courserate', array('user' => $userid, 'course' => $course), $fields = '*');
                $updRate = new stdClass();
                $updRate->id = $userRate->id;
                $updRate->rating = $rate;
                $DB->update_record('theme_edumy_courserate', $updRate);
                return json_encode(["status" => 'success', "data" => 'done']);
            } else {

                $ins = new stdClass();
                $ins->course = $course;
                $ins->user = $userid;
                $ins->rating = $rate;
                $ins->id = $DB->insert_record('theme_edumy_courserate', $ins);
                return json_encode(["status" => 'success', "data" => 'done']);
            }
        } else {
            return json_encode(["status" => 'failed', "data" => 'notenroled']);
        }
    } catch (Exception $e) {
        return json_encode(["data" => $e]);
    }
}

/*
1- check if promo activity exist or not 
2- if exist promoVar =true
else promoVar = false
*/
function get_promo_video($course)
{
    global $DB, $CFG;
    $promo = 'no';
    $promoId = 0;
    $get_cms = $DB->get_records_sql("SELECT id from mo_course_modules where course=" . $course . " and module=18 and deletioninprogress=0 ");
    foreach ($get_cms as $gcm) {
        $promo_check = $DB->get_record('local_metadata', array('instanceid' => $gcm->id, 'fieldid' => 3));

        if ($promo_check->data == "Yes") {
            $promo = 'yes';
            $promoId = $gcm->id;
            break;
        }
    }
    if ($promo == 'yes') {
        $get_resource = $DB->get_record('course_modules', array('id' => $promoId));
        $resource = $DB->get_record('resource', array('id' => $get_resource->instance));
        $context = context_module::instance($promoId);
        $fs = get_file_storage();
        $files = $fs->get_area_files($context->id, 'mod_resource', 'content', 0, 'sortorder DESC, id ASC', false); // TODO: this is not very efficient!!
        if (count($files) < 1) {
            $get_vimeo_data = $DB->get_record('vimeo_files', array('resource_id' => $get_resource->instance));
            $client = new Vimeo((require __DIR__ . '/../../local_secrets.php')['vimeo_client_id'], (require __DIR__ . '/../../local_secrets.php')['vimeo_client_secret'], (require __DIR__ . '/../../local_secrets.php')['vimeo_access_token']);
            $uri = "/videos/" . $get_vimeo_data->url;
            $response = $client->request($uri, [], 'GET');
            $response = $response['body']['embed']['html'];
            if (!empty($response)) {
                return json_encode(["data" => $response]);
            } else {
                return json_encode(["data" => 'notfound']);
            }
        } else {
            $file = reset($files);
            unset($files);
            $path = '/' . $context->id . '/mod_resource/content/' . $resource->revision . $file->get_filepath() . $file->get_filename();
            $fullurl = $CFG->wwwroot . '/pluginfile.php' . $path;
            $fullurl = str_replace(' ', '%20', $fullurl);
            //    $data=$DB->get_record('course',array('id'=>$course));
            // $data=resource_display_frame($resource, $get_resource, $data, $file);
            // return $data;
            return json_encode(["data" => $fullurl]);
        }
    }
}
function all_courses_by_category($user, $categoryid)
{
    global $DB, $CFG;
    $courses = $DB->get_records_sql("SELECT co.id as courseId ,co.visible as visible ,co.fullname as courseName,co.summary as courseDesc,co.category as catId,cat.name as catName FROM `mo_course` as co join mo_course_categories as cat ON co.category=cat.id  where co.category=" . $categoryid . "");
    $data_courses = array_values($courses);
    $coursesData = array();
    $coursecontacts = array();
    $teacherId = -1;
    $teacherName = "";

    foreach ($data_courses as $course) {
        if ($course->visible) {
            $price = $DB->get_record('customfield_data', array('fieldid' => 12, 'instanceid' => $course->courseid));
            if (empty($price)) {
                $price = 'free';
            }
            $courseDescription = $DB->get_record('customfield_data', array('fieldid' => 15, 'instanceid' => $course->courseid));

            $rating = $DB->get_records_sql("SELECT ceil(AVG(rate)) as rate FROM `mo_course_rates` WHERE courseid=$course->courseid");
            $rating = array_values($rating);

            // $inCart = 'false';
            // $record = $DB->get_record('cart', array('user' => $user, 'course' => $course->courseid));
            // if (!empty($record)) {
            //    $inCart='true';
            // } 

            $view = $DB->get_record('course_views', array('courseid' => $course->courseid));
            $imges = $DB->get_record("course", array('id' => $course->courseid));
            $courselist = new core_course_list_element($imges);
            $context = context_course::instance($course->courseid, MUST_EXIST);
            $enrol = is_enrolled($context, $user, '', true);
            if ($enrol) {
                $enrol = 'true';
            } else {
                $enrol = 'false';
            }
            $url = "";
            $overviewfiles = array();
            foreach ($courselist->get_course_overviewfiles() as $file) {
                $fileurl = moodle_url::make_webservice_pluginfile_url(
                    $file->get_contextid(),
                    $file->get_component(),
                    $file->get_filearea(),
                    null,
                    $file->get_filepath(),
                    $file->get_filename()
                )->out(false);
                $overviewfiles[] = array(
                    'filename' => $file->get_filename(),
                    'fileurl' => $fileurl,
                    'filesize' => $file->get_filesize(),
                    'filepath' => $file->get_filepath(),
                    'mimetype' => $file->get_mimetype(),
                    'timemodified' => $file->get_timemodified(),
                );
            }
            $overviewfiles = $overviewfiles[0]['fileurl'];
            $teachers = $DB->get_records_sql("SELECT u.firstname AS name,u.lastname AS lastname, u.url as picture,u.description,u.email,ra.contextid,u.id As id, c.fullname as coursename
            FROM   mo_course c
           LEFT OUTER JOIN   mo_context cx ON c.id = cx.instanceid
           LEFT OUTER JOIN   mo_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '3'
           LEFT OUTER JOIN   mo_user u ON ra.userid = u.id WHERE cx.contextlevel = '50' AND c.id= '$course->courseid';");
            foreach ($teachers as $teacher) {
                $teacherId = $teacher->id;
                $teacherName = $teacher->name . ' ' . $teacher->lastname;
            }
            $course->coursedesc = edit_description($course->coursedesc);
            if (empty($teacherId)) {
                $teacherId = -1;
                $teacherName = null;
            }
            $course->coursedesc = edit_description($course->coursedesc);

            $coursesData[] = array(
                'course_id' => $course->courseid, 'course_name' => $course->coursename,
                'enrol' => $enrol, 'course_desc' => $courseDescription->value, 'views' => $view->visit,
                'teacherId' => $teacherId, 'teacherName' => $teacherName, 'price' => $price->value, 'image' => $overviewfiles,
                'rate' => $rating[0]->rate, 'cat_id' => $course->catid, 'cat_name' => $course->catname
            );
        }
    }

    return json_encode(["data" => $coursesData]);
}

function get_all_user_enrolled_courses($user)
{
    global $DB, $CFG;
    $courses = $DB->get_records_sql("SELECT co.id as courseId ,co.fullname as courseName,co.summary as courseDesc,co.category as catId,cat.name as catName FROM `mo_course` as co join mo_course_categories as cat ON co.category=cat.id ");
    $data_courses = array_values($courses);
    $coursesData = array();
    $coursecontacts = array();
    $teacherId = -1;
    $teacherName = "";

    foreach ($data_courses as $course) {
        $context = context_course::instance($course->courseid, MUST_EXIST);
        $enrol = is_enrolled($context, $user, '', true);

        if ($enrol) {
            $enrol = 'true';

            $price = $DB->get_record('customfield_data', array('fieldid' => 12, 'instanceid' => $course->courseid));
            if (empty($price)) {
                $price = 'free';
            }

            $rating = $DB->get_records_sql("SELECT ceil(AVG(rate)) as rate FROM `mo_course_rates` WHERE courseid=$course->courseid");
            $rating = array_values($rating);

            // $inCart = 'false';
            // $record = $DB->get_record('cart', array('user' => $user, 'course' => $course->courseid));
            // if (!empty($record)) {
            //    $inCart='true';
            // } 

            $view = $DB->get_record('course_views', array('courseid' => $course->courseid));
            $imges = $DB->get_record("course", array('id' => $course->courseid));
            $courselist = new core_course_list_element($imges);

            $url = "";
            $overviewfiles = array();
            foreach ($courselist->get_course_overviewfiles() as $file) {
                $fileurl = moodle_url::make_webservice_pluginfile_url(
                    $file->get_contextid(),
                    $file->get_component(),
                    $file->get_filearea(),
                    null,
                    $file->get_filepath(),
                    $file->get_filename()
                )->out(false);
                $overviewfiles[] = array(
                    'filename' => $file->get_filename(),
                    'fileurl' => $fileurl,
                    'filesize' => $file->get_filesize(),
                    'filepath' => $file->get_filepath(),
                    'mimetype' => $file->get_mimetype(),
                    'timemodified' => $file->get_timemodified(),
                );
            }
            $overviewfiles = $overviewfiles[0]['fileurl'];
            $teachers = $DB->get_records_sql("SELECT u.firstname AS name,u.lastname AS lastname, u.description,u.email,ra.contextid,u.id As id, c.fullname as coursename
                FROM   mo_course c
               LEFT OUTER JOIN   mo_context cx ON c.id = cx.instanceid
               LEFT OUTER JOIN   mo_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '3'
               LEFT OUTER JOIN   mo_user u ON ra.userid = u.id WHERE cx.contextlevel = '50' AND c.id= '$course->courseid';");
            foreach ($teachers as $teacher) {
                $teacherId = $teacher->id;
                $teacherName = $teacher->name . ' ' . $teacher->lastname;
            }

            if (empty($teacherId)) {
                $teacherId = -1;
                $teacherName = null;
            }
            $courseDescription = $DB->get_record('customfield_data', array('fieldid' => 15, 'instanceid' => $course->courseid));
            $course->coursedesc = edit_description($course->coursedesc);

            $coursesData[] = array(
                'course_id' => $course->courseid, 'course_name' => $course->coursename,
                'enrol' => $enrol, 'course_desc' => $courseDescription->value, 'views' => $view->visit,
                'teacherId' => $teacherId, 'teacherName' => $teacherName, 'price' => $price->value,
                'image' => $overviewfiles, 'rate' => $rating[0]->rate, 'cat_id' => $course->catid, 'cat_name' => $course->catname, 'inCart' => $inCart
            );
        } else {
            $enrol = 'false';
        }
    }

    return json_encode(["data" => $coursesData]);
}

function get_course_badges($courseId)
{
    global $DB;
    $badges = $DB->get_records_sql('SELECT b.* FROM mo_badge b WHERE b.courseid=' . $courseId . '');
    $context = context_course::instance($courseId, MUST_EXIST);

    return json_encode(['badges' => array_values($badges), 'context' => $context->id]);
}


function get_badge_users($badgeId)
{
    global $DB;
    $users = $DB->get_records_sql('SELECT u.* FROM `mo_badge_issued` as bi JOIN `mo_user` as u ON u.id=bi.`userid` WHERE `badgeid`=' . $badgeId . '');
    return json_encode(['users' => array_values($users)]);
}

function get_session($userid)
{
    global $DB;
    $user = $DB->get_record('user', array('id' => $userid));
    $user = complete_user_login($user);
    if (!empty($user)) {
        $session = $DB->get_records_sql("SELECT sid  FROM `mo_sessions` WHERE `userid`=" . $userid . " ORDER BY `timecreated` DESC LIMIT 1");
        $session = array_values($session);
        $item = $session[0];

        return json_encode(["session" => $item->sid]);
    }
}
// function get_session($userid)
// {
//     global $DB;
//     $user = $DB->get_record('user', array('id' => $userid));
//     $data='';
//     $session=$DB->get_records_sql("SELECT sid  FROM `mo_sessions` WHERE `userid`=" . $userid . " ORDER BY `timecreated` DESC LIMIT 1");
//     if(!empty($session)){
//         foreach($session as $item){
//         $data=$item->sid;
//         }
//     }
//     else{
//         $user = complete_user_login($user);
//         if (!empty($user)) {
//             $session = $DB->get_records_sql("SELECT sid  FROM `mo_sessions` WHERE `userid`=" . $userid . " ORDER BY `timecreated` DESC LIMIT 1");
//             $session = array_values($session);
//             $data = $session[0]->sid;   
//         }
//     }
//     return json_encode(["session" => $data]);
// }

function unenroll_user($courseid, $userid)
{
    global $DB;
    $instances = $DB->get_records('enrol', array('courseid' => $courseid));
    foreach ($instances as $instance) {
        $plugin = enrol_get_plugin($instance->enrol);
        $plugin->unenrol_user($instance, $userid);
    }
    return json_encode(['status' => 'success', "data" => 'done']);
}
function signUpNew($firstname, $lastname, $username, $email, $password, $phone = null, $phone2 = null, $role, $year = null, $city = null, $school = null, $center = null)
{
    global $DB;
    $userInfo = new stdClass();
    $yearInfo = new stdClass();
    $roleAssignment = new stdClass();
    $record = new stdClass();
    $check_userrname = $DB->get_record('user', array('username' => $username));
    $check_email = $DB->get_record('user', array('email' => $email));
    if (!empty($check_userrname)) {
        return json_encode(["message" => 'username exists']);
    } elseif (!empty($check_email)) {
        return json_encode(["message" => 'Email exists']);
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return json_encode(["message" => 'invalid email']);
    } else {
        $userInfo->firstname = $firstname;
        $userInfo->lastname = $lastname;
        $userInfo->username = $username;
        $userInfo->email = $email;
        $hashPass = hash_internal_user_password($password);
        $userInfo->password = $hashPass;
        $userInfo->phone1 = $phone;
        $userInfo->phone2 = $phone2;
        $userInfo->confirmed = 1;
        $userInfo->mnethostid = 1;
        if ($role == 9) {
            $userInfo->id = $DB->insert_record('user', $userInfo);
        } elseif ($year != null && $role != 9) {
            if ($city != null) {
                $userInfo->city = $city;
            }
            $userInfo->country = "EG";
            $userInfo->lang = "ar";
            if ($school != null && $center != null) {
                $userInfo->id = $DB->insert_record('user', $userInfo);
                $yearMap = array("primary 1" => 1, "primary 2" => 2, "primary 3" => 3, "primary 4" => 4, "primary 5" => 5, "primary 6" => 6, "preparatory 1" => 7, "preparatory 2" => 8, "preparatory 3" => 9, "Secondary 1" => 10, "Secondary 2" => 11, "Secondary 3" => 12);
                $key = array_search(intval($year), $yearMap);
                $yearInfo->userid = $userInfo->id;
                $yearInfo->fieldid = 1;
                $yearInfo->data = $key;
                $yearInfo->dataformat = 0;
                $yearInfo->id = $DB->insert_record('user_info_data', $yearInfo);

                $optional_data = new stdClass();
                $optional_data->userid = $userInfo->id;
                $optional_data->school = $school;
                $optional_data->empty = $center;
                $optional_data->id = $DB->insert_record('optional_data_aibrahim', $optional_data);
            } else {
                return json_encode(["message" => 'you have to write your school and your center']);
            }
        } elseif ($year == null && $role != 9) {
            return json_encode(["message" => 'you have to add a year']);
        }
        $record->contextlevel = 30;
        $record->instanceid   =  $userInfo->id;
        $record->depth        = 0;
        $record->path         = null; //not known before insert
        $record->locked       = 0;
        $record->id = $DB->insert_record('context', $record);
        $parentpath = '/1';
        $record->path = $parentpath . '/' . $record->id;
        $record->depth = substr_count($record->path, '/');
        $DB->update_record('context', $record);
        $roleAssignment->roleid = $role;
        $roleAssignment->contextid = $record->id;
        $roleAssignment->userid = $userInfo->id;
        $roleAssignment->timemodified = time();
        $roleAssignment->modifierid = $userInfo->id;
        $roleAssignment->id = $DB->insert_record('role_assignments', $roleAssignment);
        return json_encode(["message" => 'success']);
    }
}
function get_all_courses($user, $teacher, $lang = '')
{
    global $DB, $CFG;
    $coursesData = array();
    $studentRole = $DB->get_field('role', 'id', array('shortname' => 'student'));
    $isStudent = $DB->record_exists('role_assignments', ['userid' => $user, 'roleid' => $studentRole]);
    $teacherRole = $DB->get_field('role', 'id', array('shortname' => 'student'));
    $teacherRole = $DB->record_exists('role_assignments', ['userid' => $user, 'roleid' => $teacherRole]);
    $assisstantRole = $DB->get_field('role', 'id', array('shortname' => 'teacher'));
    $assisstantRole = $DB->record_exists('role_assignments', ['userid' => $user, 'roleid' => $assisstantRole]);
    if ($lang == "ar") {
        $lang = "and c.lang='ar'";
    } elseif ($lang == "en") {
        $lang = "and c.lang='en'";
    }
    $data_courses = $DB->get_records_sql("SELECT  c.id AS courseId,c.visible as visible, c.fullname as courseName,c.category as catId,cat.name as catName ,cinfo.value as year
    FROM   mo_course c
    LEFT OUTER JOIN mo_customfield_data cinfo ON c.id=cinfo.instanceid

     LEFT OUTER JOIN mo_course_categories  cat   ON c.category=cat.id 
      LEFT OUTER JOIN   mo_context cx ON c.id = cx.instanceid
    LEFT OUTER JOIN   mo_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '3'
     LEFT OUTER JOIN   mo_user u ON ra.userid = u.id 
     WHERE cx.contextlevel = '50' AND cinfo.fieldid=1 AND u.id= '$teacher' $lang;");

    // $data_courses = array_values($courses);
    $teacherId = -1;
    $teacherName = "";
    $get_teacher_data = $DB->get_record('user', array('id' => $teacher));
    if ($isStudent || ($teacherRole && $teacher != $user)) {

        $student = $DB->get_record('user_info_data', array('userid' => $user, 'fieldid' => 1));
        $yearMap = array(1 => "primary 1", 2 => "primary 2", 3 => "primary 3", 4 => "primary 4", 5 => "primary 5", 6 => "primary 6", 7 => "preparatory 1", 8 => "preparatory 2", 9 => "preparatory 3", 10 => "Secondary 1", 11 => "Secondary 2", 12 => "Secondary 3");
        $key = array_search($student->data, $yearMap);
        foreach ($data_courses as $course) {

            if ($key == $course->year) {
                $price = $DB->get_record('customfield_data', array('fieldid' => 12, 'instanceid' => $course->courseid));
                if (empty($price)) {
                    $price = 'free';
                }
                $courseDescription = $DB->get_record('customfield_data', array('fieldid' => 15, 'instanceid' => $course->courseid));
                $rating = $DB->get_records_sql("SELECT ceil(AVG(rate)) as rate FROM `mo_course_rates` WHERE courseid=$course->courseid");
                $rating = array_values($rating);

                // $inCart = 'false';
                // $record = $DB->get_record('cart', array('user' => $user, 'course' => $course->courseid));
                // if (!empty($record)) {
                //    $inCart='true';
                // } 

                $view = $DB->get_record('course_views', array('courseid' => $course->courseid));
                $imges = $DB->get_record("course", array('id' => $course->courseid));
                $courselist = new core_course_list_element($imges);
                $context = context_course::instance($course->courseid, MUST_EXIST);
                $enrol = is_enrolled($context, $user, '', true);
                if ($enrol) {
                    $enrol = 'true';
                } else {
                    $enrol = 'false';
                }
                $overviewfiles = array();
                foreach ($courselist->get_course_overviewfiles() as $file) {
                    $fileurl = moodle_url::make_webservice_pluginfile_url(
                        $file->get_contextid(),
                        $file->get_component(),
                        $file->get_filearea(),
                        null,
                        $file->get_filepath(),
                        $file->get_filename()
                    )->out(false);
                    $overviewfiles[] = array(
                        'filename' => $file->get_filename(),
                        'fileurl' => $fileurl,
                        'filesize' => $file->get_filesize(),
                        'filepath' => $file->get_filepath(),
                        'mimetype' => $file->get_mimetype(),
                        'timemodified' => $file->get_timemodified(),
                    );
                }
                $overviewfiles = $overviewfiles[0]['fileurl'];


                $teacherId = $get_teacher_data->id;
                $teacherName = $get_teacher_data->firstname . ' ' . $get_teacher_data->lastname;

                $course->coursedesc = edit_description($course->coursedesc);
                if (empty($teacherId)) {
                    $teacherId = -1;
                    $teacherName = null;
                }
                // $coursesData[] = array('course_id' => $course->courseid, 'course_name' => $course->coursename,
                //  'enrol' => $enrol, 'course_desc' => $courseDescription->value,
                //   'views' => $view->visit, 'teacherId' => $teacherId,
                //    'teacherName' => $teacherName, 'price' => $price->value, 'image' => $url,
                //    'rate' => $rating[0]->rate, 'cat_id' => $course->catid, 'cat_name' => $course->catname
                //    );

                if (empty($view->visit)) {
                    $view->visit = "";
                }
                if (empty($rating[0]->rate)) {
                    $rating[0]->rate = "0";
                }
                $coursesData[] = array(
                    'course_id' => $course->courseid, 'course_name' => $course->coursename,
                    'enrol' => $enrol, 'course_desc' => $courseDescription->value, 'course_year' => $course->year,
                    'views' => $view->visit, 'teacherId' => $teacherId,
                    'teacherName' => $teacherName, 'image' => $overviewfiles, 'price' => $price->value,
                    'rate' => $rating[0]->rate, 'cat_id' => $course->catid, 'cat_name' => $course->catname
                );
            }
        }
    } else {
        // 
        // return json_encode(["data" => $data_courses]);
        foreach ($data_courses as $course) {
            // return json_encode(["data" => '2']);
            if ($course->visible) {
                $price = $DB->get_record('customfield_data', array('fieldid' => 12, 'instanceid' => $course->courseid));
                if (empty($price)) {
                    $price = 'free';
                }
                $courseDescription = $DB->get_record('customfield_data', array('fieldid' => 15, 'instanceid' => $course->courseid));
                $rating = $DB->get_records_sql("SELECT ceil(AVG(rate)) as rate FROM `mo_course_rates` WHERE courseid=$course->courseid");
                $rating = array_values($rating);

                // $inCart = 'false';
                // $record = $DB->get_record('cart', array('user' => $user, 'course' => $course->courseid));
                // if (!empty($record)) {
                //    $inCart='true';
                // } 

                $view = $DB->get_record('course_views', array('courseid' => $course->courseid));
                $imges = $DB->get_record("course", array('id' => $course->courseid));
                $courselist = new core_course_list_element($imges);
                $context = context_course::instance($course->courseid, MUST_EXIST);
                $enrol = is_enrolled($context, $user, '', true);
                if ($enrol) {
                    $enrol = 'true';
                } else {
                    $enrol = 'false';
                }
                $url = "";
                // foreach ($courselist->get_course_overviewfiles() as $file) {
                //     $isimage = $file->is_valid_image();
                //     $url = file_encode_url("{$CFG->wwwroot}/pluginfile.php", '/' . $file->get_contextid() . '/' . $file->get_component() . '/' . $file->get_filearea() . $file->get_filepath() . $file->get_filename(), !$isimage);
                // }
                $overviewfiles = array();
                foreach ($courselist->get_course_overviewfiles() as $file) {
                    $fileurl = moodle_url::make_webservice_pluginfile_url(
                        $file->get_contextid(),
                        $file->get_component(),
                        $file->get_filearea(),
                        null,
                        $file->get_filepath(),
                        $file->get_filename()
                    )->out(false);
                    $overviewfiles[] = array(
                        'filename' => $file->get_filename(),
                        'fileurl' => $fileurl,
                        'filesize' => $file->get_filesize(),
                        'filepath' => $file->get_filepath(),
                        'mimetype' => $file->get_mimetype(),
                        'timemodified' => $file->get_timemodified(),
                    );
                }
                $overviewfiles = $overviewfiles[0]['fileurl'];
                $teachers = $DB->get_records_sql("SELECT u.firstname AS name,u.lastname AS lastname,u.description,u.email,ra.contextid,u.id As id, c.fullname as coursename
                FROM   mo_course c
               LEFT OUTER JOIN   mo_context cx ON c.id = cx.instanceid
               LEFT OUTER JOIN   mo_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '3'
               LEFT OUTER JOIN   mo_user u ON ra.userid = u.id WHERE cx.contextlevel = '50' AND c.id= '$course->courseid';");
                foreach ($teachers as $teacher) {
                    $teacherId = $teacher->id;
                    $teacherName = $teacher->name . ' ' . $teacher->lastname;
                }
                $course->coursedesc = edit_description($course->coursedesc);
                if (empty($teacherId)) {
                    $teacherId = -1;
                    $teacherName = null;
                }
                // $coursesData[] = array('course_id' => $course->courseid, 'course_name' => $course->coursename,
                //  'enrol' => $enrol, 'course_desc' => $courseDescription->value,
                //   'views' => $view->visit, 'teacherId' => $teacherId,
                //    'teacherName' => $teacherName, 'price' => $price->value, 'image' => $url,
                //    'rate' => $rating[0]->rate, 'cat_id' => $course->catid, 'cat_name' => $course->catname
                //    );
                if (empty($view->visit)) {
                    $view->visit = "";
                }
                if (empty($rating[0]->rate)) {
                    $rating[0]->rate = "0";
                }

                $coursesData[] = array(
                    'course_id' => $course->courseid, 'course_name' => $course->coursename,
                    'enrol' => $enrol, 'course_desc' => $courseDescription->value, 'course_year' => $course->year,
                    'views' => $view->visit, 'teacherId' => $teacherId,
                    'teacherName' => $teacherName, 'image' => $overviewfiles, 'price' => $price->value,
                    'rate' => $rating[0]->rate, 'cat_id' => $course->catid, 'cat_name' => $course->catname
                );
            }
        }
    }

    return json_encode(["data" => $coursesData]);
}
function check_quiz_reviews($quiz)
{
    global $DB;
    $quizData = $DB->get_record('quiz', array('id' => $quiz));
    if ($quizData->reviewspecificfeedback == 0 && $quizData->reviewgeneralfeedback == 0 && $quizData->reviewgeneralfeedback == 0 && $quizData->reviewcorrectness == 0 && $quizData->reviewrightanswer == 0) {
        return json_encode(["data" => 'exam']);
    } else {
        return json_encode(["data" => 'quiz']);
    }
}
function user_language_update($userid, $lang)
{
    global $DB;
    $user = $DB->get_record('user', array('id' => $userid));
    $record = new stdClass();
    $record->id = $user->id;
    $record->lang = $lang;
    $record->id = $DB->update_record('user', $record);
}
function get_members_array($groupID)
{
    global $DB;
    $members = array();
    /*
    SELECT $fields
                                   FROM {user} u
                                     INNER JOIN {groups_members} gm ON u.id = gm.userid
                                     INNER JOIN {groupings_groups} gg ON gm.groupid = gg.groupid
                                  WHERE  gg.groupingid = ?
                               ORDER BY $sort", array($groupingid));
    */

    $members = $DB->get_records_sql("SELECT u.id As id,concat(u.firstname , ' ', u.lastname)as fullname,u.url as image,gm.timeadded as added,op.empty as center_name ,op.school as school_name
  FROM mo_user u
  INNER join mo_optional_data_aibrahim as op ON op.userid=u.id

    INNER JOIN mo_groups_members gm ON u.id = gm.userid WHERE  gm.groupid =   $groupID ORDER BY u.id ASC");
    $members = array_values($members);
    foreach ($members as $member) {
        $member->added = date('m/d/Y H:i:s', $member->added);
    }
    return $members;
}
function get_enrolled_users_members($courseid, $option)
{
    global $DB;
    $notmember = array();
    $member = array();
    $notmemberData = array();
    $memberData = array();
    $group_members = $DB->get_records_sql("SELECT u.id As id,concat(u.firstname , ' ', u.lastname)as fullname, t.token as usertoken, u.email as email, u.phone1 as student_phone ,op.empty as center_name ,op.school as school_name
    FROM mo_course c INNER JOIN mo_context cx ON c.id = cx.instanceid 
    INNER JOIN mo_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '5'
    INNER JOIN mo_user u ON ra.userid = u.id 
    INNER JOIN mo_external_tokens t ON t.userid = u.id 
    LEFT OUTER JOIN mo_optional_data_aibrahim as op ON op.userid=u.id
    WHERE cx.contextlevel = '50' AND c.id=$courseid");

    foreach ($group_members as $en_s) {
        if ($en_s->center_name == null) {
            $en_s->center_name = '';
        }
        if ($en_s->school_name == null) {
            $en_s->school_name = '';
        }
        if ($en_s->student_phone == null) {
            $en_s->student_phone = '';
        }
    }
    return json_encode(["status" => 'success', 'groupmember' => array_values($group_members), 'others' => $notmember]);
}
function check_device_code($userid, $code, $activityid, $device, $deviceid = null)
{
    global $DB;
    $check_code = $DB->get_record('codes_generator', array('code' => $code));
    $code_used = $DB->get_record('activity_restrict_views_code_device_check', array('code' => $check_code->id));
    if (!empty($check_code)) {
        $check_views = $DB->get_record('activity_restrict_views_code_device_check', array('expired' => 0, 'code' => $check_code->id));
        $check_code_expiration = $DB->get_record('activity_restrict_views_code_device_check', array('expired' => 1, 'code' => $check_code->id));
        // $code_used=$DB->get_record('activity_restrict_views_code_device_check',array('code'=>$check_code->id,'userid'=>$userid,));
    } else {
        $err = "wrong-code";
        return json_encode(['data' => $err]);
    }
    if (!empty($check_code_expiration)) {
        $err = "expired-code";
        return json_encode(['data' => $err]);
    }
    if (!empty($check_views)) {
        if ($check_views->userid != $userid) {
            $err = "wrong-code";
            return json_encode(['data' => $err]);
        }
    }

    if ($device == "1") {
        // $check_views=$DB->get_record('activity_restrict_views_code_device_check',array('userid'=>$userid,'expired'=>0,'code'=>$check_code->id));

        if (empty($check_views)) {
            $ins = new stdClass();
            $ins->code = $check_code->id;
            $ins->number_of_views = 0;
            $ins->userid = $userid; //student id
            $ins->activityid = $activityid;
            $ins->expired = 0;
            $ins->web = 1;
            $ins->mobile = 0;
            $ins->col1 = "";
            $ins->id = $DB->insert_record('activity_restrict_views_code_device_check', $ins);
            if (empty($_COOKIE['' . $check_code->code . ''])) {
                setcookie('' . $check_code->code . '', $check_code->code, time() + 60 * 60 * $check_code->last);
                $data = new stdClass();
                $data->id = $ins->id;
                $data->number_of_views = 1;
                $data->id = $DB->update_record('activity_restrict_views_code_device_check', $data);
            }
            return json_encode(['data' => "done"]);
        } elseif (!empty($check_views) && $check_views->mobile != "1") {
            if ($check_code->number_of_tries == $check_views->number_of_views) {
                $ins = new stdClass();
                $ins->id = $check_views->id;
                $ins->expired = 1;
                $ins->id = $DB->update_record('activity_restrict_views_code_device_check', $ins);
                $err = "Expired";
                return json_encode(['data' => $err]);

                // redirect("list.php");

            } elseif (!empty($check_views) && $activityid == $check_views->activityid) {
                if (!empty($_COOKIE['' . $check_code->code . '']) && $_COOKIE['' . $check_code->code . ''] == $check_code->code) {
                    $ins = new stdClass();
                    $ins->id = $check_views->id;
                    $ins->number_of_views = $check_views->number_of_views + 1;
                    $ins->id = $DB->update_record('activity_restrict_views_code_device_check', $ins);
                    $data = "true";
                    return json_encode(['data' => $data]);
                } else {
                    $err = "error";
                    return json_encode(['data' => $err]);
                }
            } elseif (!empty($check_views) && $activityid != $check_views->activityid) {
                $err = "refused";
                return json_encode(['data' => $err]);
            }
        } else {
            $err = "You have to enter from your device";
            return json_encode(['data' => $err]);
        }
    } elseif ($device == "2") {
        if (empty($check_views)) {
            $ins = new stdClass();
            $ins->code = $check_code->id;
            $ins->number_of_views = 1;
            $ins->userid = $userid; //student id
            $ins->activityid = $activityid;
            $ins->expired = 0;
            $ins->web = 0;
            $ins->mobile = 1;
            $ins->col1 = $deviceid;
            $ins->id = $DB->insert_record('activity_restrict_views_code_device_check', $ins);
            return json_encode(['data' => "true"]);
        } elseif (!empty($check_views) && $check_views->web != "1" && $check_views->mobile == "1") {
            if ($check_code->number_of_tries == $check_views->number_of_views) {
                $ins = new stdClass();
                $ins->id = $check_views->id;
                $ins->expired = 1;
                $ins->id = $DB->update_record('activity_restrict_views_code_device_check', $ins);
                $err = "Expired";
                return json_encode(['data' => $err]);

                // redirect("list.php");

            } elseif (!empty($check_views) && $activityid != $check_views->activityid || $check_views->col1 != $deviceid) {
                $err = "refused";
                return json_encode(['data' => $err]);
            } elseif (!empty($check_views) && $activityid == $check_views->activityid) {

                $ins = new stdClass();
                $ins->id = $check_views->id;
                $ins->number_of_views = $check_views->number_of_views + 1;
                $ins->id = $DB->update_record('activity_restrict_views_code_device_check', $ins);
                $data = "true";
                return json_encode(['data' => $data]);
            }
        } else {
            $err = "You have to enter from your device";
            return json_encode(['data' => $err]);
        }
    }
}
function check_availability($courseid, $cmid, $userid)
{
    global $DB, $CFG;
    require_once($CFG->dirroot . "/course/lib.php");

    $course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
    // return json_encode(['data' => $course]);
    $modinfo = get_fast_modinfo($course, $userid);
    $cm = $modinfo->get_cm($cmid);
    if ($cm->uservisible) {
        // User can access the activity.
        return json_encode(['flag' => true, 'data' => ""]);
    } else if ($cm->availableinfo) {
        // User cannot access the activity, but on the course page they will
        // see a link to it, greyed-out, with information (HTML format) from
        // $cm->availableinfo about why they can't access it.
        $reason1 = json_encode($cm->availableinfo);
        $reason = json_decode($reason1);
        $string = '';
        if (gettype($reason) == 'string') {

            $string = strip_tags($cm->availableinfo);
        } else {
            for ($i = 0; $i < count($reason->items); $i++) {
                // array_push($module['avail_message'], $reason->items[$i]->text." <br>");
                $string .= strip_tags($reason->items[$i]) . ",";
            }
            $string = substr($string, 0, -1);

            // $module['avail_message'] = $string;
        }
        return json_encode(['flag' => false, 'data' =>   $string]);
    } else {
        // User cannot access the activity and they will not see it at all.
        return json_encode(['data' => false, 'data' => "User cannot access the activity and they will not see it at all"]);
    }
}

/******************************************************/
// get user image
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

function is_admin($USERID)
{
    $admins = get_admins();
    $isadmin = false;

    foreach ($admins as $admin) {
        if ($USERID == $admin->id) {
            $isadmin = true;
            break; // No need to continue checking once we find an admin
        }
    }

    return json_encode(['status' => 'success', 'is_admin' => $isadmin]);
}

function get_course_last_access($courseid, $userid)
{
    global $DB;

    // Define the SQL query
    $sql = "SELECT MAX(timeaccess) AS last_access
            FROM {user_lastaccess}
            WHERE courseid = :courseid
            AND userid = :userid";

    // Define the parameters
    $params = [
        'courseid' => $courseid,
        'userid' => $userid,
    ];

    // Execute the SQL query
    $last_access_record = $DB->get_record_sql($sql, $params);

    // Check if a record was found
    if ($last_access_record) {
        return $last_access_record->last_access;
    } else {
        // Return a default value if no record is found
        return null;
    }
}

function get_user_token($user_id)
{
    global $DB;

    // Define the SQL query to get the user's token
    $sql = "SELECT token
            FROM {external_tokens}
            WHERE userid = :userid";

    // Define the parameters
    $params = [
        'userid' => $user_id,
    ];

    // Execute the SQL query
    $user_token = $DB->get_field_sql($sql, $params);

    // Return the user's token
    return $user_token;
}

function get_user_role_in_course($user_id, $course_id)
{
    global $DB;

    // Get the user's context in the course
    $context = context_course::instance($course_id);

    // Get all roles for the user in the course
    $user_roles = get_user_roles($context, $user_id, true);

    // Initialize an array to store role names
    $role_names = array();

    // Loop through the user's roles and store their names
    foreach ($user_roles as $user_role) {
        $role_names[] = $user_role->shortname;
    }

    // Return the role names as an array
    return $role_names;
}

function get_user_profile_image($user_id)
{
    global $DB, $OUTPUT, $CFG;

    $user = $DB->get_record('user', array('id' => $user_id));
    $user_context = $DB->get_record('context', array('instanceid' => $user_id, 'contextlevel' => 30));
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

function get_user_enrolled_courses_count($userid)
{
    global $DB;

    // Define the SQL query to count the user's enrolled courses.
    $sql = "SELECT COUNT(DISTINCT c.id)
            FROM {user_enrolments} ue
            JOIN {enrol} e ON e.id = ue.enrolid
            JOIN {course} c ON c.id = e.courseid
            WHERE ue.userid = :userid";

    // Execute the SQL query with the user's ID as a parameter.
    $params = array('userid' => $userid);
    $count = $DB->count_records_sql($sql, $params);

    return $count;
}

function get_course_ratings($courseId)
{
    global $DB;

    // Define the SQL query to retrieve ratings for a specific course.
    $sql = "SELECT rating ,user
            FROM {theme_edumy_courserate}
            WHERE course = :courseid";

    // Execute the SQL query with the course ID as a parameter.
    $params = array('courseid' => $courseId);
    $ratings = $DB->get_records_sql($sql, $params);

    // Calculate the average rating.
    $totalRating = 0;
    $count = count($ratings);

    $rates_arr = [];
    foreach ($ratings as $rating) {
        $totalRating += $rating->rating;
        $data = [
            'rate' => $rating->rating,
            'user' => $rating->user,
        ];
        $rates_arr[] = $data;
    }

    $averageRating = ($count > 0) ? $totalRating / $count : 0;

    return array('count' => $count, 'average_rating' => $averageRating, 'ratings' => $rates_arr);
}


function get_user_enrolled_courses($userId)
{
    global $DB, $CFG;

    require_once($CFG->dirroot . '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
    require_once($CFG->dirroot . '/course/renderer.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
    require_once($CFG->dirroot . '/theme/edumy/ccn/user_handler/ccn_user_handler.php');

    // Define the SQL query to retrieve information about the user's enrolled courses.
    $sql = "SELECT c.id, c.fullname
            FROM {user_enrolments} ue
            JOIN {enrol} e ON e.id = ue.enrolid
            JOIN {course} c ON c.id = e.courseid
            WHERE ue.userid = :userid";

    // Execute the SQL query with the user's ID as a parameter.
    $params = array('userid' => $userId);
    $enrolledCourses = $DB->get_records_sql($sql, $params);
    $courses_arr = [];

    foreach ($enrolledCourses as $course) {
        $ccnCourseHandler = new ccnCourseHandler();
        // Retrieve course details
        $ccnCourse = $ccnCourseHandler->ccnGetCourseDetails($course->id);
        $rating = get_course_ratings($course->id);
        $data = [
            'id' => $course->id,
            'fullname' => $course->fullname,
            'image_url' =>  $ccnCourse->imageUrl,
            /* 'rating' => $rating, */
        ];
        $courses_arr[] = $data;
    }

    // Count the number of enrolled courses.
    $count = count($enrolledCourses);

    return json_encode(['status' => 'success', 'count' => $count, 'courses' => $courses_arr]);
}


function new_get_enroll_users($userID, $courseid)
{
    global $DB;
    // Get the course context
    $course = get_course($courseid);
    $context = context_course::instance($course->id);

    // Get the list of enrolled users
    $enrolled_users = get_enrolled_users($context, '', 0, 'u.id, u.username, u.firstname, u.lastname, u.email, u.phone2, u.phone1');

    $users_arr = [];
    foreach ($enrolled_users as $enrolled_user) {
        $user_id = $enrolled_user->id;
        $last_access = get_course_last_access($courseid, $user_id);
        $last_access_date = date('Y-m-d H:i:s', $last_access);
        $user_token = get_user_token($user_id);
        if (empty($user_token)) {
            $user_token = null;
        }

        // Get user role
        $user_roles = get_user_role_in_course($user_id, $courseid);
        if (!empty($user_roles)) {
            foreach ($user_roles as $role) {
                $role_data = $role;
            }
        } else {
            $role_data = ["User doesn't have any roles in the course."];
        }

        // Get user profile image
        $user_image = get_user_profile_image($user_id);

        $admins = get_admins();
        $isadmin = false;

        foreach ($admins as $admin) {
            if ($enrolled_user->id == $admin->id) {
                $isadmin = true;
                break; // No need to continue checking once we find an admin
            }
        }

        $coursesCount = get_user_enrolled_courses_count($user_id);

        $data = [
            'id' => $enrolled_user->id,
            'email' => $enrolled_user->email,
            /* 'username' => $enrolled_user->username, */
            'token' => $user_token,
            'fullname' => $enrolled_user->firstname,
            /* 'secondName' => $enrolled_user->secondname,
            'thirdName' => $enrolled_user->thirdname, */
            /* 'lastname' => $enrolled_user->lastname, */
            /* 'scientificdegree' => $enrolled_user->scientificdegree,
            'description' => $enrolled_user->description,
            'job' => $enrolled_user->job,
            'city' => $enrolled_user->city, */
            /* 'phone2' => $enrolled_user->phone2, */
            'phone' => $enrolled_user->phone1,
            /*  'gender' => $user->gender, */
            'role' => $role_data,
            'isadmin' => $isadmin,
            'enrolled_courses_count' => $coursesCount,
            'user_image' => $user_image,
            'last_access' => $last_access_date
        ];
        $users_arr[] = $data;
    }

    $count = count($enrolled_users);

    if ($userID <= 0) {
        // Invalid or missing userID
        $response = ['status' => 'fail', 'error' => 'Invalid user ID'];
    } else {
        $user = $DB->get_record('user', array('id' => $userID));

        if ($user) {
            $response = ['status' => 'success', 'count' => $count, 'data' => $users_arr];
        } else {
            $response = ['status' => 'fail', 'data' => null, 'error' => 'Error: You must login to view this page'];
        }
    }

    echo json_encode($response);
}

function changeUserPassword($user_id, $new_password)
{
    global $DB;

    // Validate user_id and new_password
    if (empty($new_password)) {
        return json_encode(['data' => "The new password is required."]);
    }

    // Validate user_id and new_password
    if (empty($user_id)) {
        return json_encode(['data' => "User ID is required."]);
    }

    // Load the user data based on the user ID
    $user = $DB->get_record('user', array('id' => $user_id), '*', MUST_EXIST);

    // Validate the new password
    if (strlen($new_password) < 6) {
        return json_encode(['data' => "Password must be at least 6 characters long."]);
    }

    // Define the new password
    $new_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Set the new password for the user
    $user->password = $new_password;

    // Save the user data to the database
    if ($DB->update_record('user', $user)) {
        return json_encode(['status' => 'success', 'data' => "Password changed successfully!"]); // Password changed successfully
    } else {
        return json_encode(['status' => 'fail', 'data' => "Failed to change the password."]); // Password change failed
    }
}

function get_last_accessed_courses($user_id)
{
    global $DB;

    // SQL query to get the last accessed courses for the user, including last_accessed time
    $sql = "SELECT *
            FROM {course_modules_completion} cmc
            JOIN {course_modules} cm ON cmc.coursemoduleid = cm.id
            JOIN {course} c ON cm.course = c.id
            WHERE cmc.userid = :userid
            GROUP BY c.id, c.fullname, c.shortname
            ORDER BY MAX(cmc.timemodified) DESC";

    $act_params = array('userid' => $user_id);

    // Execute the SQL query and retrieve the result
    $lastAccessedCourses = $DB->get_records_sql($sql, $act_params);

    if ($lastAccessedCourses) {
        // Prepare the data in the desired format
        $data_arr = [];
        foreach ($lastAccessedCourses as $course) {
            $formattedLastAccessed = date('d M Y', $course->lastaccessed);
            $data = [
                'id' => $course->id,
                'fullname' => $course->fullname,
                'shortname' => $course->shortname,
                'lastaccessed' => $formattedLastAccessed,
            ];
            $data_arr[] = $data;
        }

        // Return the result as JSON data
        return json_encode(['data' => $data_arr]);
    } else {
        // Handle any errors or return an appropriate response if no data is found
        return json_encode(['error' => 'No data found']);
    }
}

function partners()
{
    global $CFG;
    // Sample data - replace this with your actual data
    $partnersData = [
        ['name' => 'Partner 1', 'image' => $CFG->wwwroot . '/partners_img/image1.png'],
        ['name' => 'Partner 2', 'image' => $CFG->wwwroot . '/partners_img/image2.png'],
        ['name' => 'Partner 3', 'image' => $CFG->wwwroot . '/partners_img/image3.png'],
        ['name' => 'Partner 4', 'image' => $CFG->wwwroot . '/partners_img/image4.png'],
        // Add more partners as needed
    ];

    return json_encode(['status' => 'success', 'data' => $partnersData]);
}

function Minister_speech()
{
    global $DB, $CFG;

    $minister_data = $DB->get_records('minister_data');

    $data_arr = [];
    foreach ($minister_data as $record) {
        $data = [
            'id' => $record->id,
            'name' => $record->title,
            'word' => $record->word,
            'image' => $CFG->wwwroot . '/theme/edumy/pix/minister/' . $record->image,
        ];
        $data_arr = $data;
    }

    return json_encode(['status' => 'success', 'data' => $data_arr]);
}

function calculate_course_average_rating($courseId)
{
    global $DB;

    try {
        // استعلام SQL لاحتساب متوسط التقييمات
        $sql = "SELECT AVG(rate) AS average_rating
                FROM {course_rates}
                WHERE courseid = :course_id";

        $params = ['course_id' => $courseId];
        $result = $DB->get_record_sql($sql, $params);

        if ($result) {
            $averageRating = round($result->average_rating, 2); // تقريب الناتج لرقمين بعد الفاصلة
            return $averageRating;
        } else {
            return json_encode(["status" => 'error', "message" => 'No ratings available for the course.'], JSON_UNESCAPED_UNICODE);
        }
    } catch (Exception $e) {
        // التعامل مع الأخطاء أو الاستثناءات هنا
        return json_encode(["status" => 'error', "message" => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
}

function calculate_teacher_average_rating($teacherId)
{
    global $DB;

    try {
        // استعلام SQL لاحتساب متوسط التقييمات
        $sql = "SELECT AVG(rating) AS average_rating
                FROM {teacher_rating}
                WHERE teacher_id = :teacherid";

        $params = ['teacherid' => $teacherId];
        $result = $DB->get_record_sql($sql, $params);

        if ($result) {
            $averageRating = round($result->average_rating, 2); // تقريب الناتج لرقمين بعد الفاصلة
            return $averageRating;
        } else {
            return json_encode(["status" => 'error', "message" => 'No ratings available for the teacher.'], JSON_UNESCAPED_UNICODE);
        }
    } catch (Exception $e) {
        // التعامل مع الأخطاء أو الاستثناءات هنا
        return json_encode(["status" => 'error', "message" => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
}

function training_centers($courseId)
{
    global $DB;

    // ابحث عن معرّفات المراكز المرتبطة بالدورة
    $courseCenters = $DB->get_record('customfield_data', ['fieldid' => 1, 'instanceid' => $courseId]);

    // تحقق مما إذا كان الحقل غير فارغ
    if (!empty($courseCenters->value)) {
        $centerIds = explode(",", $courseCenters->value);

        // ابحث عن بيانات المراكز باستخدام المكتبة
        $courseCenterData = $DB->get_records_list('centers', 'id', $centerIds);

        $arraycenters = [];
        foreach ($courseCenterData as $center) {
            $data_center = [
                'centername' => $center->centername,
                'address' => $center->address,
                'phone1' => $center->phone1,
                'phone2' => $center->phone2,
            ];

            $arraycenters[] = $data_center;
        }
    } else {
        $arraycenters = [];
    }

    $text = 'برجاء العلم ان في حالة اختيار كورسات ترتبط بالتدريب المهني فإنة يجب الرجوع للمراكز التدريبية التابعة لمحل إقامتك للتسجيل في دورة التدريب المهني الخاصة بالكورس المسجل فيه الطالب , نظرا لإن التدريب المهني له دورات و مواعيد مختلفة و محددة , و يكون التسجيل بالمركز عن طريق اسباقية الحضور و التسجيل في الدورة ,
    و تختلف مدة الدورات التدريبية بإختلاف الكورسات و مواعيد الدورات و يحدد ذلك المركز التدريبي الخاص بك نظرا لعدد المقاعد المحدودة و المتاحة في كل كورس تدريبي على حدا و تختلف الاعداد في ذلك , و تبدأ دورة جديدة للتدريب المهني بعد كل دورة تنتهي و يحدد موعدها المركز التدريبي المختص بعد تسجيلك المباشر في الدورة في المركز التدريبي التابع لك ,
    و قد يختلف المحاضر الاونلاين عن المحاضر في المركز التدريبي وفقا لجدول المحاضرين و ترتيب الدورات';

    // استخدام json_encode في المرة الأخيرة
    return json_encode(["status" => 'success', "text" => $text, "centers" => $arraycenters], JSON_UNESCAPED_UNICODE);
}

function get_users_with_role($roleShortname)
{
    global $DB;

    $role = $DB->get_record('role', array('shortname' => $roleShortname));

    if ($role) {
        $users = $DB->get_records_sql("SELECT u.* 
                                       FROM {user} u 
                                       INNER JOIN {role_assignments} ra ON u.id = ra.userid 
                                       WHERE ra.roleid = :roleid", array('roleid' => $role->id));

        if ($users) {
            $our_users  = [];
            foreach ($users as $user) {
                $teacherRatings = $DB->get_records('teacher_rating', array('teacher_id' => $user->id));

                $totalRating = 0;
                $numberOfRatings = count($teacherRatings);

                foreach ($teacherRatings as $teacherRating) {
                    $totalRating += $teacherRating->rating;
                }

                $averageRating = $numberOfRatings > 0 ? $totalRating / $numberOfRatings : 0;
                $formattedRating = intval($averageRating);

                $experience = $DB->get_record('user_info_data', array('userid' => $user->id, 'fieldid' => 7));
                $profession = $DB->get_record('user_info_data', array('userid' => $user->id, 'fieldid' => 5));

                $img_url = upload_user_image($user->id);

                $data = [
                    'id' => $user->id,
                    'img' => $img_url,
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                    'phone1' => $user->phone1,
                    'code' => $user->phone2,
                    'description' => $user->description,
                    'averagerating' => $formattedRating,
                    'experience' => $experience->data,
                    'profession' => $profession->data,
                ];
                $our_users[]  = $data;
            }
            // Return a JSON response with success status and user data
            return json_encode(["status" => 'success', "data" => $our_users]);
        } else {
            // Return a JSON response with success status but empty data
            return json_encode(["status" => 'success', "data" => []]);
        }
    } else {
        // Return a JSON response with error status if the role doesn't exist
        return json_encode(["status" => 'error', "message" => 'Role not found']);
    }
}

function get_user_data($userId)
{
    global $DB;

    // الحصول على سجل المستخدم
    $user = $DB->get_record('user', array('id' => $userId));

    if (!$user) {
        return json_encode(["status" => 'error', "message" => 'User not found']);
    }

    // جلب صورة المستخدم
    $img_url = upload_user_image($user->id);

    // جلب أدوار المستخدم
    $role_assignments = $DB->get_records_sql(
        "SELECT r.id, r.shortname
        FROM {role_assignments} ra
        JOIN {role} r ON ra.roleid = r.id
        WHERE ra.userid = ?
        ORDER BY ra.roleid ASC",
        [$user->id]
    );

    $role = null;

    // جلب دور المستخدم من حقل معلومات المستخدم إذا لم يتم تعيينه بالفعل
    $my_role = $DB->get_record('user_info_data', ['userid' => $user->id, 'fieldid' => 8]);
    if ($my_role) {
        if ($my_role->data == 'parent') {
            $role = "Parent";
        } elseif ($my_role->data == 'student') {
            $role = "student";
        }
    } else {

        foreach ($role_assignments as $role_assignment) {
            if ($role_assignment->id == 1) {
                $role = "manager";
                break;
            } elseif ($role_assignment->id == 3) {
                $role = "teacher";
                break;
            } elseif ($role_assignment->id == 2) {
                $role = "coursecreator";
                break;
            } elseif ($role_assignment->id == 4) {
                $role = "assistant";
                break;
            } elseif ($role_assignment->id == 5) {
                $role = "student";
                break;
            } elseif ($role_assignment->id == 6) {
                $role = "Guest";
                break;
            } elseif ($role_assignment->id == 7) {
                $role = "user";
                break;
            } elseif ($role_assignment->id == 8) {
                $role = "frontpage";
                break;
            } elseif ($role_assignment->id == 9) {
                $role = "Parent";
                break;
            }
        }
    }

    // إعداد بيانات المستخدم المراد إرجاعها
    $data = [
        'id' => $user->id,
        'fullname' => $user->firstname,
        'img' => $img_url,
        'email' => $user->email,
        'phone' => $user->phone1,
    ];

    if ($role == 'student') {
        $data = [
            'id' => $user->id,
            'fullname' => $user->firstname,
            'img' => $img_url,
            'email' => $user->email,
            'phone' => $user->phone1,
            'parentPhone' => $user->phone2,
        ];
    }

    // إرجاع الاستجابة JSON بنجاح
    return json_encode(["status" => 'success', "data" => $data]);
}


function delete_user_account($id)
{
    global $DB; // تأكيد على أن $DB متغير عام (global variable)

    $user_exists = $DB->record_exists('user', array('id' => $id));

    if ($user_exists) {
        // التحقق من صحة المعرف
        if (!is_numeric($id) || $id <= 0 || !ctype_digit((string) $id)) {
            $response = array(
                "status" => "error",
                "message" => "Invalid user ID"
            );
            return json_encode($response);
        }

        // الحصول على سجل المستخدم باستخدام المعرف
        $user = $DB->get_record('user', array('id' => $id));

        // التحقق مما إذا كان المستخدم موجودًا
        if (!$user) {
            $response = array(
                "status" => "error",
                "message" => "User not found"
            );
            return json_encode($response);
        }

        // قم بحذف السجل من قاعدة البيانات
        $deleted = $DB->delete_records('user', array('id' => $id));

        // التحقق من نجاح الحذف
        if ($deleted) {
            $response = array(
                "status" => "success",
                "message" => "User account deleted successfully",
            );
            return json_encode($response);
        } else {
            $response = array(
                "status" => "error",
                "message" => "Failed to delete user account"
            );
            return json_encode($response);
        }
    } else {
        $response = array(
            "status" => "error",
            "message" => "This user not fonund"
        );
        return json_encode($response);
    }
}

function policy()
{
    $link = 'https://nagaah.net/policies/';
    $response = array(
        "status" => "success",
        "data" => $link,
    );
    return json_encode($response);
}

function policy_data($lang)
{
    global $DB;

    $link = 'https://nagaah.net/policies/';
    $record = $DB->get_record('policies', array('lang' => $lang));
    $policies = $record->policies;
    $response = array(
        "status" => "success",
        "data" => [
            'link' => $link,
            'content' => $policies,
        ],
    );
    return json_encode($response);
}

function forgot_password()
{
    $link = 'https://nagaah.net/login/forgot_password.php';
    $response = array(
        "status" => "success",
        "data" => $link,
    );
    return json_encode($response);
}

function about()
{
    global $DB;

    // احتمالية حدوث خطأ بناء على قاعدة البيانات
    try {
        // الحصول على سجل البيانات
        $record = $DB->get_record('about_nagaah', array('id' => 1));

        // التحقق من وجود السجل
        if (!$record) {
            throw new Exception("Record not found");
        }

        // تحديد الحقول المطلوبة
        $fields = array(
            'main_img', 'vision_img', 'message_img', 'goal_img',
            'vision_header_ar', 'vision_body_ar', 'message_header_ar', 'message_body_ar',
            'goal_header_ar', 'goal_body_ar', 'vision_header', 'vision_body',
            'message_header', 'message_body', 'goal_header', 'goal_body'
        );

        // تخزين البيانات في مصفوفة
        $data = array();
        foreach ($fields as $field) {
            if (!empty($record->$field)) {
                $data[$field] = $record->$field;
            }
        }

        $response = array(
            "status" => "success",
            "data" => $data,
        );
    } catch (Exception $e) {
        // في حالة حدوث خطأ، يتم إرجاع رسالة الخطأ
        $response = array(
            "status" => "error",
            "message" => $e->getMessage(),
        );
    }

    return json_encode($response);
}

function contact_us()
{
    global $CFG;

    $data = array(
        /*'phone' => array(
            'title' => 'تواصل معنا عبر الهاتف',
            'number' => '01011111111',
            'icon' => $CFG->wwwroot . '/service_images/phoneicon.png'
        ),*/
        'facebook' => array(
            'title' => 'تواصل معنا عبر الفيسبوك',
            'link' => 'https://www.facebook.com/',
            'icon' => $CFG->wwwroot . '/service_images/fbicon.png'
        ),
        'whatsapp' => array(
            'title' => 'تواصل معنا عبر الواتساب',
            'link' => 'https://wa.me/01011111111?text=Hello%20I%20have%20a%20question%20?',
            'icon' => $CFG->wwwroot . '/service_images/whatsicon.png'
        ),
        /* 'youtube' => array(
            'title' => 'تواصل معنا عبر اليوتيوب',
            'link' => 'https://www.youtube.com/',
            'icon' => $CFG->wwwroot . '/service_images/youticon.png'
        ),*/
        'instagram' => array(
            'title' => 'تواصل معنا عبر الانستجرام',
            'link' => 'https://www.instagram.com/',
            'icon' => $CFG->wwwroot . '/service_images/instgicon.png'
        )
    );

    $response = array(
        "status" => "success",
        "data" => $data,
    );

    return json_encode($response);
}


function getBlockData($blockName)
{
    global $DB, $CFG;

    // Query to retrieve the block instance configuration data from the database
    $sql = "SELECT configdata FROM {block_instances} WHERE blockname = :blockname";
    $params = array('blockname' => $blockName);
    $htmlContent = $DB->get_field_sql($sql, $params);

    // Deserialize the configuration data to access the image URL
    $decoded_data = unserialize(base64_decode($htmlContent));

    // Retrieve the image URLs dynamically
    $fs = get_file_storage();
    $block = $DB->get_record('block_instances', array('blockname' => $blockName));
    $context = $DB->get_record('context', array('instanceid' => $block->id, 'contextlevel' => 80));
    $component = 'block_' . $blockName;
    $file_area = 'content';
    $files = $fs->get_area_files($context->id, $component, $file_area);

    $image_urls = [];
    foreach ($files as $file) {
        $filename = $file->get_filename();
        if ($filename <> '.') {
            $url = moodle_url::make_pluginfile_url(
                $file->get_contextid(),
                $file->get_component(),
                $file->get_filearea(),
                null,
                $file->get_filepath(),
                $filename
            );
            $image_urls[] = $url->out(false); // Get the URL as a string without encoding
        }
    }

    if ($blockName == 'cocoon_custom_html') {
        $response = $decoded_data;
    } else {

        // Construct the response data
        $response = [
            'text1' => strip_tags($decoded_data->body['text']),
            'text2' => strip_tags($decoded_data->body_2['text']),
            'images' => $image_urls,
        ];
    }


    return json_encode(["state" => 'success', "data" => $response, "error" => '']);
}

function getGalleryBlockData($blockName, $gallery_id)
{
    global $DB, $CFG;

    // Query to retrieve the block instance configuration data from the database
    $blockInstance = $DB->get_record('block_instances', ['blockname' => $blockName, 'id' => $gallery_id]);
    if (!$blockInstance) {
        return json_encode(["state" => 'error', "data" => [], "error" => 'Block instance not found']);
    }

    // Deserialize the configuration data to access the image URL
    $decodedData = unserialize(base64_decode($blockInstance->configdata));

    // Retrieve the image URLs dynamically
    $imageUrls = [];
    $fs = get_file_storage();
    $context = context_block::instance($blockInstance->id);
    $files = $fs->get_area_files($context->id, 'block_' . $blockName, 'content');

    $counter = 1;
    foreach ($files as $file) {
        $filename = $file->get_filename();
        if ($filename !== '.') {
            $url = moodle_url::make_pluginfile_url(
                $file->get_contextid(),
                $file->get_component(),
                $file->get_filearea(),
                null,
                $file->get_filepath(),
                $filename
            );
            $imageUrls["image_" . $counter] = $url->out(false); // Get the URL as a string without encoding
            $counter++;
        }
    }

    // Construct the response data
    $response = [
        'title' => isset($decodedData->title) ? $decodedData->title : '',
        'subtitle' => isset($decodedData->subtitle) ? $decodedData->subtitle : '',
        'images' => $imageUrls,
    ];

    return json_encode(["state" => 'success', "data" => $response, "error" => '']);
}


function get_children($userID)
{
    global $DB;

    // استرجاع نوع المستخدم من جدول بيانات معلومات المستخدم
    $userTypeFieldId = 8;
    $userType = $DB->get_field('user_info_data', 'data', array('userid' => $userID, 'fieldid' => $userTypeFieldId));

    if ($userType !== 'parent') {
        return json_encode([
            "state" => 'error',
            "data" => null,
            "error" => 'This user is not a parent'
        ]);
    }

    // Query to retrieve student emails with fieldid equal to 5 or greater than 8
    $sql = "SELECT data AS email FROM {user_info_data} WHERE userid = :userid AND (fieldid = 5 OR fieldid > 8)";
    $params = array('userid' => $userID);
    // Execute the query
    $studentEmails = $DB->get_records_sql($sql, $params);

    $students = [];
    foreach ($studentEmails as $emailRecord) {
        $student = $DB->get_record('user', array('email' => $emailRecord->email));
        if ($student) {
            $url = upload_user_image($student->id);

            $students[] = [
                'id' => $student->id,
                'image' => $url,
                'fullname' => $student->firstname . ' ' . $student->lastname,
            ];
        }
    }

    if (empty($students)) {
        return json_encode([
            "state" => 'error',
            "data" => null,
            "error" => 'No children found for this parent'
        ]);
    }

    return json_encode([
        "state" => 'success',
        "data" => $students,
        "error" => ''
    ]);
}

function generate_unique_name($length = 8)
{
    // توليد سلسلة عشوائية من البايتات وتحويلها إلى أحرف صغيرة
    $randomString = bin2hex(random_bytes($length / 2));
    return substr($randomString, 0, $length);
}

function is_phone_matching($user, $phone, $parent_phone)
{
    // Check if the phone number matches phone1 and parent phone number matches phone2
    return $user->phone1 === $phone && $user->phone2 === $parent_phone;
}

function add_children($userID, $email, $phone)
{
    global $DB;

    $errors = [];

    // Validate email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // Validate phone
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match("/^\d+$/", $phone)) {
        $errors[] = "Invalid phone number format. It should contain only digits.";
    }

    // Return errors if any
    if (!empty($errors)) {
        return json_encode([
            "state" => 'error',
            "data" => null,
            "error" => implode(", ", $errors)
        ]);
    }

    // Check if user exists with given email
    $user = $DB->get_record('user', array('email' => $email, 'deleted' => 0));

    if (!$user) {
        return json_encode([
            "state" => 'error',
            "data" => null,
            "error" => 'This student was not found'
        ]);
    }

    // Get parent phone number
    $parentPhone = $DB->get_field('user', 'phone1', array('id' => $userID, 'deleted' => 0));

    // Check if the phone numbers match
    if (!is_phone_matching($user, $phone, $parentPhone)) {
        return json_encode([
            "state" => 'error',
            "data" => null,
            "error" => 'Phone numbers do not match'
        ]);
    }

    // Check if student already exists in parent's children list
    $existing = $DB->get_record_sql(
        "SELECT *
         FROM {user_info_data}
         WHERE userid = :userid
         AND (fieldid = 5 OR fieldid > 8)
         AND data = :email",
        array('userid' => $userID, 'email' => $email)
    );

    if ($existing) {
        return json_encode([
            "state" => 'error',
            "data" => null,
            "error" => 'This student is already on your children list!'
        ]);
    }

    // Add new field to user_info_field table
    $uniqueName = generate_unique_name();
    $fieldData = new stdClass();
    $fieldData->shortname = $uniqueName;
    $fieldData->name = $user->firstname; // Assuming this is the student's name
    $fieldData->datatype = 'text';
    $fieldData->categoryid = 1; // Default category

    $insertSuccessField = $DB->insert_record('user_info_field', $fieldData);

    if (!$insertSuccessField) {
        return json_encode([
            "state" => 'error',
            "data" => null,
            "error" => 'Failed to add student field.'
        ]);
    }

    // Add student data to user_info_data table
    $data = new stdClass();
    $data->userid = $userID;
    $data->fieldid = $insertSuccessField;
    $data->data = $email;
    $data->dataformat = 0; // Default data format

    $insertSuccess = $DB->insert_record('user_info_data', $data);

    if (!$insertSuccess) {
        return json_encode([
            "state" => 'error',
            "data" => null,
            "error" => 'Failed to add student data.'
        ]);
    }

    return json_encode([
        "state" => 'success',
        "data" => $insertSuccess,
        "error" => ''
    ]);
}

function get_children_reports($id)
{
    global $DB;

    $student = $DB->get_record('user', array('id' => $id));
    if (!$student) {
        return json_encode([
            "state" => 'error',
            "data" => null,
            "error" => 'Student not found'
        ]);
    }

    $stu_data = [
        'id' => $student->id,
        'fullname' => $student->firstname . ' ' . $student->lastname,
        'email' => $student->email,
        'phone' => $student->phone1
    ];

    $courses = enrol_get_users_courses($student->id, true);
    $courses_data = [];
    foreach ($courses as $course) {
        // Calculate course progress
        $totalModulesCount = $DB->count_records('course_modules', array('course' => $course->id));
        $completedModulesCount = $DB->count_records('course_modules', array('course' => $course->id, 'completionview' => 1));
        $progressPercentage = ($totalModulesCount > 0) ? ($completedModulesCount / $totalModulesCount) * 100 : 0;

        // Fetch quiz data
        $quiz_data = fetch_quiz_data($DB, $student->id, $course->id);

        // Fetch paper exam data
        $paper_exams = fetch_paper_exam_data($DB, $student->id, $course->id);

        $courses_data[] = [
            'id' => $course->id,
            'fullname' => $course->fullname,
            'progress' => number_format($progressPercentage, 1) . '%',
            'quiz_data' => $quiz_data,
            'paper_exams' => $paper_exams
        ];
    }

    $data = [
        'stu_info' => $stu_data,
        'courses_data' => $courses_data
    ];

    return json_encode([
        "state" => 'success',
        "data" => $data,
        "error" => ''
    ]);
}

function fetch_quiz_data($DB, $student_id, $course_id)
{
    $quiz_grades = $DB->get_records('quiz_grades', array('userid' => $student_id));
    $quiz_data = [];
    foreach ($quiz_grades as $quiz_grade) {
        $quiz = $DB->get_record('quiz', array('id' => $quiz_grade->quiz));
        if ($quiz && $quiz->course == $course_id) {
            $attempts = $DB->get_records('quiz_attempts', array('quiz' => $quiz_grade->quiz, 'userid' => $student_id));
            foreach ($attempts as $attempt) {
                $percentage = ($quiz_grade->grade / $quiz->grade) * 100;
                $time_taken = $attempt->timefinish - $attempt->timestart;
                $time_taken_formatted = format_time($time_taken);

                $quiz_data[] = [
                    'name' => $quiz->name,
                    'percentage' => number_format($percentage, 0) . '%',
                    'time_taken' => $time_taken_formatted,
                    'completed_on' => userdate($attempt->timefinish),
                    'started_on' => userdate($attempt->timestart),
                    'state' => $attempt->state
                ];
                break;
            }
        }
    }

    if (empty($quiz_data)) {
        $quiz_data[] = [
            "message" => 'No quiz grades available.'
        ];
    }

    return $quiz_data;
}

function fetch_paper_exam_data($DB, $student_id, $course_id)
{
    $sql = "SELECT gg.finalgrade, gi.itemname, gi.grademax, gi.timemodified
            FROM {grade_grades} AS gg
            JOIN {grade_items} AS gi ON gg.itemid = gi.id
            WHERE gi.courseid = ? AND gg.userid = ? AND gi.itemtype = 'manual'";
    $params = array($course_id, $student_id);
    $paper_exam_grades = $DB->get_records_sql($sql, $params);
    $paper_exams = [];

    foreach ($paper_exam_grades as $grade) {
        $percentage = ($grade->finalgrade / $grade->grademax) * 100;
        $paper_exams[] = [
            'name' => $grade->itemname,
            'grade' => number_format($grade->finalgrade, 0),
            'max_grade' => number_format($grade->grademax, 0),
            'percentage' => number_format($percentage, 0) . '%',
            'date' => userdate($grade->timemodified)
        ];
    }

    if (empty($paper_exams)) {
        $paper_exams[] = [
            "message" => 'No paper exam grades available.'
        ];
    }

    return $paper_exams;
}

function send_message($conversationId, $userID, $subject, $fullmessage)
{
    global $DB, $USER;

    // تحقق من أن المحادثة موجودة وأن المستخدم مصرح له بالمشاركة فيها
    $sql = "
        SELECT 1
        FROM {message_conversation_members}
        WHERE conversationid = ? AND userid = ?
    ";

    $isMember = $DB->record_exists_sql($sql, array($conversationId, $userID));

    if (!$isMember) {
        return json_encode(['status' => 'error', 'message' => 'User is not a member of this conversation']);
    }

    // تحقق من أن الـ subject و الـ fullmessage ليسوا فارغين
    if (empty($subject) || empty($fullmessage)) {
        return json_encode(['status' => 'error', 'message' => 'Subject and full message cannot be empty']);
    }

    // إنشاء سجل جديد للرسالة
    $messageData = new stdClass();
    $messageData->conversationid = $conversationId;
    $messageData->useridfrom = $userID;
    $messageData->subject = $subject;
    $messageData->fullmessage = $fullmessage;
    $messageData->smallmessage = $fullmessage;
    $messageData->timecreated = time();

    // إدراج الرسالة في قاعدة البيانات
    try {
        $DB->insert_record('messages', $messageData);

        // قم بتحديث وقت آخر رسالة في المحادثة (اختياري)
        $DB->set_field('message_conversations', 'timemodified', time(), array('id' => $conversationId));

        return json_encode(['status' => 'success', 'message' => 'Message sent successfully']);
    } catch (Exception $e) {
        return json_encode(['status' => 'error', 'message' => 'Failed to send message: ' . $e->getMessage()]);
    }
}

function reset_password($email, $new_password, $confirm_password)
{
    global $DB;

    try {
        // Validate email is set and not empty
        if (!isset($email) || empty($email)) {
            throw new Exception('Email is required.');
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }

        // Check if the email exists in the database
        $user = $DB->get_record('user', array('email' => $email));
        if (!$user) {
            throw new Exception('Email not found.');
        }

        // Validate new password and confirm password are set and not empty
        if (!isset($new_password) || empty($new_password) || !isset($confirm_password) || empty($confirm_password)) {
            throw new Exception('New password or confirm password are required.');
        }

        // Check if new passwords match
        if ($new_password !== $confirm_password) {
            throw new Exception('New passwords do not match.');
        }

        // Hash the new password
        $hashed_password = hash_internal_user_password($new_password);

        // Update the user's password in the database
        $user->password = $hashed_password;
        if (!$DB->update_record('user', $user)) {
            throw new Exception('Error updating password.');
        }

        return json_encode(['status' => 'success', 'message' => 'Password successfully reset.']);

    } catch (Exception $e) {
        // Return JSON-encoded error message
        return json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}



<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/course/externallib.php');
require_once($CFG->dirroot . '/user/externallib.php');
require_once($CFG->libdir . "/weblib.php");
require_once($CFG->dirroot . '/webservice/lib.php');
require_once($CFG->dirroot . '/group/lib.php');
require 'vendor/autoload.php';

use Ramsey\Uuid\Uuid;

header('Content-Type: application/json');

define('PARAM_STRING', 'string');
$function = optional_param('function', '', PARAM_RAW);
$token = optional_param('token',  0, PARAM_TEXT);

$email = optional_param('email',  0, PARAM_TEXT);
$password = optional_param('password', 0, PARAM_TEXT);
$fname = optional_param('fname', 0, PARAM_TEXT);
$fullname = optional_param('fullname', 0, PARAM_TEXT);
$secondname = optional_param('secondname', 0, PARAM_TEXT);
$thirdname = optional_param('thirdname', 0, PARAM_TEXT);
$lname = optional_param('lname', 0, PARAM_TEXT);
$username = optional_param('nationalid', 0, PARAM_TEXT);
$phone1 = optional_param('phone1', 0, PARAM_TEXT);
$phone2 = optional_param('phone2', 0, PARAM_TEXT);
$phone = optional_param('phone', 0, PARAM_TEXT);
$parentPhone = optional_param('parentPhone', '', PARAM_RAW);
$city = optional_param('city', '', PARAM_RAW);
$school = optional_param('school', '', PARAM_RAW);
$center = optional_param('center', '', PARAM_RAW);
$job = optional_param('job', '', PARAM_RAW);
$address = optional_param('address', '', PARAM_RAW);
$description = optional_param('description', '', PARAM_RAW);
$gender = optional_param('gender', '', PARAM_RAW);
$readandwrite = optional_param('readandwrite', '', PARAM_RAW);
$academicqualification = optional_param('academicqualification', '', PARAM_RAW);
$scientificdegree = optional_param('scientificdegree', '', PARAM_RAW);
$coursetype = optional_param('coursetype', '', PARAM_RAW);
$year  = optional_param('year',  '', PARAM_INT);

$role = optional_param('role', 0, PARAM_TEXT);
$oldPassword = optional_param('oldpassword', 0, PARAM_TEXT);

$newPassword = optional_param('newpassword', 0, PARAM_TEXT);

$id  = optional_param('id',  0, PARAM_INT);
$teacherid  = optional_param('teacherid',  0, PARAM_INT);
$lang = optional_param('lang',  0, PARAM_TEXT);

$imageId = optional_param('imageId',  0, PARAM_INT);

$course = optional_param('course',  0, PARAM_INT);
$activityid = optional_param('activityid',  0, PARAM_INT);
$code = optional_param('code', '', PARAM_RAW);

$pushid = optional_param('pushid', 0, PARAM_RAW);

$certificate = optional_param('certificate', '', PARAM_RAW);
$newcourse = optional_param('newcourse', '', PARAM_RAW);
$workshop = optional_param('workshop', '', PARAM_RAW);
$experience = optional_param('experience', '', PARAM_RAW);

$certificateid = optional_param('certificateid', '', PARAM_RAW);
$newcourseid = optional_param('newcourseid', '', PARAM_RAW);
$workshopid = optional_param('workshopid', '', PARAM_RAW);
$experienceid = optional_param('experienceid', '', PARAM_RAW);

$my_email = optional_param('my_email', 0, PARAM_RAW);
$get = optional_param('get', '', PARAM_RAW);
$add = optional_param('add', '', PARAM_RAW);
$edit = optional_param('edit', '', PARAM_RAW);
$delete = optional_param('delete', '', PARAM_RAW);
$facebook = optional_param('facebook', '', PARAM_RAW);
$instagram = optional_param('instagram', '', PARAM_RAW);
$youtube = optional_param('youtube', '', PARAM_RAW);
$twitter = optional_param('twitter', '', PARAM_RAW);
$whatsapp = optional_param('whatsapp', '', PARAM_RAW);
$linkedin = optional_param('linkedin', '', PARAM_RAW);
$tiktok = optional_param('tiktok', '', PARAM_RAW);
$title1 = optional_param('title1', '', PARAM_RAW);
$title2 = optional_param('title2', '', PARAM_RAW);
$title3 = optional_param('title3', '', PARAM_RAW);
$body1 = optional_param('body1', '', PARAM_RAW);
$body2 = optional_param('body2', '', PARAM_RAW);
$fcm_token = optional_param('fcm_token', '', PARAM_RAW);



if ($function == 'login') {
    $user = new User();
    echo $user->login($email, $password, $fcm_token);
} elseif ($function == 'confirm_signup') {
    echo confirm_signup();
} elseif ($function == 'loginasguest') {
    echo loginasguest();
} elseif ($function == 'register') {
    $user = new User();
    echo $user->register($fname, $lname, $email, $password, $phone1);
} elseif ($function == 'aboutInfo') {
    echo aboutInfo();
} elseif ($function == 'getGovernments') {
    echo getGovernments($lang);
} elseif ($function == 'delete_teacher_images') {
    echo delete_teacher_images($imageId);
} elseif ($function == 'property_rights') {
    echo property_rights();
} elseif ($function == 'social_links') {
    echo social_links($get, $add, $edit, $delete, $facebook, $instagram, $youtube, $twitter, $whatsapp, $linkedin, $tiktok, $title1, $body1, $title2, $body2, $title3, $my_email);
}
// elseif ($function == 'change_image') {
//     $user = new User();
//     echo $user->change_image();
// }

if (!empty($token)) {

    $api = new webservice();
    $array = array();
    try {
        $array = $api->authenticate_user($token);
        if (!empty($array)) {
            $array = json_encode($api->authenticate_user($token));
            //echo $array;
            $arr = json_decode($array, true);
            $userID = $arr['user']['id'];
            if ($function == 'get_user_courses') {
                $user = new User();
                echo $user->get_user_courses($userID, $teacherid);
            } elseif ($function == 'logout') {
                $user = new User();
                echo $user->logout($userID, $device_id);
            } elseif ($function == 'change_password') {
                $user = new User();
                echo $user->change_password($userID);
            } elseif ($function == 'get_user_notifications') {
                $user = new User();
                echo $user->get_user_notifications($userID);
            } elseif ($function == 'upload_image') {
                $user = new User();
                echo $user->upload_image($userID);
            } elseif ($function == 'add_new_view') {
                $user = new User();
                echo $user->add_new_view($userID, $id);
            } elseif ($function == 'edit_user') {

                $user = new User();
                echo $user->edit_user_data($userID, $fullname, $phone, $parentPhone);
            } elseif ($function == 'edit_teacher_profile') {
                $user = new User();
                echo $user->edit_teacher_profile($userID, $certificate, $newcourse, $workshop, $experience);
            } elseif ($function == 'delete_teacher_data') {
                $user = new User();
                echo $user->delete_teacher_data($userID, $certificateid, $newcourseid, $workshopid, $experienceid);
            } elseif ($function == 'change_pas') {
                $user = new User();
                echo $user->change($userID, $oldPassword, $newPassword);
            } elseif ($function == 'teacherchangestudentpassword') {
                $user = new User();
                echo $user->teacherchangestudentpassword($userID, $newPassword);
            } elseif ($function == 'get_user_by_token') {
                $user = new User();
                echo $user->get_user_by_token($userID);
            } elseif ($function == 'get_parent_data') {
                $user = new User();
                echo $user->get_parent_data($userID);
            } elseif ($function == 'check_codes') {

                echo check_codes($course, $activityid, $code, $userID);
            }
        }
    } catch (Exception $e) {
        echo json_encode(['status' => "fail", 'data' => null, "error" => $e->errorcode]);

        // echo json_encode(['status' => "fail",'data' => null, "error" => $e]);
    }
}

class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $role;
    public $phone;
    public $year;
    public $deleted_at;
    public $fcm_token;
    public function login($email, $password, $fcm_token)
    {
        global $DB, $CFG;

        // التحقق من صحة البريد الإلكتروني
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return json_encode(['status' => "fail", "data" => null, 'error' => 'Invalid email format']);
        }

        // جلب المستخدم بناءً على البريد الإلكتروني أو اسم المستخدم
        $user = $DB->get_record('user', ['email' => $email]) ?: $DB->get_record('user', ['username' => $email]);

        // التحقق من وجود المستخدم والتحقق من كلمة المرور
        if ($user && password_verify($password, $user->password)) {
            try {
                // التحقق من ما إذا كان المستخدم مسؤولًا
                $isadmin = in_array($user->id, array_column(get_admins(), 'id'));

                // جلب الدور المخصص للمستخدم
                $roleid = $DB->get_field_sql("SELECT roleid FROM {role_assignments} WHERE userid = ? ORDER BY roleid ASC LIMIT 1", [$user->id]);
                $role = $DB->get_record('role', ['id' => $roleid]);

                // جلب دور المستخدم من حقل معلومات المستخدم إذا لم يتم تعيينه بالفعل
                $my_role = $DB->get_record('user_info_data', ['userid' => $user->id, 'fieldid' => 8]);
                $this->role = $my_role->data ?? $role->shortname;

                // جلب بيانات إضافية للمستخدم
                $user_info_data = $DB->get_record('user_info_data', ['userid' => $user->id, 'fieldid' => 1]);
                $optional_data = $DB->get_record('optional_data_aibrahim', ['userid' => $user->id]);

                $yearMap = [
                    1 => "primary 1", 2 => "primary 2", 3 => "primary 3", 4 => "primary 4",
                    5 => "primary 5", 6 => "primary 6", 7 => "preparatory 1", 8 => "preparatory 2",
                    9 => "preparatory 3", 10 => "Secondary 1", 11 => "Secondary 2", 12 => "Secondary 3"
                ];
                $key = array_search($user_info_data->data, $yearMap) ?: 0;

                $url = $CFG->wwwroot . '/pluginfile.php/' . $user_context->id . '/user/icon/0/f1.jpg?rev=0';
                $user_context = $DB->get_record('context', ['instanceid' => $user->id, 'contextlevel' => 30]);
                $fs = get_file_storage();
                $files = $fs->get_area_files($user_context->id, 'user', 'icon', 0, 'sortorder DESC, id ASC', false);

                if (!empty($files)) {
                    $file = reset($files);
                    $path = '/' . $user_context->id . '/user/icon/0' . $file->get_filepath() . $file->get_filename();
                    $url = $CFG->wwwroot . '/pluginfile.php' . $path . "?rev=" . $user->picture;
                }

                $userData = get_complete_user_data('id', (int)$user->id);
                $lastCourseAccess = $userData->lastcourseaccess;
                require_once($CFG->dirroot . '/theme/edumy/ccn/block_handler/ccn_block_handler.php');
                require_once($CFG->dirroot . '/course/renderer.php');
                require_once($CFG->dirroot . '/theme/edumy/ccn/course_handler/ccn_course_handler.php');
                require_once($CFG->dirroot . '/theme/edumy/ccn/user_handler/ccn_user_handler.php');

                $courses = [];
                if ($lastCourseAccess) {
                    foreach ($lastCourseAccess as $key => $value) {
                        $ccnCourseHandler = new ccnCourseHandler();
                        $courses[] = $ccnCourseHandler->ccnGetCourseDetails($key);
                    }
                }

                $token = json_decode(file_get_contents("$CFG->wwwroot/login/token.php?username=$email&password=$password&service=moodle_mobile_app"))->token;

                if (isset($fcm_token) && !empty($fcm_token)) {
                    try {
                        $save_fcm_token = $DB->insert_record('fcm_tokens', ['userid' => $user->id, 'fcm_token' => $fcm_token]);
                        $fcm_message = $save_fcm_token ? 'FCM token added successfully' : 'Failed to add FCM token';
                    } catch (Exception $e) {
                        $fcm_message = 'An error occurred: ' . $e->getMessage();
                    }
                } else {
                    $fcm_message = 'Invalid or empty FCM token';
                }

                $userData = [
                    "id" => (int)$user->id,
                    "fullname" => $user->firstname,
                    "image" => $url,
                    "token" => $token,
                    "email" => $user->email,
                    "role" => $this->role,
                    "is_admin" => $isadmin,
                    "fcm_message" => $fcm_message
                ];

                return json_encode(['status' => "success", 'data' => $userData, "error" => '']);
            } catch (Exception $e) {
                return json_encode(['status' => "fail", "data" => null, 'error' => $e->getMessage()]);
            }
        } else {
            return json_encode(['status' => "fail", "data" => null, 'error' => 'Invalid email or password']);
        }
    }


    /* function logout($userID, $device_id)
    {
        global $DB, $CFG;

        // Check if the userid and pushid already exist in the table
        $existingRecord = $DB->get_record('user_logout', array('user_id' => $userID, 'pushid' => $device_id));

        // If the user has logged out from this device before, update the existing record
        if ($existingRecord) {
            $existingRecord->state = 1; // Assuming 'state' is the field you want to update
            $Record = $DB->update_record('user_logout', $existingRecord);
            if ($Record) {
                return json_encode(['status' => "success"]);
            } else {
                return json_encode(['status' => "fail", "data" => null, 'error' => '']);
            }
        } else {
            // If this is the first logout from this device, insert a new record
            $newRecord = $DB->insert_record('user_logout', array('user_id' => $userID, 'pushid' => $device_id, 'state' => 1));
            if ($newRecord) {
                return json_encode(['status' => "success"]);
            } else {
                return json_encode(['status' => "fail", "data" => null, 'error' => '']);
            }
        }
    } */

    /* function register($firstname, $lastname, $email, $password, $phone = null)
    {
        global $DB, $CFG;

        $year = 1;
        $role = 5;
        $userInfo = new stdClass();
        $roleAssignment = new stdClass();
        $record = new stdClass();
        $existsEmail = $DB->record_exists('user', array('email' => $email));
        if ($existsEmail) {
            return json_encode(['status' => "fail", "data" => null, "error" => 'Email exists.']);
        }
        $check_userrname = $DB->get_record('user', array('username' => $email));
        $check_email = $DB->get_record('user', array('email' => $email));
        if (!empty($check_userrname)) {
            return json_encode(['status' => "fail", "data" => null, "error" => 'username exists']);
        } elseif (!empty($check_email)) {
            return json_encode(['status' => "fail", "data" => null, "error" => 'Email exists']);
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return json_encode(['status' => "fail", "data" => null, "error" => 'invalid email']);
        } else {
            try {
                $userInfo->firstname = $firstname;
                $userInfo->lastname = $lastname;
                $userInfo->username = $email;
                $userInfo->email = $email;
                $hashPass = hash_internal_user_password($password);
                $userInfo->password = $hashPass;
                $userInfo->phone1 = $phone;
                $userInfo->confirmed = 1;
                $userInfo->mnethostid = 1;
                $userInfo->country = "EG";
                $userInfo->lang = "en";
                // $userInfo->url = "user.png";
                $userInfo->id = $DB->insert_record('user', $userInfo);
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
                // $token= \core\session\manager::get_login_token();
                $token = file_get_contents("" . $CFG->wwwroot . "/login/token.php?username=$email&password=$password&service=moodle_mobile_app");
                $token = json_decode($token);
                if ($role == 5) {
                    $this->role = "student";
                }
                
                $url = "";
                // $url = "https://academy.nitg-eg.com/theme/edumy/images/teachers/" . $userInfo->url;
                $user_context = $DB->get_record('context', array('instanceid' => $userInfo->id, 'contextlevel' => 30));
                $fs = get_file_storage();
                $files = $fs->get_area_files($user_context->id, 'user', 'icon', 0, 'sortorder DESC, id ASC', false);
                if (count($files) < 1) {
                    $image = '' . $CFG->wwwroot . '/pluginfile.php/' . $user_context->id . '/user/icon/0/f1.jpg?rev=0';
                } else {
                    $file = reset($files);
                    unset($files);
                    $path = '/' . $user_context->id . '/user/icon/0' . $file->get_filepath() . $file->get_filename();
                    $image = $CFG->wwwroot . '/pluginfile.php' . $path . "?rev=" . $userInfo->picture;
                }
                $url = $image;
                $userData = array(
                    "id" => $userInfo->id, "username" => $userInfo->username, "firstName" => $userInfo->firstname, "secondName" => $userInfo->secondname, "thirdName" => $userInfo->thirdname,
                    "lastName" => $userInfo->lastname, "nationalid" => $userInfo->nationalid, "image" => $url, "token" => $token->token, "email" => $userInfo->email, "role" => $this->role, "coursetype" => $coursetype,
                    "phone" => $userInfo->phone1, "phone2" => $userInfo->phone2, "job" => $job, "address" => $address, "gender" => $userInfo->gender, "readandwrite" => $readandwrite,
                    "city" => $city, "academicqualification" => $academicqualification, "scientificdegree" => $scientificdegree
                );
                return json_encode(['status' => "success", "data" => $userData, "error" => '']);
            } catch (Exception $e) {
                return json_encode(['status' => "fail", "data" => null, "error" => $e->getMessage()]);
            }
        }
    } */
    function register($firstname, $secondname = null, $thirdname = null, $lastname, $email, $password, $phone = null, $phone2 = null, $city = null, $school = null, $center = null, $job = null, $address = null, $gender = null, $readandwrite = null, $academicqualification = null, $scientificdegree = null, $coursetype = null)
    {
        global $DB, $CFG;

        $year = 1;
        $username = $email;
        $role = 5;
        $userInfo = new stdClass();
        $yearInfo = new stdClass();
        $roleAssignment = new stdClass();
        $record = new stdClass();
        $existsNationalid = $DB->record_exists('user', array('username' => $username));
        $existsEmail = $DB->record_exists('user', array('email' => $email));
        if ($existsNationalid) {
            return json_encode(['status' => "fail", "data" => null, "error" => 'Nationalid exists.']);
        }
        if ($existsEmail) {
            return json_encode(['status' => "fail", "data" => null, "error" => 'Email exists.']);
        }

        $check_email = $DB->get_record('user', array('email' => $email));
        if (!empty($check_userrname)) {
            return json_encode(['status' => "fail", "data" => null, "error" => 'username exists']);
        } elseif (!empty($check_email)) {
            return json_encode(['status' => "fail", "data" => null, "error" => 'Email exists']);
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return json_encode(['status' => "fail", "data" => null, "error" => 'invalid email']);
        } else {
            try {
                $userInfo->firstname = $firstname;
                $userInfo->secondname = $secondname;
                $userInfo->thirdname = $thirdname;
                $userInfo->lastname = $lastname;
                $userInfo->username = $username;
                $userInfo->email = $email;
                $hashPass = hash_internal_user_password($password);
                $userInfo->password = $hashPass;
                $userInfo->phone1 = $phone;
                $userInfo->phone2 = $phone2;
                $userInfo->confirmed = 1;
                $userInfo->mnethostid = 1;
                // $userInfo->url = "user.png";
                if ($role == 9) {
                    $userInfo->id = $DB->insert_record('user', $userInfo);
                } elseif ($year != null && $role != 9) {
                    if ($city != null) {
                        $userInfo->city = $city;
                    }
                    $userInfo->country = "EG";
                    $userInfo->lang = "ar";
                    // if ($school != null && $center != null) {
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
                    // } else {
                    //     return json_encode(['status' => "fail", "data" => null, "error" => 'you have to write your school and your center']);
                    // }
                } elseif ($year == null && $role != 9) {
                    return json_encode(['status' => "fail", "data" => null, "error" => 'you have to add a year']);
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
                // $token= \core\session\manager::get_login_token();
                $token = file_get_contents("" . $CFG->wwwroot . "/login/token.php?username=$username&password=$password&service=moodle_mobile_app");
                $token = json_decode($token);
                if ($role == 5) {
                    $this->role = "student";
                } elseif ($role == 9) {
                    $this->role = "parent";
                }
                if (empty($school)) {
                    $school = "";
                }
                if (empty($center)) {
                    $center = "";
                }
                $url = "";
                // $url = "https://academy.nitg-eg.com/theme/edumy/images/teachers/" . $userInfo->url;
                $user_context = $DB->get_record('context', array('instanceid' => $userInfo->id, 'contextlevel' => 30));
                $fs = get_file_storage();
                $files = $fs->get_area_files($user_context->id, 'user', 'icon', 0, 'sortorder DESC, id ASC', false);
                if (count($files) < 1) {
                    $image = '' . $CFG->wwwroot . '/pluginfile.php/' . $user_context->id . '/user/icon/0/f1.jpg?rev=0';
                } else {
                    $file = reset($files);
                    unset($files);
                    $path = '/' . $user_context->id . '/user/icon/0' . $file->get_filepath() . $file->get_filename();
                    $image = $CFG->wwwroot . '/pluginfile.php' . $path . "?rev=" . $userInfo->picture;
                }
                $url = $image;
                $userData = array(
                    "id" => $userInfo->id, "username" => $userInfo->username, "firstName" => $userInfo->firstname, "secondName" => $userInfo->secondname, "thirdName" => $userInfo->thirdname,
                    "lastName" => $userInfo->lastname, "nationalid" => $userInfo->nationalid, "image" => $url, "token" => $token->token, "email" => $userInfo->email, "role" => $this->role, "coursetype" => $coursetype,
                    "phone" => $userInfo->phone1, "phone2" => $userInfo->phone2, "job" => $job, "address" => $address, "gender" => $userInfo->gender, "readandwrite" => $readandwrite,
                    "city" => $city, "academicqualification" => $academicqualification, "scientificdegree" => $scientificdegree
                );
                return json_encode(['status' => "success", "data" => $userData, "error" => '']);
            } catch (Exception $e) {
                return json_encode(['status' => "fail", "data" => null, "error" => $e->getMessage()]);
            }
        }
    }
    function edit_description($text)
    {
        $cleaner_input = strip_tags($text);
        return $cleaner_input;
    }
    function get_user_courses($userid, $teacherid, $token = 0)
    {
        //return "We are doing some updates in App and it will be available shortly";
        global $DB;
        try {
            $sql = "SELECT u.firstname AS name,u.lastname AS lastname, cat.description as catDesc,cat.name as catname,c.category as cat_id,c.summary As course_desc, c.fullname as coursename ,c.id as courseid
            FROM   mdl_course c
           LEFT OUTER JOIN   mdl_context cx ON c.id = cx.instanceid
           LEFT OUTER JOIN   mdl_role_assignments ra ON cx.id = ra.contextid AND ra.roleid = '3'
           LEFT OUTER JOIN   mdl_course_categories as cat ON c.category=cat.id
           LEFT OUTER JOIN   mdl_user u ON ra.userid = u.id WHERE cx.contextlevel = '50' AND u.id= " . $teacherid . "";
            // $courses = $DB->get_recordset_sql("");
            $courses_data = array();

            $studentRole = $DB->get_field('role', 'id', array('shortname' => 'student'));
            $isStudent = $DB->record_exists('role_assignments', ['userid' => $userid, 'roleid' => $studentRole]);

            $assistantRole = $DB->get_field('role', 'id', array('shortname' => 'teacher'));
            $isAssistant = $DB->record_exists('role_assignments', ['userid' => $userid, 'roleid' => $assistantRole]);
            $courses = $DB->get_recordset_sql($sql);
            foreach ($courses as $key => $record) {
                // Do whatever you want with this record
                $context = context_course::instance($record->courseid, MUST_EXIST);
                $enrol = is_enrolled($context, $userid, '', true);
                $status = 0;
                $endtime = "";
                $enrolment = $DB->get_records_sql("SELECT ue.status as status ,ue.timeend as endtime from mdl_user_enrolments as ue join mdl_enrol as e on ue.enrolid=e.id where ue.userid=" . $userid . " and e.courseid=" . $record->courseid . "");
                foreach ($enrolment as $enrol) {
                    $status = $enrol->status;
                    $endtime = $enrol->endtime;
                }
                if ($enrol && $isStudent) {
                    $user = $DB->get_record('user', array('id' => $userid));
                    if ($user->suspended == 1) {
                        return json_encode(['status' => "fail", "data" => null, "error" => "This user is susbended from the site"]);
                    } elseif ($status == 1) {
                        return json_encode(['status' => "fail", "data" => null, "error" => "This user is susbended from course " . $record->courseid . ""]);
                    } elseif ($_SERVER['REQUEST_TIME'] > $endtime && $endtime != 0) {
                        return json_encode(['status' => "fail", "data" => null, "error" => "the enrolment has expired"]);
                    }
                }
                $price = $DB->get_record('customfield_data', array('fieldid' => 12, 'instanceid' => $record->courseid));
                if (empty($price)) {
                    $price = 'free';
                }
                $rating = $DB->get_records_sql("SELECT ceil(AVG(rate)) as rate FROM `mdl_course_rates` WHERE courseid=$record->courseid");
                $rate = 0;
                foreach ($rating as $rate) {
                    $rate = $rate->rate;
                }

                // return json_encode(['status' => "success", "data" =>, "error" => '']);

                // foreach($rating as)
                // $rating = array_values($rating);
                $view = $DB->get_record('course_views', array('courseid' => $record->courseid));
                if ($view->visit == null) {
                    $view->visit = '0';
                }
                $imges = $DB->get_record("course", array('id' => $record->courseid));
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

                if ($enrol && $isStudent) {
                    // $courses[$key]->enrolled = true;

                    $courses_data[] = array(
                        "courseId" => $record->courseid, "courseName" => $record->coursename,
                        "courseDesc" => format_string($record->course_desc),
                        "cat_id" => $record->cat_id,
                        "catname" => format_string($record->catname), "rate" => (int)$rate, "course_image" => $overviewfiles,
                        'price' => $price->value, 'views' => $view->visit, "catDesc" => format_string($record->catDesc)
                    );
                    return json_encode(['status' => "success", "data" => $courses_data, "error" => '']);
                } elseif ($userid == $teacherid && ($endtime == 0 || $_SERVER['REQUEST_TIME'] < $endtime) || ($enrol && $isAssistant)) {
                    if ($status == 0) {
                        $courses_data[] = array(
                            "courseId" => $record->courseid, "courseName" => $record->coursename,
                            "courseDesc" => format_string($record->course_desc),
                            "cat_id" => $record->cat_id,
                            "catname" => format_string($record->catname), "rate" => (int)$rate, "course_image" => $overviewfiles,
                            'price' => $price->value, 'views' => $view->visit, "catDesc" => format_string($record->catDesc),

                        );
                    }
                }
            }
            if (empty($courses_data)) {
                return json_encode(['status' => "fail", "data" => null, "error" => "this user is not enrolled in any course with this teacher"]);
            } else {
                return json_encode(['status' => "success", "data" => $courses_data, "error" => '']);
            }
        } catch (Exception $e) {
            return json_encode(['status' => "fail", "data" => null, "error" => "this user is not enrolled in any course with this teacher"]);
        }
    }
    function change_password($userid)
    {
        // return json_encode(['status' => "success", "data" => "updated", "error" => '']);

        global $DB;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $oldPassword = $_REQUEST['oldpassword'];
            $newPassword = $_REQUEST['newpassword'];
            // $name= $_REQUEST['name'];
            // $data = json_decode();
            // return file_get_contents("php://input");
            // return json_encode(['status' => "fail", "data" =>array('old'=>$oldPassword), "error" => "passwords are not the same"]);
            // return json_encode(['status' => "fail", "data" =>array('old'=>$oldPassword,'new'=>$newPassword,'name'=>$name), "error" => "passwords are not the same"]);

            $user = $DB->get_record('user', array('id' => $userid));
            try {
                if (password_verify($oldPassword, $user->password)) {
                    $new = new stdClass();
                    $new->id = $user->id;
                    $new->password = hash_internal_user_password($newPassword);
                    $new->id = $DB->update_record('user', $new);
                    if (!empty($new->id)) {
                        return json_encode(['status' => "success", "data" => "updated", "error" => '']);
                    } else {
                        return json_encode(['status' => "fail", "data" => '', "error" => "password not changed"]);
                    }
                } else {
                    return json_encode(['status' => "fail", "data" => array('old' => $oldPassword, 'new' => $newPassword), "error" => "passwords are not the same"]);
                }
            } catch (Exception $e) {
                return json_encode(['status' => "fail", "data" => '', "error" => $e->getMessage()]);
            }
        } else {
            return json_encode(['status' => "fail", "data" => '', "error" => "The  Method should be POST"]);
        }
    }

    function change($userid, $oldPassword, $newPassword)
    {

        global $DB;

        // $oldPassword = $_POST['oldpassword'];
        // $newPassword = $_POST['newpassword'];
        $user = $DB->get_record('user', array('id' => $userid));
        $error_messages = [
            'empty_password' => 'Password cannot be empty or null',
            'password_linth' => 'Password must contain 6 or more characters',
        ];
        if (empty($newPassword) || is_null($newPassword)) {
            return json_encode(['status' => "fail", "data" => null, 'error' => $error_messages['empty_password']]);
        } else {
            if (strlen($newPassword) < 6) {
                return json_encode(['status' => "fail", "data" => null, 'error' => $error_messages['password_linth']]);
            }
        }
        try {
            if (password_verify($oldPassword, $user->password)) {
                $new = new stdClass();
                $new->id = $user->id;
                $new->password = hash_internal_user_password($newPassword);
                $new->id = $DB->update_record('user', $new);
                if (!empty($new->id)) {
                    return json_encode(['status' => "success", "data" => "updated", "error" => '']);
                } else {
                    return json_encode(['status' => "fail", "data" => '', "error" => "password not changed"]);
                }
            } else {
                return json_encode(['status' => "fail", "data" => '', "error" => "The old password not correct"]);
            }
        } catch (Exception $e) {
            return json_encode(['status' => "fail", "data" => '', "error" => $e->getMessage()]);
        }
    }
    function teacherchangestudentpassword($userid, $newPassword)
    {
        global $DB;
        $user = $DB->get_record('user', array('id' => $userid));
        try {
            $new = new stdClass();
            $new->id = $user->id;
            $new->password = hash_internal_user_password($newPassword);
            $new->id = $DB->update_record('user', $new);
            if (!empty($new->id)) {
                return json_encode(['status' => "success", "data" => "updated", "error" => '']);
            } else {
                return json_encode(['status' => "fail", "data" => '', "error" => "password not changed"]);
            }
        } catch (Exception $e) {
            return json_encode(['status' => "fail", "data" => '', "error" => $e->getMessage()]);
        }
    }
    function get_user_by_token($userid)
    {
        global $DB;
        $user = $DB->get_record('user', array('id' => $userid));
        try {
            if ($user) {
                $roleassignments = $DB->get_record('role_assignments', ['userid' => $user->id]);
                $role = $DB->get_record('role', ['id' => $roleassignments->roleid]);
                if ($role->id == 3) {
                    $this->role = "teacher";
                } elseif ($role->id == 5) {
                    $this->role = "student";
                } elseif ($role->id == 6) {
                    $this->role = "Guest";
                } elseif ($role->id == 9) {
                    $this->role = "Parent";
                } elseif ($role->id == 4) {
                    $this->role = "assistant";
                }
                $user_info_data = $DB->get_record('user_info_data', ['userid' => $user->id, "fieldid" => "1"]);
                $optional_data = $DB->get_record('optional_data_aibrahim', ['userid' => $user->id]);
                $yearMap = array(1 => "primary 1", 2 => "primary 2", 3 => "primary 3", 4 => "primary 4", 5 => "primary 5", 6 => "primary 6", 7 => "preparatory 1", 8 => "preparatory 2", 9 => "preparatory 3", 10 => "Secondary 1", 11 => "Secondary 2", 12 => "Secondary 3");
                $key = array_search($user_info_data->data, $yearMap);
                if (empty($key)) {
                    $key = 0;
                }
                if (empty($optional_data->school)) {
                    $optional_data->school = "";
                }
                if (empty($optional_data->empty)) {
                    $optional_data->empty = "";
                }
                $url = "";
                $user_context = $DB->get_record('context', array('instanceid' => $user->id, 'contextlevel' => 30));
                $fs = get_file_storage();
                $files = $fs->get_area_files($user_context->id, 'user', 'icon', 0, 'sortorder DESC, id ASC', false);
                if (count($files) < 1) {
                    $url = '' . $CFG->wwwroot . '/pluginfile.php/' . $user_context->id . '/user/icon/0/f1.jpg?rev=0';

                    // $url = '';
                } else {
                    $file = reset($files);
                    unset($files);
                    $path = '/' . $user_context->id . '/user/icon/0' . $file->get_filepath() . $file->get_filename();
                    $url = $CFG->wwwroot . '/pluginfile.php' . $path . "?rev=" . $user->picture;;
                }
                // }
                // $url = $image;
                $token = file_get_contents("" . $CFG->wwwroot . "/login/token.php?username=$email&password=$password&service=moodle_mobile_app");
                $token = json_decode($token);
                $userData = array(
                    "id" => (int)$user->id, "username" => $user->username,
                    "firstName" => $user->firstname, "lastName" => $user->lastname, "image" => $url,
                    "token" => $token->token,
                    "email" => $user->email, "role" =>  $this->role, "year" => $key,
                    "phone" => $user->phone1, "phone2" => $user->phone2,
                    "city" => $user->city, "school" => $optional_data->school, "center" => $optional_data->empty
                );
                return json_encode(['status' => "success", 'data' => $userData, "error" => '']);
            } else {
                return json_encode(['status' => "fail", "data" => null, 'error' => 'User not found']);
            }
        } catch (Exception $e) {
            return json_encode(['status' => "fail", "data" => null, 'error' => $e->getMessage()]);
        }
    }
    function change_image()
    {
        global $DB;
        // $data = file_get_contents("php://input");
        // // echo $data;
        // $data=json_decode($data,true);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            return json_encode(['status' => "success", "data" => $_FILES, "error" => '']);
        } else {
            return json_encode(['status' => "success", "data" => $_SERVER, "error" => '']);
        }

        // return $data;

        // if(isset($_FILES['image'])){
        //     return json_encode(['status' => "success", "data" =>$_FILES['image']['tmp_name'], "error" => '']);

        // }
        // else{
        //     return json_encode(['status' => "fail", "data" =>$_REQUEST, "error" => "passwords are not the same"]);

        // }
    }
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
    function get_parent_data($parent)
    {
        global $DB, $CFG;
        try {
            $childs = $DB->get_records_sql('SELECT  p.childid,u.firstname,u.lastname  from mdl_parent_child as p join mdl_user as u on u.id=p.childid where parentid=' . $parent . '');
            foreach ($childs as $key => $value) {

                $childs[$key]->url = $this->upload_user_image($value->childid);
            }

            return json_encode(['status' => "success", 'data' => array_values($childs), "error" => '']);
        } catch (Exception $e) {
            return json_encode(['status' => "fail", "data" => null, "error" => $e->getMessage()]);
        }
    }
    function edit_user_data($userid, $fullname = null, $phone = null, $parentPhone)
    {
        global $DB;
        try {
            // التحقق من وجود المستخدم
            $user = $DB->get_record('user', array('id' => $userid));
            if (!$user) {
                throw new Exception("User not found.");
            }

            $new = new stdClass();
            $new->id = $user->id;

            // تحديث الحقول فقط إذا كانت القيم غير فارغة
            if ($fullname !== null) {
                $new->firstname = $fullname;
            }
            $new->lastname = '.'; // تعيين قيمة افتراضية للاسم الأخير
            if ($phone !== null) {
                $new->phone1 = $phone;
            }
            if (isset($parentPhone) && !empty($parentPhone)) {
                $new->phone2 = $parentPhone;
            }

            // تحديث سجل المستخدم
            $DB->update_record('user', $new);

            return json_encode(['status' => "success", "data" => "updated", "error" => '']);
        } catch (Exception $e) {
            return json_encode(['status' => "fail", "data" => null, "error" => $e->getMessage()]);
        }
    }

    function edit_teacher_profile($userid, $certificate = null, $newcourse = null, $workshop = null, $experience = null)
    {
        global $DB;

        $successMessages = []; // لتخزين رسائل النجاح
        $errorMessages = [];   // لتخزين رسائل الخطأ

        if (!empty($certificate)) {
            $teacher_certificate = new stdClass();
            $teacher_certificate->teacher_id = $userid;
            $teacher_certificate->certificate = $certificate;
            if ($DB->insert_record('teacher_certificates', $teacher_certificate)) {
                $data = [
                    'status' => "success",
                    'message' => "تم إضافة الشهادة بنجاح.",
                ];
                $successMessages[] = $data;
            } else {
                $data = [
                    'status' => "fail",
                    'message' => "حدث خطأ أثناء إضافة الشهادة.",
                ];
                $errorMessages[] = $data;
            }
        }

        if (!empty($newcourse)) {
            $teacher_newcourse = new stdClass();
            $teacher_newcourse->teacher_id = $userid;
            $teacher_newcourse->course = $newcourse;
            if ($DB->insert_record('teacher_courses_obtained', $teacher_newcourse)) {
                $data = [
                    'status' => "success",
                    'message' => "تم إضافة الدورة الجديدة بنجاح.",
                ];
                $successMessages[] = $data;
            } else {
                $data = [
                    'status' => "fail",
                    'message' => "حدث خطأ أثناء إضافة الدورة الجديدة.",
                ];
                $errorMessages[] = $data;
            }
        }

        if (!empty($workshop)) {
            $teacher_workshop = new stdClass();
            $teacher_workshop->teacher_id = $userid;
            $teacher_workshop->workshop = $workshop;
            if ($DB->insert_record('teacher_workshops', $teacher_workshop)) {
                $data = [
                    'status' => "success",
                    'message' => "تم إضافة ورشة العمل بنجاح.",
                ];
                $successMessages[] = $data;
            } else {
                $data = [
                    'status' => "fail",
                    'message' => "حدث خطأ أثناء إضافة ورشة العمل.",
                ];
                $errorMessages[] = $data;
            }
        }

        if (!empty($experience)) {
            $teacher_experience = new stdClass();
            $teacher_experience->teacher_id = $userid;
            $teacher_experience->experience = $experience;
            if ($DB->insert_record('teacher_exp', $teacher_experience)) {
                $data = [
                    'status' => "success",
                    'message' => "تم إضافة التجربة بنجاح.",
                ];
                $successMessages[] = $data;
            } else {
                $data = [
                    'status' => "fail",
                    'message' => "حدث خطأ أثناء إضافة التجربة.",
                ];
                $errorMessages[] = $data;
            }
        }


        $response = [
            "successMessages" => $successMessages,
            "errorMessages" => $errorMessages
        ];

        return json_encode(['data' => $response]);
    }

    function delete_teacher_data($userid, $certificateid = null, $newcourseid = null, $workshopid = null, $experienceid = null)
    {
        global $DB;

        //$experienceid = $_GET['experienceid'];

        $successMessages = []; // لتخزين رسائل النجاح
        $errorMessages = [];   // لتخزين رسائل الخطأ

        if (!empty($experienceid)) {

            if ($DB->record_exists('teacher_exp', array('id' => $experienceid, 'teacher_id' => $userid))) {
                $delete = $DB->delete_records('teacher_exp', array('id' => $experienceid, 'teacher_id' => $userid));
                if ($delete) {
                    $data = [
                        'status' => "success",
                        'message' => "تم حذف التجربة بنجاح.",
                    ];
                    $successMessages[] = $data;
                } else {
                    $data = [
                        'status' => "fail",
                        'message' => "حدث خطأ أثناء حذف التجربة.",
                    ];
                    $errorMessages[] = $data;
                }
            } else {
                $data = [
                    'status' => "fail",
                    'message' => "حدث خطأ أثناء حذف التجربة.",
                ];
                $errorMessages[] = $data;
            }
        }

        if (!empty($workshopid)) {

            if ($DB->record_exists('teacher_workshops', array('teacher_id' => $userid, 'id' => $workshopid))) {
                $delete = $DB->delete_records('teacher_workshops', array('teacher_id' => $userid, 'id' => $workshopid));
                if ($delete) {
                    $data = [
                        'status' => "success",
                        'message' => "تم حذف ورشة العمل بنجاح.",
                    ];
                    $successMessages[] = $data;
                } else {
                    $data = [
                        'status' => "fail",
                        'message' => "حدث خطأ أثناء حذف ورشة العمل.",
                    ];
                    $errorMessages[] = $data;
                }
            } else {
                $data = [
                    'status' => "fail",
                    'message' => "حدث خطأ أثناء حذف ورشة العمل.",
                ];
                $errorMessages[] = $data;
            }
        }

        if (!empty($newcourseid)) {

            if ($DB->record_exists('teacher_courses_obtained', array('teacher_id' => $userid, 'id' => $newcourseid))) {
                $delete = $DB->delete_records('teacher_courses_obtained', array('teacher_id' => $userid, 'id' => $newcourseid));
                if ($delete) {
                    $data = [
                        'status' => "success",
                        'message' => "تم حذف الدورة الجديدة بنجاح.",
                    ];
                    $successMessages[] = $data;
                } else {
                    $data = [
                        'status' => "fail",
                        'message' => "حدث خطأ أثناء حذف الدورة الجديدة.",
                    ];
                    $errorMessages[] = $data;
                }
            } else {
                $data = [
                    'status' => "fail",
                    'message' => "حدث خطأ أثناء حذف الدورة الجديدة.",
                ];
                $errorMessages[] = $data;
            }
        }

        if (!empty($certificateid)) {

            if ($DB->record_exists('teacher_certificates', array('teacher_id' => $userid, 'id' => $certificateid))) {
                $delete = $DB->delete_records('teacher_certificates', array('teacher_id' => $userid, 'id' => $certificateid));
                if ($delete) {
                    $data = [
                        'status' => "success",
                        'message' => "تم حذف الشهادة بنجاح.",
                    ];
                    $successMessages[] = $data;
                } else {
                    $data = [
                        'status' => "fail",
                        'message' => "حدث خطأ أثناء حذف الشهادة.",
                    ];
                    $errorMessages[] = $data;
                }
            } else {
                $data = [
                    'status' => "fail",
                    'message' => "حدث خطأ أثناء حذف الشهادة.",
                ];
                $errorMessages[] = $data;
            }
        }

        $response = [
            "successMessages" => $successMessages,
            "errorMessages" => $errorMessages
        ];

        return json_encode(['data' => $response]);
    }

    function add_new_view($userid, $pdfid)
    {
        global $DB;
        $studentRole = $DB->get_field('role', 'id', array('shortname' => 'student'));
        $isStudent = $DB->record_exists('role_assignments', ['userid' => $userid, 'roleid' => $studentRole]);
        if ($isStudent) {
            $checkUser = $DB->get_record('testnew_logs', array('user' => $userid, 'testnewid' => $pdfid));
            if (empty($checkUser)) {
                $ins = new stdClass();
                $ins->views = 1;
                $ins->testnewid = $pdfid;
                $ins->user = $userid;
                $ins->id = $DB->insert_record('testnew_logs', $ins);
                if (!empty($ins->id)) {
                    return json_encode(['data' => "done"]);
                } else {
                    return json_encode(['data' => "error"]);
                }
            } else {
                $upd = new stdClass();
                $upd->id = $checkUser->id;
                $upd->views = $checkUser->views + 1;
                $upd->id = $DB->update_record('testnew_logs', $upd);
                if (!empty($upd->id)) {
                    return json_encode(['data' => "done"]);
                } else {
                    return json_encode(['data' => "error"]);
                }
            }
        } else {
            return json_encode(['data' => "NotStudent"]);
        }
    }
    function get_user_notifications($userid)
    {
        global $DB, $CFG;

        $notifications22 = $DB->get_records_sql("SELECT * FROM `mdl_notifications` WHERE useridto = $userid and timeread is  null and contexturl is not null order by id DESC");
        $notifications = $DB->get_records_sql("SELECT * FROM `mdl_notifications` WHERE useridto = $userid and contexturl is not null order by id DESC");
        $notificount = count($notifications22);
        foreach ($notifications as $newnotification) {
            if ($newnotification->contexturl != false) {
                //change time format to display activity date
                if ($newnotification->timeread != "0" && isset($newnotification->timeread))
                    $newnotification->timeread = date('d/m/Y H:i', $newnotification->timeread);
                if ($newnotification->timecreated != "0" && isset($newnotification->timecreated))
                    $newnotification->timecreated = date('d/m/Y H:i', $newnotification->timecreated);

                //replace $CFG->wwwroot as it is not true in config.php    
                $newcontext = str_replace("http://courses.ifta-learning.net/", "https://courses.ifta-learning.net/", $newnotification->contexturl);
                if (strstr($newcontext, "#p", true)) {
                    $newcontext = strstr($newcontext, '#p', true);
                }
                $newnotification->contexturl = $newcontext;
                //$newnotification->contexturl = "https://courses.ifta-learning.net/message/output/popup/mark_notification_read.php?notificationid=".$newnotification->id;

                //return first name and last name for from user and to user and user image
                $users = $DB->get_records_sql("SELECT * FROM `mdl_user` WHERE id = $newnotification->useridfrom or id = $newnotification->useridto");
                foreach ($users as $user) {
                    if ($newnotification->useridfrom != $user->id) {
                        $newnotification->useridfrom = $user->firstname . ' ' . $user->lastname;
                        // get user image
                        $userimage = "";
                        $user_context = $DB->get_record('context', array('instanceid' => $user->id, 'contextlevel' => 30));
                        $fs = get_file_storage();
                        $files = $fs->get_area_files($user_context->id, 'user', 'icon', 0, 'sortorder DESC, id ASC', false);
                        if (count($files) < 1) {
                            $userimage = '' . $CFG->wwwroot . '/pluginfile.php/' . $user_context->id . '/user/icon/0/f1.jpg?rev=0';
                        } else {
                            $file = reset($files);
                            unset($files);
                            $path = '/' . $user_context->id . '/user/icon/0' . $file->get_filepath() . $file->get_filename();
                            $userimage = $CFG->wwwroot . '/pluginfile.php' . $path . "?rev=" . $user->picture;
                        }

                        array_push($newnotification->userimage);
                        $newnotification->userimage = $userimage;
                    } else {
                        $newnotification->useridfrom = $user->firstname . ' ' . $user->lastname;
                    }

                    if ($newnotification->useridto == $user->id) {
                        $newnotification->useridto = $user->firstname . ' ' . $user->lastname;
                    }
                }
            }
        }
        return json_encode(["state" => 'success', "count" => $notificount, "data" => array_values($notifications), 'error' => ""]);
    }

    function upload_image($id)
    {
        // global $DB, $OUTPUT, $CFG;
        // $postImageName = $_FILES['image']['name'];
        // $postImageTemp = $_FILES['image']['tmp_name'];
        // $postImage = rand(0, 1000) . "_" . $postImageName;
        // $uploadFiles = move_uploaded_file($postImageTemp, $CFG->dirroot . "/theme/edumy/images/teachers/" . $postImage);
        // $checkUser = $DB->get_records_sql("SELECT * FROM mdl_user WHERE id = '$id'");
        // if ($uploadFiles) {
        //     $DB->execute(" UPDATE mdl_user SET url= '$postImage' WHERE id = '$id' ");
        //     return json_encode(['status' => "success", "data" => $CFG->wwwroot . "/theme/edumy/images/teachers/" . $postImage, "error" => '']);;
        // } else {
        //     return json_encode(['status' => "fail", "data" => '', "error" => "error uploading the image"]);
        // }


        global $DB, $CFG;
        // $img=$_FILES['image']['tmp_name'];
        $user = $DB->get_record('user', array('id' => $id));
        if (isset($_FILES['image'])) {
            // 

            if (!empty($user)) {
                // var_dump($_FILES['image']['tmp_name']);

                require_once($CFG->libdir . '/gdlib.php');
                // path to the image
                $tempfile = $_FILES['image']['tmp_name'];

                if (file_exists($tempfile)) {

                    $usericonid = process_new_icon(context_user::instance($id, MUST_EXIST), 'user', 'icon', 0, $tempfile);


                    if ($usericonid) {

                        $DB->set_field('user', 'picture', $usericonid, array('id' => $id));
                    }
                }
                unset($tempfile);
                // $path = '/' . $user_context->id . '/user/icon/0' . $file->get_filepath() . $file->get_filename();
                // $image = $CFG->wwwroot . '/pluginfile.php' . $path;
                // return json_encode(['status' => "success", "data" => $CFG->wwwroot . "/pluginfile.php/" . $usericonid . "/user/icon0/f1.jpg", "error" => '']);
                // return json_encode(['status' => "success", "data" =>, "error" => '']);
                $url = '';
                $user_context = $DB->get_record('context', array('instanceid' => $id, 'contextlevel' => 30));
                $fs = get_file_storage();
                $files = $fs->get_area_files($user_context->id, 'user', 'icon', 0, 'sortorder DESC, id ASC', false);
                if (count($files) < 1) {
                    $url = '';
                } else {
                    $file = reset($files);
                    unset($files);
                    $path = '/' . $user_context->id . '/user/icon/0' . $file->get_filepath() . $file->get_filename();
                    $url = $CFG->wwwroot . '/pluginfile.php' . $path . "?rev=" . $usericonid;
                }
                return json_encode(['status' => "success", "data" => $url, "error" => '']);
            } else {
                return json_encode(['status' => "fail", "data" => '', "error" => "User not found!"]);
            }
        } else {
            return json_encode(['status' => "fail", "data" => '', "error" => "error uploading the image"]);
        }
    }
}
function aboutInfo()
{
    require_once('teacher.php');
    echo teacher_aboutInfo();
}
function getGovernments($lang = '')
{
    global $DB, $USER;
    if ($lang == "en") {
        $governorates = $DB->get_records('governorates', array(), $sort = '', $fields = 'id ,governorate_name_en name', $limitfrom = 0, $limitnum = 0);
    } else {
        $governorates = $DB->get_records('governorates', array(), $sort = '', $fields = 'id ,governorate_name_ar name', $limitfrom = 0, $limitnum = 0);
    }

    if (!empty($governorates)) {
        return json_encode(["data" => array_values($governorates)]);
    } else {
        return json_encode(["error" => "No Governorates"]);
    }
}
function delete_teacher_images($imageId)
{
    global $DB, $OUTPUT, $CFG;
    $image = $DB->get_record('teachersphotos', array('id' => $imageId));
    if (!empty($image)) {
        $file = $CFG->dirroot . '/theme/edumy/images/teachers/' . $image->image;
        if (file_exists($file)) {
            unlink($file);
        }
        $DB->delete_records('teachersphotos', array('id' => $imageId));
        return json_encode(["status" => "success", "data" => "deleted", "error" => ""]);
    } else {
        return json_encode(["status" => "error", "data" => "", "error" => "No Image Found"]);
    }
}

function check_codes($course, $actid, $code, $userid)
{
    global $DB;
    try {
        $cm = $DB->get_record('course_modules', array('id' => $actid));
        $avail = json_decode($cm->availability);
        $id = '';

        for ($i = 0; $i < sizeof($avail->c); $i++) {
            if ($avail->c[$i]->type == 'group') {
                $group = $DB->get_record('groups', array('id' => $avail->c[$i]->id));
                if (strpos($group->name, 'week') !== false || strpos($group->name, 'اسبوع') !== false) {
                    $id = $avail->c[$i]->id;
                    break;
                }
            }
        }

        $groupCode = $DB->get_record('groups_attendence_codes', array('code' => $code, 'used' => 0));
        if (!empty($groupCode)) {
            $getGroupId = $DB->get_record('groups_attendence_patch', array('id' => $groupCode->patchid, 'courseid' => $course));
            if (!empty($getGroupId)) {
                if ($getGroupId->empty1 == 1) {
                    $checkAdding = groups_add_member($id, $userid);
                    if ($checkAdding) {
                        $upd = new stdClass();
                        $upd->id = $groupCode->id;
                        $upd->used = 1;
                        $upd->empty1 = $id;
                        $upd->empty2 = $userid;
                        $DB->update_record('groups_attendence_codes', $upd);
                        return json_encode(["status" => "success", "data" => "added", "error" => ""]);
                    } else {
                        return json_encode(['status' => "fail", "data" => '', "error" => "error adding to a group"]);
                    }
                } else {
                    if ($id == $getGroupId->groupid) {
                        $checkAdding = groups_add_member($getGroupId->groupid, $userid);
                        if ($checkAdding) {
                            $upd = new stdClass();
                            $upd->id = $groupCode->id;
                            $upd->used = 1;
                            $upd->empty2 = $userid; //userid
                            $DB->update_record('groups_attendence_codes', $upd);
                            return json_encode(["status" => "success", "data" => "added", "error" => ""]);
                        } else {
                            return json_encode(['status' => "fail", "data" => '', "error" => "error adding to a group"]);
                        }
                    } else {
                        return json_encode(['status' => "fail", "data" => '', "error" => "this code doesn't belong to this course or this group"]);
                    }
                }
            } else {
                return json_encode(['status' => "fail", "data" => '', "error" => "this code doesn't belong to this course or this group"]);
            }
        } else {
            return json_encode(['status' => "fail", "data" => '', "error" => "Group Code is not valid"]);
        }
    } catch (Exception $e) {
        return json_encode(['status' => "fail", "data" => '', "error" => $e->getMessage()]);
    }
}


function confirm_signup()
{
    require_once('teacher.php');
    echo teacher_confirm_signup();
}
function loginasguest()
{
    $guestLogin = array(
        ['id' => 1, 'videourl' => 'https://academy2022.nitg-eg.com/videos/01.mp4'],
    );
    return json_encode(["data" => array_values($guestLogin)]);
    //return json_encode('Hello');
}

function property_rights()
{
    $data_array = [];
    $currentYear = date('Y');

    $data = [
        'rights' => 'All rights reserved.',
        'company' => 'National Company N.I.T',
        'link' => 'https://nitg-eg.com/',
        'Copyright' => 'Copyright © ' . $currentYear . ' Designed and developed by'
    ];
    $data_array[] = $data;
    return json_encode(['status' => 'success', 'data' => $data_array]);
}

function social_links($get, $add, $edit, $delete, $facebook = null, $instagram = null, $youtube = null, $twitter = null, $whatsapp = null, $linkedin = null, $tiktok = null, $title1 = null, $body1 = null, $title2 = null, $body2 = null, $title3 = null, $my_email)
{
    global $DB;

    $record_id = 1;

    if ($get == 1) {
        // Check if the record with the specified ID exists
        if ($DB->record_exists('social_likes', ['id' => $record_id])) {
            // Get the social links data for the specified record
            $socialLinks = $DB->get_record('social_likes', ['id' => $record_id]);

            if ($socialLinks) {
                return json_encode(['status' => 'success', 'data' => $socialLinks, 'message' => 'Social links data retrieved successfully.']);
            } else {
                return json_encode(['status' => 'fail', 'data' => [], 'message' => 'Failed to retrieve social links data.']);
            }
        } else {
            return json_encode(['data' => [], 'message' => 'Record not found.']);
        }
    } elseif ($add == 1) {
        // Insert operation when $add is 1
        $newLinks = new stdClass();
        $newLinks->facebook = $facebook;
        $newLinks->instagram = $instagram;
        $newLinks->youtube = $youtube;
        $newLinks->twitter = $twitter;
        $newLinks->whatsapp = $whatsapp;
        $newLinks->linkedin = $linkedin;
        $newLinks->tiktok = $tiktok;
        $insertedId = $DB->insert_record('social_likes', $newLinks);

        if ($insertedId) {
            return json_encode(['status' => 'success', 'data' => ['id' => $insertedId], 'message' => 'Social links added successfully.']);
        } else {
            return json_encode(['status' => 'fail', 'data' => [], 'message' => 'Failed to add social links.']);
        }
    } elseif ($edit == 1) {
        // Update operation when $edit is 1
        if (!empty($record_id)) {
            if ($DB->record_exists('social_likes', ['id' => $record_id])) {
                $sql = "UPDATE mdl_social_likes 
                        SET 
                            facebook = '$facebook',
                            instagram = '$instagram',
                            youtube = '$youtube',
                            twitter = '$twitter',
                            whatsapp = '$whatsapp',
                            linkedin = '$linkedin',
                            tiktok = '$tiktok',
                            title1 = '$title1',
                            title2 = '$title2',
                            title3 = '$title3',
                            body1 = '$body1',
                            body2 = '$body2',
                            myemail = '$my_email'
                        WHERE id = $record_id";

                // Execute the SQL query
                $success = $DB->execute($sql);

                if ($success) {
                    return json_encode(['status' => 'success', 'data' => $success, 'message' => 'Social links updated successfully.']);
                } else {
                    return json_encode(['status' => 'fail', 'data' => [], 'message' => 'Failed to update social links.']);
                }
            } else {
                return json_encode(['status' => 'fail', 'data' => [], 'message' => 'Record not found.']);
            }
        } else {
            return json_encode(['status' => 'fail', 'data' => [], 'message' => 'Invalid ID for update operation.']);
        }
    } elseif ($delete == 1) {
        // Delete operation when $delete is 1
        if ($DB->record_exists('social_likes', ['id' => $record_id])) {
            $DELETE = $DB->delete_records('social_likes', ['id' => $record_id]);

            if ($DELETE) {
                return json_encode(['status' => 'success', 'data' => 'success', 'message' => 'Social links deleted successfully.']);
            } else {
                return json_encode(['status' => 'fail', 'data' => [], 'message' => 'Failed to delete social links.']);
            }
        } else {
            return json_encode(['data' => [], 'message' => 'This record was not found.']);
        }
    } else {
        return json_encode(['data' => [], 'message' => 'Invalid operation or missing data.']);
    }
}

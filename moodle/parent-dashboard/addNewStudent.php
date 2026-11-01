<?php
require_once('../config.php');
require_login();
global $DB;

function generate_unique_name($length = 8)
{
    // توليد سلسلة عشوائية من البايتات وتحويلها إلى أحرف صغيرة
    $randomString = bin2hex(random_bytes($length / 2));
    return substr($randomString, 0, $length);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parentId = isset($_POST['id']) ? trim($_POST['id']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

    $errors = [];

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    } elseif (!preg_match("/^\d+$/", $phone)) {
        $errors[] = "Invalid phone number format. It should contain only digits.";
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            \core\notification::add($error, \core\output\notification::NOTIFY_ERROR);
        }
        redirect(new moodle_url('/parent-dashboard'));
    } else {

        // التحقق من وجود البريد الإلكتروني في جدول المستخدمين
        $user = $DB->get_record('user', array('email' => $email, 'deleted' => 0));

        if ($user) {

            // get parent phone number
            $parent_phone = $DB->get_field('user', 'phone1', array('id' => $parentId, 'deleted' => 0));

            // Check if the phone number matches phone1 and parent phone number matches phone2
            $phones_matching = is_phone_matching($user, $phone, $parent_phone);

            if ($phones_matching) {
                // التحقق من أن الطالب موجود بالفعل في قائمة الأبناء الخاصة بالوالد
                $existing = $DB->get_record_sql(
                    "SELECT *
                FROM {user_info_data}
                WHERE userid = :userid
                AND (fieldid = 5 OR fieldid > 8)
                AND data = :email",
                    array('userid' => $parentId, 'email' => $email)
                );

                if ($existing) {
                    \core\notification::add("This student is already on your children's list!", \core\output\notification::NOTIFY_WARNING);
                    redirect(new moodle_url('/parent-dashboard'));
                } else {

                    $uniqueName = generate_unique_name();
                    // إضافة الحقل إلى جدول بيانات معلومات المستخدمين
                    $fieldData = new stdClass();
                    $fieldData->shortname = $uniqueName;
                    $fieldData->name = $user->firstname; // افتراضياً اسم الطالب يتم التحقق من ذلك
                    $fieldData->datatype = 'text';
                    $fieldData->categoryid = 1; // افتراضياً الفئة 1
                    $insertSuccessField = $DB->insert_record('user_info_field', $fieldData);

                    if ($insertSuccessField) {
                        // إضافة بيانات الطالب إلى جدول بيانات معلومات المستخدمين
                        $data = new stdClass();
                        $data->userid = $parentId;
                        $data->fieldid = $insertSuccessField;
                        $data->data = $email;
                        $data->dataformat = 0; // افتراضياً تنسيق البيانات 0
                        $insertSuccess = $DB->insert_record('user_info_data', $data);

                        if ($insertSuccess) {
                            \core\notification::add('Student added successfully!', \core\output\notification::NOTIFY_SUCCESS);
                        } else {
                            \core\notification::add('Failed to add student data.', \core\output\notification::NOTIFY_ERROR);
                        }
                    } else {
                        \core\notification::add('Failed to add student field.', \core\output\notification::NOTIFY_ERROR);
                    }
                    redirect(new moodle_url('/parent-dashboard'));
                }
            } else {
                \core\notification::add('Phone numbers do not match', \core\output\notification::NOTIFY_ERROR);
                redirect(new moodle_url('/parent-dashboard'));
            }
        } else {
            \core\notification::add('This student was not found', \core\output\notification::NOTIFY_ERROR);
            redirect(new moodle_url('/parent-dashboard'));
        }
    }
} else {
    \core\notification::add('Invalid request method.', \core\output\notification::NOTIFY_ERROR);
    redirect(new moodle_url('/parent-dashboard'));
}

/**
 * Function to check if the given phone number matches any of the user's phone numbers.
 *
 * @param object $user The user object containing phone numbers.
 * @param string $phone The phone number to match for the user.
 * @param string $parent_phone The phone number to match for the parent.
 * @return bool Returns true if both phone numbers match, false otherwise.
 */
function is_phone_matching($user, $phone, $parent_phone)
{
    // Check if the phone number matches phone1 and parent phone number matches phone2
    return $user->phone1 === $phone && $user->phone2 === $parent_phone;
}

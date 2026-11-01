<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * user signup page.
 *
 * @package    core
 * @subpackage auth
 * @copyright  1999 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../config.php');
require_once($CFG->dirroot . '/user/editlib.php');
require_once($CFG->libdir . '/authlib.php');
require_once('lib.php');

if (!$authplugin = signup_is_enabled()) {
    throw new \moodle_exception('notlocalisederrormessage', 'error', '', 'Sorry, you may not use this page.');
}

$PAGE->set_url('/login/signup.php');
$PAGE->set_context(context_system::instance());

// If wantsurl is empty or /login/signup.php, override wanted URL.
// We do not want to end up here again if user clicks "Login".
if (empty($SESSION->wantsurl)) {
    $SESSION->wantsurl = $CFG->wwwroot . '/';
} else {
    $wantsurl = new moodle_url($SESSION->wantsurl);
    if ($PAGE->url->compare($wantsurl, URL_MATCH_BASE)) {
        $SESSION->wantsurl = $CFG->wwwroot . '/';
    }
}

if (isloggedin() and !isguestuser()) {
    // Prevent signing up when already logged in.
    echo $OUTPUT->header();
    echo $OUTPUT->box_start();
    $logout = new single_button(new moodle_url(
        '/login/logout.php',
        array('sesskey' => sesskey(), 'loginpage' => 1)
    ), get_string('logout'), 'post');
    $continue = new single_button(new moodle_url('/'), get_string('cancel'), 'get');
    echo $OUTPUT->confirm(get_string('cannotsignup', 'error', fullname($USER)), $logout, $continue);
    echo $OUTPUT->box_end();
    echo $OUTPUT->footer();
    exit;
}

// If verification of age and location (digital minor check) is enabled.
if (\core_auth\digital_consent::is_age_digital_consent_verification_enabled()) {
    $cache = cache::make('core', 'presignup');
    $isminor = $cache->get('isminor');
    if ($isminor === false) {
        // The verification of age and location (minor) has not been done.
        redirect(new moodle_url('/login/verify_age_location.php'));
    } else if ($isminor === 'yes') {
        // The user that attempts to sign up is a digital minor.
        redirect(new moodle_url('/login/digital_minor.php'));
    }
}

// Plugins can create pre sign up requests.
// Can be used to force additional actions before sign up such as acceptance of policies, validations, etc.
core_login_pre_signup_requests();

$mform_signup = $authplugin->signup_form();

if ($mform_signup->is_cancelled()) {
    redirect(get_login_url());
} else if ($user = $mform_signup->get_data()) {
    // Add missing required fields.
    $user = signup_setup_new_user($user);

    // Plugins can perform post sign up actions once data has been validated.
    core_login_post_signup_requests($user);

    $authplugin->user_signup($user, true); // prints notice and link to login/index.php
    exit; //never reached
}


$newaccount = get_string('newaccount');
$login      = get_string('login');

$PAGE->navbar->add($login);
$PAGE->navbar->add($newaccount);

$PAGE->set_pagelayout('login');
$PAGE->set_title($newaccount);
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();

echo '
    <style>
    /* .ccn_context_frontend .inner_page_breadcrumb {
        display: none;
    } */
    .bgc_xc {
        top: 0;
        margin: 0px;
        padding: 0px;
        display: flex;
        justify-content: center;
        height: auto;
        flex-direction: row-reverse;
    }
    .container_c {
        height: 100%;
        width: 100%;
        /* background-image: url(' . $CFG->wwwroot . '/service_images/login_cover_2.png); 
        background-repeat: no-repeat;
        background-size: cover;
        background-size: 100% 100%; */
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .my_login_form {
        padding: 100px 50px 20px 50px;
    }
    /* .my_login_form form .heading {display: none;} */
    .hero_image_side {
        height: auto;
        width: 100%;
        background-image: url(' . $CFG->wwwroot . '/service_images/3alemny_signup_cover.svg);
        background-repeat: no-repeat;
        background-size: cover;
        /* background-size: 100% 100%; */
    }
    @media only screen and (max-width: 600px) {
        .bgc_xc {
            margin: 0px;
            padding: 0px;
            display: flex;
            justify-content: center;
            height: auto;
            flex-direction: column-reverse;
        }
        .hero_image_side {
            height: 600px;
        }
        .container_c {
            height: 900px;
        }
    }


    .jsenabled .collapsible-actions,
    #id_category_3 legend,
    .mform .col-form-label .form-label-addon,
    .word-break,
    #id_cancel,
    .fdescription,
    .signup_place {
        display: none !important;
    }
    .form-group input[type=submit] {
        background-color: #92251E;
        color: white !important;
        display: flex;
        justify-content: center;
        text-align: center;
        padding: 15px 28px !important;
    }
    .text-center {
        padding-right: 15px;
        padding-left: 15px;
    }
    
    .mform .form-inline .form-group {
        width: 100%;
    }
    .mform .form-inline .form-group span {
        width: 100%;
    }
    #id_submitbutton {
        width: 100%;
    }
    input::placeholder {
        font-size: 14px;
        font-width: 400px;
    }
    .form-group {
        margin-bottom: 0.4rem !important;
    }
    .mform fieldset {
        border-bottom: 0px solid !important;
    }

    label[for="id_profile_field_privacy_policy"] {
        margin-left: 15px;
        margin-bottom: 0px !important;
        font-size: 14px;
        font-weight: 500;
    }

    /* Hide the default checkbox */
    #id_profile_field_privacy_policy {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    #id_profile_field_privacy_policy + label::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        height: 25px;
        width: 25px;
        background-color: #ccc;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    /* On checkbox checked */
    #id_profile_field_privacy_policy:checked + label::before {
        background-color: #92251E;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    #id_profile_field_privacy_policy + label::after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    #id_profile_field_privacy_policy:checked + label::after {
        display: block;
    }

    /* Style the checkmark/indicator */
    #id_profile_field_privacy_policy + label::after {
        left: 9px;
        top: 30%;
        width: 6px;
        height: 11px;
        border: solid white;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
    }

    
    </style>';

if ($mform_signup instanceof renderable) {
    // Try and use the renderer from the auth plugin if it exists.
    try {
        $renderer = $PAGE->get_renderer('auth_' . $authplugin->authtype);
    } catch (coding_exception $ce) {
        // Fall back on the general renderer.
        $renderer = $OUTPUT;
    }
    echo $renderer->render($mform_signup);
} else {
    // Fall back for auth plugins not using renderables.
    $mform_signup->display();
}


echo '
<style>
#page {
   background-image: linear-gradient(to right, #183041 0%, #183041 100%) !important;
}
#fitem_id_username,
#fitem_id_email2 {
    display: none !important;
}
#MC_button {
    position: relative;
    top: 10px;
    left: -15px;
    background-color: #92251E;
    color: white;
    border-radius: 50%;
    opacity: 0.8;
    padding: 1px 6px;
}
</style>
<script>
    document.addEventListener(\'DOMContentLoaded\', function () {
        // Get references to the email and username fields.
        var emailField = document.getElementById(\'id_email\');
        var usernameField = document.getElementById(\'id_username\');
        var emailagain = document.getElementById(\'id_email2\');

        // Add input event listener to the email field.
        emailField.addEventListener(\'input\', function () {
            var emailValue = emailField.value.toLowerCase();
            var validUsername = emailValue.replace(/[^a-z0-9._@-]/g, \'\');

            // Update the value of the username field with the email value.
            usernameField.value = validUsername;
            emailagain.value = emailField.value;
        });
    });
</script>
';

echo '
<script>
var label = document.querySelector(\'label[for="id_profile_field_privacy_policy"]\');
if (label) {
    label.innerHTML = \'By Signing Up, You Agree To <a type="button" data-toggle="modal" data-target="#myConditions" style="color: #92251E;text-decoration: underline;">Terms & Conditions & Privacy Policy.</a>\';
} else {
    console.error("Label not found");
}
</script>
';
?>
<!-- The Modal -->
<div class="modal" id="myConditions">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal body -->
            <div class="modal-body">
            <button type="button" id="MC_button" class="close" data-dismiss="modal">&times;</button>
                <div class="container">
                    <h2 class="mb-2">Terms And Conditions</h2>
                    <h4>Introduction</h4>
                    <p>Welcome to [Platform Name]. By accessing or using our educational platform, you agree to be bound by these Terms and Conditions. Please read them carefully before using our services.</p>
                    <h4>Acceptance of Terms</h4>
                    <p>By registering for an account, accessing, browsing, or using [Platform Name] and its services, you acknowledge that you have read, understood, and agree to be bound by these Terms and Conditions.</p>
                    <h4>Eligibility</h4>
                    <p>To use our services, you must be at least 18 years old or have reached the age of majority in your jurisdiction, and have the legal capacity to enter into a binding contract. If you are under 18, you may use our services only with the involvement and consent of a parent or guardian.</p>
                    <h4>Account Registration</h4>
                    <p>You may need to create an account to access some of our services. You agree to provide accurate, current, and complete information during the registration process and to update such information to keep it accurate, current, and complete. You are responsible for safeguarding your password and for all activities that occur under your account.</p>
                    <h4>Use of the Platform</h4>
                    <ul>
                        <li><strong>User Conduct</strong>: You agree to use the platform for lawful purposes only. You must not use the platform to transmit, distribute, store, or destroy material in violation of any applicable law or regulation.</li>
                        <li><strong>Prohibited Activities</strong>: You are prohibited from violating or attempting to violate the security of the platform, including, without limitation:<ul>
                                <li>Accessing data not intended for you or logging into an account you are not authorized to access.</li>
                                <li>Attempting to probe, scan, or test the vulnerability of the system or network.</li>
                                <li>Breaching security or authentication measures without proper authorization.</li>
                                <li>Interfering with, disrupting, or causing harm to the system or network, or disobeying any requirements, procedures, policies, or regulations of networks connected to the platform.</li>
                            </ul>
                        </li>
                    </ul>
                    <h4>Content</h4>
                    <ul>
                        <li><strong>User Content</strong>: You are responsible for all content that you upload, post, email, or otherwise transmit via the platform. You retain ownership of your content but grant [Platform Name] a worldwide, non-exclusive, royalty-free license to use, distribute, reproduce, modify, adapt, and publicly display your content.</li>
                        <li><strong>Platform Content</strong>: All content provided by [Platform Name], including but not limited to courses, text, graphics, logos, images, and software, is the property of [Platform Name] or its content suppliers and is protected by copyright, trademark, and other laws.</li>
                    </ul>
                    <h4>Payments and Refunds</h4>
                    <ul>
                        <li><strong>Payments</strong>: Some services on the platform may be subject to fees. You agree to pay all fees and charges, including applicable taxes, incurred through your account at the rates in effect when the charges were incurred.</li>
                        <li><strong>Refunds</strong>: Refunds, if applicable, will be processed according to our Refund Policy, which is available on the platform.</li>
                    </ul>
                    <h4>Privacy</h4>
                    <p>Your privacy is important to us. Our Privacy Policy explains how we collect, use, and protect your information. By using the platform, you consent to the collection and use of information in accordance with the Privacy Policy.</p>
                    <h4>Termination</h4>
                    <p>We reserve the right to suspend or terminate your account and access to the platform at our discretion, without notice, for conduct that we believe violates these Terms and Conditions or is harmful to other users, us, or third parties, or for any other reason.</p>
                    <h4>Limitation of Liability</h4>
                    <p>To the maximum extent permitted by law, [Platform Name] shall not be liable for any indirect, incidental, special, consequential, or punitive damages, or any loss of profits or revenues, whether incurred directly or indirectly, or any loss of data, use, goodwill, or other intangible losses, resulting from:</p>
                    <ul>
                        <li>Your use or inability to use the platform.</li>
                        <li>Any unauthorized access to or use of our servers and/or any personal information stored therein.</li>
                        <li>Any interruption or cessation of transmission to or from the platform.</li>
                        <li>Any bugs, viruses, Trojan horses, or the like that may be transmitted to or through our platform by any third party.</li>
                    </ul>
                    <h4>Governing Law</h4>
                    <p>These Terms and Conditions shall be governed by and construed in accordance with the laws of [Your Country/State], without regard to its conflict of law principles. Any legal action or proceeding related to your access to or use of the platform must be instituted in a state or federal court in [Your Jurisdiction].</p>
                    <h4>Changes to Terms</h4>
                    <p>We may modify these Terms and Conditions from time to time. We will notify you of changes by posting the new Terms and Conditions on the platform. Your continued use of the platform after such changes constitutes your acceptance of the new Terms and Conditions.</p>
                    <h4>Contact Us</h4>
                    <p>If you have any questions about these Terms and Conditions, please contact us at [Your Contact Information].</p>
                    <hr>
                    <p>By using [Platform Name], you acknowledge that you have read and agree to these Terms and Conditions.</p>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<?php
echo $OUTPUT->footer();

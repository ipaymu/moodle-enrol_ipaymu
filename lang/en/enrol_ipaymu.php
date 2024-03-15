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
 * Contains all the strings used in the plugin.
 * @package   enrol_ipaymu
 * @copyright 2024 Syaifudin <syaifudin@ipaymu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'iPaymu Payment';
$string['pluginname_desc'] = 'The iPaymu module allows you to set up paid courses.  If the cost for any course is zero, then students are not asked to pay for entry.  There is a site-wide cost that you set here as a default for the whole site and then a course setting that you can set for each course individually. The course cost overrides the site cost.';

$string['apikey'] = 'API Key';
$string['apikey_desc'] = 'API Key located in the Project website';

$string['ipaymu_va'] = 'VA Live/Production';
$string['ipaymu_va_desc'] = '<small>Dapatkan VA Production <a href="https://my.ipaymu.com/integration" target="_blank">di sini</a></small>';
$string['ipaymu_apikey'] = 'API Key Live/Production';
$string['ipaymu_apikey_desc'] = '<small>Dapatkan API Key Production <a href="https://my.ipaymu.com/integration" target="_blank">di sini</a></small>';

$string['ipaymu_va_sandbox'] = 'VA Sandbox';
$string['ipaymu_va_sandbox_desc'] = '<small>Dapatkan VA Sandbox <a href="https://sandbox.ipaymu.com/integration" target="_blank">di sini</a></small>';
$string['ipaymu_apikey_sandbox'] = 'API Key Sandbox';
$string['ipaymu_apikey_sandbox_desc'] = '<small>Dapatkan API Key Sandbox <a href="https://sandbox.ipaymu.com/integration" target="_blank">di sini</a></small>';

$string['assignrole'] = 'Assign role';
$string['call_error'] = 'An error has occured when requesting transaction. Please try again or contact the site admin';
$string['cost'] = 'Enrol cost';
$string['costerror'] = 'The enrolment cost is not numeric';
$string['costorkey'] = 'Please choose one of the following methods of enrolment.';
$string['course_error'] = 'Course not found';
$string['currency'] = 'Currency';
$string['defaultrole'] = 'Default role assignment';
$string['defaultrole_desc'] = 'Select role which should be assigned to users during ipaymu enrolments';
$string['ipaymu:config'] = 'Configure ipaymu enrol instances';
$string['ipaymu:manage'] = 'Manage enrolled users';
$string['ipaymu:unenrol'] = 'Unenrol users from course';
$string['ipaymu:unenrolself'] = 'Unenrol self from the course';
$string['ipaymuaccepted'] = 'iPaymu payments accepted';
$string['enrolenddate'] = 'End date';
$string['enrolenddate_help'] = 'If enabled, users can be enrolled until this date only.';
$string['enrolenddaterror'] = 'Enrolment end date cannot be earlier than start date';
$string['enrolperiod'] = 'Enrolment duration';
$string['enrolperiod_desc'] = 'Default length of time that the enrolment is valid. If set to zero, the enrolment duration will be unlimited by default.';
$string['enrolperiod_help'] = 'Length of time that the enrolment is valid, starting with the moment the user is enrolled. If disabled, the enrolment duration will be unlimited.';
$string['enrolstartdate'] = 'Start date';
$string['enrolstartdate_help'] = 'If enabled, users can be enrolled from this date onward only.';
$string['environment'] = 'Environment';
$string['environment_desc'] = 'Configure ipaymu endpoint to be sandbox or production';
$string['errdisabled'] = 'The ipaymu enrolment plugin is disabled and does not handle payment notifications.';
$string['expiredaction'] = 'Enrolment expiry action';
$string['expiredaction_help'] = 'Select action to carry out when user enrolment expires. Please note that some user data and settings are purged from course during course unenrolment.';
$string['expiry'] = 'Expiry Period';
$string['expiry_desc'] = 'Expiry period for each transaction. Units set in Hour';
$string['mailadmins'] = 'Notify admin';
$string['mailstudents'] = 'Notify students';
$string['mailteachers'] = 'Notify teachers';
$string['mail_logging'] = 'ipaymu Logs the email that is sent';
$string['merchantcode'] = 'Merchant Code';
$string['merchantcode_desc'] = 'Merchant code located in the Project website';



$string['nocost'] = 'There is no cost associated with enrolling in this course!';
$string['payment_expirations'] = 'ipaymu checks for expired transaction in database';
$string['payment_not_exist'] = 'Transaction does not exist or has not been saved. Please create a new transaction';
$string['payment_cancelled'] = 'Transaction cancelled. Please create a new transaction';
$string['payment_paid'] = 'Transaction paid succesfully. Please wait a moment and refresh the page again.';
$string['pending_message'] = 'User has not completed payment yet';
$string['sendpaymentbutton'] = 'Pay via iPaymu';
$string['status'] = 'Allow ipaymu enrolments';
$string['status_desc'] = 'Allow users to use ipaymu to enrol into a course by default.';
$string['transactions'] = 'ipaymu Transactions';
$string['user_return'] = 'User has returned from redirect page';

$string['ipaymu_request_log'] = 'ipaymu Enrol Plugin Log';
$string['log_request_transaction'] = 'Requesting a transaction to ipaymu';
$string['log_request_transaction_response'] = 'ipaymu response to Request Transaction';
$string['log_check_transaction'] = 'Checking transaction to ipaymu';
$string['log_check_transaction_response'] = 'ipaymu respose for Checking Transaction';
$string['log_callback'] = 'Received Callback from ipaymu. Affected student should be enrolled';

$string['environment:production'] = 'Production';
$string['environment:sandbox'] = 'Sandbox';

$string['return_header'] = '<h2>Pending Transaction</h2>';
$string['return_sub_header'] = 'Course name : {$a->fullname}<br />';
$string['return_body'] = 'If you have already paid, wait a few moments then check again if you are already enrolled. <br /> We kept your payment <a href="{$a->reference}">here</a> in case you would like to return.';

$string['admin_email'] = 'Email to Admin on Enrolment';
$string['admin_email_desc'] = 'Fill with HTML format. Leave blank for default template. <br /> Use "$courseShortName" to display the enrolled course short name, <br /> "$studentUsername" to display enrolled student username, <br /> "$courseFullName" to display the enrolled course full name, <br /> "$amount" to get the amount payed during enrolment, "$adminUsername" to get the admin username, "$teacherName" to get the teacher username. (All without quotation marks).';
$string['admin_email_template_header'] = '<h1>New Enrolment in {$a->shortname}</h1><br />';
$string['admin_email_template_greeting'] = '<p>Hello {$a->adminUsername}!</p><br />';
$string['admin_email_template_body'] = '<p>{$a->studentUsername} has successfully payed {$a->amount} and enrolled in the {$a->courseFullName} course via ipaymu Enrolment Plugin</p>';

$string['teacher_email'] = 'Email to Teacher on Enrolment';
$string['teacher_email_desc'] = 'Fill with HTML format. Leave blank for default template. <br /> Use "$courseShortName" to display the enrolled course short name, <br /> "$studentUsername" to display enrolled student username, <br /> "$courseFullName" to display the enrolled course full name, <br /> "$amount" to get the amount payed during enrolment, "$adminUsername" to get the admin username, "$teacherName" to get the teacher username. (All without quotation marks).';
$string['teacher_email_template_header'] = '<h1>New Enrolment in {$a->shortname}</h1><br />';
$string['teacher_email_template_greeting'] = '<p>Hello {$a->teachername}!</p><br />';
$string['teacher_email_template_body'] = '<p>{$a->studentUsername} has successfully payed {$a->amount} and enrolled in the {$a->courseFullName} course via ipaymu Enrolment Plugin</p>';

$string['student_email'] = 'Email to Student on Enrolment';
$string['student_email_desc'] = 'Fill with HTML format. Leave blank for default template. <br /> Use "$courseShortName" to display the enrolled course short name, <br /> "$studentUsername" to display enrolled student username, <br /> "$courseFullName" to display the enrolled course full name, <br /> "$amount" to get the amount payed during enrolment, "$adminUsername" to get the admin username, "$teacherName" to get the teacher username. (All without quotation marks).';
$string['student_email_template_header'] = '<h1>Enrolment Successful</h1>';
$string['student_email_template_greeting'] = '<p>Hello {$a->studentUsername},</p><br /><p>Welcome to {$a->courseFullName}!</p><br />';
$string['student_email_template_body'] = '<p>Your payment of {$a->amount} using ipaymu has been successful. Enjoy your course!</p><br/>';

$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu'] = 'Transaction data for the ipaymu Payment Gateway Plugin.';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:userid'] = 'The ID of the user making requesting a transaction';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:courseid'] = 'The ID of the course being requested';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:instanceid'] = 'The instance ID of the course being requested';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:reference'] = 'Reference number received from ipaymu.';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:timestamp'] = 'Timestamp of when the transaction was requested';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:signature'] = 'Signature used to verify the transaction';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:merchant_order_id'] = 'The order id used to identify the transaction';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:receiver_id'] = 'The receiver user id. Usually the admin';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:receiver_email'] = 'The receiver email. Usually the admin';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:payment_status'] = 'Transaction Payment Status.';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:pending_reason'] = 'The reason for the payment status';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:timeupdated'] = 'The time this specific transaction is updated';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:expiryperiod'] = 'The expiry period for this specific transaction';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:referenceurl'] = 'The reference link for when user wants to go back to a previous transaction.';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com'] = 'ipaymu Payment Gateway plugin sends user data from Moodle to ipaymu.';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:merchantcode'] = 'ipaymu Merchant Code';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:apikey'] = 'ipaymu API Key';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:signature'] = 'Signature generated to verify a transaction';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:merchant_order_id'] = 'The order ID generated per order';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:paymentAmount'] = 'The cost of the course requested for transaction';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:username'] = 'Username of the user requesting a transaction';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:first_name'] = 'First name of the user requesting a transaction';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:last_name'] = 'Last name of the user requesting a transaction';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:address'] = 'Address of the user requesting a transaction';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:city'] = 'City of the user requesting a transaction';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:email'] = 'Email of the user requesting a transaction';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:country'] = 'Country of the user requesting a transaction';

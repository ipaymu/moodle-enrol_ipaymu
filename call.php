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
 * Creates an invoice to ipaymu and redirects the user to ipaymu POP page.
 * @package   enrol_ipaymu
 * @copyright 2024 Syaifudin <syaifudin@ipaymu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use enrol_ipaymu\ipaymu_status_codes;
use enrol_ipaymu\ipaymu_mathematical_constants;
use enrol_ipaymu\ipaymu_helper;

require("../../config.php");

require_login();

$expiryperiod = get_config('enrol_ipaymu', 'expiry');
$currenttimestamp = round(microtime(true) * ipaymu_mathematical_constants::SECOND_IN_MILLISECONDS);// In milisecond.

$environment = required_param('environment', PARAM_TEXT);
$paymentamount = required_param('amount', PARAM_INT);
        
$merchantorderid = required_param('orderId', PARAM_TEXT);
$customervaname = required_param('customerVa', PARAM_TEXT);
$productdetails = required_param('item_name', PARAM_TEXT);
$email = required_param('email', PARAM_TEXT);
$callbackurl = required_param('notify_url', PARAM_TEXT);

$custom = explode('-', $merchantorderid);
$userid = (int)$custom[1];
$courseid = (int)$custom[2];
$instanceid = (int)$custom[3];

$phonenumber = empty($USER->phone1) === true ? "" : $USER->phone1;

$admin = get_admin(); // Only 1 MAIN admin can exist at a time.

// Check if the user has not made a transaction before.
$params = [
    'userid' => $userid,
    'courseid' => $courseid,
    'instanceid' => $instanceid,
];
$sql = 'SELECT * FROM {enrol_ipaymu} WHERE userid = :userid AND courseid = :courseid AND instanceid = :instanceid ORDER BY {enrol_ipaymu}.timestamp DESC';
$context = context_course::instance($courseid, MUST_EXIST);

$existingdata = $DB->get_record_sql($sql, $params, 1); // Will return exactly 1 row. The newest transaction that was saved.

$enroldata = new stdClass();
$enroldata->userid = $USER->id;
$enroldata->courseid = $courseid;
$enroldata->instanceid = $instanceid;
$enroldata->timestamp = $currenttimestamp;
$enroldata->merchant_order_id = $merchantorderid;
$enroldata->receiver_id = $admin->id;
$enroldata->receiver_email = $admin->email;
$enroldata->payment_status = ipaymu_status_codes::CHECK_STATUS_PENDING;
$enroldata->pending_reason = get_string('pending_message', 'enrol_ipaymu');
$enroldata->expiryperiod = $currenttimestamp + ($expiryperiod * ipaymu_mathematical_constants::MINUTE_IN_SECONDS * ipaymu_mathematical_constants::SECOND_IN_MILLISECONDS);

$enroldata->reference = $request->reference; // Reference only received after successful request transaction.
$enroldata->timeupdated = round(microtime(true) * ipaymu_mathematical_constants::SECOND_IN_MILLISECONDS); // In milisecond.

$product[] = $productdetails;
$price[] = $paymentamount;
$qty[] = 1;
$name = $USER->firstname.' '. $USER->lastname;
$email = $USER->email;
$phone = $phonenumber;

$returnurl = "$CFG->wwwroot/course/view.php?id=$courseid";

function createLink($product, $qty, $price, $name, $phone, $email, $returnurl, $callbackurl) {
    $ipaymuhelper = new ipaymu_helper();
    $createLink = $ipaymuhelper->create($product, $qty, $price, $name, $phone, $email, $returnurl, $callbackurl);
    
    if (!empty($createLink['err'])) {
        throw new Exception('Invalid Response from iPaymu. Please contact support@ipaymu.com');
        exit;
    }

    if (empty($createLink['res'])) {
        throw new Exception('Request Failed: Invalid Response from iPaymu. Please contact support@ipaymu.com');
        exit;
    }

    if (empty($createLink['res']['Data']['Url'])) {
        throw new Exception('Invalid request. Response iPaymu: ' . $createLink['res']['Message']);
        exit;
    }

    return $createLink;
}

if (empty($existingdata)) {

    $createLink = createLink($product, $qty, $price, $name, $phone, $email, $returnurl, $callbackurl);

    $url = $createLink['res']['Data']['Url'];

    $enroldata->reference = $createLink['res']['Data']['SessionID']; // Reference only received after successful request transaction.
    $enroldata->referenceurl = $url; // Link payment iPaymu
    $enroldata->timeupdated = round(microtime(true) * ipaymu_mathematical_constants::SECOND_IN_MILLISECONDS); // In milisecond.
    $DB->insert_record('enrol_ipaymu', $enroldata);
    
    header('location: '. $url);die;
}

if ($existingdata->expiryperiod < $currenttimestamp) {

    $createLink = createLink($product, $qty, $price, $name, $phone, $email, $returnurl, $callbackurl);

    $url = $createLink['res']['Data']['Url'];

    $sql = 'SELECT * FROM {enrol_ipaymu} WHERE reference = :reference ORDER BY {enrol_ipaymu}.timestamp DESC';
    $dtExitst = $DB->get_record_sql($sql, ['reference' => $existingdata->reference], 1);

    $data = new stdClass();
    $data->id = $dtExitst->id;
    $data->expiryperiod = $currenttimestamp + ($expiryperiod * ipaymu_mathematical_constants::MINUTE_IN_SECONDS * ipaymu_mathematical_constants::SECOND_IN_MILLISECONDS);
    $data->timeupdated = round(microtime(true) * ipaymu_mathematical_constants::SECOND_IN_MILLISECONDS); // In milisecond.
    $data->reference = $createLink['res']['Data']['SessionID']; // Reference only received after successful request transaction.
    $data->referenceurl = $url; // Link payment iPaymu
    $DB->update_record('enrol_ipaymu', $data);

    header('location: '. $url);die;

}

if ($existingdata->payment_status === ipaymu_status_codes::CHECK_STATUS_PENDING) {
    header('location: '. $existingdata->referenceurl);die;
}


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

require("../../config.php");
require_once("$CFG->wwwroot/enrol/ipaymu/lib.php");

require_login();

// Get course details and instance
$courseid = required_param('id', PARAM_INT);
$course = $DB->get_record('course', array('id' => $courseid), '*', MUST_EXIST);
$context = context_course::instance($courseid, MUST_EXIST);

// Get enrolment instance
$instanceid = required_param('instance', PARAM_INT);
$instance = $DB->get_record('enrol', array('id' => $instanceid, 'courseid' => $courseid), '*', MUST_EXIST);

// Calculate cost and other details
$cost = (float)$instance->cost;
$currency = $instance->currency;

$merchantOrderId = time() . '-' . $USER->id . '-' . $course->id . '-' . $instance->id;
$callbackurl = "$CFG->wwwroot/enrol/ipaymu/callback.php?merchantOrderId=$merchantOrderId";
$returnurl = "$CFG->wwwroot/course/view.php?id=$courseid";

$productdetails = $course->fullname;
$email = $USER->email;
$phonenumber = empty($USER->phone1) ? "" : $USER->phone1;
$name = $USER->firstname . ' ' . $USER->lastname;

$product[] = $productdetails;
$price[] = $cost;
$qty[] = 1;

$expiryperiod = get_config('enrol_ipaymu', 'expiry');
$currenttimestamp = round(microtime(true) * ipaymu_mathematical_constants::SECOND_IN_MILLISECONDS);

// Check if the user has an existing payment record
$params = [
    'userid' => $USER->id,
    'courseid' => $courseid,
    'instanceid' => $instanceid,
];
$sql = 'SELECT * FROM {enrol_ipaymu} WHERE userid = :userid AND courseid = :courseid AND instanceid = :instanceid ORDER BY {enrol_ipaymu}.timestamp DESC';
$existingdata = $DB->get_record_sql($sql, $params, 1); // Will return exactly 1 row. The newest transaction that was saved.

if (empty($existingdata)) {

    $createLink = createLink($product, $qty, $price, $name, $phonenumber, $email, $returnurl, $callbackurl);

    $url = $createLink['res']['Data']['Url'];

    $enroldata = new stdClass();
    $enroldata->userid = $USER->id;
    $enroldata->courseid = $courseid;
    $enroldata->instanceid = $instanceid;
    $enroldata->timestamp = $currenttimestamp;
    $enroldata->merchant_order_id = $merchantOrderId;
    $enroldata->receiver_id = get_admin()->id;
    $enroldata->receiver_email = get_admin()->email;
    $enroldata->payment_status = ipaymu_status_codes::CHECK_STATUS_PENDING;
    $enroldata->pending_reason = get_string('pending_message', 'enrol_ipaymu');
    $enroldata->expiryperiod = $currenttimestamp + ($expiryperiod * ipaymu_mathematical_constants::MINUTE_IN_SECONDS * ipaymu_mathematical_constants::SECOND_IN_MILLISECONDS);
    $enroldata->reference = $createLink['res']['Data']['SessionID'];
    $enroldata->referenceurl = $url;
    $enroldata->timeupdated = $currenttimestamp;

    $DB->insert_record('enrol_ipaymu', $enroldata);

    header('Location: ' . $url);
    exit;
}

if ($existingdata->expiryperiod < $currenttimestamp) {

    $createLink = createLink($product, $qty, $price, $name, $phonenumber, $email, $returnurl, $callbackurl);

    $url = $createLink['res']['Data']['Url'];

    $data = new stdClass();
    $data->id = $existingdata->id;
    $data->expiryperiod = $currenttimestamp + ($expiryperiod * ipaymu_mathematical_constants::MINUTE_IN_SECONDS * ipaymu_mathematical_constants::SECOND_IN_MILLISECONDS);
    $data->timeupdated = $currenttimestamp;
    $data->reference = $createLink['res']['Data']['SessionID'];
    $data->referenceurl = $url;

    $DB->update_record('enrol_ipaymu', $data);

    header('Location: ' . $url);
    exit;
}

if ($existingdata->payment_status === ipaymu_status_codes::CHECK_STATUS_PENDING) {
    header('Location: ' . $existingdata->referenceurl);
    exit;
}

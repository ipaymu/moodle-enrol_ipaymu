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
 * Contains the functions that override Moodle Enrolment Plugin Libraries.
 * @package   enrol_ipaymu
 * @copyright 2024 Syaifudin <syaifudin@ipaymu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use enrol_ipaymu\ipaymu_status_codes;
use enrol_ipaymu\ipaymu_mathematical_constants;
use enrol_ipaymu\ipaymu_helper;

defined('MOODLE_INTERNAL') || die();

/**
 * Creates a link for ipaymu payment.
 * 
 * @param array $product
 * @param array $qty
 * @param array $price
 * @param string $name
 * @param string $phone
 * @param string $email
 * @param string $returnurl
 * @param string $callbackurl
 * @return array
 * @throws Exception
 */
function create_ipaymu_link($product, $qty, $price, $name, $phone, $email, $returnurl, $callbackurl)
{
    $ipaymuhelper = new ipaymu_helper();
    $createLink = $ipaymuhelper->create($product, $qty, $price, $name, $phone, $email, $returnurl, $callbackurl);

    if (!empty($createLink['err'])) {
        throw new Exception('Invalid Response from iPaymu. Please contact support@ipaymu.com');
    }

    if (empty($createLink['res'])) {
        throw new Exception('Request Failed: Invalid Response from iPaymu. Please contact support@ipaymu.com');
    }

    if (empty($createLink['res']['Data']['Url'])) {
        throw new Exception('Invalid request. Response iPaymu: ' . $createLink['res']['Message']);
    }

    return $createLink;
}

/**
 * Creates a notification for every non-expired pending payment.
 * Function must be outside of class to be detected by Moodle.
 *
 * @return void
 */
function enrol_ipaymu_before_footer()
{
    global $USER, $DB;

    if (!enrol_is_enabled('ipaymu')) {
        return null;
    }
    $params = [
        'userid' => (int)$USER->id,
        'payment_status' => ipaymu_status_codes::CHECK_STATUS_PENDING
    ];
    $pendingtransactions = $DB->get_records_sql('SELECT * FROM {enrol_ipaymu} WHERE userid = :userid AND payment_status = :payment_status', $params);

    foreach ($pendingtransactions as $transaction) {
        $referenceurl = $transaction->referenceurl;
        $course = $DB->get_record('course', ['id' => $transaction->courseid]);

        // Prepare the data to be passed into the language string
       

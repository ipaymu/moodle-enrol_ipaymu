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
 * Will delete all expired records from enrol_ipaymu table
 * @package   enrol_ipaymu
 * @copyright 2024 Syaifudin <syaifudin@ipaymu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_ipaymu\task;

use enrol_ipaymu\ipaymu_status_codes;
use enrol_ipaymu\ipaymu_mathematical_constants;


/**
 * Scheduled task to turn the transaction status of any pending transaction into expired
 *
 * @author  2024 Syaifudin <syaifudin@ipaymu.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class payment_expirations extends \core\task\scheduled_task {

    /**
     * Name for this task.
     *
     * @return string
     */
    public function get_name() {
        return get_string('payment_expirations', 'enrol_ipaymu');
    }

    /**
     * Run task for processing expirations.
     */
    public function execute() {
        global $DB;
        mtrace('Executing ipaymu Enrol Plugin Cleaning');
        $params = [
            'payment_status' => ipaymu_status_codes::CHECK_STATUS_PENDING
        ];
        $sql = 'SELECT * FROM {enrol_ipaymu} WHERE payment_status = :payment_status';
        $transactions = $DB->get_records_sql($sql, $params);
        foreach ($transactions as $transaction) {
            $expiryperiod = (int)$transaction->expiryperiod;
            mtrace(round(microtime(true) * ipaymu_mathematical_constants::SECOND_IN_MILLISECONDS));
            if ($expiryperiod < round(microtime(true) * ipaymu_mathematical_constants::SECOND_IN_MILLISECONDS)) {
                $object = (object)[ // Somehow only this method of object instantiation works. Others creates errors.
                    'id' => $transaction->id,
                    'payment_status' => ipaymu_status_codes::CHECK_STATUS_CANCELED,
                    'pending_reason' => 'Transaction expired'
                ];
                $DB->update_record('enrol_ipaymu', $object);
            }
        }
        mtrace('Finished Cleaning');
    }
}

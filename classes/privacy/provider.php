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
 * Privacy Subsystem implementation for enrol_ipaymu plugin
 * @package   enrol_ipaymu
 * @copyright 2024 Syaifudin <syaifudin@ipaymu.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace enrol_ipaymu\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\userlist;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\writer;

/**
 * Privacy Subsystem implementation for enrol_ipaymu plugin.
 *
 * @copyright   2024 Syaifudin <syaifudin@ipaymu.com>
 * @copyright   based on work by 2018 Shamim Rezaie <shamim@moodle.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
        // Ipaymu Stores user data.
        \core_privacy\local\metadata\provider,

        // The ipaymu enrolment plugin contains user's transactions.
        \core_privacy\local\request\plugin\provider,

        // This plugin is capable of determining which users have data within it.
        \core_privacy\local\request\core_userlist_provider {

    /**
     * Returns meta data about this system.
     *
     * @param collection $collection The initialised collection to add items to.
     * @return collection A listing of user data stored through this system.
     */
    public static function get_metadata(collection $collection) : collection {

        // Data may be exported to an external location.
        $collection->add_external_location_link(
            'ipaymu.com',
            [
                'merchantcode'              => 'privacy:metadata:enrol_ipaymu:ipaymu_com:merchantcode',
                'apikey'                    => 'privacy:metadata:enrol_ipaymu:ipaymu_com:apikey',
                'signature'                 => 'privacy:metadata:enrol_ipaymu:ipaymu_com:signature',
                'merchant_order_id'         => 'privacy:metadata:enrol_ipaymu:ipaymu_com:merchant_order_id',
                'paymentAmount'             => 'privacy:metadata:enrol_ipaymu:ipaymu_com:paymentAmount',
                'username'                  => 'privacy:metadata:enrol_ipaymu:ipaymu_com:username',
                'first_name'                => 'privacy:metadata:enrol_ipaymu:ipaymu_com:first_name',
                'last_name'                 => 'privacy:metadata:enrol_ipaymu:ipaymu_com:last_name',
                'address'                   => 'privacy:metadata:enrol_ipaymu:ipaymu_com:address',
                'city'                      => 'privacy:metadata:enrol_ipaymu:ipaymu_com:city',
                'email'                     => 'privacy:metadata:enrol_ipaymu:ipaymu_com:email',
                'country'                   => 'privacy:metadata:enrol_ipaymu:ipaymu_com:country',
            ],
            'privacy:metadata:enrol_ipaymu:ipaymu_com'
        );

        // The enrol_ipaymu has a database table that contains user data.
        $collection->add_database_table(
            'enrol_ipaymu',
            [
                'userid'                    => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:userid',
                'courseid'                  => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:courseid',
                'instanceid'                => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:instanceid',
                'reference'                 => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:reference',
                'referenceurl'              => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:referenceurl',
                'timestamp'                 => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:timestamp',
                'signature'                 => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:signature',
                'merchant_order_id'         => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:merchant_order_id',
                'receiver_id'               => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:receiver_id',
                'receiver_email'            => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:receiver_email',
                'payment_status'            => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:payment_status',
                'pending_reason'            => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:pending_reason',
                'expiryperiod'              => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:expiryperiod',
                'timeupdated'               => 'privacy:metadata:enrol_ipaymu:enrol_ipaymu:timeupdated'
            ],
            'privacy:metadata:enrol_ipaymu:enrol_ipaymu'
        );
        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param int $userid The user to search.
     * @return contextlist The contextlist containing the list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid(int $userid) : contextlist {
        $contextlist = new contextlist();

        $sql = "SELECT ctx.id
                  FROM {enrol_ipaymu} ed
                  JOIN {enrol} e ON ed.instanceid = e.id
                  JOIN {context} ctx ON e.courseid = ctx.instanceid AND ctx.contextlevel = :contextcourse
                  JOIN {user} u ON u.id = ed.userid
                 WHERE u.id = :userid";
        $params = [
            'contextcourse' => CONTEXT_COURSE,
            'userid'        => $userid,
        ];

        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Get the list of users who have data within a context.
     *
     * @param   userlist    $userlist   The userlist containing the list of users who have data in this context/plugin combination.
     */
    public static function get_users_in_context(userlist $userlist) {
        $context = $userlist->get_context();

        if (!$context instanceof \context_course) {
            return;
        }

        $sql = "SELECT u.id
                  FROM {enrol_ipaymu} ed
                  JOIN {enrol} e ON ed.instanceid = e.id
                  JOIN {user} u ON ed.userid = u.id
                 WHERE e.courseid = :courseid";
        $params = ['courseid' => $context->instanceid];

        $userlist->add_from_sql('id', $sql, $params);
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts to export information for.
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;

        if (empty($contextlist->count())) {
            return;
        }

        $user = $contextlist->get_user();

        list($contextsql, $contextparams) = $DB->get_in_or_equal($contextlist->get_contextids(), SQL_PARAMS_NAMED);

        $sql = "SELECT ed.*
                  FROM {enrol_ipaymu} ed
                  JOIN {enrol} e ON ed.instanceid = e.id
                  JOIN {context} ctx ON e.courseid = ctx.instanceid AND ctx.contextlevel = :contextcourse
                  JOIN {user} u ON u.id = ed.userid
                 WHERE ctx.id {$contextsql} AND u.id = :userid
              ORDER BY e.courseid";

        $params = [
            'contextcourse' => CONTEXT_COURSE,
            'userid'        => $user->id,
        ];
        $params += $contextparams;

        $lastcourseid = null;

        $strtransactions = get_string('transactions', 'enrol_ipaymu');
        $transactions = [];
        $ipaymurecords = $DB->get_recordset_sql($sql, $params);
        foreach ($ipaymurecords as $ipaymurecord) {
            if ($lastcourseid != $ipaymurecord->courseid) {
                if (!empty($transactions)) {
                    $coursecontext = \context_course::instance($ipaymurecord->courseid);
                    writer::with_context($coursecontext)->export_data(
                            [$strtransactions],
                            (object) ['transactions' => $transactions]
                    );
                }
                $transactions = [];
            }

            $transaction = (object) [
                'userid' => $ipaymurecord->userid,
                'courseid' => $ipaymurecord->courseid,
                'instanceid' => $ipaymurecord->instanceid,
                'reference' => $ipaymurecord->reference,
                'referenceurl' => $ipaymurecord->referenceurl,
                'timestamp' => $ipaymurecord->timestamp,
                'signature' => $ipaymurecord->signature,
                'merchant_order_id' => $ipaymurecord->merchant_order_id,
                'receiver_id' => $ipaymurecord->receiver_id,
                'receiver_email' => $ipaymurecord->receiver_email,
                'payment_status' => $ipaymurecord->payment_status,
                'pending_reason' => $ipaymurecord->pending_reason,
                'expiryperiod' => $ipaymurecord->expiryperiod,
                'timeupdated' => $ipaymurecord->timeupdated
            ];
            if ($ipaymurecord->userid == $user->id) {
                $transaction->userid = $ipaymurecord->userid;
            }

            $transactions[] = $ipaymurecord;

            $lastcourseid = $ipaymurecord->courseid;
        }
        $ipaymurecords->close();

        // The data for the last activity won't have been written yet, so make sure to write it now!
        if (!empty($transactions)) {
            $coursecontext = \context_course::instance($ipaymurecord->courseid);
            writer::with_context($coursecontext)->export_data(
                    [$strtransactions],
                    (object) ['transactions' => $transactions]
            );
        }
    }

    /**
     * Delete all data for all users in the specified context.
     *
     * @param \context $context The specific context to delete data for.
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;

        if (!$context instanceof \context_course) {
            return;
        }

        $DB->delete_records('enrol_ipaymu', array('courseid' => $context->instanceid));
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist The approved contexts and user information to delete information for.
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;

        if (empty($contextlist->count())) {
            return;
        }

        $user = $contextlist->get_user();

        $contexts = $contextlist->get_contexts();
        $courseids = [];
        foreach ($contexts as $context) {
            if ($context instanceof \context_course) {
                $courseids[] = $context->instanceid;
            }
        }

        list($insql, $inparams) = $DB->get_in_or_equal($courseids, SQL_PARAMS_NAMED);

        $select = "userid = :userid AND courseid $insql";
        $params = $inparams + ['userid' => $user->id];
        $DB->delete_records_select('enrol_ipaymu', $select, $params);

        // We do not want to delete the payment record when the user is just the receiver of payment.
        // In that case, we just delete the receiver's info from the transaction record.

        $select = "receiver_email = :receiver_email AND courseid $insql";
        $params = $inparams + ['receiver_email' => \core_text::strtolower($user->email)];
        $DB->set_field_select('enrol_ipaymu', 'receiver_email', '', $select, $params);
    }

    /**
     * Delete multiple users within a single context.
     *
     * @param   approved_userlist       $userlist The approved context and user information to delete information for.
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        $context = $userlist->get_context();

        if ($context->contextlevel != CONTEXT_COURSE) {
            return;
        }

        $userids = $userlist->get_userids();

        list($usersql, $userparams) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);

        $params = ['courseid' => $context->instanceid] + $userparams;

        $select = "courseid = :courseid AND userid $usersql";
        $DB->delete_records_select('enrol_ipaymu', $select, $params);

        // We do not want to delete the payment record when the user is just the receiver of payment.
        // In that case, we just delete the receiver's info from the transaction record.

        $select = "courseid = :courseid AND receiver_email IN (SELECT LOWER(email) FROM {user} WHERE id $usersql)";
        $DB->set_field_select('enrol_ipaymu', 'receiver_email', '', $select, $params);
    }
}

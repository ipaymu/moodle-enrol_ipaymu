<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Proses enrol user ke dalam course ketika pembayaran berhasil.
 *
 * @param int $userid ID user yang akan dienrol
 * @param int $courseid ID course tujuan
 * @param int $instanceid ID dari instance enrol ipaymu
 * @param string $orderid ID pesanan dari iPaymu (merchant_order_id)
 * @return bool true jika berhasil, false jika gagal
 */
function enrol_ipaymu_process_successful_payment($userid, $courseid, $instanceid, $orderid) {
    global $DB;

    // Ambil plugin enrol ipaymu
    $plugin = enrol_get_plugin('ipaymu');
    if (!$plugin) {
        error_log("❌ Plugin enrol_ipaymu tidak ditemukan.");
        return false;
    }

    // Ambil instance enrol ipaymu untuk course ini
    $instance = $DB->get_record('enrol', [
        'id' => $instanceid,
        'courseid' => $courseid,
        'enrol' => 'ipaymu'
    ], '*', MUST_EXIST);

    // Ambil data user
    $user = $DB->get_record('user', ['id' => $userid], '*', MUST_EXIST);

    // Proses enrol user ke course
    $plugin->enrol_user($instance, $userid, $instance->roleid, time());

    // Update status pembayaran pada tabel enrol_ipaymu
    $DB->set_field('enrol_ipaymu', 'payment_status', 'lunas', [
        'userid' => $userid,
        'courseid' => $courseid
    ]);
    $DB->set_field('enrol_ipaymu', 'timeupdated', time(), [
        'userid' => $userid,
        'courseid' => $courseid
    ]);

    // Tulis log untuk debug
    $log = "✅ User {$userid} enrolled to course {$courseid} via iPaymu. Order ID: {$orderid}\n";
    file_put_contents(__DIR__ . '/debug-callback.txt', $log, FILE_APPEND);

    return true;
}

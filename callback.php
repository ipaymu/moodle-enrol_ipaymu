<?php

define('AJAX_SCRIPT', true);
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/locallib.php');

global $DB;

$logfile = __DIR__ . '/debug-callback.txt';
file_put_contents($logfile, "==== CALLBACK START ====\n", FILE_APPEND);

// Ambil raw input
$rawBody = file_get_contents('php://input');
file_put_contents($logfile, "RAW BODY:\n" . $rawBody . "\n", FILE_APPEND);

// Ambil data POST
$postdata = $_POST;
file_put_contents($logfile, "POST DATA:\n" . print_r($postdata, true), FILE_APPEND);

// Validasi minimal
if (!isset($postdata['status'], $postdata['reference_id'], $postdata['url'])) {
    file_put_contents($logfile, "❌ Data tidak lengkap.\n", FILE_APPEND);
    http_response_code(400);
    exit('Invalid request');
}

// Ambil orderId dari URL
$url = $postdata['url'];
$parsed_url = parse_url($url);
parse_str($parsed_url['query'] ?? '', $queryParams);
$orderid = $queryParams['merchantOrderId'] ?? null;

file_put_contents($logfile, "ORDER ID: " . $orderid . "\n", FILE_APPEND);

if (!$orderid) {
    file_put_contents($logfile, "❌ Order ID tidak ditemukan.\n", FILE_APPEND);
    http_response_code(400);
    exit('Missing order id');
}

// Pecah orderid menjadi [timestamp, userid, courseid, instanceid]
$orderparts = explode('-', $orderid);
if (count($orderparts) < 4) {
    file_put_contents($logfile, "❌ Format Order ID salah.\n", FILE_APPEND);
    http_response_code(400);
    exit('Invalid order format');
}

list($timestamp, $userid, $courseid, $instanceid) = $orderparts;

// Ambil status dan paid_at
$status = strtolower(trim($postdata['status'] ?? ''));
$paid_at = trim($postdata['paid_at'] ?? '');

// Validasi pembayaran berhasil
if ($status === 'berhasil' && $paid_at !== '') {
    $result = enrol_ipaymu_process_successful_payment($userid, $courseid, $instanceid, $orderid);

    if ($result) {
        // Update status ke 'lunas' di tabel enrol_ipaymu
        $DB->set_field('enrol_ipaymu', 'payment_status', 'lunas', ['merchant_order_id' => $orderid]);

        file_put_contents($logfile, "✅ Enrolment berhasil & status diperbarui ke 'lunas'.\n", FILE_APPEND);
        echo "OK";
    } else {
        file_put_contents($logfile, "❌ Gagal saat enrol.\n", FILE_APPEND);
        http_response_code(500);
        echo "Failed to enrol";
    }
} else {
    file_put_contents($logfile, "⚠️ Pembayaran tidak sah. Status: '$status', paid_at: '$paid_at'\n", FILE_APPEND);
    http_response_code(200);
    echo "Ignored: Not a valid payment";
}

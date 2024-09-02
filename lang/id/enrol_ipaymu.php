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

$string['pluginname'] = 'Pembayaran iPaymu';
$string['pluginname_desc'] = 'Modul iPaymu memungkinkan Anda untuk mengatur kursus berbayar. Jika biaya untuk kursus apa pun adalah nol, maka siswa tidak diminta untuk membayar untuk masuk. Ada biaya di seluruh situs yang Anda atur di sini sebagai default untuk seluruh situs dan kemudian pengaturan kursus yang dapat Anda atur untuk setiap kursus secara individual. Biaya kursus menggantikan biaya situs.';

$string['apikey'] = 'Kunci API';
$string['apikey_desc'] = 'Kunci API yang terletak di situs Proyek';

$string['ipaymu_va'] = 'VA Live/Produksi';
$string['ipaymu_va_desc'] = '<small>Dapatkan VA Produksi <a href="https://my.ipaymu.com/integration" target="_blank">di sini</a></small>';
$string['ipaymu_apikey'] = 'Kunci API Live/Produksi';
$string['ipaymu_apikey_desc'] = '<small>Dapatkan Kunci API Produksi <a href="https://my.ipaymu.com/integration" target="_blank">di sini</a></small>';

$string['ipaymu_va_sandbox'] = 'VA Sandbox';
$string['ipaymu_va_sandbox_desc'] = '<small>Dapatkan VA Sandbox <a href="https://sandbox.ipaymu.com/integration" target="_blank">di sini</a></small>';
$string['ipaymu_apikey_sandbox'] = 'Kunci API Sandbox';
$string['ipaymu_apikey_sandbox_desc'] = '<small>Dapatkan Kunci API Sandbox <a href="https://sandbox.ipaymu.com/integration" target="_blank">di sini</a></small>';

$string['call_error'] = 'Terjadi kesalahan saat meminta transaksi. Silakan coba lagi atau hubungi admin situs';
$string['cost'] = 'Biaya Pendaftaran';
$string['costerror'] = 'Biaya pendaftaran bukan angka';
$string['costorkey'] = 'Silakan pilih salah satu metode pendaftaran berikut.';
$string['course_error'] = 'Kursus tidak ditemukan';
$string['currency'] = 'Mata Uang';
$string['defaultrole'] = 'Penugasan peran default';
$string['defaultrole_desc'] = 'Pilih peran yang harus ditugaskan kepada pengguna selama pendaftaran iPaymu';
$string['ipaymu:config'] = 'Konfigurasi instansi pendaftaran iPaymu';
$string['ipaymu:manage'] = 'Kelola pengguna yang terdaftar';
$string['ipaymu:unenrol'] = 'Batalkan pendaftaran pengguna dari kursus';
$string['ipaymu:unenrolself'] = 'Batalkan pendaftaran sendiri dari kursus';
$string['ipaymuaccepted'] = 'Pembayaran iPaymu diterima';
$string['enrolenddate'] = 'Tanggal berakhir';
$string['enrolenddate_help'] = 'Jika diaktifkan, pengguna hanya dapat mendaftar hingga tanggal ini.';
$string['enrolenddaterror'] = 'Tanggal berakhir pendaftaran tidak boleh lebih awal dari tanggal mulai';
$string['enrolperiod'] = 'Durasi pendaftaran';
$string['enrolperiod_desc'] = 'Durasi default waktu pendaftaran yang valid. Jika diatur menjadi nol, durasi pendaftaran akan tidak terbatas secara default.';
$string['enrolperiod_help'] = 'Durasi waktu pendaftaran yang valid, dimulai dari saat pengguna mendaftar. Jika dinonaktifkan, durasi pendaftaran akan tidak terbatas.';
$string['enrolstartdate'] = 'Tanggal mulai';
$string['enrolstartdate_help'] = 'Jika diaktifkan, pengguna hanya dapat mendaftar mulai dari tanggal ini.';
$string['environment'] = 'Lingkungan';
$string['environment_desc'] = 'Konfigurasikan endpoint iPaymu menjadi sandbox atau produksi';
$string['errdisabled'] = 'Plugin pendaftaran iPaymu dinonaktifkan dan tidak menangani pemberitahuan pembayaran.';
$string['expiredaction'] = 'Tindakan saat pendaftaran berakhir';
$string['expiredaction_help'] = 'Pilih tindakan yang akan dilakukan ketika pendaftaran pengguna berakhir. Harap dicatat bahwa beberapa data pengguna dan pengaturan akan dihapus dari kursus saat pembatalan pendaftaran kursus.';
$string['expiry'] = 'Periode Kadaluarsa';
$string['expiry_desc'] = 'Periode kadaluarsa untuk setiap transaksi. Satuan diatur dalam Jam';
$string['mailadmins'] = 'Beritahu admin';
$string['mailstudents'] = 'Beritahu siswa';
$string['mailteachers'] = 'Beritahu guru';
$string['mail_logging'] = 'iPaymu mencatat email yang dikirim';
$string['merchantcode'] = 'Kode Merchant';
$string['merchantcode_desc'] = 'Kode merchant yang terletak di situs Proyek';

$string['payment_expirations'] = 'iPaymu memeriksa transaksi yang kadaluarsa di database';
$string['payment_not_exist'] = 'Transaksi tidak ada atau belum disimpan. Silakan buat transaksi baru';
$string['payment_cancelled'] = 'Transaksi dibatalkan. Silakan buat transaksi baru';
$string['payment_paid'] = 'Transaksi berhasil dibayar. Harap tunggu sebentar dan segarkan halaman lagi.';
$string['pending_message'] = 'Anda memiliki pembayaran tertunda untuk kursus {$a->course} <a href="{$a->url}">di sini</a>';
$string['sendpaymentbutton'] = 'Bayar melalui iPaymu';
$string['status'] = 'Izinkan pendaftaran iPaymu';
$string['status_desc'] = 'Izinkan pengguna menggunakan iPaymu untuk mendaftar ke kursus secara default.';
$string['transactions'] = 'Transaksi iPaymu';
$string['user_return'] = 'Pengguna telah kembali dari halaman pengalihan';

$string['ipaymu_request_log'] = 'Log Plugin Pendaftaran iPaymu';
$string['log_request_transaction'] = 'Meminta transaksi ke iPaymu';
$string['log_request_transaction_response'] = 'Respon iPaymu untuk Permintaan Transaksi';
$string['log_check_transaction'] = 'Memeriksa transaksi ke iPaymu';
$string['log_check_transaction_response'] = 'Respon iPaymu untuk Memeriksa Transaksi';
$string['log_callback'] = 'Menerima Callback dari iPaymu. Siswa yang terpengaruh harus terdaftar';

$string['environment:production'] = 'Produksi';
$string['environment:sandbox'] = 'Sandbox';

$string['return_header'] = '<h2>Transaksi Tertunda</h2>';
$string['return_sub_header'] = 'Nama kursus: {$a->fullname}<br />';
$string['return_body'] = 'Jika Anda sudah membayar, tunggu beberapa saat lalu periksa kembali apakah Anda sudah terdaftar. <br /> Kami menyimpan pembayaran Anda <a href="{$a->reference}">di sini</a> jika Anda ingin kembali.';

$string['admin_email'] = 'Email ke Admin saat Pendaftaran';
$string['admin_email_desc'] = 'Isi dengan format HTML. Kosongkan untuk template default. <br /> Gunakan "$courseShortName" untuk menampilkan nama singkat kursus yang terdaftar, <br /> "$studentUsername" untuk menampilkan nama pengguna siswa yang terdaftar, <br /> "$courseFullName" untuk menampilkan nama lengkap kursus yang terdaftar, <br /> "$amount" untuk mendapatkan jumlah yang dibayar saat pendaftaran, "$adminUsername" untuk mendapatkan nama pengguna admin, "$teacherName" untuk mendapatkan nama pengguna guru. (Semua tanpa tanda kutip).';
$string['admin_email_template_header'] = '<h1>Pendaftaran Baru di {$a->shortname}</h1><br />';
$string['admin_email_template_greeting'] = '<p>Halo {$a->adminUsername}!</p><br />';
$string['admin_email_template_body'] = '<p>{$a->studentUsername} telah berhasil membayar {$a->amount} dan terdaftar di kursus {$a->courseFullName} melalui Plugin Pendaftaran iPaymu</p>';

$string['teacher_email'] = 'Email ke Guru saat Pendaftaran';
$string['teacher_email_desc'] = 'Isi dengan format HTML. Kosongkan untuk template default. <br /> Gunakan "$courseShortName" untuk menampilkan nama singkat kursus yang terdaftar, <br /> "$studentUsername" untuk menampilkan nama pengguna siswa yang terdaftar, <br /> "$courseFullName" untuk menampilkan nama lengkap kursus yang terdaftar, <br /> "$amount" untuk mendapatkan jumlah yang dibayar saat pendaftaran, "$adminUsername" untuk mendapatkan nama pengguna admin, "$teacherName" untuk mendapatkan nama pengguna guru. (Semua tanpa tanda kutip).';
$string['teacher_email_template_header'] = '<h1>Pendaftaran Baru di {$a->shortname}</h1><br />';
$string['teacher_email_template_greeting'] = '<p>Halo {$a->teachername}!</p><br />';
$string['teacher_email_template_body'] = '<p>{$a->studentUsername} telah berhasil membayar {$a->amount} dan terdaftar di kursus {$a->courseFullName} melalui Plugin Pendaftaran iPaymu</p>';

$string['student_email'] = 'Email ke Siswa saat Pendaftaran';
$string['student_email_desc'] = 'Isi dengan format HTML. Kosongkan untuk template default. <br /> Gunakan "$courseShortName" untuk menampilkan nama singkat kursus yang terdaftar, <br /> "$studentUsername" untuk menampilkan nama pengguna siswa yang terdaftar, <br /> "$courseFullName" untuk menampilkan nama lengkap kursus yang terdaftar, <br /> "$amount" untuk mendapatkan jumlah yang dibayar saat pendaftaran, "$adminUsername" untuk mendapatkan nama pengguna admin, "$teacherName" untuk mendapatkan nama pengguna guru. (Semua tanpa tanda kutip).';
$string['student_email_template_header'] = '<h1>Pendaftaran Berhasil</h1>';
$string['student_email_template_greeting'] = '<p>Halo {$a->studentUsername},</p><br /><p>Selamat datang di {$a->courseFullName}!</p><br />';
$string['student_email_template_body'] = '<p>Pembayaran Anda sebesar {$a->amount} menggunakan iPaymu telah berhasil. Nikmati kursus Anda!</p><br/>';

$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu'] = 'Data transaksi untuk Plugin Gateway Pembayaran iPaymu.';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:userid'] = 'ID pengguna yang melakukan permintaan transaksi';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:courseid'] = 'ID kursus yang diminta';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:instanceid'] = 'ID instansi kursus yang diminta';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:reference'] = 'Nomor referensi yang diterima dari iPaymu.';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:timestamp'] = 'Timestamp saat transaksi diminta';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:signature'] = 'Tanda tangan yang digunakan untuk memverifikasi transaksi';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:merchant_order_id'] = 'ID pesanan yang digunakan untuk mengidentifikasi transaksi';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:receiver_id'] = 'ID penerima. Biasanya admin';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:receiver_email'] = 'Email penerima. Biasanya admin';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:payment_status'] = 'Status Pembayaran Transaksi.';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:pending_reason'] = 'Alasan status pembayaran';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:timeupdated'] = 'Waktu transaksi ini diperbarui';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:expiryperiod'] = 'Periode kadaluarsa untuk transaksi ini';
$string['privacy:metadata:enrol_ipaymu:enrol_ipaymu:referenceurl'] = 'Tautan referensi untuk saat pengguna ingin kembali ke transaksi sebelumnya.';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com'] = 'Plugin Gateway Pembayaran iPaymu mengirimkan data pengguna dari Moodle ke iPaymu.';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:merchantcode'] = 'Kode Merchant iPaymu';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:apikey'] = 'Kunci API iPaymu';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:signature'] = 'Tanda tangan yang dihasilkan untuk memverifikasi transaksi';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:merchant_order_id'] = 'ID pesanan yang dihasilkan per pesanan';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:paymentAmount'] = 'Biaya kursus yang diminta untuk transaksi';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:username'] = 'Nama pengguna yang meminta transaksi';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:first_name'] = 'Nama depan pengguna yang meminta transaksi';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:last_name'] = 'Nama belakang pengguna yang meminta transaksi';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:address'] = 'Alamat pengguna yang meminta transaksi';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:city'] = 'Kota pengguna yang meminta transaksi';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:email'] = 'Email pengguna yang meminta transaksi';
$string['privacy:metadata:enrol_ipaymu:ipaymu_com:country'] = 'Negara pengguna yang meminta transaksi';

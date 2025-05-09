<?php
// Set zona waktu ke WIB (Asia/Jakarta)
date_default_timezone_set('Asia/Jakarta');

// Koneksi ke database
$servername = "localhost";
$username = "portalbu_admin";
$password = "ferry26101990";
$dbname = "portalbu_bukutamu";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
<?php
// Start session at the very beginning
session_start();

require_once 'includes/config.php';
require_once 'includes/functions.php';

// Initialize messages
$_SESSION['error'] = '';
$_SESSION['success'] = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $nama = sanitize_input($_POST['nama']);
    $telepon = sanitize_input($_POST['telepon']);
    $instansi = sanitize_input($_POST['instansi']);
    $kategori = sanitize_input($_POST['kategori']);
    $janji_temu = sanitize_input($_POST['janji_temu']);
    $keperluan = sanitize_input($_POST['keperluan']);
    $tanggal = date('Y-m-d H:i:s');

    // Validate required fields
    if (empty($nama) || empty($telepon) || empty($kategori) || empty($janji_temu) || empty($keperluan)) {
        $_SESSION['error'] = "Mohon lengkapi semua field yang wajib diisi!";
        header("Location: index.php");
        exit();
    }

    try {
        // Prepare and execute SQL
        $sql = "INSERT INTO tamu (nama, telepon, instansi, kategori, janji_temu, keperluan, tanggal_kunjungan) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $nama, $telepon, $instansi, $kategori, $janji_temu, $keperluan, $tanggal);

        if ($stmt->execute()) {
            $_SESSION['success'] = true;
        } else {
            $_SESSION['error'] = "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['error'] = "Terjadi kesalahan sistem: " . $e->getMessage();
    } finally {
        // Always redirect to index.php
        header("Location: index.php");
        exit();
    }
}

$conn->close();
?>
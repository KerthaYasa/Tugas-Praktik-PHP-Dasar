<?php
$host = "localhost";   // alamat server MySQL
$user = "root";        // user default XAMPP
$pass = "";             // password kosong (default)
$db   = "kampus";       // nama database yang sudah kamu buat

// Buat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>

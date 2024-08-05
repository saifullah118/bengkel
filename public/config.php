<?php
// Konfigurasi database
$host = 'localhost'; // Host database Anda
$user = 'root';      // Username database Anda
$password = '';      // Password database Anda
$dbname = 'bengkel';   // Nama database Anda

// Membuat koneksi
$mysqli = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
?>

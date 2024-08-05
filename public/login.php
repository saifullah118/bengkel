<?php
session_start();

// Konfigurasi database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pakar";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Enkripsi password
    $password = md5($password);

    $sql = "SELECT id FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Simpan informasi pengguna dalam sesi
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;

        // Redirect ke halaman admin
        header("Location: admin.html");
    } else {
        echo "Invalid email or password";
    }
}

$conn->close();
?>

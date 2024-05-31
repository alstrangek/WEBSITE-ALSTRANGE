<?php
// Koneksi ke database
$servername = "localhost"; // atau sesuaikan dengan pengaturan Anda
$username = "root"; // pengguna database
$password = ""; // kata sandi database
$dbname = "loginfilm"; // nama database

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Hash kata sandi
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Simpan data pengguna
$sql = "INSERT INTO user(username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo "Pendaftaran berhasil! Silakan <a href='login.html'>login di sini</a>.";
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar</title>
    <link rel="stylesheet" href="style.css"> <!-- Tambahkan style -->
</head>
<body>
    <div class="register-container">
        <h2>Daftar</h2>
        <form action="register_process.php" method="POST"> <!-- Prosesor PHP -->
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.html">Login di sini</a></p>
    </div>
</body>
</html>

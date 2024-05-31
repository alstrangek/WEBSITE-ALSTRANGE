<?php
session_start();

// Hapus semua sesi
session_unset();
session_destroy();

// Hapus semua cookie yang terkait
$cookie_name = "cookie_username";
$cookie_value = "";
$time = time() - 3600;
setcookie($cookie_name, $cookie_value, $time, "/");

$cookie_name = "cookie_password";
setcookie($cookie_name, $cookie_value, $time, "/");

// Redirect ke halaman login
header("Location: login.php");
exit();
?>

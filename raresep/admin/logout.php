<?php
// Mulai session
session_start();

// Hapus semua data session
$_SESSION = []; // Kosongkan array session

// Hapus session dari server
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit(); // Pastikan tidak ada kode yang dieksekusi setelah redirect
?>
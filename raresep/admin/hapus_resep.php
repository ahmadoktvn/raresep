<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Periksa apakah ada ID yang dikirimkan
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID resep tidak valid!'); window.location.href='kelola_resep.php';</script>";
    exit();
}

$id_resep = $_GET['id'];

// Hapus langkah terkait dari tabel langkah
$conn->query("DELETE FROM langkah WHERE id_resep = $id_resep");

// Hapus bahan terkait dari tabel bahan
$conn->query("DELETE FROM bahan WHERE id_resep = $id_resep");

// Hapus resep setelah semua data terkait dihapus
$conn->query("DELETE FROM resep WHERE id_resep = $id_resep");

// Redirect kembali ke halaman kelola resep dengan pesan sukses
echo "<script>alert('Resep berhasil dihapus!'); window.location.href='kelola_resep.php';</script>";
exit();

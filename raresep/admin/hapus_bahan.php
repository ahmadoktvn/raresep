<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../config/db.php';

// Pastikan id_bahan dan id_resep ada di URL
if (!isset($_GET['id_bahan']) || !isset($_GET['id_resep'])) {
    echo "ID bahan atau ID resep tidak ditemukan.";
    exit();
}

$id_bahan = $_GET['id_bahan'];
$id_resep = $_GET['id_resep'];

// Hapus bahan berdasarkan ID
$query = "DELETE FROM bahan WHERE id_bahan = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_bahan);

if ($stmt->execute()) {
    header("Location: kelola_bahan_detail.php?id_resep=$id_resep");
    exit();
} else {
    echo "Gagal menghapus bahan.";
}
?>

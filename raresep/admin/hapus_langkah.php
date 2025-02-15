<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../config/db.php';

if (!isset($_GET['id_langkah']) || !isset($_GET['id_resep'])) {
    echo "Data tidak valid!";
    exit();
}

$id_langkah = $_GET['id_langkah'];
$id_resep = $_GET['id_resep'];

$query = "DELETE FROM langkah WHERE id_langkah = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_langkah);

if ($stmt->execute()) {
    header("Location: kelola_langkah_detail.php?id_resep=$id_resep");
    exit();
} else {
    echo "Gagal menghapus langkah!";
}
?>

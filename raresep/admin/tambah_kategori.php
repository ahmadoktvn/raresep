<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nama_kategori = $_POST['nama_kategori'];

    $query = "INSERT INTO kategori (nama_kategori) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nama_kategori);
    $stmt->execute();

    header("Location: kelola_kategori.php");
    exit();
}
?>

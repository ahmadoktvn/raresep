<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_resep = $_POST['id_resep'];
    $nama_bahan = $_POST['nama_bahan'];
    $jumlah = $_POST['jumlah'];

    $query = "INSERT INTO bahan (id_resep, nama_bahan, jumlah) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $id_resep, $nama_bahan, $jumlah);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>

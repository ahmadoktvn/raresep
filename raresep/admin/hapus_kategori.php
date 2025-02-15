<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id_kategori = $_GET['id'];

    // Cek apakah kategori masih digunakan dalam resep_kategori
    $cek_query = "SELECT COUNT(*) as total FROM resep_kategori WHERE id_kategori = ?";
    $stmt = $conn->prepare($cek_query);
    $stmt->bind_param("i", $id_kategori);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data['total'] == 0) {
        // Hapus kategori jika tidak dipakai
        $query = "DELETE FROM kategori WHERE id_kategori = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_kategori);
        $stmt->execute();
        header("Location: kelola_kategori.php");
        exit();
    } else {
        echo "<script>alert('Kategori ini masih digunakan dalam resep! Tidak bisa dihapus.'); window.location='kelola_kategori.php';</script>";
    }
}
?>

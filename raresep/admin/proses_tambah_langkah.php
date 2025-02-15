<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: kelola_langkah_detail.php?status=error&message=Akses ditolak");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_resep = intval($_POST['id_resep']);
    $deskripsi = trim($_POST['deskripsi']);
    $gambar = null;

    // Ambil nomor langkah terakhir dan tentukan nomor berikutnya
    $queryNomor = "SELECT COALESCE(MAX(nomor_langkah), 0) + 1 AS nomor_baru FROM langkah WHERE id_resep = ?";
    $stmtNomor = $conn->prepare($queryNomor);
    $stmtNomor->bind_param("i", $id_resep);
    $stmtNomor->execute();
    $resultNomor = $stmtNomor->get_result();
    $rowNomor = $resultNomor->fetch_assoc();
    $nomor_langkah = $rowNomor['nomor_baru'];
    
    // Proses upload gambar jika ada
    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "../uploads/langkah/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = time() . "_" . basename($_FILES['gambar']['name']);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi tipe file
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_types)) {
            header("Location: kelola_langkah_detail.php?id_resep=$id_resep&status=error&message=Format gambar tidak valid");
            exit();
        }

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            $gambar = $file_name;
        } else {
            header("Location: kelola_langkah_detail.php?id_resep=$id_resep&status=error&message=Gagal mengunggah gambar");
            exit();
        }
    }

    // Simpan ke database
    $query = "INSERT INTO langkah (id_resep, nomor_langkah, deskripsi, gambar) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiss", $id_resep, $nomor_langkah, $deskripsi, $gambar);
    
    if ($stmt->execute()) {
        header("Location: kelola_langkah_detail.php?id_resep=$id_resep&status=success&message=Langkah berhasil ditambahkan");
        exit();
    } else {
        header("Location: kelola_langkah_detail.php?id_resep=$id_resep&status=error&message=Gagal menambahkan langkah");
        exit();
    }
} else {
    header("Location: kelola_langkah_detail.php?status=error&message=Metode tidak valid");
    exit();
}

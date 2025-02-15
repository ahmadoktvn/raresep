<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../config/db.php';

// Pastikan id_resep ada di URL
if (!isset($_GET['id_resep'])) {
    echo "ID resep tidak ditemukan.";
    exit();
}

$id_resep = $_GET['id_resep'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_bahan = $_POST['nama_bahan'];
    $jumlah = $_POST['jumlah'];
    
    $query = "INSERT INTO bahan (id_resep, nama_bahan, jumlah) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $id_resep, $nama_bahan, $jumlah);
    
    if ($stmt->execute()) {
        header("Location: kelola_bahan_detail.php?id_resep=$id_resep");
        exit();
    } else {
        echo "Gagal menambahkan bahan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Bahan</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Tambah Bahan</h2>
    <form method="POST" action="">
        <label for="nama_bahan">Nama Bahan:</label>
        <input type="text" id="nama_bahan" name="nama_bahan" required>
        
        <label for="jumlah">Jumlah:</label>
        <input type="text" id="jumlah" name="jumlah" required>
        
        <button type="submit">Tambah</button>
    </form>
    <a href="kelola_bahan_detail.php?id_resep=<?php echo $id_resep; ?>">Kembali</a>
</body>
</html>

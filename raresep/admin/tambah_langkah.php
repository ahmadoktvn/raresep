<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../config/db.php';

if (!isset($_GET['id_resep'])) {
    echo "Resep tidak ditemukan!";
    exit();
}

$id_resep = $_GET['id_resep'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $urutan = $_POST['urutan'];
    $deskripsi = $_POST['deskripsi'];

    $query = "INSERT INTO langkah (id_resep, nomor_langkah, deskripsi) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $id_resep, $urutan, $deskripsi);
    
    if ($stmt->execute()) {
        header("Location: kelola_langkah.php?id_resep=$id_resep");
        exit();
    } else {
        echo "Gagal menambahkan langkah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Langkah</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Tambah Langkah</h2>
        <form method="POST">
            <label>Urutan:</label>
            <input type="number" name="urutan" required>
            <label>Deskripsi:</label>
            <textarea name="deskripsi" required></textarea>
            <a href="../admin/kelola_langkah_detail.php"><button type="submit">Simpan</button></a>
        </form>
        <a href="kelola_langkah.php?id_resep=<?php echo $id_resep; ?>" class="btn">Kembali</a>
    </div>
</body>
</html>

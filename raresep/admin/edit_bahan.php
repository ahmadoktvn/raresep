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

// Jika ada permintaan hapus
if (isset($_GET['hapus'])) {
    $query = "DELETE FROM bahan WHERE id_bahan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_bahan);
    
    if ($stmt->execute()) {
        header("Location: kelola_bahan_detail.php?id_resep=$id_resep");
        exit();
    } else {
        echo "Gagal menghapus bahan.";
    }
}

// Ambil data bahan berdasarkan ID
$query = "SELECT * FROM bahan WHERE id_bahan = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_bahan);
$stmt->execute();
$result = $stmt->get_result();
$bahan = $result->fetch_assoc();

if (!$bahan) {
    echo "Bahan tidak ditemukan.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_bahan = $_POST['nama_bahan'];
    $jumlah = $_POST['jumlah'];
    
    $query = "UPDATE bahan SET nama_bahan = ?, jumlah = ? WHERE id_bahan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $nama_bahan, $jumlah, $id_bahan);
    
    if ($stmt->execute()) {
        header("Location: kelola_bahan_detail.php?id_resep=$id_resep");
        exit();
    } else {
        echo "Gagal mengupdate bahan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bahan</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Edit Bahan</h2>
    <form method="POST" action="">
        <label for="nama_bahan">Nama Bahan:</label>
        <input type="text" id="nama_bahan" name="nama_bahan" value="<?php echo $bahan['nama_bahan']; ?>" required>
        
        <label for="jumlah">Jumlah:</label>
        <input type="text" id="jumlah" name="jumlah" value="<?php echo $bahan['jumlah']; ?>" required>
        
        <button type="submit">Simpan Perubahan</button>
    </form>
    <a href="kelola_bahan_detail.php?id_resep=<?php echo $id_resep; ?>">Kembali</a>
    <br><br>
    <a href="edit_bahan.php?id_bahan=<?php echo $id_bahan; ?>&id_resep=<?php echo $id_resep; ?>&hapus=true" onclick="return confirm('Yakin ingin menghapus bahan ini?');">Hapus Bahan</a>
</body>
</html>

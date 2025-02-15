<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../config/db.php';

// Pastikan id_langkah dan id_resep ada di URL
if (!isset($_GET['id_langkah']) || !isset($_GET['id_resep'])) {
    echo "ID langkah atau ID resep tidak ditemukan.";
    exit();
}

$id_langkah = intval($_GET['id_langkah']);
$id_resep = intval($_GET['id_resep']);

// Ambil data langkah berdasarkan ID
$query = "SELECT * FROM langkah WHERE id_langkah = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_langkah);
$stmt->execute();
$result = $stmt->get_result();
$langkah = $result->fetch_assoc();

if (!$langkah) {
    echo "Langkah tidak ditemukan.";
    exit();
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_langkah = $_POST['nomor_langkah'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $langkah['gambar']; // Default ke gambar lama

    // Cek apakah ada file baru yang diunggah
    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "../uploads/langkah/";
        $gambar = time() . "_" . basename($_FILES['gambar']['name']);
        $target_file = $target_dir . $gambar;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types) && move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            if (!empty($langkah['gambar']) && file_exists($target_dir . $langkah['gambar'])) {
                unlink($target_dir . $langkah['gambar']); // Hapus gambar lama
            }
        } else {
            echo "Gagal mengunggah gambar.";
            exit();
        }
    }

    $query = "UPDATE langkah SET nomor_langkah = ?, deskripsi = ?, gambar = ? WHERE id_langkah = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issi", $nomor_langkah, $deskripsi, $gambar, $id_langkah);
    
    if ($stmt->execute()) {
        header("Location: kelola_langkah.php?id_resep=$id_resep");
        exit();
    } else {
        echo "Gagal mengupdate langkah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Langkah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card p-4 shadow-sm">
        <h2 class="mb-4">Edit Langkah</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nomor_langkah" class="form-label">Nomor Langkah:</label>
                <input type="number" class="form-control" id="nomor_langkah" name="nomor_langkah" value="<?php echo htmlspecialchars($langkah['nomor_langkah']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi:</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" required><?php echo htmlspecialchars($langkah['deskripsi']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini:</label><br>
                <?php if (!empty($langkah['gambar'])) { ?>
                    <img src="../uploads/langkah/<?php echo $langkah['gambar']; ?>" alt="Langkah" class="img-thumbnail" width="150">
                <?php } else { echo "-"; } ?>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Ganti Gambar (Opsional):</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="kelola_langkah_detail.php?id_resep=<?php echo $id_resep; ?>" class="btn btn-secondary">Kembali</a>
        </form>
        <hr>
        <a href="edit_langkah.php?id_langkah=<?php echo $id_langkah; ?>&id_resep=<?php echo $id_resep; ?>&hapus=true" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus langkah ini?');">Hapus Langkah</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

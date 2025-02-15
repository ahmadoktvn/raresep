<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Periksa apakah ID tersedia di URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('ID resep tidak valid!'); window.location.href='kelola_resep.php';</script>";
    exit();
}

$id_resep = intval($_GET['id']); // Pastikan ID adalah integer

// Ambil data resep berdasarkan ID
$query = "SELECT * FROM resep WHERE id_resep = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_resep);
$stmt->execute();
$result = $stmt->get_result();
$resep = $result->fetch_assoc();

if (!$resep) {
    echo "<script>alert('Resep tidak ditemukan!'); window.location.href='kelola_resep.php';</script>";
    exit();
}

// Ambil kategori untuk dropdown
$query_kategori = "SELECT * FROM kategori";
$result_kategori = $conn->query($query_kategori);

// Proses update resep
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi input
    $judul_resep = htmlspecialchars(strip_tags($_POST['judul_resep']));
    $id_kategori = intval($_POST['id_kategori']);
    $waktu_masak = intval($_POST['waktu_masak']);
    $deskripsi = htmlspecialchars(strip_tags($_POST['deskripsi']));

    // Penanganan gambar
    $gambar_resep = $resep['gambar_resep']; // Gunakan gambar lama secara default
    if (!empty($_FILES['gambar']['name'])) {
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $file_extension = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

        if (in_array($file_extension, $allowed_types)) {
            $gambar_resep = uniqid() . "." . $file_extension;
            $target_dir = "../assets/images/";
            $target_file = $target_dir . $gambar_resep;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
                if (!empty($resep['gambar_resep']) && file_exists($target_dir . $resep['gambar_resep'])) {
                    unlink($target_dir . $resep['gambar_resep']);
                }
            } else {
                echo "<script>alert('Gagal mengunggah gambar!');</script>";
                $gambar_resep = $resep['gambar_resep'];
            }
        } else {
            echo "<script>alert('Format file tidak didukung!');</script>";
            $gambar_resep = $resep['gambar_resep'];
        }
    }

    // Update database
    $query_update = "UPDATE resep SET judul_resep=?, id_kategori=?, waktu_masak=?, deskripsi=?, gambar_resep=? WHERE id_resep=?";
    $stmt = $conn->prepare($query_update);
    $stmt->bind_param("siissi", $judul_resep, $id_kategori, $waktu_masak, $deskripsi, $gambar_resep, $id_resep);

    if ($stmt->execute()) {
        echo "<script>alert('Resep berhasil diperbarui!'); window.location.href='kelola_resep.php';</script>";
        exit();
    } else {
        echo "<script>alert('Gagal memperbarui resep: " . $stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-edit"></i> Edit Resep</h3>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Judul Resep</label>
                        <input type="text" name="judul_resep" class="form-control" value="<?php echo htmlspecialchars($resep['judul_resep']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            <?php while ($kategori = $result_kategori->fetch_assoc()) { ?>
                                <option value="<?php echo $kategori['id_kategori']; ?>" <?php echo ($kategori['id_kategori'] == $resep['id_kategori']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($kategori['nama_kategori']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Waktu Masak (menit)</label>
                        <input type="number" name="waktu_masak" class="form-control" value="<?php echo $resep['waktu_masak']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required><?php echo htmlspecialchars($resep['deskripsi']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Gambar Resep</label>
                        <input type="file" name="gambar" class="form-control">
                        <?php if (!empty($resep['gambar_resep'])) { ?>
                            <div class="mt-2">
                                <img src="../assets/images/<?php echo htmlspecialchars($resep['gambar_resep']); ?>" class="img-thumbnail" width="150">
                            </div>
                        <?php } ?>
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Resep</button>
                    <a href="kelola_resep.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

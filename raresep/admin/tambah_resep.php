<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $kategori = $_POST['kategori'];
    $waktu_masak = $_POST['waktu_masak'];

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "../assets/images/";
    $target_file = $target_dir . basename($gambar);
    move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file);

    // Insert ke database
    $query = "INSERT INTO resep (judul_resep, deskripsi, id_kategori, waktu_masak, gambar_resep, tanggal_posting) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssiss", $judul, $deskripsi, $kategori, $waktu_masak, $gambar);
    if ($stmt->execute()) {
        $success = "Resep berhasil ditambahkan!";
    } else {
        $error = "Gagal menambahkan resep.";
    }
}

// Ambil kategori dari database
$kategori_query = "SELECT * FROM kategori";
$kategori_result = $conn->query($kategori_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Resep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="text-center mb-4"><i class="fas fa-plus-circle"></i> Tambah Resep</h3>
                        
                        <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
                        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Judul Resep</label>
                                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul resep" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="4" placeholder="Deskripsi resep..." required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="">Pilih Kategori</option>
                                    <?php while ($row = $kategori_result->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['id_kategori']; ?>"><?php echo $row['nama_kategori']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Waktu Masak (menit)</label>
                                <input type="number" name="waktu_masak" class="form-control" placeholder="Masukkan waktu masak" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Upload Gambar</label>
                                <input type="file" name="gambar" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-save"></i> Simpan Resep</button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="../admin/dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

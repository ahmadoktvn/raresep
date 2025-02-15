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

$id_resep = intval($_GET['id_resep']);

// Ambil nama resep
$queryResep = "SELECT judul_resep FROM resep WHERE id_resep = ?";
$stmtResep = $conn->prepare($queryResep);
$stmtResep->bind_param("i", $id_resep);
$stmtResep->execute();
$resultResep = $stmtResep->get_result();
$resep = $resultResep->fetch_assoc();

if (!$resep) {
    echo "Resep tidak ditemukan.";
    exit();
}

// Ambil daftar langkah berdasarkan id_resep
$queryLangkah = "SELECT * FROM langkah WHERE id_resep = ? ORDER BY nomor_langkah ASC";
$stmtLangkah = $conn->prepare($queryLangkah);
$stmtLangkah->bind_param("i", $id_resep);
$stmtLangkah->execute();
$resultLangkah = $stmtLangkah->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Langkah - <?php echo htmlspecialchars($resep['judul_resep']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2 class="mb-4 text-center">Kelola Langkah untuk: <span class="text-primary"><?php echo htmlspecialchars($resep['judul_resep']); ?></span></h2>

    <!-- Alert jika ada notifikasi -->
    <?php if (isset($_GET['status']) && isset($_GET['message'])): ?>
        <div class="alert alert-<?php echo ($_GET['status'] === 'success') ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahLangkah">Tambah Langkah</button>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $resultLangkah->fetch_assoc()) { ?>
                <tr>
                    <td class="text-center"><?php echo $row['nomor_langkah']; ?></td>
                    <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                    <td class="text-center">
                        <?php if (!empty($row['gambar'])) { ?>
                            <img src="../uploads/langkah/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Langkah" class="img-thumbnail" style="width: 100px; height: auto;">
                        <?php } else { echo "<span class='text-muted'>Tidak ada gambar</span>"; } ?>
                    </td>
                    <td class="text-center">
                        <a href="edit_langkah.php?id_langkah=<?php echo $row['id_langkah']; ?>&id_resep=<?php echo $id_resep; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus_langkah.php?id_langkah=<?php echo $row['id_langkah']; ?>&id_resep=<?php echo $id_resep; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus langkah ini?');">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <a href="kelola_langkah.php" class="btn btn-secondary">Kembali</a>

    <!-- Modal Tambah Langkah -->
    <div class="modal fade" id="modalTambahLangkah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Langkah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="proses_tambah_langkah.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_resep" value="<?php echo $id_resep; ?>">
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar (Opsional)</label>
                            <input type="file" class="form-control" name="gambar">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

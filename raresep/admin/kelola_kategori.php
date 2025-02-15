<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Ambil semua kategori dari database
$query = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Kelola Kategori</h3>
        </div>
        <div class="card-body">
            <!-- Form Tambah Kategori -->
            <form action="tambah_kategori.php" method="POST" class="mb-3">
                <div class="input-group">
                    <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </form>

            <!-- Tabel Kategori -->
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $row['nama_kategori']; ?></td>
                        <td>
                            <a href="edit_kategori.php?id=<?php echo $row['id_kategori']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="hapus_kategori.php?id=<?php echo $row['id_kategori']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <a href="dashboard.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>

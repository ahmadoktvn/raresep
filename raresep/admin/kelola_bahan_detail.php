<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../config/db.php';

// Pastikan id_resep ada di URL
if (!isset($_GET['id_resep'])) {
    echo "<div class='alert alert-danger text-center'>ID resep tidak ditemukan.</div>";
    exit();
}

$id_resep = $_GET['id_resep'];

// Ambil nama resep
$queryResep = "SELECT judul_resep FROM resep WHERE id_resep = $id_resep";
$resultResep = $conn->query($queryResep);
$resep = $resultResep->fetch_assoc();

// Ambil daftar bahan
$queryBahan = "SELECT * FROM bahan WHERE id_resep = $id_resep";
$resultBahan = $conn->query($queryBahan);

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
    <title>Kelola Bahan - <?php echo $resep['judul_resep']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h3><i class="fas fa-carrot"></i> Kelola Bahan untuk Resep: <?php echo $resep['judul_resep']; ?></h3>
            </div>
            <div class="card-body">
                <div class="text-end mb-3">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahBahanModal">
    <i class="fas fa-plus"></i> Tambah Bahan
</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama Bahan</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $resultBahan->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['nama_bahan']; ?></td>
                                <td><?php echo $row['jumlah']; ?></td>
                                <td>
                                    <a href="edit_bahan.php?id_bahan=<?php echo $row['id_bahan']; ?>&id_resep=<?php echo $id_resep; ?>" 
                                       class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="hapus_bahan.php?id_bahan=<?php echo $row['id_bahan']; ?>&id_resep=<?php echo $id_resep; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Yakin ingin menghapus?');">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <a href="kelola_bahan.php" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left"></i> Kembali ke Kelola Bahan
                </a>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahBahanModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Bahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahBahan">
                    <input type="hidden" name="id_resep" id="id_resep" value="<?php echo $id_resep; ?>">
                    
                    <div class="mb-3">
                        <label for="nama_bahan" class="form-label">Nama Bahan</label>
                        <input type="text" class="form-control" id="nama_bahan" name="nama_bahan" required>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="text" class="form-control" id="jumlah" name="jumlah" required>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $("#formTambahBahan").submit(function(e){
        e.preventDefault(); // Mencegah reload halaman

        $.ajax({
            type: "POST",
            url: "tambah_bahan_ajax.php", // File untuk memproses data
            data: $(this).serialize(), // Mengirim data form
            success: function(response){
                if (response === "success") {
                    $("#tambahBahanModal").modal('hide'); // Tutup modal
                    location.reload(); // Refresh halaman untuk update tabel
                } else {
                    alert("Gagal menambahkan bahan.");
                }
            }
        });
    });
});
</script>

</body>
</html>

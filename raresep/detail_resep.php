<?php
include 'config/db.php';
include 'includes/header.php';

if (!isset($_GET['id'])) {
    echo "Resep tidak ditemukan!";
    exit();
}

$id_resep = $_GET['id'];
$query = "SELECT resep.*, kategori.nama_kategori FROM resep 
          INNER JOIN kategori ON resep.id_kategori = kategori.id_kategori 
          WHERE id_resep = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_resep);
$stmt->execute();
$result = $stmt->get_result();
$resep = $result->fetch_assoc();

if (!$resep) {
    echo "Resep tidak ditemukan!";
    exit();
}

// Ambil bahan berdasarkan id_resep
$query_bahan = "SELECT * FROM bahan WHERE id_resep = ?";
$stmt_bahan = $conn->prepare($query_bahan);
$stmt_bahan->bind_param("i", $id_resep);
$stmt_bahan->execute();
$result_bahan = $stmt_bahan->get_result();

// Ambil langkah
$query_langkah = "SELECT * FROM langkah WHERE id_resep = ?";
$stmt_langkah = $conn->prepare($query_langkah);
$stmt_langkah->bind_param("i", $id_resep);
$stmt_langkah->execute();
$result_langkah = $stmt_langkah->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $resep['judul_resep']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Header Resep -->
        <div class="row align-items-center mb-4">
            <div class="col-md-5">
                <img src="assets/images/<?php echo $resep['gambar_resep']; ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($resep['judul_resep']); ?>">
            </div>
            <div class="col-md-7">
                <h2 class="fw-bold"> <?php echo $resep['judul_resep']; ?> </h2>
                <p class="text-muted"><strong>Kategori:</strong> <?php echo $resep['nama_kategori']; ?></p>
                <p><strong>Waktu Masak:</strong> <?php echo $resep['waktu_masak']; ?> menit</p>
                <p><strong>Tanggal Posting:</strong> <?php echo $resep['tanggal_posting']; ?></p>
                <p><?php echo nl2br($resep['deskripsi']); ?></p>
            </div>
        </div>
        
        <!-- Bahan & Langkah -->
        <div class="row">
            <div class="col-md-6">
                <h3 class="fw-bold">Bahan</h3>
                <ul class="list-group">
                    <?php while ($bahan = $result_bahan->fetch_assoc()) { ?>
                        <li class="list-group-item"> <?php echo $bahan['nama_bahan'] . " - " . $bahan['jumlah']; ?> </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-6">
                <h3 class="fw-bold">Langkah-langkah</h3>
                <ol class="list-group list-group-numbered">
                    <?php while ($langkah = $result_langkah->fetch_assoc()) { ?>
                        <li class="list-group-item"> <?php echo $langkah['deskripsi']; ?> </li>
                    <?php } ?>
                </ol>
            </div>
        </div>
        
        <!-- Tombol Kembali -->
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-warning">Kembali</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

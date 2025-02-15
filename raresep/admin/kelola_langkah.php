<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include '../config/db.php';

// Ambil semua resep
$queryResep = "SELECT id_resep, judul_resep FROM resep";
$resultResep = $conn->query($queryResep);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola langkah-langkah</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="card shadow">
    <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><i class="fas fa-utensils"></i> Kelola Bahan</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Resep</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($row = $resultResep->fetch_assoc()) { ?>
                            <tr>
                <td><?php echo $row['judul_resep']; ?></td>
                <td>
                    <a href="kelola_langkah_detail.php?id_resep=<?php echo $row['id_resep']; ?>">Kelola Bahan</a>
                </td>
            </tr>
            <?php } ?>
                          
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    <a href="dashboard.php" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
    </div>
   
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            display: flex;
        }
        #sidebar {
            width: 250px;
            height: 100vh;
            background: #343a40;
            color: white;
            position: fixed;
            padding-top: 20px;
        }
        #sidebar a {
            color: white;
            padding: 10px;
            display: block;
            text-decoration: none;
        }
        #sidebar a:hover {
            background: #495057;
        }
        #content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }
        .stats-card {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            color: white;
        }
        .bg-primary { background: #007bff; }
        .bg-success { background: #28a745; }
        .bg-warning { background: #ffc107; }
        .bg-danger { background: #dc3545; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div id="sidebar">
        <h4 class="text-center">Admin Panel</h4>
        <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="tambah_resep.php"><i class="fas fa-plus"></i> Tambah Resep</a>
        <a href="kelola_kategori.php"><i class="fas fa-layer-group"></i> Kelola Kategori</a>
        <a href="kelola_resep.php"><i class="fas fa-utensils"></i> Kelola Resep</a>
        <a href="kelola_bahan.php"><i class="fas fa-seedling"></i> Kelola Bahan</a>
        <a href="kelola_langkah.php"><i class="fas fa-list"></i> Kelola Langkah</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Content -->
    <div id="content">
        <h2>Selamat Datang di Dashboard Admin</h2>
        <p>Kelola data resep, bahan, dan langkah-langkah dengan mudah.</p>

        <!-- Statistik -->
        <div class="row">
            <div class="col-md-3">
                <div class="stats-card bg-primary">
                    <h3>120</h3>
                    <p>Total Resep</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-success">
                    <h3>450</h3>
                    <p>Total Bahan</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-warning">
                    <h3>300</h3>
                    <p>Total Langkah</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-danger">
                    <h3>50</h3>
                    <p>Resep Populer</p>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

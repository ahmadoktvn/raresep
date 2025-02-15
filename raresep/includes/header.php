<?php
// Mulai sesi jika diperlukan untuk login atau notifikasi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($title) ? $title : "Resep Masakan"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>

<header class="p-2 mb-2 border-bottom">
  <nav>
  <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between">

            <!-- Logo -->
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                <img src="assets/images/logo(text).png" alt="Logo" width="90" height="80">
            </a>

            <!-- Navigasi di Tengah -->
            <ul class="nav mx-auto d-flex justify-content-center">
                <li><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>
                <li><a href="resep.php" class="nav-link px-2 link-body-emphasis">Resep</a></li>
                <li><a href="about.php" class="nav-link px-2 link-body-emphasis">Tentang Kami</a></li>
            </ul>

            <!-- Form Pencarian -->
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3 d-flex" role="search" action="search.php" method="GET">
    <input type="search" name="q" class="form-control me-2" placeholder="Temukan Resep" aria-label="Search">
    <button class="btn btn-outline-secondary" type="submit">
        <i class="bi bi-search"></i>
    </button>
</form>


        </div>
    </div>
  </nav>
   
</header>

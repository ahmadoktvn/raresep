<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <!-- Tombol Hamburger -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand ms-2" href="#">Admin Dashboard</a>
    </div>
</nav>

<!-- Sidebar / Offcanvas -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarLabel">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-group">
            <li class="list-group-item list-group-item-dark"><a href="#" class="text-decoration-none text-white">Dashboard</a></li>
            <li class="list-group-item list-group-item-dark"><a href="#" class="text-decoration-none text-white">Users</a></li>
            <li class="list-group-item list-group-item-dark"><a href="#" class="text-decoration-none text-white">Settings</a></li>
            <li class="list-group-item list-group-item-dark"><a href="#" class="text-decoration-none text-white">Logout</a></li>
        </ul>
    </div>
</div>

<!-- Content -->
<div class="container mt-5 pt-4">
    <h1>Selamat Datang di Dashboard Admin</h1>
    <p>Gunakan sidebar untuk navigasi.</p>
</div>

</body>
</html>

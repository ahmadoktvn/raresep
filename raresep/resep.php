<?php
include "config/db.php";
include "includes/header.php";

$query = "SELECT * FROM resep";
$result = $conn->query($query);
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Populer</title>
    <link rel="stylesheet" href="style.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"> 
</head>
<body>
<main>
  <section class="py-5 text-center container">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light">Album example</h1>
        <p class="lead text-body-secondary">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sunt, dolor.</p>
        <p>
          <a href="#" class="btn btn-primary my-2">Main call to action</a>
          <a href="#" class="btn btn-secondary my-2">Secondary action</a>
        </p>
      </div>
    </div>
  </section>

  <div class="album py-5 bg-body-tertiary">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
      <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="col">
          <div class="card shadow-sm">
          <img src="assets/images/<?php echo htmlspecialchars($row['gambar_resep']); ?>" >
            <div class="card-body">
                <h4 class="card-title"><?php echo ($row['judul_resep']); ?></h4>
              <p class="card-text"><?php echo ($row['deskripsi']); ?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                <a href="detail_resep.php?id=<?php echo $row['id_resep']; ?>" class="btn btn-outline-primary">Lihat Resep</a>
                </div>
                <small class="text-body-secondary"><?php echo ($row['waktu_masak']); ?> menit</small>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      
    </div>
  </div>

</main>

<footer class="text-body-secondary py-5">
  <div class="container">
    <p class="float-end mb-1">
      <a href="#">Back to top</a>
    </p>
    <p class="mb-1">Album example is © Bootstrap, but please download and customize it for yourself!</p>
    <p class="mb-0">New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a href="/docs/5.3/getting-started/introduction/">getting started guide</a>.</p>
  </div>
</footer>
<script src="/docs/5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    

</body>
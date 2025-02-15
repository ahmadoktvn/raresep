<?php
include 'config/db.php';
include 'includes/header.php';  

$query = "SELECT * FROM resep";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
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
    <div class="container my-3">
      <div class="position-relative p-5 text-center text-muted bg-body border border-dashed rounded-5 bg-image">
        <h1 class="text-light">Temukan Resep Kesukaanmu Disini.</h1>
        <p class="col-lg-6 mx-auto mb-4 text-white">
          Jelajahi berbagai resep menarik dan coba masakan favoritmu dengan panduan lengkap dari kami.
        </p>
        <button class="btn btn-warning px-5 mb-5" type="button">
          Jelajahi
        </button>
      </div>
    </div> 
  </main>

  <section alt="resep populer">
    <div class="container my-5">
      <h2 class="text-center mb-4">Resep Populer</h2>
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="swiper-slide">
              <div class="card">
                <img src="assets/images/<?php echo htmlspecialchars($row['gambar_resep']); ?>" 
                     class="card-img-top" 
                     alt="<?php echo htmlspecialchars($row['judul_resep']); ?>">
                <div class="card-body">
                  <h5 class="card-title"><?php echo htmlspecialchars($row['judul_resep']); ?></h5>
                  <p class="card-text"><?php echo substr(htmlspecialchars($row['deskripsi']), 0, 50) . '...'; ?></p>
                  <a href="detail_resep.php?id=<?php echo $row['id_resep']; ?>" class="btn btn-primary">Lihat Resep</a>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <!-- Tombol Navigasi -->
        <div class="swiper-button-next"></div>
        <!-- <div class="swiper-button-prev"></div> -->
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>

<div class="container">
  <h1 class="text-center">Unggah Resep</h1>
<div class="row align-items-md-stretch justify-content-center">
      <div class="col-md-12">
        <div class="h-100 p-5 text-bg-dark rounded-3">
          <h2>Change the background</h2>
          <p>Swap the background-color utility and add a `.text-*` color utility to mix up the jumbotron look. Then, mix and match with additional component themes and more.</p>
          <button class="btn btn-outline-light col-5" type="button">Example button</button>
          <button class="btn btn-outline-light col-5" type="button">Example button</button>
        </div>
      </div>
    </div>
</div>
 

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>

<?php
include 'includes/footer.php';
?>
</html>

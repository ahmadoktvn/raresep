<?php
include 'config/db.php';
include 'includes/header.php';

$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';

?>

<div class="container my-5">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-chevron p-3 bg-body-tertiary rounded-3">
      <li class="breadcrumb-item">
        <a class="link-body-emphasis" href="#">
          <svg class="bi" width="16" height="16"><use xlink:href="#house-door-fill"></use></svg>
          <span class="visually-hidden">Home</span>
        </a>
      </li>
      <li class="breadcrumb-item">
        <a class="link-body-emphasis fw-semibold text-decoration-none" href="#">Cari</a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">
        Data
      </li>
    </ol>
  </nav>
</div>

<div class="container mt-4">
    <h2 class="text-center">Hasil Pencarian untuk: "<?php echo htmlspecialchars($search_query); ?>"</h2>

    <div class="row mt-4">
        <?php
        if (!empty($search_query)) {
            $stmt = $conn->prepare("SELECT * FROM resep WHERE judul_resep LIKE ? OR deskripsi LIKE ?");
            $search_param = "%{$search_query}%";
            $stmt->bind_param("ss", $search_param, $search_param);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="assets/images/<?php echo htmlspecialchars($row['gambar_resep']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['judul_resep']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['judul_resep']); ?></h5>
                                <p class="card-text"><?php echo substr(htmlspecialchars($row['deskripsi']), 0, 50) . '...'; ?></p>
                                <a href="detail_resep.php?id=<?php echo $row['id_resep']; ?>" class="btn btn-primary">Lihat Resep</a>
                            </div>
                        </div>
                    </div>
                <?php }
            } else {
                echo "<p class='text-center'>Tidak ada resep yang ditemukan.</p>";
            }

            $stmt->close();
        } else {
            echo "<p class='text-center'>Silakan masukkan kata kunci pencarian.</p>";
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<?php
include '../config/db.php';

if (isset($_GET['id'])) {
    $id_kategori = $_GET['id'];
    $query = "SELECT * FROM kategori WHERE id_kategori = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_kategori);
    $stmt->execute();
    $result = $stmt->get_result();
    $kategori = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nama_kategori = $_POST['nama_kategori'];
    $query = "UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $nama_kategori, $id_kategori);
    $stmt->execute();

    header("Location: kelola_kategori.php");
    exit();
}
?>

<form method="POST">
    <input type="text" name="nama_kategori" value="<?php echo $kategori['nama_kategori']; ?>" required>
    <button type="submit">Update</button>
</form>

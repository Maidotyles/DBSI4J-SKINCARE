<?php
include 'koneksi.php';
include 'auth.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM kategori WHERE id = '$id'");
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: kategori.php");
    exit;
}

if (isset($_POST['update'])) {
    $nama = htmlspecialchars($_POST['nama_kategori']);
    mysqli_query($conn, "UPDATE kategori SET nama_kategori = '$nama' WHERE id = '$id'");
    header("Location: kategori.php");
    exit;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- Custom CSS -->
  
<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<div class="content"><br><br><br>
    <h4><i class="fas fa-edit"></i> Edit Kategori</h4>
    <form method="post">
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" value="<?= htmlspecialchars($data['nama_kategori']) ?>" class="form-control" required>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="kategori.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap 4.6 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>


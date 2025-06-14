<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

// Ambil data user dari database
$id_user = $_SESSION['id_user'];
$query = "SELECT * FROM users WHERE id_user = '$id_user'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Pengguna</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/css/bootstrap.min.css">

  <!-- Font Awesome 5 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 70px;
    }
    .profile-card {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      padding: 30px;
    }
  </style>
</head>
<body>
<?php include 'partials/header.php'; ?>
<?php include 'partials/navbar.php'; ?>
<?php include 'partials/sidebar.php'; ?>


<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 profile-card">
      <h4 class="mb-4"><i class="fas fa-user-circle"></i> Profil Pengguna</h4>
      <table class="table table-borderless">
        <tr>
          <th>Username</th>
          <td><?= $_SESSION['username'] ?></td>
        </tr>
        <tr>
          <th>Role</th>
          <td><?= $_SESSION['role'] ?></td>
        </tr>
      </table>
     
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<!-- Bootstrap 4.6 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/script.js"></script>
</body>
</html>

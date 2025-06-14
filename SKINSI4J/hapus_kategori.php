<?php
include 'koneksi.php';
include 'auth.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM kategori WHERE id = '$id'");
header("Location: kategori.php");
exit;

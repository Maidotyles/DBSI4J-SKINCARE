<?php
include 'auth.php';
include 'koneksi.php';
include 'partials/header.php';

// 1. Total Produk
$q_produk = mysqli_query($conn, "SELECT COUNT(*) AS total_produk FROM produk");
$total_produk = mysqli_fetch_assoc($q_produk)['total_produk'];

// 2. Total Stok
$q_stok = mysqli_query($conn, "SELECT SUM(stok) AS total_stok FROM produk");
$total_stok = mysqli_fetch_assoc($q_stok)['total_stok'];

// 3. Uang Masuk Bulan Ini (Omset)
$bulan_ini = date('Y-m');
$q_omset = mysqli_query($conn, "SELECT SUM(total) AS uang_masuk FROM transaksi WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bulan_ini'");
$uang_masuk = mysqli_fetch_assoc($q_omset)['uang_masuk'] ?? 0;

// 4. Pelanggan Bulan Ini
$q_pelanggan = mysqli_query($conn, "
    SELECT COUNT(DISTINCT id_pelanggan) AS pelanggan_bulan_ini 
    FROM transaksi 
    WHERE DATE_FORMAT(tanggal, '%Y-%m') = '$bulan_ini' AND id_pelanggan IS NOT NULL AND id_pelanggan != 0
");
$pelanggan_bulan_ini = mysqli_fetch_assoc($q_pelanggan)['pelanggan_bulan_ini'] ?? 0;
?>
<?php
// Ambil total transaksi per bulan (6 bulan terakhir)
$query_chart = mysqli_query($conn, "
  SELECT DATE_FORMAT(tanggal, '%M %Y') AS bulan, SUM(total) AS total 
  FROM transaksi 
  WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
  GROUP BY DATE_FORMAT(tanggal, '%Y-%m')
  ORDER BY DATE_FORMAT(tanggal, '%Y-%m') ASC
");

$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($query_chart)) {
    $labels[] = $row['bulan'];
    $data[] = $row['total'];
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Kasir Skincare</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body { font-family: 'Segoe UI', sans-serif; }
        .sidebar {
            height: 100vh;
            position: fixed;
            width: 220px;
            background: #343a40;
            color: #fff;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 10px 20px;
        }
        .sidebar a:hover {
            background: #495057;
            text-decoration: none;
        }
        .main {
            margin-left: 230px;
            padding: 20px;
        }
        .card-summary {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php include 'partials/navbar.php'; ?>
<?php include 'partials/sidebar.php'; ?>

<div class="main">
    <h3>Dashboard</h3>

    <div class="row">
        <div class="col-md-3 card-summary">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title"><?= $total_produk ?> Produk</h5>
                    <p class="card-text">Total Produk</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 card-summary">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title"><?= $total_stok ?> Item</h5>
                    <p class="card-text">Total Stok</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 card-summary">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Rp <?= number_format($uang_masuk, 0, ',', '.') ?></h5>
                    <p class="card-text">Uang Masuk Bulan Ini</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 card-summary">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title"><?= $pelanggan_bulan_ini ?> Orang</h5>
                    <p class="card-text">Pelanggan Bulan Ini</p>
                </div>
            </div>
        </div>
    </div>
<div class="card mt-4">
    <div class="card-header">
        Grafik Omset 6 Bulan Terakhir
    </div>
    <div class="card-body">
        <canvas id="omsetChart" height="100"></canvas>
    </div>
</div>

</div>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('omsetChart').getContext('2d');
    const omsetChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Omset (Rp)',
                data: <?= json_encode($data) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>

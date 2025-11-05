<?php
session_start();
require "koneksi.php";

if (empty($_SESSION['keranjang'])) {
    header("Location: keranjang.php");
    exit;
}

// Hitung total
$total = 0;
foreach ($_SESSION['keranjang'] as $item) {
    $total += $item['harga'] * $item['jumlah'];
}

$no_dana = "083875318486";
$nama_penerima = "Linno";
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran | SMLW Store</title>
<link rel="stylesheet" href="bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="fontawesome/fontawesome-free-7.1.0-web/css/all.min.css">
<style>
body { background-color: #f5f7fa; }
.pembayaran-container {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    margin-top: 60px;
    max-width: 700px;
}
.text-harga { font-size: 2rem; color: #007bff; font-weight: bold; }
.btn-konfirmasi {
    background-color: #25d366; color: white; font-weight: 600;
    border-radius: 10px; padding: 10px 25px;
}
.btn-konfirmasi:hover { background-color: #1ebe5d; }
</style>
</head>
<body>

<?php require "navbar.php"; ?>

<div class="container d-flex justify-content-center">
    <div class="pembayaran-container text-center">
        <h2 class="fw-bold text-primary mb-3">Lanjutkan Pembayaran</h2>
        <p class="text-muted">Transfer ke DANA:</p>
        <h4><strong><?php echo $nama_penerima; ?></strong> (<?php echo $no_dana; ?>)</h4>
        <img src="image/barcode.jpg" class="img-fluid rounded my-3" width="200">

        <h3 class="text-harga mb-3">Total: Rp <?php echo number_format($total,0,',','.'); ?></h3>
        <p class="text-muted">Setelah pembayaran, klik tombol selesai di bawah.</p>

        <a href="selesai.php" class="btn btn-success mt-3">
            <i class="fa-solid fa-check me-2"></i> Selesai / Konfirmasi
        </a>
        <br>
        <a href="keranjang.php" class="btn btn-secondary mt-3">
            <i class="fa-solid fa-arrow-left me-2"></i> Kembali ke Keranjang
        </a>
    </div>
</div>

<?php require "footer.php"; ?>
</body>
</html>

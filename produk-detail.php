<?php
require "koneksi.php";

$nama = htmlspecialchars($_GET["nama"]);
$queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama='$nama'");
$produk = mysqli_fetch_array($queryProduk);

$queryProdukTerkait = mysqli_query($conn, "
    SELECT * FROM produk 
    WHERE kategori_id='$produk[kategori_id]' AND id!='$produk[id]' 
    LIMIT 4
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk | <?php echo $produk['nama']; ?></title>
    <link rel="stylesheet" href="bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome-free-7.1.0-web/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            background-color: #f7f9fc;
        }
        .produk-detail-container {
            padding: 60px 0;
        }
        .produk-img {
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.1);
        }
        .produk-nama {
            font-size: 2rem;
            font-weight: 700;
        }
        .text-harga {
            font-size: 1.6rem;
            color: #007bff;
            font-weight: bold;
        }
        .btn-beli {
            background-color: #007bff;
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 12px;
            transition: 0.3s;
        }
        .btn-beli:hover {
            background-color: #0056b3;
            color: white;
        }
        .warna2 {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }
        .produk-terkait-image {
            border-radius: 12px;
            transition: 0.3s;
        }
        .produk-terkait-image:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<?php require "navbar.php"; ?>

<!-- Detail Produk -->
<div class="container produk-detail-container">
    <div class="row align-items-center">
        <div class="col-lg-5 mb-4">
            <img src="image/<?php echo $produk['foto']; ?>" class="w-100 produk-img" alt="<?php echo $produk['nama']; ?>">
        </div>
        <div class="col-lg-6 offset-lg-1">
            <h1 class="produk-nama mb-3"><?php echo $produk['nama']; ?></h1>
            <p class="fs-5 text-secondary"><?php echo nl2br($produk['detail']); ?></p>

            <p class="text-harga mb-2">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
            <p class="fs-6 mb-4">
                <strong>Ketersediaan:</strong> 
                <?php echo $produk['ketersediaan_stock']; ?>
            </p>

            <!-- Tombol Beli Sekarang -->
            <a href="beli.php?nama=<?php echo urlencode($produk['nama']); ?>" class="btn btn-beli">
                <i class="fa-solid fa-cart-shopping me-2"></i>Beli Sekarang
            </a>
        </div>
    </div>
</div>

<!-- Produk Terkait -->
<div class="container-fluid py-5 warna2">
    <div class="container">
        <h2 class="text-center text-white mb-5">Produk Terkait</h2>
        <div class="row">
            <?php while($data=mysqli_fetch_array($queryProdukTerkait)){ ?>
            <div class="col-md-6 col-lg-3 mb-4 text-center">
                <a href="produk-detail.php?nama=<?php echo $data['nama']; ?>" class="text-decoration-none">
                    <img src="image/<?php echo $data['foto']; ?>" class="img-fluid produk-terkait-image mb-3" alt="">
                    <h6 class="text-white"><?php echo $data['nama']; ?></h6>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>

<script src="bootstrap/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/fontawesome-free-7.1.0-web/js/all.min.js"></script>
</body>
</html>

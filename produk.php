<?php
require "koneksi.php";
session_start();

$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");

// get produk by nama produk
if (isset($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
    $queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama LIKE '%$keyword%'");
}

// get produk by kategori
else if (isset($_GET['kategori'])) {
    $kategoriNama = mysqli_real_escape_string($conn, $_GET['kategori']);
    $queryGetKategoriId = mysqli_query($conn, "SELECT id FROM kategori WHERE nama='$kategoriNama'");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);

    // cek apakah kategori ditemukan
    if ($kategoriId && isset($kategoriId['id'])) {
        $queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE kategori_id='{$kategoriId['id']}'");
    } else {
        $queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE 0");
    }
}

// default
else {
    $queryProduk = mysqli_query($conn, "SELECT * FROM produk");
}

$countdata = mysqli_num_rows($queryProduk);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online | Produk</title>
    <link rel="stylesheet" href="bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome-free-7.1.0-web/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        .cart-icon {
            font-size: 1.5rem;
            color: gold;
            position: relative;
        }
        .cart-count {
            position: absolute;
            top: -8px;
            right: -10px;
            background-color: red;
            color: white;
            font-size: 12px;
            border-radius: 50%;
            padding: 2px 6px;
        }
        .card-produk {
            position: relative;
            overflow: hidden;
        }
        .keranjang-kuning {
            position: absolute;
            top: 12px;
            right: 12px;
            background-color: gold;
            color: white;
            border-radius: 50%;
            padding: 8px;
            font-size: 1rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
        .banner1 {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 60px 0;
            text-align: center;
        }
    </style>
</head>
<body style="background-color: #f4f7fc;">
    <?php require "navbar.php"; ?>


    <!-- Banner -->
    <div class="container-fluid banner1 d-flex align-items-center justify-content-center">
        <div class="text-center text-white">
            <h1 class="fw-bold"><strong>SMLW</strong></h1>
            <p class="lead mb-0">Shop More, Live Well</p>
        </div>
    </div>

    <!-- Konten Produk -->
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar Kategori -->
            <div class="col-lg-3 mb-4">
                <div class="p-3 bg-white shadow-sm rounded-4">
                    <h5 class="fw-bold mb-3 text-center">Kategori</h5>
                    <ul class="list-group list-group-flush">
                        <?php while ($kategori = mysqli_fetch_array($queryKategori)) { ?>
                            <a class="no-decoration" href="produk.php?kategori=<?php echo urlencode($kategori['nama']); ?>">
                                <li class="list-group-item list-hover text-center">
                                    <?php echo htmlspecialchars($kategori['nama']); ?>
                                </li>
                            </a>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <!-- Daftar Produk -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-primary mb-0">Discover More</h3>
                    <form class="d-flex" method="get" action="">
                        <input type="text" name="keyword" class="form-control me-2 rounded-4" placeholder="Cari produk...">
                        <button class="btn btn-primary rounded-4"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="row">
                    <?php if ($countdata < 1) { ?>
                        <div class="text-center py-5">
                            <h4 class="text-muted">Produk yang Anda cari tidak ditemukan.</h4>
                        </div>
                    <?php } ?>

                    <?php 
                    // ambil daftar produk yang sudah dibeli
                    $keranjangIds = [];
                    if (isset($_SESSION['keranjang'])) {
                        foreach ($_SESSION['keranjang'] as $item) {
                            $keranjangIds[] = $item['id'];
                        }
                    }

                    while ($produk = mysqli_fetch_array($queryProduk)) { 
                        $sudahDibeli = in_array($produk['id'], $keranjangIds);
                    ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card card-produk shadow-sm border-0 rounded-4 h-100 position-relative">
                                <?php if ($sudahDibeli) { ?>
                                    <div class="keranjang-kuning">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </div>
                                <?php } ?>
                                <div class="image-box">
                                    <img src="image/<?php echo $produk['foto']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produk['nama']); ?>">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-semibold text-dark">
                                        <?php echo htmlspecialchars($produk['nama']); ?>
                                    </h5>
                                    <p class="card-text text-muted small text-truncate">
                                        <?php echo htmlspecialchars($produk['detail']); ?>
                                    </p>
                                    <p class="text-harga">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                                    <a href="produk-detail.php?nama=<?php echo urlencode($produk['nama']); ?>" 
                                       class="btn btn-primary rounded-4 w-100">
                                       <i class="fa-solid fa-eye me-1"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>

    <script src="bootstrap/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/fontawesome-free-7.1.0-web/js/all.min.js"></script>
</body>
</html>

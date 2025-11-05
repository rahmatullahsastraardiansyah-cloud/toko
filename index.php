<?php
require "koneksi.php";
$queryProduk = mysqli_query($conn, "SELECT id, nama, harga, foto, detail FROM produk LIMIT 6");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SMLW Store | Home</title>
  <link rel="stylesheet" href="bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/fontawesome-free-7.1.0-web/css/all.min.css">
  <style>
    /* 🌈 Warna utama */
    :root {
      --warna1: #0d1844;
      --warna2: #1b2a70;
      --warna3: #f5b301;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f8f9fa;
    }

    /* 🏠 Banner */
    .banner2 {
      background: linear-gradient(90deg, var(--warna1), var(--warna2));
      height: 80vh;
      color: white;
      text-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }

    .banner2 h1 {
      font-size: 3rem;
      font-weight: 700;
    }

    .banner2 h3 {
      font-weight: 400;
      color: #ffda77;
    }

    .banner2 .form-control {
      border-radius: 30px 0 0 30px;
      border: none;
      padding: 15px;
    }

    .banner2 .btn {
      border-radius: 0 30px 30px 0;
      background-color: var(--warna3);
      border: none;
    }

    .banner2 .btn:hover {
      background-color: #ffcc00;
    }

    /* 🛍️ Produk */
    .card {
      border-radius: 15px;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .card-img-top {
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
      height: 250px;
      object-fit: cover;
    }

    .warna3 {
      background-color: var(--warna3);
    }

    .warna3:hover {
      background-color: #ffcc00;
    }

    .btn-outline-warning {
      border-color: var(--warna3);
      color: var(--warna1);
      font-weight: 500;
    }

    .btn-outline-warning:hover {
      background-color: var(--warna3);
      color: white;
    }
  </style>
</head>
<body>
  <?php require "navbar.php"; ?>

  <!-- 🌐 Banner -->
  <div class="container-fluid banner2 d-flex align-items-center text-center">
    <div class="container">
      <h1 class="mb-3">Selamat Datang di <span class="text-warning">SMLW Store</span></h1>
      <h3 class="mb-4">Temukan Barang Favorit anda di Sini</h3>
      <form method="get" action="produk.php" class="mt-4">
        <div class="col-md-8 offset-md-2">
          <div class="input-group input-group-lg shadow">
            <input type="text" class="form-control" name="keyword" placeholder="Cari produk..." required>
            <button type="submit" class="btn text-white"><i class="fa-solid fa-magnifying-glass me-2"></i>Telusuri</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- 🛒 Produk -->
  <div class="container-fluid py-5 bg-light">
    <div class="container text-center">
      <h3 class="fw-bold mb-4 text-primary">Produk Unggulan</h3>
      <div class="row mt-4">
        <?php while ($data = mysqli_fetch_array($queryProduk)) { ?>
          <div class="col-sm-6 col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0">
              <img src="image/<?php echo htmlspecialchars($data['foto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($data['nama']); ?>">
              <div class="card-body">
                <h5 class="card-title text-dark fw-semibold"><?php echo htmlspecialchars($data['nama']); ?></h5>
                <p class="card-text text-secondary text-truncate"><?php echo htmlspecialchars($data['detail']); ?></p>
                <p class="card-text fw-bold text-primary mb-3">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></p>
                <a href="produk-detail.php?nama=<?php echo urlencode($data['nama']); ?>" class="btn warna3 text-white w-100">Lihat Detail</a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>

      <a class="btn btn-outline-warning mt-4 px-4 fs-5" href="produk.php">Lihat Semua Produk</a>
    </div>
  </div>

  <?php require "footer.php"; ?>

  <script src="bootstrap/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
  <script src="fontawesome/fontawesome-free-7.1.0-web/js/all.min.js"></script>
</body>
</html>

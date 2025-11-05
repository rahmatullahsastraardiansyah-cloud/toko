<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SMLW Store | Tentang Kami</title>
  <link rel="stylesheet" href="bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/fontawesome-free-7.1.0-web/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #333; }
    .banner2 { background: linear-gradient(rgba(13,24,68,0.7), rgba(13,24,68,0.7)), url('image/banner4.jpg') center/cover no-repeat; height: 45vh; }
    .section-title { color: #0d1844; font-weight: 700; }
    .highlight { color: #ffc107; font-weight: 600; }
    .icon-box {
      background: white;
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      transition: 0.3s;
      box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    .icon-box:hover { transform: translateY(-5px); box-shadow: 0 5px 20px rgba(0,0,0,0.15); }
    .icon-box i { font-size: 2.5rem; color: #0d1844; margin-bottom: 10px; }
  </style>
</head>
<body>
  <?php require "navbar.php"; ?>

  <!-- Banner -->
  <div class="container-fluid banner2 d-flex align-items-center justify-content-center text-white">
    <h1 class="fw-bold">Tentang Kami</h1>
  </div>

  <!-- Isi -->
  <div class="container py-5">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4">
        <img src="image/foto.png" class="img-fluid rounded shadow" alt="Tentang Kami">
      </div>
      <div class="col-lg-6">
        <h2 class="section-title mb-3">Siapa Kami?</h2>
        <p class="fs-5">
          <strong class="highlight">SMLW Store</strong> adalah toko online yang menyediakan berbagai produk terbaik dengan harga terjangkau.
          Kami berkomitmen menghadirkan pengalaman belanja yang mudah, cepat, dan aman bagi semua pelanggan kami.
        </p>
        <p class="fs-5">
          Dengan tim profesional dan dedikasi tinggi, kami selalu memperbarui koleksi produk agar sesuai dengan tren terbaru
          dan kebutuhan pelanggan di seluruh Indonesia.
        </p>
      </div>
    </div>
  </div>

  <!-- Nilai & Misi -->
  <div class="container py-5">
    <h3 class="text-center mb-5 fw-bold section-title">Nilai & Misi Kami</h3>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="icon-box">
          <i class="fa-solid fa-heart"></i>
          <h5 class="fw-bold mt-3">Kepuasan Pelanggan</h5>
          <p>Kami selalu menempatkan kepuasan pelanggan sebagai prioritas utama dalam setiap layanan kami.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box">
          <i class="fa-solid fa-box"></i>
          <h5 class="fw-bold mt-3">Produk Berkualitas</h5>
          <p>Hanya produk terbaik yang kami pilih agar pelanggan mendapatkan nilai maksimal dari setiap pembelian.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="icon-box">
          <i class="fa-solid fa-truck-fast"></i>
          <h5 class="fw-bold mt-3">Pengiriman Cepat</h5>
          <p>Kami memastikan setiap pesanan dikirim dengan aman dan cepat ke seluruh wilayah Indonesia.</p>
        </div>
      </div>
    </div>
  </div>

  <?php require "footer.php"; ?>
  <script src="bootstrap/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

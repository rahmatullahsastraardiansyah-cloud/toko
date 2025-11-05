<?php
require "koneksi.php";
$queryKomik = mysqli_query($conn, "SELECT * FROM komik ORDER BY tanggal_upload DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Komik Online</title>
  <link rel="stylesheet" href="bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/fontawesome-free-7.1.0-web/css/all.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .komik-card {
      border-radius: 10px;
      overflow: hidden;
      transition: transform .2s;
    }
    .komik-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }
    .komik-img {
      height: 300px;
      object-fit: cover;
    }
  </style>
</head>
<body>
  <?php require "navbar.php"; ?>

  <div class="container py-5">
    <h2 class="text-center mb-5 text-primary fw-bold">📚 Koleksi Komik</h2>
    <div class="row">
      <?php while($data = mysqli_fetch_assoc($queryKomik)) { ?>
        <div class="col-md-4 mb-4">
          <div class="card komik-card">
            <img src="image/<?php echo htmlspecialchars($data['gambar']); ?>" class="card-img-top komik-img" alt="<?php echo htmlspecialchars($data['judul']); ?>">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($data['judul']); ?></h5>
              <p class="card-text text-truncate"><?php echo htmlspecialchars($data['deskripsi']); ?></p>
              <a href="komik-baca.php?id=<?php echo $data['id']; ?>" class="btn btn-primary w-100">Baca Sekarang</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <?php require "footer.php"; ?>
  <script src="bootstrap/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

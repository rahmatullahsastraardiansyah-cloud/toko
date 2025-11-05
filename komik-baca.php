<?php
require "koneksi.php";
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM komik WHERE id='$id'");
$data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($data['judul']); ?> | Baca Komik</title>
  <link rel="stylesheet" href="bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="fontawesome/fontawesome-free-7.1.0-web/css/all.min.css">
  <style>
    body {
      background: linear-gradient(135deg, #f5f6fa, #dcdde1);
      font-family: 'Poppins', sans-serif;
    }

    .comic-container {
      background-color: #fff;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      max-width: 900px;
      margin: 40px auto;
      padding: 30px;
    }

    .comic-image {
      display: block;
      margin: 0 auto 25px auto;
      max-width: 70%;
      height: auto;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .comic-image:hover {
      transform: scale(1.05);
    }

    .comic-title {
      font-weight: 700;
      color: #0d1844;
      text-align: center;
      margin-bottom: 20px;
    }

    .comic-content {
      color: #333;
      line-height: 1.8;
      text-align: justify;
      font-size: 1.05rem;
    }

    .back-btn {
      display: inline-block;
      background-color: #0d1844;
      color: #fff;
      padding: 10px 20px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
    }

    .back-btn:hover {
      background-color: #1b2a70;
      text-decoration: none;
      color: #fff;
    }
  </style>
</head>

<body>
  <?php require "navbar.php"; ?>

  <div class="container">
    <div class="comic-container">
      <img src="image/<?php echo htmlspecialchars($data['gambar']); ?>" 
           alt="<?php echo htmlspecialchars($data['judul']); ?>" 
           class="comic-image">

      <h2 class="comic-title"><?php echo htmlspecialchars($data['judul']); ?></h2>
      <p class="comic-content"><?php echo nl2br(htmlspecialchars($data['isi'])); ?></p>

      <div class="text-center mt-4">
        <a href="komik.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Komik</a>
      </div>
    </div>
  </div>

  <?php require "footer.php"; ?>
  <script src="bootstrap/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

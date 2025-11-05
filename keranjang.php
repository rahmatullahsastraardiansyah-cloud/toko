<?php
session_start();
require "koneksi.php";

// Inisialisasi array jika belum ada
if (!isset($_SESSION['keranjang'])) $_SESSION['keranjang'] = [];
if (!isset($_SESSION['selesai'])) $_SESSION['selesai'] = [];

// Hapus item dari keranjang
if (isset($_GET['hapus'])) {
    $hapusId = $_GET['hapus'];
    foreach ($_SESSION['keranjang'] as $key => $item) {
        if ($item['id'] == $hapusId) {
            unset($_SESSION['keranjang'][$key]);
            break;
        }
    }
    $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
    header("Location: keranjang.php");
    exit;
}

// Update jumlah
if (isset($_POST['update_jumlah'])) {
    $id = $_POST['id'];
    $jumlah = max(1, (int)$_POST['jumlah']);
    foreach ($_SESSION['keranjang'] as $key => $item) {
        if ($item['id'] == $id) {
            $_SESSION['keranjang'][$key]['jumlah'] = $jumlah;
            break;
        }
    }
    header("Location: keranjang.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Keranjang | SMLW Store</title>
<link rel="stylesheet" href="bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="fontawesome/fontawesome-free-7.1.0-web/css/all.min.css">
<style>
body { background-color: #f5f7fb; }
.sidebar {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.sidebar a {
    display: block;
    color: #333;
    text-decoration: none;
    padding: 10px 15px;
    border-radius: 10px;
    margin-bottom: 8px;
    transition: 0.3s;
}
.sidebar a.active, .sidebar a:hover {
    background-color: #0d6efd;
    color: white;
}
.content-area {
    background: white;
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.keranjang-item {
    border-bottom: 1px solid #eee;
    padding: 15px 0;
}
.text-harga { color: #0d6efd; font-weight: 600; }
</style>
</head>
<body>

<?php require "navbar.php"; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="sidebar">
                <h5 class="fw-bold mb-3">Pesanan</h5>
                <a href="#" id="btn-belum" class="active"><i class="fa-solid fa-clock me-2"></i> Belum Dibayar</a>
                <a href="#" id="btn-selesai"><i class="fa-solid fa-check me-2"></i> Selesai</a>
            </div>
        </div>

        <div class="col-md-9">
            <!-- Belum Dibayar -->
            <div id="belum" class="content-area">
                <h4 class="fw-bold text-warning mb-3"><i class="fa-solid fa-clock me-2"></i> Belum Dibayar</h4>
                <?php if (empty($_SESSION['keranjang'])) { ?>
                    <div class="text-center text-muted py-5">
                        <i class="fa-solid fa-box-open fa-3x mb-3"></i>
                        <h5>Tidak ada produk di keranjang</h5>
                    </div>
                <?php } else {
                    $total = 0;
                    foreach ($_SESSION['keranjang'] as $item) {
                        $jumlah = isset($item['jumlah']) ? $item['jumlah'] : 1;
                        $subtotal = $item['harga'] * $jumlah;
                        $total += $subtotal; ?>
                        <div class="keranjang-item row align-items-center">
                            <div class="col-md-2 text-center">
                                <img src="image/<?php echo $item['foto']; ?>" class="img-fluid rounded">
                            </div>
                            <div class="col-md-4">
                                <h6><?php echo $item['nama']; ?></h6>
                                <form method="post" class="d-flex align-items-center gap-2 mt-1">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="jumlah" min="1" value="<?php echo $jumlah; ?>" class="form-control form-control-sm" style="width:70px;">
                                    <button type="submit" name="update_jumlah" class="btn btn-sm btn-success"><i class="fa-solid fa-rotate"></i></button>
                                </form>
                            </div>
                            <div class="col-md-3 text-harga">Rp <?php echo number_format($subtotal,0,',','.'); ?></div>
                            <div class="col-md-3 text-end">
                                <a href="?hapus=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="text-end mt-3">
                        <h5>Total: Rp <?php echo number_format($total,0,',','.'); ?></h5>
                        <a href="pembayaran.php" class="btn btn-primary mt-2">Lanjutkan Pembayaran</a>
                    </div>
                <?php } ?>
            </div>

            <!-- Selesai -->
            <div id="selesai" class="content-area" style="display:none;">
                <h4 class="fw-bold text-success mb-3"><i class="fa-solid fa-check me-2"></i> Selesai</h4>
                <?php if (empty($_SESSION['selesai'])) { ?>
                    <div class="text-center text-muted py-5">
                        <i class="fa-solid fa-circle-check fa-3x mb-3"></i>
                        <h5>Belum ada pesanan yang selesai</h5>
                    </div>
                <?php } else {
                    foreach ($_SESSION['selesai'] as $item) { ?>
                        <div class="keranjang-item row align-items-center">
                            <div class="col-md-2 text-center">
                                <img src="image/<?php echo $item['foto']; ?>" class="img-fluid rounded">
                            </div>
                            <div class="col-md-6">
                                <h6><?php echo $item['nama']; ?></h6>
                                <p class="text-success fw-semibold"><i class="fa-solid fa-check me-1"></i> Pembayaran Selesai</p>
                            </div>
                            <div class="col-md-4 text-harga">Rp <?php echo number_format($item['harga'] * $item['jumlah'],0,',','.'); ?></div>
                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>

<script>
document.getElementById("btn-belum").addEventListener("click", function() {
    document.getElementById("belum").style.display = "block";
    document.getElementById("selesai").style.display = "none";
    this.classList.add("active");
    document.getElementById("btn-selesai").classList.remove("active");
});
document.getElementById("btn-selesai").addEventListener("click", function() {
    document.getElementById("belum").style.display = "none";
    document.getElementById("selesai").style.display = "block";
    this.classList.add("active");
    document.getElementById("btn-belum").classList.remove("active");
});
</script>

<script src="bootstrap/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

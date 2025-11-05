<?php
session_start();
require "koneksi.php";

if (!isset($_GET['nama'])) {
    header("Location: index.php");
    exit;
}

$nama = htmlspecialchars($_GET['nama']);
$queryProduk = mysqli_query($conn, "SELECT * FROM produk WHERE nama='$nama'");
$produk = mysqli_fetch_array($queryProduk);

if (!$produk) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

// Nomor WhatsApp dan DANA
$no_wa = "6285847439679"; // Ganti sesuai kebutuhan
$no_dana = "085847439679";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Produk | <?php echo $produk['nama']; ?></title>
    <link rel="stylesheet" href="bootstrap/bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome-free-7.1.0-web/css/all.min.css">

    <style>
        body {
            background-color: #f4f6fa;
        }

        .beli-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-top: 60px;
        }

        .produk-img {
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .text-harga {
            font-size: 1.6rem;
            font-weight: bold;
            color: #007bff;
        }

        .btn-wa {
            background-color: #25d366;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            padding: 12px 30px;
            transition: 0.3s;
        }

        .btn-wa:hover {
            background-color: #1ebe5d;
            color: white;
        }

        .btn-kembali {
            background-color: #6c757d;
            color: white;
            border-radius: 10px;
            padding: 10px 25px;
        }

        .btn-kembali:hover {
            background-color: #5a6268;
            color: white;
        }

        .btn-dana {
            background-color: #1087ff;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            padding: 12px 30px;
            transition: 0.3s;
        }

        .btn-dana:hover {
            background-color: #0a6edb;
            color: white;
        }

        .btn-done {
            background-color: #28a745;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            padding: 12px 30px;
            transition: 0.3s;
        }

        .btn-done:hover {
            background-color: #218838;
            color: white;
        }

        .copy-number {
            cursor: pointer;
            color: #1087ff;
            font-weight: 600;
        }

        .copy-number:hover {
            text-decoration: underline;
        }

        .total-harga {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }
    </style>
</head>
<body>

<?php require "navbar.php"; ?>

<div class="container beli-container">
    <div class="row align-items-center">
        <div class="col-lg-5 mb-4">
            <img src="image/<?php echo $produk['foto']; ?>" class="w-100 produk-img" alt="<?php echo $produk['nama']; ?>">
        </div>
        <div class="col-lg-7">
            <h2 class="fw-bold mb-3"><?php echo $produk['nama']; ?></h2>
            <p class="text-harga mb-2">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
            <p class="mb-4"><?php echo nl2br($produk['detail']); ?></p>

            <form id="formBeli" method="post">
                <div class="mb-3">
                    <label for="jumlah" class="form-label">Jumlah Beli</label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control w-50" value="1" min="1">
                </div>

                <p class="total-harga mb-4">Total: <span id="totalHarga">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></span></p>

                <div class="d-flex flex-wrap gap-3 mb-3">
                    <a id="linkWa" href="#" target="_blank" class="btn btn-wa">
                        <i class="fab fa-whatsapp me-2"></i>Pesan via WhatsApp
                    </a>

                    <button type="button" class="btn btn-dana" id="btnDana">
                        <i class="fa-solid fa-wallet me-2"></i>Bayar via DANA
                    </button>

                    <a href="produk-detail.php?nama=<?php echo $produk['nama']; ?>" class="btn btn-kembali">
                        <i class="fa-solid fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>

            <div id="infoDana" class="mt-4" style="display:none;">
                <h5 class="fw-bold text-primary mb-2">🔹 Pembayaran via DANA</h5>
                <p>Kirim sesuai nominal di atas ke nomor:</p>
                <p class="mb-0">
                    <span id="noDana" class="copy-number"><?php echo $no_dana; ?></span>
                    <i class="fa-regular fa-copy ms-2 copy-number" id="copyDana"></i>
                </p>
                <small class="text-muted">Klik nomor untuk menyalin dan jangan lupa kirim bukti pembayaran via WhatsApp.</small>

                <div class="mt-4">
                    <form method="post">
                        <button type="submit" name="done" class="btn btn-done">
                            <i class="fa-solid fa-check me-2"></i> Done / Selesai Bayar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// ======= Jika user klik Done =======
if (isset($_POST['done'])) {
    $jumlah = intval($_POST['jumlah']);
    if ($jumlah < 1) $jumlah = 1;

    $produkBaru = [
        'id' => $produk['id'],
        'nama' => $produk['nama'],
        'harga' => $produk['harga'],
        'foto' => $produk['foto'],
        'jumlah' => $jumlah
    ];

    if (!isset($_SESSION['keranjang'])) {
        $_SESSION['keranjang'] = [];
    }

    $found = false;
    foreach ($_SESSION['keranjang'] as &$item) {
        if ($item['id'] == $produkBaru['id']) {
            $item['jumlah'] += $jumlah;
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['keranjang'][] = $produkBaru;
    }

    echo "<script>alert('Pembayaran berhasil! Produk masuk ke keranjang.'); window.location='keranjang.php';</script>";
}
?>

<?php require "footer.php"; ?>

<script src="bootstrap/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script src="fontawesome/fontawesome-free-7.1.0-web/js/all.min.js"></script>

<script>
    const jumlahInput = document.getElementById('jumlah');
    const linkWa = document.getElementById('linkWa');
    const totalHarga = document.getElementById('totalHarga');
    const infoDana = document.getElementById('infoDana');
    const btnDana = document.getElementById('btnDana');
    const copyDana = document.getElementById('copyDana');
    const noDana = document.getElementById('noDana');

    const hargaProduk = <?php echo $produk['harga']; ?>;
    const produkNama = "<?php echo $produk['nama']; ?>";
    const noWa = "<?php echo $no_wa; ?>";

    function formatRupiah(angka) {
        return "Rp " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function updateData() {
        const jumlah = parseInt(jumlahInput.value) || 1;
        const total = hargaProduk * jumlah;
        totalHarga.innerText = formatRupiah(total);

        const pesan = `Halo, saya ingin membeli produk *${produkNama}* sebanyak *${jumlah}* unit seharga ${formatRupiah(hargaProduk)} (Total ${formatRupiah(total)}). Apakah masih tersedia?`;
        const link = `https://wa.me/${noWa}?text=${encodeURIComponent(pesan)}`;
        linkWa.href = link;
    }

    jumlahInput.addEventListener('input', updateData);
    window.addEventListener('load', updateData);

    btnDana.addEventListener('click', () => {
        infoDana.style.display = "block";
    });

    copyDana.addEventListener('click', () => {
        navigator.clipboard.writeText(noDana.textContent);
        alert("Nomor DANA disalin: " + noDana.textContent);
    });

    noDana.addEventListener('click', () => {
        navigator.clipboard.writeText(noDana.textContent);
        alert("Nomor DANA disalin: " + noDana.textContent);
    });
</script>

</body>
</html>

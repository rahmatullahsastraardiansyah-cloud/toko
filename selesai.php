<?php
session_start();

// Jika ada produk di keranjang, pindahkan ke selesai
if (!empty($_SESSION['keranjang'])) {
    foreach ($_SESSION['keranjang'] as $item) {
        $_SESSION['selesai'][] = $item;
    }
    $_SESSION['keranjang'] = []; // kosongkan keranjang
}

header("Location: keranjang.php");
exit;
?>

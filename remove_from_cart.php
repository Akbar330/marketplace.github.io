<?php
session_start();
if (isset($_GET['id_produk'])) {
    $id_produk = intval($_GET['id_produk']);

    if (isset($_SESSION['cart'][$id_produk])) {
        unset($_SESSION['cart'][$id_produk]);
    }

    header("Location: cart.php"); // Arahkan ke halaman cart
    exit();
}
?>

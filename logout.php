<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php"); // Arahkan ke halaman login setelah logout
?>

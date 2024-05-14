<?php
    session_start();
    if(isset($_SESSION['peminjam'])) {
        // Hapus sesi 'peminjam'
        unset($_SESSION['peminjam']);
    }

    header("location:../index.php");
?>
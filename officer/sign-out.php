<?php
    session_start();
    if(isset($_SESSION['petugas'])) {
        // Hapus sesi 'petugas'
        unset($_SESSION['petugas']);
    }

    header("location:../sign-in.php");
?>
<?php
    session_start();
    if(isset($_SESSION['pengelola'])) {
        // Hapus sesi 'pengelola'
        unset($_SESSION['pengelola']);
    }

    header("location:../sign-in.php");
?>
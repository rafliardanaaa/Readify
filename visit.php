<?php
    session_start();

    if(!isset($_SESSION['peminjam'])) {
        header("location:../index.php");
        exit;
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="img/readify-main.png">
    <title>Readify - Digital Library</title>
</head>
<body class="bg-slate-100">
    <nav class="bg-sky-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex justify-center items-center">
                <a href="../../index.php">
                    <img src="img/readify.png" alt="Readify Logo" class="h-8">
                </a>
                <a href="../../index.php" class="px-1 text-white text-lg font-semibold">Readify</a>
            </div>
            <div class="flex space-x-10">
                <a href="books/loan-box.php" class="text-white hover:text-gray-300">Pinjam</a>
                <a href="" class="text-gray-300">Kunjungan</a>
                <a href="../../index.php" class="text-white hover:text-gray-300">Beranda</a>
                <a href="my-collection.php" class="text-white hover:text-gray-300">Koleksi</a>
                <a href="account/manage-account.php" class="text-white hover:text-gray-300">Akun</a>
            </div>
            <div class="">
                <a href="../sign-out.php" class="text-white hover:text-gray-300">Keluar</a>
            </div>
        </div>
    </nav>
</body>
</html>
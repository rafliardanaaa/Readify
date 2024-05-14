<?php
    session_start();

    if(!isset($_SESSION['peminjam'])) {
        header("location:../index.php");
        exit;
    }

    $user = $_SESSION['peminjam'];

    require 'connection/connect.php';

    $book_code = $_GET['code'];
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
    <div class="left-8 top-8 flex items-center font-semibold absolute">
        <a href="loan-form.php?code=<?= $book_code; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-slate-400 w-8 h-8 hover:fill-sky-600 hover:text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </a>
        <a href="loan-form.php?code=<?= $book_code; ?>" class="mx-1.5 text-slate-400 hover:text-sky-600">Kembali</a>
    </div>
</body>
</html>
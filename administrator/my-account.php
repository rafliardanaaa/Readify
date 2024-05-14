<?php
    session_start();

    if(!isset($_SESSION['pengelola'])) {
        header("location:../sign-in.php");
        exit;
    }

    $user = $_SESSION['pengelola'];

    require 'connection/connect.php';

    $account = query("SELECT * FROM user WHERE Username = '$user'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../img/readify-main.png">
    <title>Readify - Administrator</title>
</head>
<body class="bg-slate-100">
    <div class="flex">
        <aside class="bg-sky-600 h-screen w-72 rounded-r-2xl shadow-lg">
            <div class="py-6 text-center">
                <a href="dashboard.php" class="text-white py-6 text-center text-lg font-semibold select-none">Readify Admin</a>
            </div>
            <div class="py-6 font-semibold">
                <div class="mt-40">
                    <a href="dashboard.php">
                        <div class="text-slate-300 px-10 py-3 font-semibold hover:text-white">
                            <p>Dashboard</p>
                        </div>
                    </a>
                    <a href="account-list.php">
                        <div class="text-slate-300 px-10 py-3 font-semibold hover:text-white">
                            <p>Kelola Akun</p>
                        </div>
                    </a>
                    <a href="loan-list.php">
                        <div class="text-slate-300 px-10 py-3 font-semibold hover:text-white">
                            <p>Daftar Pinjaman</p>
                        </div>
                    </a>
                </div>
            </div>
        </aside>
        <main class="h-screen w-screen">
            <nav class="h-20 px-12 flex justify-between items-center">
                <div class="flex justify-center items-center">
                    <p class="text-sky-600 text-lg font-bold">Profil</p>
                    <p class="pl-1 text-sky-600 text-lg font-semibold">Administrator</p>
                </div>
                 <a href="sign-out.php" class="text-gray-400 font-semibold underline hover:text-sky-600">Keluar</a>        
            </nav>
            <div class="px-8">
                <div class="bg-sky-600 h-44 p-6 rounded-lg shadow-md">
                    <p class="text-white text-xl font-semibold">Halo, Pengelola</p>
                </div>
                <div class="bg-white w-full p-4 rounded-lg shadow-md">
                    <div class="">
                        <p class="text-lg font-semibold">Informasi Data Diri</p>
                    </div>
                    <?php foreach($account as $row): ?>
                    <div class="my-2">
                        <p>Nama Lengkap</p>
                        <p><?= $row['NamaLengkap']; ?></p>
                        <p>Alamat Email</p>
                        <p>Alamat</p>
                        <p>No. Telepon</p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
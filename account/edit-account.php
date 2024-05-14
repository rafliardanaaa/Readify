<?php
    session_start();

    if(!isset($_SESSION['peminjam'])) {
        header("location:../../index.php");
        exit;
    }

    require 'connection/connect.php';

    if(isset($_POST['edit'])) {
        if(edit($_POST) > 0) {
            echo "
                <script>
                    alert('Data diri berhasil diubah')
                    document.location.href = 'manage-account.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Data diri gagal diubah')
                    document.location.href = 'manage-account.php';
                </script>
            ";
        }
    }

    $user = $_SESSION['peminjam'];

    $account = query("SELECT * FROM user WHERE Username = '$user'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../img/readify-main.png">
    <title>Readify - Digital Library</title>
</head>
<body class="bg-slate-100">
    <nav class="bg-sky-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex justify-center items-center">
                <a href="../../index.php">
                    <img src="../img/readify.png" alt="Readify Logo" class="h-8">
                </a>
                <a href="../../index.php" class="px-1 text-white text-lg font-semibold">Readify</a>
            </div>
            <div class="flex space-x-10">
                <a href="" class="text-white hover:text-gray-300">Pinjam</a>
                <a href="" class="text-white hover:text-gray-300">Ketentuan</a>
                <a href="../../index.php" class="text-white hover:text-gray-300">Beranda</a>
                <a href="" class="text-white hover:text-gray-300">Koleksi</a>
                <a href="manage-account.php" class="text-gray-300">Akun</a>
            </div>
            <div class="">
                <a href="../sign-out.php" class="text-white hover:text-gray-300">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="h-[873px] p-8 flex">
        <aside class="w-1/5 mr-3">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <div class="">
                    <p class="font-semibold">Koleksi Saya</p>
                    <p class="">Tidak ada</p>
                </div>
            </div>
            <div class="bg-white my-6 p-4 rounded-lg shadow-md">
                <a href="manage-account.php">
                    <div class="px-10 py-2 text-slate-400 flex items-center rounded-md hover:bg-slate-200 hover:text-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <p class="mx-3 font-semibold">Kelola Akun</p>
                    </div>
                </a>
                <a href="change-password.php">
                    <div class="my-2 px-10 py-2 text-slate-400 flex items-center rounded-md hover:bg-slate-200 hover:text-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        <p class="mx-3 font-semibold">Ganti Password</p>
                    </div>
                </a>
                <a href="my-loan.php">
                    <div class="my-2 px-10 py-2 text-slate-400 flex items-center rounded-md hover:bg-slate-200 hover:text-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                        </svg>
                        <p class="mx-3 font-semibold">Riwayat Pinjaman</p>
                    </div>
                </a>
                <a href="">
                    <div class="px-10 py-2 text-slate-400 flex items-center rounded-md hover:bg-slate-200 hover:text-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                        </svg>
                        <p class="mx-3 font-semibold">Riwayat Ulasan</p>
                    </div>
                </a>
            </div>
        </aside>
        <main class="w-4/5 ml-3">
            <?php foreach ($account as $row): ?>
            <div class="bg-white h-full p-4 rounded-lg shadow-md">
                <div class="bg-slate-200 p-6 border-sky-600 border-2 rounded-md">
                    <p class="text-sky-600 text-xl font-semibold">Sunting Akun</p>
                    <p class="mt-2 text-sky-600">Selamat datang di halaman kelola akun Anda! Di sini, Anda dapat dengan mudah mengelola informasi pribadi dan aktivitas peminjaman Anda</p>
                </div>
                <div class="mt-4 px-2">
                    <form action="" method="post">
                        <input type="hidden" name="user_id" value="<?= $row['UserID'] ?>">
                        <input type="hidden" name="username" value="<?= $row['Username']; ?>">
                        <input type="hidden" name="password" value="<?= $row['Password']; ?>">
                        <p class="ml-2.5 font-semibold">Nama Lengkap</p>
                        <input type="text" name="fullname" value="<?= $row['NamaLengkap']; ?>" class="bg-white my-2 border-gray-400 border w-full px-3 py-1.5 rounded-md focus:outline-none focus:border-sky-600 focus:border" autocomplete="off"> <br>
                        <p class="ml-2.5 font-semibold">Alamat Email</p>
                        <input type="text" name="email" value="<?= $row['Email']; ?>" class="bg-white my-2 border-gray-400 border w-full px-3 py-1.5 rounded-md focus:outline-none focus:border-sky-600 focus:border" autocomplete="off"> <br>
                        <p class="ml-2.5 font-semibold">Alamat Rumah</p>
                        <input type="text" name="address" value="<?= $row['Alamat']; ?>" class="bg-white my-2 border-gray-400 border w-full px-3 py-1.5 rounded-md focus:outline-none focus:border-sky-600 focus:border" autocomplete="off"> <br>
                        <button type="submit" name="edit" class="bg-slate-200 w-full mt-4 py-1.5 text-slate-400 rounded-md hover:bg-sky-600 hover:text-white">Sunting</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </main>
    </div>
</body>
</html>
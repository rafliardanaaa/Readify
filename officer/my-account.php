<?php
    session_start();

    if(!isset($_SESSION['petugas'])) {
        header("location:../sign-in.php");
        exit();
    }

    require 'connection/connect.php';

    $username = $_SESSION['petugas'];

    $officer = query("SELECT * FROM user WHERE Username = '$username'");

    $account = query("SELECT * FROM user WHERE Username = '$username'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../img/readify-main.png">
    <title>Readify - Officer</title>
</head>
<body class="bg-slate-100">
    <div class="flex">
        <aside class="bg-sky-600 h-screen w-72 rounded-r-2xl shadow-lg">
            <div class="py-6 text-center">
                <a href="" class="text-white py-6 text-center text-lg font-semibold select-none">Readify Officer</a>
            </div>
            <div class="py-6 font-semibold">
                <div class="mt-40">
                    <a href="dashboard.php">
                        <div class="text-slate-300 px-10 py-3 font-semibold hover:text-white">
                            <p>Dashboard</p>
                        </div>
                    </a>
                    <a href="book-list.php">
                        <div class="text-slate-300 px-10 py-3 font-semibold hover:text-white">
                            <p>Kelola Buku</p>
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
                    <p class="pl-1 text-sky-600 text-lg font-semibold">Petugas</p>
                </div>
                 <a href="sign-out.php" class="text-gray-400 font-semibold underline hover:text-sky-600">Keluar</a>        
            </nav>
            <div class="px-8 h-[860px]">
                <div class="bg-white h-44 p-6 rounded-lg shadow-md">
                    <p class="text-white text-xl font-semibold">Halo, Petugas</p>
                </div>
                <div class="flex">
                    <div class="bg-white w-full my-4 p-4 rounded-lg shadow-md">
                        <div class="bg-sky-600 p-2 rounded-md">
                            <p class="text-white text-lg font-semibold">Informasi Akun</p>
                        </div>
                        <div class="my-2">
                            <p>Username :</p>
                            <p>Password :</p>
                        </div>
                        <div class="bg-yellow-100 mt-2 p-2 flex items-center rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-yellow-500 ml-1 mr-3        stroke-2 w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <p class="text-sm">Konfirmasi kepada Administrator jika ingin mengganti kata sandi Anda!</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white w-full p-4 rounded-lg shadow-md">
                    <div class="flex items-end">
                        <p class="text-lg font-semibold">Informasi Data Diri</p>
                    </div>
                    <?php foreach($account as $row): ?>
                    <div class="my-2">
                        <p class="ml-2.5 font-semibold">Nama Lengkap</p>
                        <input type="text" value="<?= $row['NamaLengkap']; ?>" class="bg-white my-2 border-sky-600 border w-full px-3 py-1.5 rounded-md" disabled>
                        <p class="ml-2.5 font-semibold">Alamat Email</p>
                        <input type="text" value="<?= $row['Email']; ?>" class="bg-white my-2 border-sky-600 border w-full px-3 py-1.5 rounded-md" disabled>
                        <p class="ml-2.5 font-semibold">Alamat Rumah</p>
                        <input type="text" value="<?= $row['Alamat']; ?>" class="bg-white my-2 border-sky-600 border w-full px-3 py-1.5 rounded-md" disabled>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
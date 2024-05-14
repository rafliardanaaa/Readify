<?php
    session_start();

    if(!isset($_SESSION['peminjam'])) {
        header("location:../index.php");
        exit;
    }

    require 'connect.php';

    $user = $_SESSION['peminjam'];

    $username = query("SELECT * FROM user WHERE Username = '$user'");

    foreach($username as $row) {
        $user_id = $row['UserID'];
    }

    $my_collection = mysqli_query($conn, "SELECT koleksipribadi.*, user.*, buku.* FROM koleksipribadi
                    INNER JOIN user ON koleksipribadi.UserID = user.UserID
                    INNER JOIN buku ON koleksipribadi.BukuID = buku.BukuID
                    WHERE koleksipribadi.UserID = '$user_id' ORDER BY koleksipribadi.BukuID DESC")
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
                <a href="visit.php" class="text-white hover:text-gray-300">Kunjungan</a>
                <a href="../../index.php" class="text-white hover:text-gray-300">Beranda</a>
                <a href="" class="text-gray-300">Koleksi</a>
                <a href="account/manage-account.php" class="text-white hover:text-gray-300">Akun</a>
            </div>
            <div class="">
                <a href="../sign-out.php" class="text-white hover:text-gray-300">Keluar</a>
            </div>
        </div>
    </nav>
    <main class="h-[881px] p-8">
        <?php if(empty($my_collection)): ?>
        <div class="h-full flex justify-center items-center">
            <div class="">
                <div class="flex justify-center items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-slate-300 w-20 h-20">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 0 0 5.636 5.636m12.728 12.728A9 9 0 0 1 5.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <p class="mt-4 text-slate-300 font-semibold text-center">Koleksi Kosong Tambahkan Koleksi. <a href="books/book-list.php" class="text-sky-600 hover:underline">Klik</a></p>
            </div>
        </div>
        <?php else: ?>
            <div class="px-60 py-20">
                <div class="bg-white mb-10 flex items-center rounded-md focus-within:shadow-md">
                    <div class="h-full w-24 text-gray-300 grid place-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="search" name="search" class="text-gray-700 w-full pr-2 py-3 outline-none rounded-md" placeholder="Cari buku disini" autocomplete="off"/> 
                </div>
                <div class="grid grid-cols-5 gap-6">
                    <?php foreach($my_collection as $row): ?>
                    <a href="books/loan-form.php?code=<?= $row['Kode']; ?>">
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <img src="assets/img/<?= $row['Gambar']; ?>" alt="" class="h-80 w-full rounded-md">
                            <div class="mt-3 px-0.5">
                                <p class="font-semibold"><?= $row['Judul']; ?></p>
                                <p class=""><?= $row['TahunTerbit']; ?></p>
                            </div>
                        </div>
                    </a>

                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
      
        
    </main>
</body>
</html>
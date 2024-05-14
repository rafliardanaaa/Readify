<?php
    session_start();

    if(!isset($_SESSION['petugas'])) {
        header("location:../sign-in.php");
        exit();
    }

    require 'connection/connect.php';

    $username = $_SESSION['petugas'];

    $officer = query("SELECT * FROM user WHERE Username = '$username'");

    $waiting_loan = mysqli_query($conn, "SELECT peminjaman.*, user.*, buku.* FROM peminjaman
            INNER JOIN user ON peminjaman.UserID = user.UserID
            INNER JOIN buku ON peminjaman.BukuID = buku.BukuID
            WHERE peminjaman.Status = '0' ORDER BY peminjaman.Dipinjam DESC LIMIT 6");

    $new_loan = mysqli_query($conn, "SELECT peminjaman.*, user.*, buku.* FROM peminjaman
            INNER JOIN user ON peminjaman.UserID = user.UserID
            INNER JOIN buku ON peminjaman.BukuID = buku.BukuID
            WHERE peminjaman.Status = '1' OR peminjaman.Status = '2' ORDER BY peminjaman.Dipinjam DESC LIMIT 6");

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
                    <a href="">
                        <div class="bg-sky-700 border-white text-white px-10 py-3 font-semibold">
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
                    <p class="text-sky-600 text-lg font-bold">Dashboard</p>
                    <p class="pl-1 text-sky-600 text-lg font-semibold">Petugas</p>
                </div>
                <?php foreach($officer as $row): ?>
                <a href="my-account.php" class="text-gray-400 font-semibold hover:text-sky-600 hover:underline"><?= $row['NamaLengkap']; ?></a>  
                <?php endforeach; ?>      
            </nav>
            <div class="h-[865px] px-8">
                <div class="h-1/3 pb-5">
                    <div class="bg-white h-full w-full p-4 rounded-lg shadow-md">
                        <div class="bg-sky-600 h-20 rounded-lg"></div>
                        <p>asd</p>
                    </div>
                </div>
                <div class="h-2/3">
                    <div class="flex w-full h-full pb-8">
                        <div class="h-full w-3/4 pr-5">
                            <div class="h-1/3 pb-5">
                                <div class="h-full grid grid-cols-3 gap-5">
                                    <div class="bg-white p-4 rounded-lg shadow-md">
                                        <div class="h-3/4">

                                        </div>
                                        <hr class="border-slate-300 border-1.5 rounded-full">
                                        <div class="h-1/4 flex justify-end items-end hover:underline">
                                            <a href="" class="text-sky-600 text-sm">Selengkapnya</a>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-md">
                                        <div class="h-3/4">

                                        </div>
                                        <div class="h-1/4 flex justify-end items-end hover:underline">
                                            <a href="" class="text-sky-600 text-sm">Selengkapnya</a>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-md">
                                        <div class="h-3/4">

                                        </div>
                                        <div class="h-1/4 flex justify-end items-end hover:underline">
                                            <a href="" class="text-sky-600 text-sm">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="h-2/3">
                                <div class="bg-white h-full p-4 rounded-lg shadow-md">
                                    <p class="font-semibold">Peminjaman Teraru</p>
                                    <div class="mt-4">
                                        <div class="flex justify-between items-center">
                                            <div class="w-3/12  ">
                                                <p class="text-sm font-semibold">Nama Peminjam</p>
                                            </div>
                                            <div class="w-3/12">
                                                <p class="text-sm font-semibold">Judul Buku</p>
                                            </div>
                                            <div class="w-5/12 text-center">
                                                <p class="text-sm font-semibold">Waktu</p>
                                            </div>
                                            <div class="w-1/12 text-center">
                                                <p class="text-sm font-semibold">Status</p>
                                            </div>
                                        </div>
                                        <hr class="border-slate-200 border-1.5 my-3 rounded-full">
                                        <?php foreach($new_loan as $row): ?>
                                        <div class="my-5 flex justify-between items-center">
                                            <div class="w-3/12  ">
                                                <p class="text-sm font-semibold"><?= $row['NamaLengkap']; ?></p>
                                            </div>
                                            <div class="w-3/12">
                                                <p class="text-sm font-semibold"><?= $row['Judul']; ?></p>
                                            </div>
                                            <div class="w-5/12 text-center">
                                                <p class="text-sm font-semibold"><?= $row['Dipinjam']; ?> s/d <?= $row['BatasPeminjaman']; ?></p>
                                            </div>
                                            <div class="w-1/12 flex justify-center items-center">
                                        
                                                <div class="bg-green-400 bg-opacity-30 px-4 py-1 rounded-full">
                                                    <p class="text-green-500 text-xs font-semibold">Dipinjam</p>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="h-full w-1/4">
                            <div class="bg-white h-full p-4 rounded-lg shadow-md">
                                <div class="flex justify-between items-center">
                                    <p class="font-semibold">Menunggu Respon</p>
                                    <a href="loan-list.php" class="text-sky-600 text-sm hover:underline">Selengkapnya</a>
                                </div>
                                <div class="mt-4">
                                    <?php foreach($waiting_loan as $row): ?>
                                    <div class="border-slate-400 border h-fit mb-3.5 py-2 px-3 rounded-md">
                                        <p class="font-semibold"><?= $row['NamaLengkap']; ?></p>
                                        <div class="flex justify-between items-center">
                                            <p>Bumi - Tere Liye</p>
                                            <p><?= $row['Kode']; ?></p>
                                        </div>
                                      
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
       
    </div>
</body>
</html>
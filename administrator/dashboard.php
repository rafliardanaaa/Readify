<?php
    session_start();

    if(!isset($_SESSION['pengelola'])) {
        header("location:../sign-in.php");
        exit();
    }

    require 'connection/connect.php';

    $username = $_SESSION['pengelola'];

    $admin = query("SELECT * FROM user WHERE Username = '$username'");
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
                <a href="" class="text-white py-6 text-center text-lg font-semibold select-none">Readify Admin</a>
            </div>
            <div class="py-6 font-semibold">
                <div class="mt-40">
                    <a href="">
                        <div class="bg-sky-700 border-white text-white px-10 py-3 font-semibold">
                            <p>Dashboard</p>
                        </div>
                    </a>
                    <a href="account-list.php">
                        <div class="text-slate-300 px-10 py-3 font-semibold hover:text-white">
                            <p>Kelola Akun</p>
                        </div>
                    </a>
                    <a href="book-list.php">
                        <div class="text-slate-300 px-10 py-3 font-semibold hover:text-white">
                            <p>Kelola Buku</p>
                        </div>
                    </a>
                </div>
            </div>
        </aside>
        <main class="h-screen w-screen">
            <nav class="h-20 px-12 flex justify-between items-center">
                <div class="flex justify-center items-center">
                    <p class="text-sky-600 text-lg font-bold">Dashboard</p>
                    <p class="pl-1 text-sky-600 text-lg font-semibold">Administrator</p>
                </div>
                <div class="flex items-center">
                    <a href="">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 mx-6 w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                        </svg>
                    </a>
                    <a href="my-account.php" class="text-gray-400 font-semibold underline hover:text-sky-600">Administrator</a>        
                </div>
            </nav>
            <div class="h-[865px] px-8">
                <div class="h-1/3 pb-5">
                    <div class="bg-white h-full w-full p-4 rounded-lg shadow-md">
                        <div class="bg-sky-600 h-20 p-4 rounded-lg">
                            <p class="text-white text-lg font-semibold">Selamat Datang, Admin berikan kesan terbaik untuk peminjam</p>
                        </div>
                        <p>asd</p>
                    </div>
                </div>
                <div class="h-2/3">
                    <div class="flex w-full h-full pb-8">
                        <div class="h-full w-3/4 pr-5">
                            <div class="h-1/3 pb-5">
                                <div class="h-full grid grid-cols-3 gap-5">
                                    <div class="bg-white p-4 rounded-lg shadow-md">
                                        <div class="h-3/4 flex">
                                            <div class="bg-sky-600 h-full w-1/3 text-white rounded-lg">
                                                <p class="text-white text-xl font-bold">70</p>
                                            </div>
                                            <div class="">
                                                <p>Petugas</p>
                                            </div>
                                        </div>
                                        <div class="h-1/4 flex justify-end items-end hover:underline">
                                            <a href="officer-list.php" class="text-sky-600 text-sm">Selengkapnya</a>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-md">
                                        <div class="h-3/4">

                                        </div>
                                        <div class="h-1/4 flex justify-end items-end hover:underline">
                                            <a href="account-list.php" class="text-sky-600 text-sm">Selengkapnya</a>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 rounded-lg shadow-md">
                                        <div class="h-3/4">

                                        </div>
                                        <div class="h-1/4 flex justify-end items-end hover:underline">
                                            <a href="book-list.php" class="text-sky-600 text-sm">Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="h-2/3">
                                <div class="bg-white h-full p-4 rounded-lg shadow-md">
                                    <p class="font-semibold">Informasi</p>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="h-full w-1/4">
                            <div class="bg-white h-full p-4 rounded-lg shadow-md">
                                <div class="flex justify-between items-center">
                                    <p class="font-semibold">Peminjaman Baru</p>
                                    <a href="loan-list.php" class="text-sky-600 text-sm hover:underline">Selengkapnya</a>
                                </div>
                                <div class="mt-4">
                           
                                    
                                
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
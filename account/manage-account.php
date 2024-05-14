<?php
    session_start();

    if(!isset($_SESSION['peminjam'])) {
        header("location:../../index.php");
        exit;
    }

    require 'connection/connect.php';

    $user = $_SESSION['peminjam'];

    $username = query("SELECT * FROM user WHERE Username = '$user'");

    foreach($username as $row) {
        $user_id = $row['UserID'];
    }

    $account = query("SELECT * FROM user WHERE Username = '$user'");

    $collection = mysqli_query($conn, "SELECT COUNT(*) AS collection_count FROM koleksipribadi WHERE UserID = '$user_id'");
    $row = mysqli_fetch_assoc($collection);
    $my_collection_amount = $row['collection_count'];
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
                <a href="../books/loan-box.php" class="text-white hover:text-gray-300">Pinjam</a>
                <a href="../visit.php" class="text-white hover:text-gray-300">Kunjungan</a>
                <a href="../../index.php" class="text-white hover:text-gray-300">Beranda</a>
                <a href="../my-collection.php" class="text-white hover:text-gray-300">Koleksi</a>
                <a href="" class="text-gray-300">Akun</a>
            </div>
            <div class="">
                <a href="../sign-out.php" class="text-white hover:text-gray-300">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="h-[873px] p-8 flex">
        <aside class="w-1/5 mr-3">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <div class="px-10 flex items-center">
                    <div class=" p-2 flex justify-center items-center rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                        </svg>
                    </div>
                    <div class="mx-3">
                        <p class="font-semibold">Koleksi Saya <?php echo $my_collection_amount; ?></p>
                            <a href="../my-collection.php" class="text-slate-400 hover:text-sky-600 hover:underline">Selengkapnya</a>
                    </div>
                   
                </div>
            </div>
            <div class="bg-white my-6 p-4 rounded-lg shadow-md">
                <a href="">
                    <div class="bg-slate-200 text-sky-600 px-10 py-2 flex items-center rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <p class="text-sky-600 mx-3 font-semibold">Kelola Akun</p>
                    </div>
                </a>
                <a href="change-password.php">
                    <div class="mt-2 px-10 py-2 text-slate-400 flex items-center rounded-md hover:bg-slate-200 hover:text-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        <p class="mx-3 font-semibold">Ganti Password</p>
                    </div>
                </a>
                <a href="my-loan.php">
                    <div class="mt-2 px-10 py-2 text-slate-400 flex items-center rounded-md hover:bg-slate-200 hover:text-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                        </svg>
                        <p class="mx-3 font-semibold">Riwayat Pinjaman</p>
                    </div>
                </a>
                <a href="my-review.php">
                    <div class="mt-2 px-10 py-2 text-slate-400 flex items-center rounded-md hover:bg-slate-200 hover:text-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                        </svg>
                        <p class="mx-3 font-semibold">Riwayat Ulasan</p>
                    </div>
                </a>
                <a href="settings.php">
                    <div class="mt-2 px-10 py-2 text-slate-400 flex items-center rounded-md hover:bg-slate-200 hover:text-sky-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <p class="mx-3 font-semibold">Pengaturan</p>
                    </div>
                </a>
            </div>
        </aside>
        <main class="w-4/5 ml-3">
            <?php foreach ($account as $row): ?>
            <div class="bg-white h-full p-4 rounded-lg shadow-md">
                <div class="bg-slate-200 p-6 border-sky-600 border-2 rounded-lg">
                    <p class="text-sky-600 text-xl font-semibold">Hi, <?= $row['NamaLengkap']; ?></p>
                    <p class="mt-2 text-sky-600">Selamat datang di halaman kelola akun Anda! Di sini, Anda dapat dengan mudah mengelola informasi pribadi dan aktivitas peminjaman Anda</p>
                </div>
                <div class="mt-4 px-2">
                    <p class="ml-2.5 font-semibold">Nama Lengkap</p>
                    <input type="text" value="<?= $row['NamaLengkap']; ?>" class="bg-white my-2 border-sky-600 border w-full px-3 py-1.5 rounded-md" disabled>
                    <p class="ml-2.5 font-semibold">Alamat Email</p>
                    <input type="text" value="<?= $row['Email']; ?>" class="bg-white my-2 border-sky-600 border w-full px-3 py-1.5 rounded-md" disabled>
                    <p class="ml-2.5 font-semibold">Alamat Rumah</p>
                    <input type="text" value="<?= $row['Alamat']; ?>" class="bg-white my-2 border-sky-600 border w-full px-3 py-1.5 rounded-md" disabled>
                </div>
                <div class="mx-2.5 my-2 flex justify-end">
                    <a href="edit-account.php" class="text-slate-400 hover:text-sky-600">Sunting</a>
                </div>
                <div class="px-2">
                    <div class="flex justify-between items-center">
                        <p class="ml-2.5 font-semibold">Enkripsi Akun</p>
                        <div class="bg-slate-200 h-6 w-16 flex items-center rounded-full">
                            <div class="bg-slate-400 h-3 w-3 mx-2 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </main>
    </div>
</body>
</html>
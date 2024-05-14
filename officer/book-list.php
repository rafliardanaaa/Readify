<?php
    session_start();

    if(!isset($_SESSION['petugas'])) {
        header("location:../sign-in.php");
        exit();
    }

    require 'connection/connect.php';

    $username = $_SESSION['petugas'];

    $officer = query("SELECT * FROM user WHERE Username = '$username'");

    $jumlahDataPerhalaman = 13;
    $jumlahData = count(query("SELECT * FROM buku"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
    $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $jumlahAktif = (isset($_GET["jumlah"])) ? $_GET["jumlah"] : 1;
    $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

    $book = query("SELECT * FROM buku ORDER BY BukuID DESC LIMIT $awalData, $jumlahDataPerhalaman");
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
                    <a href="">
                        <div class="bg-sky-700 border-white text-white px-10 py-3 font-semibold">
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
                    <p class="text-sky-600 text-lg font-bold">Kelola Buku</p>
                    <p class="pl-1 text-sky-600 text-lg font-semibold">Petugas</p>
                </div>
                <?php foreach($officer as $row): ?>
                <a href="my-account.php" class="text-gray-400 font-semibold hover:text-sky-600 hover:underline"><?= $row['NamaLengkap']; ?></a>  
                <?php endforeach; ?>     
            </nav>
            <div class="px-8">
                <div class="flex justify-between">
                    <div class="px-2">
                        <ul class="flex items-center">
                            <li class="inline-flex items-center">
                                <a href="dashboard.php">
                                    <svg class="w-5 h-auto fill-current mx-2 text-gray-400 hover:text-sky-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10 19v-5h4v5c0 .55.45 1 1 1h3c.55 0 1-.45 1-1v-7h1.7c.46 0 .68-.57.33-.87L12.67 3.6c-.38-.34-.96-.34-1.34 0l-8.36 7.53c-.34.3-.13.87.33.87H5v7c0 .55.45 1 1 1h3c.55 0 1-.45 1-1z"/></svg>
                                </a>
                                <svg class="w-5 h-auto fill-current mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z"/></svg>
                            </li>
                            <li class="inline-flex items-center">
                                <a href="" class="text-sky-600">Kelola Buku</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full my-4 flex justify-between">
                    <div class="flex">
                        <div class="">
                            <div class="px-4 py-3">
                                <a href="" class="font-semibold text-sky-600">Kelola Buku</a>
                            </div>
                            <hr class="mx-6 border-sky-600 border-2 rounded-lg">
                        </div>
                        <div>
                            <div class="px-4 py-3">
                                <a href="category-list.php" class="font-semibold hover:text-sky-600">Kelola Kategori</a>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="mr-2">
                            <a href="book-list/print-book.php" target="blank">
                                <div class="bg-white px-4 py-3 text-gray-400 font-semibold rounded-md hover:text-sky-600 hover:shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="mr-2">
                            <a href="book-list/add-book.php">
                                <div class="bg-white px-4 py-3 text-gray-400 font-semibold rounded-md hover:text-sky-600 hover:shadow-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </div>
                            </a>
                        </div>
                        <div class="bg-white flex items-center rounded-md focus-within:shadow-md">
                            <div class="h-full w-24 text-gray-300 grid place-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="keyword" class="text-gray-700 w-full pr-2 py-3 outline-none rounded-md" placeholder="Cari buku disini" autocomplete="off"/> 
                        </div>
                    </div>
                </div>
                <div class="bg-white py-4 rounded-lg shadow-md">
                    <table class="w-full">
                        <tr class="">
                            <th class="w-1/12 pb-4">Kode</th>
                            <th class="w-2/12 pb-4">Judul Buku</th>
                            <th class="w-1/12 pb-4">Penulis</th>
                            <th class="w-2/12 pb-4">Penerbit</th>
                            <th class="w-1/12 pb-4">Tahun Terbit</th>
                            <th class="w-1/12 pb-4">Stok</th>
                            <th class="w-1/12 pb-4">Tersedia</th>
                            <th class="w-1/12 pb-4">Terpinjam</th>
                            <th class="w-1/12 pb-4">Gambar</th>
                            <th class="w-1/12 pb-4">Kelola</th>
                        </tr>
                        <?php foreach($book as $row): ?>
                        <tr>
                            <td class="text-center"><?= strtoupper($row['Kode']); ?></td>
                            <td class="px-4"><?= $row['Judul']; ?></td>
                            <td class="px-4"><?= $row['Penulis']; ?></td>
                            <td class="px-4 line-clamp "><?= $row['Penerbit']; ?></td>
                            <td class="text-center"><?= $row['TahunTerbit']; ?></td>
                            <td class="text-center"><?= $row['Stok']; ?></td>
                            <td class="text-center"><?= $row['Tersedia']; ?></td>
                            <td class="text-center"><?= $row['Terpinjam']; ?></td>
                            <td class="text-center"><a href="../assets/img/<?= $row['Gambar']; ?>" target="blank" class="text-blue-500 hover:underline">Lihat Detail</a></td>
                            <td class="py-3.5 flex justify-evenly items-center">
                                <a href="book-list/edit-book.php?id=<?= $row['BukuID']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 stroke-2 h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                </a>
                                <a href="book-list/delete.php?id=<?= $row['BukuID']; ?>" onclick="return confirm('Yakin menghapus buku?');">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 stroke-2 h-4 w-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="my-4 flex justify-between items-center">
                    <div class="px-4">
                        <p class="text-sm">Menampilkan <?php echo $jumlahDataPerhalaman ?> dari <?php echo $jumlahData ?> buku</p>
                    </div>
                    <div>
                        <?php if( $halamanAktif > 1 ) : ?>
                            <a class="laquo" href="?halaman=<?= $halamanAktif - 1; ?>" disabled>
                                <div class="bg-white text-slate-400 mr-1.5 w-12 h-12 flex justify-center items-center rounded-md hover:text-sky-600 hover:shadow-md">❮</div>
                            </a>
                        <?php endif; ?>

                        <?php if( $halamanAktif < $jumlahHalaman ) : ?>
                            <a href="?halaman=<?= $halamanAktif + 1; ?>">
                                <div class="bg-white text-slate-400 mr-1.5 w-12 h-12 flex justify-center items-center rounded-md hover:text-sky-600 hover:shadow-md">❯</div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>      
        </main>
    </div>
</body>
</html>
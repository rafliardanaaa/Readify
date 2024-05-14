<?php
    session_start();

    if(!isset($_SESSION['petugas'])) {
        header("location:../sign-in.php");
        exit();
    }

    require 'connection/connect.php';

    $username = $_SESSION['petugas'];

    $officer = query("SELECT * FROM user WHERE Username = '$username'");

    $amount_data_perpage = 16;
    $amount_data = count(query("SELECT * FROM buku"));
    $amount_page = ceil($amount_data / $amount_data_perpage);
    $active_page = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $amount_active = (isset($_GET["jumlah"])) ? $_GET["jumlah"] : 1;
    $first_page = ($amount_data_perpage * $active_page) - $amount_data_perpage;

    $loan = "SELECT peminjaman.*, user.*, buku.*  FROM peminjaman
            INNER JOIN user ON peminjaman.UserID = user.UserID
            INNER JOIN buku ON peminjaman.BukuID = buku.BukuID
            WHERE Peminjaman.Status = '0' LIMIT $first_page, $amount_data_perpage ";

    $loan_list = mysqli_query($conn, $loan);


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
                    <a href="">
                        <div class="bg-sky-700 border-white text-white px-10 py-3 font-semibold">
                            <p>Daftar Pinjaman</p>
                        </div>
                    </a>
                </div>
            </div>
        </aside>
        <main class="h-screen w-screen">
            <nav class="h-20 px-12 flex justify-between items-center">
                <div class="flex justify-center items-center">
                    <p class="text-sky-600 text-lg font-bold">Daftar Pinjaman</p>
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
                                <a href="" class="text-sky-600">Menunggu Respon</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="w-full my-4 flex justify-between items-center">
                    <div class="flex">
                        <div class="">
                            <div class="px-4 py-3">
                                <a href="" class="font-semibold text-sky-600">Menunggu Respon</a>
                            </div>
                            <hr class="mx-6 border-sky-600 border-2 rounded-full">
                        </div>
                        <div class="">
                            <div class="px-4 py-3">
                                <a href="in-loan.php" class="font-semibold hover:text-sky-600">Sedang Dipinjam</a>
                            </div>
                        </div>
                        <div>
                            <div class="px-4 py-3">
                                <a href="loan-history.php" class="font-semibold hover:text-sky-600">Riwayat Pinjaman</a>
                            </div>
                        </div>
                    </div>
                    <div class="">
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
                        <tr>
                            <th class="w-2/11 pb-4">Nama Lengkap</th>
                            <th class="w-1/11 pb-4">Kode Buku</th>
                            <th class="w-2/11 pb-4">Judul Buku</th>
                            <th class="w-1/11 pb-4">Kategori</th>
                            <th class="w-1/11 pb-4">Penulis</th>
                            <th class="w-1/11 pb-4">Penerbit</th>
                            <th class="w-1/11 pb-4">Tahun Terbit</th>
                            <th class="w-1/11 pb-4">Jumlah</th>
                            <th class="w-1/11 pb-4">Konfirmasi</th>
                        </tr>
          
                        <?php foreach($loan_list as $row): ?>
                        <tr>
                            <td class="px-4"><?= $row['NamaLengkap']; ?></td>
                            <td class="text-center"><?= $row['Kode']; ?></td>
                            <td class="px-4"><?= $row['Judul']; ?></td>
                            <!-- <td class="px-4"><?= $row1['NamaKategori']; ?></td> -->
                            <td class="px-4"><?= $row['Penulis']; ?></td>
                            <td class="px-4"><?= $row['Penerbit']; ?></td>
                            <td class="text-center"><?= $row['TahunTerbit']; ?></td>
                            <td class="text-center"><?= $row['Jumlah']; ?></td>
                            <td class="py-2.5 flex justify-center items-center">
                                <a href="loan-confirmation.php?id=<?= $row['PeminjamanID'] ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 w-6 h-6 hover:fill-sky-600 hover:text-white ">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
              
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="my-4 flex justify-between items-center">
                    <div class="px-4">
                        <?php
                            $show_data = ($active_page - 1) * $amount_data_perpage;
                        ?>
                        <p class="text-sm">Menampilkan 1 hingga <?php echo $show_data; ?> dari <?php echo $amount_data; ?> pinjaman</p>
                    </div>
                    <div>
                        <?php if( $active_page > 1 ) : ?>
                            <a class="laquo" href="?halaman=<?= $active_page - 1; ?>" disabled>
                                <div class="bg-white text-slate-400 mr-1.5 w-12 h-12 flex justify-center items-center rounded-md hover:text-sky-600 hover:shadow-md">❮</div>
                            </a>
                        <?php endif; ?>

                        <?php if( $active_page < $amount_page ) : ?>
                            <a href="?halaman=<?= $active_page + 1; ?>">
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
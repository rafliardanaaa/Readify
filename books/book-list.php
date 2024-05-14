<?php
    session_start();

    require 'connection/connect.php';

    function userStatus() {
        return isset($_SESSION['peminjam']);
    }

    $jumlahDataPerhalaman = 18;
    $jumlahData = count(query("SELECT * FROM buku"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
    $halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
    $jumlahAktif = (isset($_GET["jumlah"])) ? $_GET["jumlah"] : 1;
    $awalData = ($jumlahDataPerhalaman * ($halamanAktif - 1));

    $book = query("SELECT * FROM buku ORDER BY BukuID DESC LIMIT $awalData, $jumlahDataPerhalaman");

    $category = query("SELECT * FROM kategoribuku");
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
    <div class="left-8 top-8 flex items-center font-semibold absolute">
        <a href="../../index.php">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-slate-400 w-8 h-8 hover:fill-sky-600 hover:text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </a>
        <a href="../../index.php" class="mx-1.5 text-slate-400 hover:text-sky-600">Kembali</a>
    </div>
    <div class="px-44 py-20">
        <div class="mb-10 flex justify-between items-center">
            <div class="w-1/4 flex">
                <div class="bg-sky-600 w-1/3 px-2 py-2.5 rounded-s-md  ">
                    <p class="text-white font-semibold text-center">Kategori Buku</p>
                </div>
                <select name="" id="category" class="bg-white w-2/3">
                    <?php foreach($category as $row): ?>
                    <option value=""><?= $row['NamaKategori']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w-2/4">
                <div class="bg-white flex items-center rounded-md focus-within:shadow-md">
                    <div class="h-full w-24 text-gray-300 grid place-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="search" name="search" class="text-gray-700 w-full pr-2 py-2.5 outline-none rounded-md" placeholder="Cari buku disini" autocomplete="off"/> 
                </div>
            </div>

        </div>

        <div class="grid grid-cols-6 gap-6">
            <?php foreach ($book as $row): ?>
            <div class="bg-white p-3 rounded-md shadow-md">
                <div class="relative">
                    <img src="../assets/img/<?= $row['Gambar']; ?>" alt="<?= $row['Judul']; ?>" class="h-80 rounded object-cover size-52">
                </div>
                <div class="my-2">
                    <p class="font-semibold"><?= $row['Judul']; ?></p>
                    <p class="text-sm "><?= $row['Penulis']; ?></p>
                </div>
                <?php if($row['Tersedia'] <= 0): ?>
                    <div class="bg-slate-300 px-1 text-slate-400 text-center rounded">
                        <a href="" class="cursor-not-allowed ">
                            <p class="py-1 text-sm">Habis Terpinjam</p>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="bg-sky-600 px-1 text-white text-center rounded ">
                        <a href="loan-form.php?code=<?= $row['Kode']?>">
                            <p class="py-1 text-sm">Pinjam</p>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="my-4 flex justify-between items-center">
            <div class="px-4">
                <?php
                // Hitung nomor buku yang ditampilkan pada halaman saat ini
                $nomorBukuMulai = ($halamanAktif - 1) * $jumlahDataPerhalaman + 1;
                $nomorBukuAkhir = min($halamanAktif * $jumlahDataPerhalaman, $jumlahData);
                ?>
                <p class="text-sm">Menampilkan <?php echo $nomorBukuMulai ?> - <?php echo $nomorBukuAkhir ?> dari <?php echo $jumlahData ?> buku</p>
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
</body>
</html>
<?php
    session_start();

    if(!isset($_SESSION['peminjam'])) {
        header("location:../../index.php");
        exit;
    }

    $user = $_SESSION['peminjam'];

    require 'connection/connect.php';

    if(isset($_POST['add'])) {
        if(addCollections($_POST) > 0) {
            echo "
                <script>
                    alert('Ditambahkan ke Koleksi');
                    document.location.href = '';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Buku gagal dipinjam');
                    document.location.href = '';
                </script>
        ";
        }
    }

    if(isset($_POST['loan'])) {
        if(loan($_POST) > 0) {
            echo "
                <script>
                    alert('Anda Berhasil Meminjam Buku');
                    document.location.href = '../account/manage-account.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Jumlah Melebihi Stok Tersedia');
                    document.location.href = '';
                </script>
        ";
        }
    }

    $username = query("SELECT * FROM user WHERE Username = '$user'");

    foreach($username as $row) {
        $user_id = $row['UserID'];
    }

    $book_code = $_GET['code'];

    $book = query("SELECT * FROM buku WHERE Kode = '$book_code'");

    foreach($book as $row) {
        $book_id = $row['BukuID'];
        $author = $row['Penulis'];
    }

    $recomend = mysqli_query($conn, "SELECT * FROM buku WHERE Penulis = '$author' AND Kode != '$book_code' ORDER BY TahunTerbit DESC");

    $category_list = "SELECT kategoribuku_relasi.*, kategoribuku.*, buku.* FROM kategoribuku_relasi
                INNER JOIN kategoribuku ON kategoribuku_relasi.KategoriID = kategoribuku.kategoriID
                INNER JOIN buku ON kategoribuku_relasi.BukuID = buku.BukuID
                WHERE buku.Kode = '$book_code'";

    $category = mysqli_query($conn, $category_list);

    $review_list = "SELECT ulasanbuku.*, user.*, buku.* FROM ulasanbuku
                    INNER JOIN user ON ulasanbuku.UserID = user.UserID
                    INNER JOIN buku ON ulasanbuku.BukuID = buku.BukuID
                    WHERE buku.Kode = '$book_code'";

    $review = mysqli_query($conn, $review_list);

    $review_count = mysqli_query($conn, "SELECT COUNT(*) AS review_count FROM ulasanbuku WHERE BukuID = '$book_id'");
    $row = mysqli_fetch_assoc($review_count);
    $total_review = $row['review_count'];

    $my_collection = query("SELECT * FROM koleksipribadi WHERE BukuID = '$book_id' AND UserID = '$user_id'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../js/main.js"></script>
    <link rel="stylesheet" href="../css/swiper-bundle.min.css">
    <link rel="icon" href="../img/readify-main.png">
    <title>Readify - Digital Library</title>
</head>
<body class="bg-slate-100">
    <div class="left-8 top-8 flex items-center font-semibold absolute">
        <a href="book-list.php">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-slate-400 w-8 h-8 hover:fill-sky-600 hover:text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </a>
        <a href="book-list.php" class="mx-1.5 text-slate-400 hover:text-sky-600">Kembali</a>
    </div>
    <div class="h-screen p-8 flex">
        <div class="w-4/12">
            <div class="h-12">

            </div>
            <div class="h-[840px]">
                <div class="bg-white h-[360px] p-5 rounded-lg shadow-md relative">
                    <div class="h-4/6">
                        <p class="text-lg font-semibold">Deskripsi buku</p>
                        <p class="text-sm">Keterangan buku  </p>
                        <div class="my-4 flex">
                            <?php foreach($book as $row): ?>
                            <div class="w-1/3">
                                <p class="my-1 font-semibold">Kategori</p>
                                <p class="my-1 font-semibold">Judul</p>
                                <p class="my-1 font-semibold">Penulis</p>
                                <p class="my-1 font-semibold">Penerbit</p>
                                <p class="my-1 font-semibold">Tahun Terbit</p>
                            </div>
                            <div class="w-1/2">
                                <p class="my-1">: Novel</p>
                                <p class="my-1">: <?= $row['Judul'] ?></p>
                                <p class="my-1">: <?= $row['Penulis'] ?></p>
                                <p class="my-1">: <?= $row['Penerbit'] ?></p>
                                <p class="my-1">: <?= $row['TahunTerbit'] ?></p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="h-2/6 flex items-center">
                        <div class="w-1/6 text-jusitfy">
                            <?php foreach($book as $row): ?>
                            <p class="text-lg font-semibold text-justify">Kode Buku</p>
                            <p class="text-justify "><?= (strtoupper($row['Kode'])); ?></p>
                            <?php endforeach; ?>
                        </div>
                        <div class="w-5/6 flex justify-evenly items-center">
                            <?php foreach($book as $row): ?>
                            <p class="font-semibold">Tersedia : <?= $row['Tersedia'] ?></p>
                            <p class="font-semibold">Terpinjam : <?= $row['Terpinjam'] ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="h-1/6 flex justify-evenly items-center">
                        
                    </div>
                    <div class="bg-slate-200 h-10 p-2 top-0 right-6 shadow-md absolute">
                        <?php if($my_collection): ?>
                            <button type="submit" name="add" title="Koleksi saya" disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-sky-600 fill-sky-600 w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                </svg>
                            </button>
                        <?php else: ?>
                            <form action="" method="post">
                                <?php foreach($username as $row): ?>
                                <input type="hidden" name="user_id" value="<?= $row['UserID']; ?>">
                                <?php endforeach; ?>
                                <?php foreach($book as $row): ?>
                                <input type="hidden" name="book_id" value="<?= $row['BukuID']; ?>">
                                <?php endforeach; ?>
                                <button type="submit" name="add" title="Tambahkan koleksi saya">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="hover:text-sky-600 hover:fill-sky-600 w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                    </svg>
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="bg-white h-[440px] mt-8 p-5 rounded-lg shadow-md">
                    <div class="h-1/6">
                        <?php foreach($book as $row): ?>
                        <p class="text-lg font-semibold">Rekomendasi buku</p>
                        <p class="text-sm">Menampilkan karya dari <?= $row['Penulis']; ?></p>
                        <?php endforeach; ?>
                    </div>
                    <div class="h-5/6 swiper">
                        <div class="h-full p-2.5 flex overflow-hidden slide-content">   
                            <div class="swiper-wrapper">
                                <?php foreach($recomend as $row): ?>
                                <div class="border-slate-200 border h-full p-2.5 rounded-md swiper-slide">
                                    <img src="../assets/img/<?= $row['Gambar']; ?>" class="bg-sky-600 h-52 w-full rounded-md">
                                    <p class="px-1 pt-1.5 text-sm font-semibold"><?= $row['Judul']; ?></p>
                                    <p class="px-1 py-1 text-xs"><?= $row['TahunTerbit']; ?></p>
                                    <?php if($row['Tersedia'] <= 0): ?>
                                        <a href="" class="cursor-not-allowed">
                                            <div class="bg-slate-300 mt-2.5 text-white text-center rounded">
                                                <p class="py-1 text-slate-400 text-xs">Habis Terpinjam</p>
                                            </div>
                                        </a>   
                                    <?php else: ?>
                                        <a href="?code=<?= $row['Kode']; ?>">
                                            <div class="bg-sky-600 mt-2.5 text-white text-center rounded hover:bg-sky-700">
                                                <p class="py-1 text-xs">Pinjam</p>
                                            </div>
                                        </a>   
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <script src="../js/swiper-bundle.min.js"></script>
        <script src="../js/script.js"></script>
        <div class="bg-white w-4/12 mx-8 p-5 rounded-lg shadow-md relative">
            <div class="py-1 rounded">
                <p class="text-lg font-semibold text-center">Form Peminjaman</p>
            </div>
            <div class="mt-10">
                <?php foreach ($book as $row): ?>
                <form action="" method="post">
                    <input type="text" name="user_id" value="<?php echo $user_id; ?>" hidden>
                    <input type="text" name="book_id" value="<?php echo $book_id; ?>" hidden>
                    <div class="px-2.5 flex justify-between items-center">
                        <p class="font-semibold">Judul Buku</p>
                        <a href="explore/book-list.php" class="text-gray-400 text-sm underline hover:text-sky-600">Ganti buku</a>
                    </div>
                    <input type="text" value="<?= $row['Judul'] ?>" class="bg-white h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md" disabled>
                    <p class="pl-2.5 font-semibold">Penulis</p>
                    <input type="text" value="<?= $row['Penulis'] ?>" class="bg-white h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md" disabled>
                    <p class="pl-2.5 font-semibold">Penerbit</p>
                    <input type="text" value="<?= $row['Penerbit'] ?>" class="bg-white h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md" disabled>
                    <p class="pl-2.5 font-semibold">Tahun Terbit</p>
                    <input type="text" value="<?= $row['TahunTerbit'] ?>" class="bg-white h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md" disabled>
                    <p class="pl-2.5 font-semibold">Batas pinjaman</p>
                    <input type="date" name="limit" id="returned" class="h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md focus:outline-none focus:border-sky-600 focus:border-2" required>
                    <script>
                        datePicker();
                    </script>
                    <p class="pl-2.5 font-semibold">Jumlah Buku</p>
                    <input type="number" name="amount" min="1" placeholder="Masukan jumlah buku" class="h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md focus:outline-none focus:border-sky-600 focus:border-2" required>
                    <div class="bg-yellow-100 my-5 px-4 py-3 flex justify-between items-center rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-yellow-500 ml-1 mr-5 stroke-2 w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <p class="text-xs  text-justify">Apabila anda melebihi batas waktu yang dipilih, Petugas akan memberikan anda sanksi</p>
                    </div>
                    <button type="submit" name="loan" class="bg-sky-600 w-[546px] bottom-5 py-1.5 text-white text-center rounded-md hover:bg-sky-600 hover:text-white absolute">Pinjam</button>
                </form>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="bg-white w-4/12 p-5 rounded-lg shadow-md">
            <div class="py-1 flex justify-between items-center">
                <div class="">
                    <p class="text-lg font-semibold">Penilaian Buku</p>
                    <p class="text-sm">(<?php echo $total_review; ?> Ulasan)</p>
                </div>
                <a href="book-review.php?code=<?php echo $book_code ?>">
                    <div class="text-slate-400 flex items-center hover:text-sky-600">
                        <p class="mx-2">Lihat semua</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </a>
            </div>
            <div class="mt-10">
                <?php foreach($review as $row): ?>
                <div class="my-4">
                    <p class="font-semibold"><?= $row['NamaLengkap']; ?></p>
                    <div class="my-1.5 flex items-center">
                        <p class="text-slate-400 text-sm">Reaksi :</p>
                        <?php if($row['Rating'] == 1): ?>
                            <p class="mx-1.5 text-sky-600 text-sm">Tidak Puas</p>
                        <?php elseif($row['Rating'] == 2): ?>
                            <p class="mx-1.5 text-sky-600 text-sm">Puas</p>
                        <?php elseif($row['Rating'] == 3): ?>
                            <p class="mx-1.5 text-sky-600 text-sm">Sangat Puas</p>
                        <?php endif; ?>
                    </div>
                    <div class="my-1.5">
                        <p class=""><?= $row['Ulasan']; ?></p>
                    </div>
                    <p class="text-slate-400 text-sm"><?= $row['Dikirim']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        
        </div>
    </div>
   
</body>
</html>
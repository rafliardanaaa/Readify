<?php
    session_start();

    if(!isset($_SESSION['petugas'])) {
        header("location:../sign-in.php");
        exit();
    }
    
    require '../connection/connect.php';

    $username = $_SESSION['petugas'];

    $officer = query("SELECT * FROM user WHERE Username = '$username'");

    $book_id = $_GET['id'];

    $book = query("SELECT * FROM buku WHERE BukuID = '$book_id'");

    $category = query("SELECT * FROM kategoribuku");

    if(isset($_POST['edit'])) {
        if(edit($_POST) > 0) {
            echo "
                <script>
                    alert('Buku berhasil disunting');
                    document.location.href = '../book-list.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Buku gagal disunting');
                    document.location.href = '../book-list.php';
                </script>
            ";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../../img/readify-main.png">
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
                    <a href="../dashboard.php">
                        <div class="text-slate-300 px-10 py-3 font-semibold hover:text-white">
                            <p>Dashboard</p>
                        </div>
                    </a>
                    <a href="../book-list.php">
                        <div class="text-slate-300 px-10 py-3 font-semibold hover:text-white">
                            <p>Kelola Buku</p>
                        </div>
                    </a>
                    <a href="../loan-list.php">
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
                <a href="../my-account.php" class="text-gray-400 font-semibold hover:text-sky-600 hover:underline"><?= $row['NamaLengkap']; ?></a>  
                <?php endforeach; ?>    
            </nav>
            <div class="px-8">
                <div class="flex justify-between">
                    <div class="px-2">
                        <ul class="flex items-center">
                            <li class="inline-flex items-center">
                                <a href="../dashboard.php">
                                    <svg class="w-5 h-auto fill-current mx-2 text-gray-400 hover:text-sky-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#000000"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10 19v-5h4v5c0 .55.45 1 1 1h3c.55 0 1-.45 1-1v-7h1.7c.46 0 .68-.57.33-.87L12.67 3.6c-.38-.34-.96-.34-1.34 0l-8.36 7.53c-.34.3-.13.87.33.87H5v7c0 .55.45 1 1 1h3c.55 0 1-.45 1-1z"/></svg>
                                </a>
                                <svg class="w-5 h-auto fill-current mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z"/></svg>
                            </li>
                            <li class="inline-flex items-center">
                                <a href="../book-list.php" class="text-gray-400 hover:text-sky-600">Kelola Buku</a>
                                <svg class="w-5 h-auto fill-current mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z"/></svg>
                            </li>
                            <?php foreach($book as $row): ?>
                            <li class="inline-flex items-center">
                                <a href="" class="text-sky-600"><?= $row['Judul']; ?> - <?= $row['Penulis']; ?></a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>  
                <div class="w-full mt-4 flex">
                    <div class="bg-white w-3/4 p-4 rounded-lg shadow-md">
                        <div class="bg-sky-600 px-4 py-2 rounded-md">
                            <p class="text-white text-lg font-semibold">Form Sunting Buku</p>
                        </div>
                        <div class="mt-4">
                            <?php foreach($book as $row): ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="book_id" value="<?= $row['BukuID']; ?>">
                                <p class="pl-2.5 font-semibold">Kode Buku</p>
                                <input type="text" name="book_code" value="<?= $row['Kode']; ?>" class="h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md focus:outline-none focus:border-sky-600 focus:border-2" autocomplete="off" required>
                                <p class="pl-2.5 font-semibold">Cover Buku</p>
                                <input type="file" name="cover" value="<?= $row['Gambar']; ?>" class="h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md focus:outline-none focus:border-sky-600 focus:border-2">
                                <p class="pl-2.5 font-semibold">Kategori</p>
                                <select name="" class="h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md focus:outline-none focus:border-sky-600 focus:border-2 focus:text-black" autocomplete="off" required>
                                    <option value="" class="text-gray-400">Pilih kategori buku</option>
                                    <?php foreach($category as $row1):?>
                                    <option value="<?= $row1['KategoriID']; ?>"><?= $row1['NamaKategori']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="pl-2.5 font-semibold">Judul</p>
                                <input type="text" name="title" value="<?= $row['Judul']; ?>" class="h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md focus:outline-none focus:border-sky-600 focus:border-2" autocomplete="off" required>
                                <p class="pl-2.5 font-semibold">Penulis</p>
                                <input type="text" name="author" value="<?= $row['Penulis']; ?>" class="h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md focus:outline-none focus:border-sky-600 focus:border-2" autocomplete="off" required>
                                <p class="pl-2.5 font-semibold">Penerbit</p>
                                <input type="text" name="publisher" value="<?= $row['Penerbit']; ?>" class="h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md focus:outline-none focus:border-sky-600 focus:border-2" autocomplete="off" required>
                                <p class="pl-2.5 font-semibold">Tahun Terbit</p>
                                <input type="text" name="publication" value="<?= $row['TahunTerbit']; ?>" class="h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md focus:outline-none focus:border-sky-600 focus:border-2" autocomplete="off" required>
                                <p class="pl-2.5 font-semibold">Stok</p>
                                <input type="number" name="stock" min="1" value="<?= $row['Stok']; ?>" class="h-10 w-full my-1.5 px-3 border-grey-400 border-2 rounded-md focus:outline-none focus:border-sky-600 focus:border-2" autocomplete="off" required>
                                <button type="submit" name="add" class="bg-slate-200 w-full mt-2 py-1.5 text-gray-400 text-center rounded-md hover:bg-sky-600 hover:text-white">Tambah</button>
                            </form>
                            <?php endforeach; ?>
                        </div>
                    
                    </div>
                    <div class="bg-white w-1/4 ml-6 p-4 rounded-lg shadow-md">
                        <?php foreach($book as $row): ?>
                        <img src="../../assets/img/<?= $row['Gambar']; ?>" alt="" class="rounded-md">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
<?php
    session_start();

    if(!isset($_SESSION['peminjam'])) {
        header("location:../index.php");
        exit;
    }

    require 'connection/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
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
                <a href="" class="text-gray-300">Pinjam</a>
                <a href="../visit.php" class="text-white hover:text-gray-300">Kunjungan</a>
                <a href="../../index.php" class="text-white hover:text-gray-300">Beranda</a>
                <a href="../my-collection.php" class="text-white hover:text-gray-300">Koleksi</a>
                <a href="../account/manage-account.php" class="text-white hover:text-gray-300">Akun</a>
            </div>
            <div class="">
                <a href="../sign-out.php" class="text-white hover:text-gray-300">Keluar</a>
            </div>
        </div>
    </nav>
    <main class="h-[881px] flex justify-center items-center">
        <div class="bg-white h-1/3 w-1/3 p-4 rounded-lg shadow-md">
            <div class="bg-sky-600 h-1/5 flex justify-center items-center rounded-md">
                <p class="mx-4 text-white text-lg font-semibold">Peminjaman Buku Berdasarkan Kode</p>
            </div>
            <div class="h-1/6 flex justify-center items-center">
                <p class="text-center">Masukan kode buku yang akan dipinjam</p>
            </div>
            <div class="h-4/5">
           
                <form action="" method="post">
                    <input type="text" name="code" class="bg-white my-2 border-gray-400 border-2 w-full px-3 py-1.5 font-semibold text-center text-lg rounded-md focus:outline-none focus:border-sky-600 focus:border-2" autocomplete="off" required>
                    <button type="submit" name="submit" class="bg-sky-600 w-full mt-16  py-1.5 bottom-0 left-0 text-white rounded-md hover:bg-sky-700 hover:text-white">Kirim</button>
                </form>
                <?php
                    if(isset($_POST['submit'])) {
                        $book_code = $_POST['code'];
                        $query = mysqli_query($conn, "SELECT * FROM buku WHERE Kode = '$book_code'");
                        $check = mysqli_fetch_assoc($query);
                        if($check > 0) {
                            header("location:books/loan-form.php?code=$book_code");
                            exit;
                        } else {
                            echo "
                                <script>
                                    alert('Kode buku tidak valid');
                                    document.location.href = '';
                                </script>
                            ";
                        }
                    }
                ?>
            </div>
        </div>
    </main>
</body>
</html>
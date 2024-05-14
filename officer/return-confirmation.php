<?php
    session_start();

    if(!isset($_SESSION['petugas'])) {
        header("location:../sign-in.php");
        exit();
    }

    require 'connection/connect.php';

    $username = $_SESSION['petugas'];

    $officer = query("SELECT * FROM user WHERE Username = '$username'");

    $loan_id = $_GET['id'];

    $loan = "SELECT peminjaman.*, user.*, buku.* FROM peminjaman
    INNER JOIN user ON peminjaman.UserID = user.UserID
    INNER JOIN buku ON peminjaman.BukuID = buku.BukuID
    WHERE peminjaman.PeminjamanID = '$loan_id'";

    $loan_list = mysqli_query($conn, $loan);

    if(isset($_POST['return'])) {
        $loan_id = $_POST['loan_id'];
        $status = $_POST['status'];

        $data = [
            'loan_id' => $loan_id,
            'status' => $status,
        ];

        $result = returnConfirmation($data);

        if($result) {
            echo "
                <script>
                    alert('Pengembalian Buku Berhasil');
                    document.location.href = 'loan-history.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Pengembalian Buku gagal');
                    document.location.href = '';
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
                                <a href="in-loan.php" class="text-gray-400 hover:text-sky-600">Sedang Dipinjam</a>
                                <svg class="w-5 h-auto fill-current mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6-6-6z"/></svg>
                            </li>
                            <li class="inline-flex items-center">
                                <a href="" class="text-sky-600">Konfirmasi Pengembalian</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="bg-white my-5 px-4 py-3 rounded-lg shadow-md">
                    <?php foreach($loan_list as $row): ?>
                    <p class="">Mohon siapkan buku <b><?= $row['Judul']; ?></b> - <b><?= $row['Penulis']; ?></b> dengan kode <b><?= $row['Kode']; ?></b>, berikan kepada <b><?= $row['NamaLengkap']; ?></b> </p>
                    <?php endforeach ?>
                </div>
                <div class="flex">
                    <div class="bg-white w-1/4 p-4 rounded-lg shadow-md">
                        <div class="bg-sky-600 h-20 rounded-md">
                            <p>Judul Buku</p>
                        </div>
                    </div>
                    <div class="bg-white w-3/4 ml-4 p-4 rounded-lg shadow-md">
                        <div class="bg-sky-600 px-4 py-1.5 rounded-md">
                            <p class="text-white text-lg font-semibold">Detail Buku</p>
                        </div>
                        <?php foreach($loan_list as $row): ?>
                        <div class="my-6 px-2 flex">
                            <div class="w-1/2">
                                <div class="my-2 flex">
                                    <div class="flex w-48 mr-2 justify-between">
                                        <p class="font-semibold">Judul Buku</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $row['Judul']; ?></p>
                                </div>
                                <div class="my-2 flex">
                                    <div class="flex w-48 mr-2 justify-between">
                                        <p class="font-semibold">Penulis</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $row['Penulis']; ?></p>
                                </div>
                                <div class="my-2 flex">
                                    <div class="flex w-48 mr-2 justify-between">
                                        <p class="font-semibold">Penerbit</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $row['Penerbit']; ?></p>
                                </div>
                                <div class="my-2 flex">
                                    <div class="flex w-48 mr-2 justify-between">
                                        <p class="font-semibold">Tahun Terbit</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $row['TahunTerbit']; ?></p>
                                </div>
                            </div>
                            <div class="w-1/2">
                                <?php foreach($loan_list as $row): ?>
                                <div class="my-2 flex">
                                    <div class="flex w-48 mr-2 justify-between">
                                        <p class="font-semibold">Nama Peminjam</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $row['NamaLengkap']; ?></p>
                                </div>
                                <div class="my-2 flex">
                                    <div class="flex w-48 mr-2 justify-between">
                                        <p class="font-semibold">Alamat Email</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $row['Email'] ?></p>
                                </div>
                                <div class="my-2 flex">
                                    <div class="flex w-48 mr-2 justify-between">
                                        <p class="font-semibold">Alamat</p>
                                        <p>:</p>
                                    </div>
                                    <p><?= $row['Alamat'] ?></p>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            
                        </div>
                        <form action="" method="post">
                            <input type="hidden" name="loan_id" value="<?= $row['PeminjamanID']; ?>">
                            <div class="px-4 my-6 flex items-center">
                                <input type="checkbox" name="status" value="1" class="h-4 mr-2">
                                <p>Tekan <b>Checkbox</b> jika buku sudah diserahkan kepada peminjam</p>
                            </div>
                            <div class="bg-yellow-100 my-4 p-2 flex items-center rounded-md">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-yellow-500 ml-1 mr-3 stroke-2 w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                                <p class="text-sm">Jika buku sudah dikonfirmasi maka peminjaman sudah</p>
                            </div>
                            <button type="submit" name="return" class="bg-sky-600 w-[1238px] py-1.5 text-white bottom-4 rounded-lg absolute hover:bg-sky-600 hover:text-white">Konfirmasi</button>
                        </form>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
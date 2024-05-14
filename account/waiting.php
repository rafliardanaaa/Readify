<?php
    $username = query("SELECT * FROM user WHERE Username = '$user'");

    foreach($username as $row) {
        $user_id = $row['UserID'];
    }

    $loan = "SELECT peminjaman.*, user.*, buku.* FROM peminjaman
            INNER JOIN user ON peminjaman.UserID = user.UserID
            INNER JOIN buku ON peminjaman.BukuID = buku.BukuID
            WHERE peminjaman.UserID = '$user_id' AND peminjaman.Status = '2'";

    $my_loan = mysqli_query($conn, $loan);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php foreach($my_loan as $row): ?>
    <div class="p-4 border-sky-600 border rounded-md">
        <div class="flex justify-between items-center">
            <p class="font-semibold"><?= $row['Judul']; ?></p>
            <p>x<?= $row['Jumlah'] ?></p>
        </div>
        <div class="">
            <p class=""><?= $row['Penulis']; ?></p>
            <p class=""><?= $row['Penerbit']; ?></p>
        </div>
        <div class="text-sm flex justify-between items-center">
            <p><?= $row['Dipinjam']; ?> s/d <?= $row['BatasPeminjaman']; ?></p>
        </div>
    </div>
    <?php endforeach; ?>  
</body>
</html>
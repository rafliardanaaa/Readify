<?php
    require '../connection/connect.php';

    $keyword = $_GET["search"];

    $book = "SELECT * FROM buku WHERE
                Kode LIKE '%$keyword%' OR
                Judul LIKE '%$keyword$' OR
                Penulis LIKE '%$keyword%' OR
                Penerbit LIKE '%$keyword%' OR
                TahunTerbit LIKE '%$keyword%'";

    $book_list = query($book);
?>
<table class="w-full">
    <tr class="h-10 "> 
        <th class="w-1/12">Kode</th>
        <th class="w-2/12">Judul</th>
        <th class="w-1/12">Penulis</th>
        <th class="w-1/12">Penerbit</th>
        <th class="w-1/12">Tahun Terbit</th>
        <th class="w-1/12">Stok</th>
        <th class="w-1/12">Tersedia</th>
        <th class="w-1/12">Terpinjam</th>
        <th class="w-1/12">Gambar</th>
        <th class="w-1/12">Kelola</th>
    </tr>
    <?php foreach($book_list as $row): ?>
    <tr class="">
        <td class="px-6"><?= $row['Kode']; ?></td>
        <td class="px-10 text-start"><?= $row['Judul']; ?></td>
        <td class="text-start"><?= $row['Penulis']; ?></td>
        <td class="text-start"><?= $row['Penerbit']; ?></td>
        <td class="text-center"><?= $row['TahunTerbit']; ?></td>
        <td class="text-center"><?= $row['Stok']; ?></td>
        <td class="text-center"><?= $row['Tersedia']; ?></td>
        <td class="text-center"><?= $row['Terpinjam']; ?></td>
        <?php if($row['Gambar'] > 0): ?>
        <td class="text-center"><a href="img/<?= $row['Gambar']; ?>" target="blank" class="text-slate-400 underline hover:text-sky-600">Lihat</a></td>
        <?php else: ?>
        <td class="text-center">-</td>
        <?php endif; ?>
        <td class="py-2.5 flex justify-evenly">
            <a href="book-list/edit-book.php?id=<?= $row['BukuID']; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 stroke-2 h-4 w-4 hover:text-sky-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
            </a>
            <a href="book-list/delete.php?id=<?= $row['BukuID']; ?>" onclick="return confirm('Yakin menghapus buku?');">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-gray-400 stroke-2 h-4 w-4 hover:text-sky-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
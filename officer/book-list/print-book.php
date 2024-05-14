<?php

require_once __DIR__ . '/../../vendor/autoload.php';

require '../connection/connect.php';

$jumlahDataPerhalaman = 16;
$jumlahData = count(query("SELECT * FROM buku"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$jumlahAktif = (isset($_GET["jumlah"])) ? $_GET["jumlah"] : 1;
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

$book = query("SELECT * FROM buku LIMIT $awalData, $jumlahDataPerhalaman");

$mpdf = new \Mpdf\Mpdf();

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak - Daftar Buku</title>
    <style>
        body {
            font-family : arial;
        }
    </style>
</head>
<body>
    <h1>Daftar Buku Readify Digital Library</h1>
    <table border="1" cellpadding="4" cellspacing="2">
        <tr class="">
            <th class="">Kode</th>
            <th class="">Judul Buku</th>
            <th class="">Penulis</th>
            <th class="">Penerbit</th>
            <th class="">Tahun Terbit</th>
            <th class="">Stok</th>
            <th class="">Tersedia</th>
            <th class="">Terpinjam</th>
        </tr>';
        foreach($book as $row) {
            $html .= '<tr>
                <td>'. strtoupper($row['Kode']) .'</td>
                <td>'. $row['Judul'] .'</td>
                <td>'. $row['Penulis'] .'</td>
                <td>'. $row['Penerbit'] .'</td>
                <td>'. $row['TahunTerbit'] .'</td>
                <td>'. $row['Stok'] .'</td>
                <td>'. $row['Tersedia'] .'</td>
                <td>'. $row['Terpinjam'] .'</td>
            </tr>
            ';
        }
$html .= '</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output();

?>

<table>
    <tr>
        <th>Judul</th>
    </tr>

</table>
<?php

require_once __DIR__ . '/../../vendor/autoload.php';

require '../connection/connect.php';

$book = query("SELECT * FROM kategoribuku");

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
    <h1>Daftar Kategori Buku Readify Digital Library</h1>
    <table border="1" cellpadding="4" cellspacing="2">
        <tr class="">
            <th class="">Nama Kategori</th>
        </tr>';
        foreach($book as $row) {
            $html .= '<tr>
                <td>'. $row['NamaKategori'] .'</td>
            </tr>
            ';
        }
$html .= '</table>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output();

?>
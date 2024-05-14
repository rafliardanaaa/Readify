<?php
    require '../connection/connect.php';

    $category_id = $_GET['id'];

    $category = query("SELECT * FROM kategoribuku WHERE KategoriID = '$category_id'");
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
<body>
    <?php foreach($category as $row): ?>
    <form action="" method="post">
        <input type="hidden" name="category_id" value="<?= $row['KategoriID'];  ?>">
        <input type="text" name="category_name" value="<?= $row['NamaKategori'];  ?>"> <br>
        <button type="submit" name="edit">Sunting</button>
    </form>
    <?php endforeach; ?>
</body>
</html>
<?php 
    session_start();

    if(!isset($_SESSION['peminjam'])) {
        header("location:../../index.php");
        exit;
    }

    $user = $_SESSION['peminjam'];

    require 'connection/connect.php';

    if(isset($_POST['submit'])) {
        if(submitReview($_POST) > 0) {
            echo "
                <script>
                    alert('Ulasan berhasil terkirim');
                    document.location.href = '';
                </script>
            ";
        } else {
            echo "
            <script>
                alert('Ulasan gagal terkirim');
                document.location.href = '';
            </script>
        ";
        }
    }

    $book_id = $_GET['id'];

    $username = query("SELECT * FROM user WHERE Username = '$user'");

    foreach($username as $row) {
        $user_id = $row['UserID'];
    }
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
    <form action="" method="post">
        <input type="text" name="review_id">
        <input type="text" name="user_id" value="<?php echo $user_id;?>"> <br>
        <input type="text" name="book_id"  value="<?php echo $book_id;?>"> <br>
        <textarea name="review" id="" cols="30" rows="10"></textarea> <br>
        <select name="rating" id=""> <br>
            <option value="1">Tidak Puas</option>
            <option value="2">Puas</option>
            <option value="3">Sangat Puas</option>
        </select>
        <button type="submit" name="submit">Kirim</button>
    </form>
</body>
</html>
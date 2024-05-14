<?php
    require '../connection/connect.php';

    $book_id = $_GET['id'];

    if(deleteBook($book_id) > 0) {
        echo "
            <script>
                alert('Buku berhasil dihapus');
                document.location.href = '../book-list.php';
            </script>
        ";
    } else {
        echo "
        <script>
            alert('Buku gagal dihapus');
            document.location.href = '../book-list.php';
        </script>
    ";
    }
?>
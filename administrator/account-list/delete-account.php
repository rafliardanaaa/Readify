<?php
    require '../connection/connect.php';

    $user_id = $_GET['id'];

    if(deleteUsers($user_id) > 0) {
        echo "
            <script>
                alert('Akun berhasil dihapus');
                document.location.href = '../account-list.php';
            </script>
        ";
    } else {
        echo "
        <script>
            alert('Akun gagal dihapus');
            document.location.href = '../account-list.php';
        </script>
    ";
    }
?>
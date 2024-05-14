<?php
    $conn = mysqli_connect("localhost", "root", "", "db_readify");

    function query($query) {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        };
        return $rows;
    }

    function addUsers($data) {
        global $conn;
        date_default_timezone_set('Asia/jakarta');
        $current_time = date('Y-m-d H:i:s');      
        $username = htmlspecialchars($data['username']);
        $password = htmlspecialchars($data['password']);
        $email = htmlspecialchars($data['email']);
        $fullname = htmlspecialchars($data['fullname']);
        $address = htmlspecialchars($data['address']);

        $query = "INSERT INTO user VALUES ('', '$username', '$password', '$email', '$fullname', '$address', '', '$current_time', '')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function editUsers($data) {
        global $conn;
        $id = $data['id'];
        $username = htmlspecialchars($data['username']);
        $password = htmlspecialchars($data['password']);
        $email = htmlspecialchars($data['email']);
        $fullname = htmlspecialchars($data['fullname']);
        $status = htmlspecialchars($data['status']);

        $query = "UPDATE user SET
                Username = '$username',
                Password = '$password',
                Email = '$email',
                NamaLengkap = '$fullname',
                Status = '$status'
                WHERE UserID = '$id'";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function deleteUsers($user_id) {
        global $conn;
        mysqli_query($conn, "DELETE FROM user WHERE UserID = '$user_id'");
        return mysqli_affected_rows($conn);
    }

    function addBooks($data) {
        global $conn;
        date_default_timezone_set('Asia/jakarta');
        $current_time = date('Y-m-d H:i:s');
        $code = uniqid();
        $code = strtoupper(substr($code, -6));        
        $title = htmlspecialchars($data['title']);
        $author = htmlspecialchars($data['author']);
        $publisher = htmlspecialchars($data['publisher']);
        $publication = htmlspecialchars($data['publication']);
        $stock = htmlspecialchars($data['stock']);
        $category = htmlspecialchars($data['category']);

        $cover = uploadBooks();
                if(!$cover) {
                    return false;
                }

        $query = "INSERT INTO buku VALUES ('', '$code', '$title', '$cover','$author', '$publisher', '$publication', '$stock', '$stock', '','$current_time', '')";
        mysqli_query($conn, $query);
        $book_id = mysqli_insert_id($conn);

        $query = "INSERT INTO kategoribuku_relasi VALUES ('', '$book_id', '$category')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function uploadBooks() {
        $file_name = $_FILES['cover']['name'];
        $file_size = $_FILES['cover']['size'];
        $error = $_FILES['cover']['error'];
        $tmpName = $_FILES['cover']['tmp_name'];

        if($error === 4) {
            echo "<script>
                alert('Pilih cover!');
            </script>";
            return false;
        }

        $extention = ['jpg', 'jpeg', 'png'];
        $cover_extention = explode('.', $file_name);
        $cover_extention = strtolower(end($cover_extention));

        if(!in_array($cover_extention, $extention)) {
            echo "<script>
                alert('Bukan Gambar');
            </script>";
            return false;
        }

        if($file_size > 1000000) {
            echo "<script>
                alert('Ukuran gambar terlalu besar');
            </script>";
            return false;
        }

        $new_file_name = uniqid();
        $new_file_name .= '.';
        $new_file_name .= $cover_extention;

        move_uploaded_file($tmpName, '../../assets/img/' . $new_file_name);
        return $new_file_name;
    }

    function deleteBook($book_id) {
        global $conn;
        mysqli_query($conn, "DELETE FROM buku WHERE BukuID = '$book_id'");
        return mysqli_affected_rows($conn);
    }

    function editBooks($data) {
        global $conn;
        $id = $data['id'];
        $title = htmlspecialchars($data['title']);
        $image = htmlspecialchars($data['iamge']);
        $author = htmlspecialchars($data['author']);
        $publisher = htmlspecialchars($data['publisher']);
        $publication = htmlspecialchars($data['publication']);
        $stock = htmlspecialchars($data['stock']);

        $query = "UPDATE buku SET
                Judul = '$title',
                Gambar = '$image',
                Penulis = '$author',
                Penerbit = '$publisher',
                TahunTerbit = '$publication',
                Stok = '$stock'
                WHERE BukuID = '$id'";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function searchBooks($keyword) {
        $query = "SELECT * FROM buku
            WHERE
            Kode LIKE '%$keyword%' OR
            Judul LIKE '%$keyword%' OR
            Penulis LIKE '%$keyword%' OR
            Penerbit LIKE '%$keyword%' OR
            TahunTerbit LIKE '%$keyword%' OR
            ";
        return query($query);
    }
?>
<?php
    $conn = mysqli_connect("localhost", "root", "", "db_readify");

    function query($query) {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        } 
        return $rows;
    }

    function addBooks($data) {
        global $conn;
        date_default_timezone_set('Asia/jakarta');
        $current_time = date('Y-m-d H:i:s');
        $code = uniqid();
        $code = strtolower(substr($code, -4));        
        $title = htmlspecialchars($data['title']);
        $author = htmlspecialchars($data['author']);
        $publisher = htmlspecialchars($data['publisher']);
        $publication = htmlspecialchars($data['publication']);
        $stock = htmlspecialchars($data['stock']);

        $cover = upload();
                if(!$cover) {
                    return false;
                }

        $query = "INSERT INTO buku VALUES ('', '$code', '$title', '$cover','$author', '$publisher', '$publication', '$stock', '$stock', '','$current_time', '')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function upload() {
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

    function editBooks($data) {
        global $conn;
        $book_id = $data['book_id'];
        $book_code = htmlspecialchars($data['book_code']);
        $title = htmlspecialchars($data['title']);
        $author = htmlspecialchars($data['author']);
        $publisher = htmlspecialchars($data['publisher']);
        $publication = $data['publication'];
        $stock = $data['stock'];

        $query = "UPDATE buku SET
                Kode = '$book_code',
                Judul = '$title',
                Penulis = '$author',
                Penerbit = '$publisher',
                TahunTerbit = '$publication''
                Stok = '$stock'
                WHERE BukuID = '$book_id'";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function loanConfirm($data) {
        global $conn;
        $loan_id = $data['loan_id'];
        $status = htmlspecialchars($data['status']) ? 1 : 0;

        $query = "UPDATE peminjaman SET
            Status = '$status'
            WHERE PeminjamanID = '$loan_id'";

        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function returnConfirmation($data) {
        global $conn;
        date_default_timezone_set('Asia/Jakarta');
        $current_time = date('Y-m-d H:i:s');
        $loan_id = $data['loan_id'];
        $status = $data['status'] ? 2 : 1;

        $query = "UPDATE peminjaman SET
                Status = '$status',
                Dikembalikan = '$current_time'
                WHERE PeminjamanID = '$loan_id'";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function deleteBook($book_id) {
        global $conn;
        mysqli_query($conn, "DELETE FROM buku WHERE BukuID = '$book_id'");
        return mysqli_affected_rows($conn);
    }
?>
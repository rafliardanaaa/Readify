<?php
    $conn = mysqli_connect("localhost", "root", "", "db_readify");

    function query($query) {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    function loan($data) {
        global $conn;
        date_default_timezone_set('Asia/Jakarta');
        $current_time = date('Y-m-d H:i:s'); 
        $user_id = htmlspecialchars($data['user_id']);
        $book_id = htmlspecialchars($data['book_id']);
        $amount = htmlspecialchars($data['amount']);
        $limit = htmlspecialchars($data['limit']);
    
        // Periksa jumlah yang diinput lebih besar dari jumlah yang tersedia
        $query_check_amount = "SELECT Tersedia FROM buku WHERE BukuID = '$book_id'";
        $result = mysqli_query($conn, $query_check_amount);
        $row = mysqli_fetch_assoc($result);
        $available_amount = $row['Tersedia'];
    
        if ($amount > $available_amount) {
            // Jika jumlah yang diminta lebih besar dari yang tersedia, kembalikan false
            return false;
        } else {
            // Jika jumlah yang diminta kurang dari atau sama dengan yang tersedia, lakukan penyisipan
            $query = "INSERT INTO peminjaman VALUES ('', '$user_id', '$book_id', '$amount', '$limit', '', '$current_time', '')";
            mysqli_query($conn, $query);
            return mysqli_affected_rows($conn);
        }
    }
    

    function addCollections($data) {
        global $conn;
        $user_id = $data['user_id'];
        $book_id = $data['book_id'];

        $query = "INSERT INTO koleksipribadi VALUES ('', '$user_id', '$book_id')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
?>
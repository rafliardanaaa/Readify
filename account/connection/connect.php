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

    function edit($data) {
        global $conn;
        $user_id = $data['user_id'];
        $username = htmlspecialchars($data['username']);
        $password = htmlspecialchars($data['password']);
        $fullname = htmlspecialchars($data['fullname']);
        $email = htmlspecialchars($data['email']);
        $address = htmlspecialchars($data['address']);

        $query = "UPDATE user SET
                Username = '$username',
                Password = '$password',
                NamaLengkap = '$fullname',
                Email = '$email',
                Alamat = '$address'
                WHERE UserID = '$user_id'                
        ";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function change($data) {
        global $conn;
        $user_id = $data['user_id'];
        $password = htmlspecialchars($data['password']);

        $query = "UPDATE user SET
                Password = '$password'
                WHERE UserID = '$user_id'";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }

    function submitReview($data) {
        global $conn;
        date_default_timezone_set('Asia/Jakarta');
        $current_time = date('Y-m-d H:i:s');
        $user_id = $data['user_id'];
        $book_id = $data['book_id'];
        $review = htmlspecialchars($data['review']);
        $rating = htmlspecialchars($data['rating']);

        $query = "INSERT INTO ulasanbuku VALUES ('', '$user_id', '$book_id', '$review', '$rating', '$current_time')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
?>
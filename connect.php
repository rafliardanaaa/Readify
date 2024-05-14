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

    function registration($data) {
        global $conn;
        date_default_timezone_set('Asia/Jakarta');
        $current_time = date('Y-m-d H:i:s'); 
        $username = htmlspecialchars($data["username"]);
        $password = htmlspecialchars($data["password"]);
        $email = htmlspecialchars($data["email"]);
        $fullname = htmlspecialchars($data["fullname"]);

        if (strpos($username, ' ') !== false) {
            // Jika username mengandung spasi, maka beri respon atau lakukan tindakan yang sesuai
            return "Username tidak boleh mengandung spasi";
        }
    
        $query = "INSERT INTO user VALUES ('', '$username', '$password', '$email', '$fullname', '', '', '$current_time', '')";
        mysqli_query($conn, $query);
        return mysqli_affected_rows($conn);
    }
?>
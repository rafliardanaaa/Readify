<?php
    session_start();

    require 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="img/readify-main.png">
    <title>Readify - Digital Library</title>
</head>
<body class="g-red-500">
    <div class="h-screen flex">
        <aside class="bg-sky-600 w-8/12 ">
            <img src="main.jpeg" alt="" class="h-screen">
        </aside>
        <main class="h-full w-4/12 p-32">
            <div class="h-full">
                <div class="flex items-center">
                    <img src="img/readify-main.png" alt="Readify Logo" class="h-7 w-7 mr-3">
                    <p class="text-sky-600 text-xl font-bold">Readify</p>
                </div>
                <div class="pt-14 pb-16">
                    <p class="mb-2 text-3xl font-bold">Masukan akun anda</p>
                    <p class="text-sm">Selamat datang di Readify Digital Library</p>
                </div>
                <div class="pt-28 pb-10 relative">
                    <script>
                        function viewCancelledNotification();
                    </script>
                    <div id="cancelledNotification" class="bg-red-100 px-4 py-3 w-[380px] border border-red-500 text-red-700 top-0 rounded-md absolute hidden">
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">Akun tidak terdaftar</span>
                        <span class="cursor-pointer absolute top-0 bottom-0 right-0 px-4 py-3" onclick="closeCancelledNotification()">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                        </span>
                    </div> 
                    <form action="" method="post">
                        <div class="border mb-6 px-3 py-2.5 rounded-md flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-slate-400 w-6 h-6 mx-1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <input type="text" name="username" placeholder="Username" class="bg-white w-full ml-3 focus:outline-none" required autocomplete="off"> <br>   
                        </div>
                        <div class="bg-white border mb-4 px-3 py-2.5 rounded-md flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-slate-400 w-6 h-6 mx-1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                            <input type="password" name="password" placeholder="Password" class="bg-white w-full ml-3 focus:outline-none" required autocomplete="off"> <br> 
                        </div>
                        <div class="text-end">
                            <a href="" class="text-sky-600 text-sm hover:underline">Lupa password?</a>
                        </div>
                        <button type="submit" name="login" class="bg-sky-600 my-10 py-2 text-white text-center w-full rounded-md">Masuk</button>
                    </form>
                    <?php
                        if(isset($_POST['login'])) {
                            $username = $_POST['username'];
                            $password = $_POST['password'];
                            $qry = mysqli_query($conn, "SELECT * FROM user WHERE Username = '$username' AND Password = '$password'");
                            $user = mysqli_fetch_assoc($qry);
                        
                            if($user) {
                                if ($user['Status'] == 1) {
                                    $_SESSION['petugas'] = $username;
                                    header("location:officer/dashboard.php");
                                    exit();
                                } elseif ($user['Status'] == 2) {
                                    $_SESSION['pengelola'] = $username;
                                    header("location:administrator/dashboard.php");
                                    exit();
                                } else {
                                    $_SESSION['peminjam'] = $username; // Default role jika status tidak didefinisikan
                                    header("location:../index.php"); // Default ke halaman peminjam jika status tidak valid
                                    exit();
                                }
                            } else {
                                echo "<script>viewCancelledNotification();</script>";
                            }
                        }
                        
                    ?>
                </div>
                <div class="flex justify-center">
                    <p class="">Tidak memiliki akun?</p>
                    <a href="sign-up.php" class="text-sky-600 ml-1.5 font-semibold hover:underline">Buat akun</a>
                </div>
            </div>
        </main>
    </div>
    
</body>
</html>

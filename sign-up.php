<?php
    session_start();

    if(isset($_SESSION['peminjam'])) {
        header("location:../index.php");
    }

    require 'connect.php';

    if(isset($_POST['regist'])) {
        $username = $_POST['username'];
        
        // Memeriksa apakah username mengandung spasi
        if (strpos($username, ' ') !== false) {
            echo "
                <script>
                    alert('Username tidak boleh mengandung spasi');
                    document.location.href = '';
                </script>
            ";
        }
        // Memeriksa apakah username menggunakan kata "Admin" atau "admin"
        elseif (strtolower($username) === 'admin') {
            echo "
                <script>
                    alert('Username tidak boleh menggunakan kata Admin/admin');
                    document.location.href = '';
                </script>
            ";
        }
        // Jika tidak ada larangan, lanjutkan proses pendaftaran
        else {
            if(registration($_POST) > 0) {
                echo "
                    <script>
                        alert('Akun berhasil terdaftar');
                        document.location.href = 'sign-in.php';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        alert('Akun gagal terdaftar');
                        document.location.href = '';
                    </script>
                ";
            }
        }
    }
    
    
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
<body>
    <div class="h-screen flex">
        <aside class="bg-sky-600 w-8/12">
            
        </aside>
        <main class="h-full w-4/12 p-32">
            <div class="h-min ">
                <div class="flex items-center">
                    <img src="img/readify-main.png" alt="Readify Logo" class="h-7 w-7 mr-3">
                    <p class="text-sky-600 text-xl font-bold">Readify</p>
                </div>
                <div class="pt-14 pb-16">
                    <p class="mb-2 text-3xl font-bold">Daftarkan akun anda</p>
                    <p class="text-sm">Selamat datang di Readify Digital Library</p>
                </div>
                <div class="pt-16 pb-10 relative">
                    <form action="" method="post">
                        <div class="border mb-6 px-3 py-2.5 rounded-md flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-slate-400 w-6 h-6 mx-1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <input type="text" name="fullname" placeholder="Nama Lengkap" class="w-full ml-3 focus:outline-none" required autocomplete="off"> <br> 
                        </div>
                        <div class="border mb-6 px-3 py-2.5 rounded-md flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-slate-400 w-6 h-6 mx-1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <input type="email" name="email" placeholder="Alamat Email" class="w-full ml-3 focus:outline-none" required autocomplete="off"> <br> 
                        </div>

                        <div class="border mb-6 px-3 py-2.5 rounded-md flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-slate-400 w-6 h-6 mx-1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <input type="text" name="username" placeholder="Username" class="w-full ml-3 focus:outline-none" required autocomplete="off"> <br>   
                        </div>   
                        <div class="border mb-6 px-3 py-2.5 rounded-md flex">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-slate-400 w-6 h-6 mx-1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                            <input type="password" name="password" placeholder="Password" class="w-full ml-3 focus:outline-none" required autocomplete="off"> <br> 
                        </div>
                        <button type="submit" name="regist" class="bg-sky-600 my-10 py-2 text-white text-center w-full rounded-md">Daftar</button>
                    </form>
                </div>
                <div class="flex justify-center">
                    <p class="">Sudah memiliki akun?</p>
                    <a href="sign-in.php" class="text-sky-600 ml-2 font-semibold hover:underline">Masuk</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
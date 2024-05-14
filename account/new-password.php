<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="h-1/3">

        <form action="" method="post">
            <input type="hidden" name="user_id" value="<?= $user_id; ?>">
            <p class="font-semibold">Password sebelumnya</p>
            <input type="password" name="password" class="my-2 border-gray-400 border w-full px-3 py-1.5 rounded-md focus:outline-none focus:border-sky-600 focus:border" value="<?= $password; ?>">
            <p class="font-semibold">Masukan password baru</p>
            <input type="text" name="password" class="my-2 border-gray-400 border w-full px-3 py-1.5 rounded-md focus:outline-none focus:border-sky-600 focus:border" autocomplete="off">
            <button type="submit" name="change" class="bg-sky-600 px-4 py-1.5 text-white rounded-md">Simpan</button>
        </form>   
    </div>
</body>
</html>
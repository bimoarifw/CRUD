<?php

session_start();


if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'config/functions.php';
// pisah



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registrasi</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <h2>Registrasi</h2>
    <a href="index.php">Back</a>
    <?php 
    if (isset($_POST["submit"])) {

        // var_dump($_POST);
        // var_dump($_FILES);
        // die;
    
        // apakah data berhasil ditambahkan
        if (tambah($_POST) > 0) {
            echo "
            data berhasil ditambahkan!
            ";
        } else {
            echo "
            data tidak diubah/gagal ditambahkan!
            ";
        }
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama">
            </li>
            <li>
                <label for="nisn">NISN</label>
                <input type="text" name="nisn" id="nisn">
            </li>
            <li>
                <label for="email">Email</label>
                <input type="text" name="email" id="email">
            </li>
            <li>
                <label for="jurusan">Jurusan</label>
                <input type="text" name="jurusan" id="jurusan">
            </li>
            <li>
                <label for="gambar">Gambar</label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">REG!</button>
            </li>
        </ul>
    </form>

</body>

</html>
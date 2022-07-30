<?php

session_start();


if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'config/functions.php';
// pisah

// ambil data di url

$id = $_GET["id"];

// query berdasarkan id

$usr = query("SELECT * FROM aplikasi WHERE id = $id")[0];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Data</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <h2>Edit Data</h2>
    <a href="index.php">Back</a>
    <div>

        <?php

        if (isset($_POST["submit"])) {

            // apakah datab berhasil ditambahkan
            if (ubah($_POST) > 0) {
                echo "
            data berhasil diubah!
            ";
            } else {
                echo "
            data gagal diubah/tidak diubah!
            ";
            }
        }

        ?>
    </div>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $usr["id"] ?>">
        <input type="hidden" name="gambarLama" value="<?= $usr["gambar"] ?>">
        <ul>
            <li>
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama" value="<?= $usr["nama"] ?>">
            </li>
            <li>
                <label for="nisn">NISN</label>
                <input type="text" name="nisn" id="nisn" value="<?= $usr["nisn"] ?>">
            </li>
            <li>
                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="<?= $usr["email"] ?>">
            </li>
            <li>
                <label for="jurusan">Jurusan</label>
                <input type="text" name="jurusan" id="jurusan" value="<?= $usr["jurusan"] ?>">
            </li>
            <li>
                <label for="gambar">Gambar</label> <br>
                <img src="img/<?= $usr["gambar"]; ?>" alt="" width="50" <br>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Ubah!</button>
            </li>
        </ul>
    </form>

</body>

</html>
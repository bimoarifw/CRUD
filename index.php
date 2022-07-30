<?php
session_start();


if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'config/functions.php';

$aplikasi = query("SELECT * FROM aplikasi LIMIT $awalPage, $jumlahPagePer ");


// search 
$hide = "visibility: visible";
$show = "visibility: hidden";


if (isset($_POST["cari"])) {
    $aplikasi = cari($_POST["keyword"]);
    $hasil = ($_POST["keyword"]);
    $hide = "visibility: hidden";
    $show = "visibility: visible";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Aplikasi Data</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <h1>Data Pengguna</h1>
    <a href="tambah.php">tambah</a> | <a href="config/logout.php">logout</a>
    <p></p>
    <p></p>
    <form action="" method="post">
        <input type="text" name="keyword" placeholder="cari keyword!" size="40" autofocus autocomplete="off">
        <button type="submit" name="cari">CARI!</button>
    </form>

    <div style="<?= $show ?>">
        <?php
        if (empty($aplikasi)) {
            echo 'Tidak ada hasil untuk : ', $hasil;
        } else {
            echo 'Hasil pencarian untuk : ', $hasil;
        }
        ?>
    </div>

    <p></p>
    <table border="1" cellpadding="10" cellspacing="0">
        <?php $i = 1; ?>
        <?php foreach ($aplikasi as $row) : ?>
            <tr>
                <th>No. </th>
                <th>Aksi</th>
                <th>Gambar</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jurusan</th>
            </tr>
            <tr>
                <td><?= $i + $awalPage; ?></td>
                <td>
                    <a href="ubah.php?id=<?= $row["id"]; ?> ">ubah</a>|
                    <a href="config/hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('yakin?');">hapus</a>
                </td>

                <td><img src="img/<?= $row["gambar"]; ?> " width="50" height="auto"></td>
                <td><?= $row["nisn"]; ?> </td>
                <td><?= $row["nama"]; ?></td>
                <td><?= $row["email"]; ?></td>
                <td><?= $row["jurusan"]; ?></td>
            </tr>
            <?php $i++ ?>
        <?php endforeach; ?>
    </table>
    <!-- navigasi -->

    <div style="<?= $hide ?>">
        <?php if ($pageNow > 1) : ?>
            <a href="?page=<?= $pageNow - 1; ?>">&laquo;</a>
        <?php endif; ?>


        <?php for ($i = 1; $i <= $jumlahPage; $i++) : ?>
            <?php if ($i == $pageNow) : ?>
                <a href="?page=<?= $i ?>" style="font-weight:bold; color:red;"><?= $i ?></a>
            <?php else : ?>
                <a href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($pageNow < $jumlahPage) : ?>
            <a href="?page=<?= $pageNow + 1; ?>">&raquo;</a>
        <?php endif; ?>
    </div>
</body>

</html>
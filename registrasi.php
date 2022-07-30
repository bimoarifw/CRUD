<?php
ini_set('display_errors', "1");
require 'config/functions.php';

if (isset($_POST["register"])) {
    if (register($_POST) > 0) {
        echo "<script>
        alert('berhasil daftar!')
        </script>";
    } else {
        echo mysqli_error($conn);
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
    <title>Registrasi User</title>
</head>

<body>

    <h1>Halaman Registrasi User</h1>
    <a href="index.php">back</a>

    <form action="" method="post">

        <ul>
            <li>
                <label for="username">username :</label> <br>
                <input type="text" name="username" placeholder="username" id="username">
            </li>
            <li>
                <label for="email">email :</label> <br>
                <input type="text" name="email" placeholder="email" id="email">
            </li>
            <li>
                <label for="password">password :</label> <br>
                <input type="password" name="password" placeholder="password" id="password">
            </li>
            <li>
                <label for="password2">konfirmasi password :</label> <br>
                <input type="password" name="password2" placeholder="password" id="password2">
            </li>
            <li>
                <button type="submit" name="register">Daftar!</button>
            </li>

        </ul>

    </form>

</body>

</html>
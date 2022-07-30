<?php

session_start();
require 'config/functions.php';
// cek cookie
if (isset($_COOKIE['cook']) && isset($_COOKIE['kie'])) {
    $cook = $_COOKIE['cook'];
    $kie = $_COOKIE['kie'];

    // ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $cook");
    $row = mysqli_fetch_assoc($result);

    // cek cookie dan username

    if ($kie === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}
// cek sesi
if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

ini_set('display_errors', "1");
if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // cek

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    //    cek username

    if (mysqli_num_rows($result) === 1) {
        // cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {

            // sesi
            $_SESSION["login"] = true;
            // cookie
            if (isset($_POST["remember"])) {

                setcookie('cook', $row['id'], time() + 60);
                setcookie(
                    'kie',
                    hash('sha256', $row['username']),
                    time() + 60
                );
            }
            header("Location: index.php");
            exit;
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <h1>Halaman Login</h1>

    <?php
    if (isset($error)) : ?>

        <p style="color:red;">username/password salah!</p>

    <?php endif; ?>

    <form action="" method="post">

        <ul>
            <li>
                <label for="username">Username :</label> <br>
                <input type="text" name="username" id="username" placeholder="username" autofocus>
            </li>
            <li>
                <label for="password">Password :</label> <br>
                <input type="password" name="password" placeholder="*******" id="password">
            </li>
            <li>
                <input type="checkbox" name="remember" placeholder="*******" id="remember">
                <label for="remember">Remember me: </label>
            </li>
            <li>
                <button type="submit" name="login">Masuk</button>
            </li>
        </ul>

    </form>

</body>

</html>
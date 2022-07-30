<?php
ini_set('display_errors', "1");
$conn = mysqli_connect("localhost", "root", "", "aplikasi");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $conn;
    $nama = htmlspecialchars($data["nama"]);
    $nisn = htmlspecialchars($data["nisn"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // upload gambar
    // $gambar = htmlspecialchars($data["gambar"]);
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // QUERY INSERT
    $query = "INSERT IGNORE INTO aplikasi
        VALUES
             ('','$nama', '$nisn', '$email', '$jurusan', '$gambar')
 ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function upload()
{
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $errorFile  = $_FILES['gambar']['error'];
    $tmpName  = $_FILES['gambar']['tmp_name'];

    // cek upload
    if ($errorFile === 4) {
        echo "<script>
        alert('pilih gambar terlebih dahulu!')
        </script>";
        return false;
    }
    // cek ekstensi file
    $ekstensiValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiValid)) {
        echo "<script>
        alert('anda tidak mengupload file gambar!')
        </script>";
        return false;
    }
    // cek ukuran file
    if ($ukuranFile > 2000000) {
        echo "<script>
        alert('ukuran gambar terlalu besar!')
        </script>";
        return false;
    }
    $fileBaru = uniqid();
    $fileBaru .= '.';
    $fileBaru .= $ekstensiGambar;
    move_uploaded_file($tmpName, 'img/' . $fileBaru);
    return $fileBaru;
}

function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM aplikasi WHERE id= $id");
    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    global $conn;
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nisn = htmlspecialchars($data["nisn"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    $gambarLama = htmlspecialchars($data["gambarLama"]);

    // cek gambar baru
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama;
    } else {

        $gambar = upload();
    }
    // QUERY INSERT
    $query = "UPDATE aplikasi SET
                nisn ='$nisn',
                nama = '$nama',
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'

                WHERE id = $id
    ";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "SELECT * FROM aplikasi
            WHERE
            nama LIKE '%$keyword%' OR
            nisn LIKE '%$keyword%' OR
            email LIKE '%$keyword%' OR
            jurusan LIKE '%$keyword%'

    ";
    return query($query);
}

function register($data)
{
    global $conn;
    $username = strtolower(stripslashes($data["username"]));
    $email = $data["email"];
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);


    // cek username

    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
    alert('username yang dipilih telah terdaftar!');
    </script>
    ";
        return false;
    }

    $result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
    alert('email yang dipilih telah terdaftar!');
    </script>
    ";
        return false;
    }

    // cek password
    if ($password !== $password2) {
        echo "<script>
        alert('password tidak sama');
        </script>";
        return false;
    }
    // enkripsi passwor
    $password = password_hash($password, PASSWORD_DEFAULT);
    // $password = md5($password); md string ini bisa di reverse ygy

    // tambah data registrasi
    mysqli_query($conn, "INSERT IGNORE INTO user 
                         VALUES 
                        ('','$username', '$email', '$password')");
    return mysqli_affected_rows($conn);
}

// pagination

$jumlahPagePer = 6;
$jumlahData = count(query("SELECT * FROM aplikasi"));
$jumlahPage = ceil($jumlahData / $jumlahPagePer);
$pageNow = (isset($_GET["page"])) ? $_GET["page"] : 1;

// pageNow
$awalPage = ($jumlahPagePer * $pageNow - $jumlahPagePer);

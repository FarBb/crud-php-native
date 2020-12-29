<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location:login.php");
    exit;
}

require 'functions.php';
//cek apakah tombol submit sudah ditekan apa belom?
if (isset($_POST["submit"])) {
    //var_dump($_POST); //untuk melihat data sudah tampil apa belom
    //var_dump($_FILES); //untuk menampilkan data gambar

    //cek apakah data berhasil ditambahkan atau tidak?

    // mysqli_affetch_row function digunakan untuk melihat ada data yang mempengaruhi database atau tidak. jika ada = 1, jika ada kesalahan = -1

    if (tambah($_POST) > 0) {
        echo "
        <script>
            alert('Data Berhasil ditambahkan');
            document.location.href='index.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Data Gagal Ditambahkan');
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Data Mahasiswa</title>
</head>

<body>
    <h1>Tambah Data Mahasiswa</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nim">Nim : </label>
                <input type="text" name="nim" id="nim">
            </li>
            <li>
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama">
            </li>
            <li>
                <label for="email">Email</label>
                <input type="text" name="email" id="email">
            </li>
            <li>
                <label for="jurusan">jurusan</label>
                <input type="text" name="jurusan" id="jurusan">
            </li>
            <li>
                <label for="gambar">gambar</label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Tambah Data</button>
            </li>
        </ul>
    </form>
</body>

</html>
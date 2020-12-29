<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location:login.php");
    exit;
}

require 'functions.php';

//ambil data di url
$tangkap_id_url = $_GET["id"];

//query data mahasiwa berdasarkan id dari url
$mahasiswa = query("SELECT * FROM mahasiswa WHERE id = $tangkap_id_url")[0];


if (isset($_POST["submit"])) {

    //data berhasil ditambahkan atau tidak?
    if (ubah($_POST) > 0) {
        echo "
        <script>
            alert('Data Berhasil Diperbarui');
            document.location.href='index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data Gagal Diperbarui');
            document.location.href='index.php';
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
    <title>Ubah Data | Mahasiswa</title>
</head>

<body>
    <h1>Ubah Data Mahasiswa</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <input type="hidden" name="id" id="id" value="<?= $mahasiswa['id'] ?>">
            <input type="hidden" name="gambarlama" id="gambarlama" value="<?= $mahasiswa['gambar'] ?>">
            <li>
                <label for="nim">NIM : </label>
                <input type="text" name="nim" id="nim" value="<?= $mahasiswa['nim'] ?>">
            </li>
            <li>
                <label for="nama">NAMA : </label>
                <input type="text" name="nama" id="nama" value="<?= $mahasiswa['nama'] ?>">
            </li>
            <li>
                <label for="email">EMAIL : </label>
                <input type="text" name="email" id="email" value="<?= $mahasiswa['email'] ?>">
            </li>
            <li>
                <label for="jurusan">JURUSAN : </label>
                <input type="text" name="jurusan" id="jurusan" value="<?= $mahasiswa['jurusan'] ?>">
            </li>
            <li>
                <label for="gambar">GAMBAR : </label><br>
                <img src="img/<?= $mahasiswa['gambar'] ?>" alt="" width="50"><br>
                <input type="file" name="gambar" id="gambar"></li>
            <br>
            <li>
                <button type="submit" name="submit">Edit Data</button>
            </li>
        </ul>
    </form>
</body>

</html>
<?php
session_start();
require 'functions.php';

if (!isset($_SESSION['login'])) {
    header("Location:login.php");
    exit;
}

$mahasiswa = query("SELECT * FROM mahasiswa");

//jika tombol cari di klik maka data mahasiswa yang ditampilakan semua akan ditimpa dengan yang ada true di cari
if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Admin</title>
</head>

<body>
    <a href="logout.php">Logout</a>
    <h1>Daftar Mahasiswa</h1>

    <a href="tambah.php">tambah data mahasiswa</a>
    <br><br>

    <form action="" method="POST">
        <input type="text" name="keyword" size="30" placeholder="Masukan keyword pencarian" autofocus autocomplete="off">
        <button type="submit" name="cari">Cari!</button>
    </form>
    <br>

    <table border=" 1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No.</th>
            <th>NIM</th>
            <th>NAMA</th>
            <th>EMAIL</th>
            <th>JURUSAN</th>
            <th>GAMBAR</th>
            <th>AKSI</th>
        </tr>
        <?php
        $a = 1;
        foreach ($mahasiswa as $row) : ?>
            <tr>
                <td><?= $a ?></td>
                <td><?= $row["nim"] ?></td>
                <td><?= $row["nama"] ?></td>
                <td><?= $row["email"] ?></td>
                <td><?= $row["jurusan"] ?></td>
                <td><img src="img/<?= $row["gambar"] ?>" alt="" width="80px"></td>
                <td>
                    <button><a href="ubah.php?id=<?= $row['id']; ?>"> Edit </a></button>
                    <button><a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('Apakah Anda Ingin Menghapus Data Mahasiswa');">Delete</a></button>
                </td>
            </tr>
        <?php
            $a++;
        endforeach; ?>
    </table>
</body>

</html>
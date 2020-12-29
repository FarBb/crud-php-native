<?php
//koneksi database
$conn = mysqli_connect("localhost", "root", "", "php_dasar");


function query($kuery)
{
    global $conn;
    $result = mysqli_query($conn, $kuery);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $conn;
    //untuk menangkap data dari post tambah mahasiswa
    //htmlspesialchars menjadikan inputan html menjadi char

    $nim     = htmlspecialchars($data["nim"]);
    $nama    = htmlspecialchars($data["nama"]);
    $email   = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);

    // upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    //memasukan data yang ditangkap ke dalam database

    $query = "INSERT INTO mahasiswa VALUES ('','$nim','$nama','$email','$jurusan','$gambar')";

    mysqli_query($conn, $query);

    //mengembalikan berupa angka yang masuk ke database

    return mysqli_affected_rows($conn);
}


function upload()
{
    $namafile          = $_FILES['gambar']['name'];
    $ukuranfile        = $_FILES['gambar']['size'];
    $error             = $_FILES['gambar']['error'];
    $tempatpenyimpanan = $_FILES['gambar']['tmp_name'];


    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "
        <script>
            alert('Pilih Gambar Terlebih Dahulu');
        </script>
        ";
        return false;
    }


    // cek apakah yang diupload adalah gambar
    $ekstensigambarvalid = ['jpg', 'jpeg', 'png'];
    $ekstensigambar = explode('.', $namafile);
    $ekstensigamabr = strtolower(end($ekstensigambar));

    //gambar yang diupload + dan formatnya jika bener maka program true, jika salah program tidak dijalankan.
    if (!in_array($ekstensigamabr, $ekstensigambarvalid)) {
        echo "
        <script>
            alert('Yang ada Upload Bukan Gambar');
        </script>
        ";
    }

    // cek jika ukurannya terlalu besar
    // gambar 1000000 = 1mb
    if ($ukuranfile > 1000000) {
        echo "
        <script>
            alert('Ukuran Gambar Terlalu Besar');
        </script>
        ";
    }

    //lolos pengecekan, gambar siap diupload
    // move_uploaded_file($tempatpenyimpanan, 'img/' . $namafile);

    //jika pake cara diatas, jika ada nama file foto yang sama maka akan diganti dengan file foto yang baru. untuk mengatasinya maka kita membuat uniqid yang dimana membuat string secara random

    $namafilebaru = uniqid();
    $namafilebaru .= '.'; //dirangkai atau disambungkan dengan .
    $namafilebaru .= $ekstensigamabr; //format ekstensi gambar

    move_uploaded_file($tempatpenyimpanan, 'img/' . $namafilebaru);

    return $namafilebaru;
}



function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    global $conn;

    $id      = $data['id'];
    $nim     = htmlspecialchars($data['nim']);
    $nama    = htmlspecialchars($data['nama']);
    $email   = htmlspecialchars($data['email']);
    $jurusan = htmlspecialchars($data['jurusan']);
    $gambarlama  = htmlspecialchars($data['gambarlama']);

    //cek apakah user pilih gambar baru
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarlama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE mahasiswa SET
                        nim     = '$nim',
                        nama    = '$nama',
                        email   = '$email',
                        jurusan = '$jurusan',
                        gambar  = '$gambar'
                        
                        WHERE id = $id
                        ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function cari($data_pencarian)
{
    $query = "SELECT * FROM mahasiswa
                WHERE
                nama LIKE '%$data_pencarian%' OR
                nim LIKE '%$data_pencarian%' OR
                email LIKE '%$data_pencarian%' OR
                jurusan LIKE '%$data_pencarian%'
                ";
    return query($query);
}


function registrasi($pendaftaran)
{
    global $conn;

    $username = strtolower(stripslashes($pendaftaran["username"]));
    $password = $pendaftaran["password"];
    $password2 = $pendaftaran["password2"];

    //cek apakah ada username yang sama di dalam database
    $cek_user = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    if (mysqli_fetch_assoc($cek_user)) {
        echo "
        <script>
            alert('Username Sudah Terdaftar!');
        </script>
        ";
        return false;
    }


    //cek konfirmasi password
    if ($password !== $password2) {
        echo "
        <script>
            alert('Password Tidak Sesuai');
        </script>
        ";
        return false;
    }

    //enkripsi password
    $enkripsi_password = password_hash($password, PASSWORD_DEFAULT);

    //masukan kedalam database
    $query = "INSERT INTO user VALUES ('','$username','$enkripsi_password')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

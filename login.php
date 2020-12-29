<?php
session_start();
require 'functions.php';

//cek cookie
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    //ambil username berdasarkan id
    $result = mysqli_query($conn, "SELECT * FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    //cek cookie dan username

    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}



if (isset($_SESSION['login'])) {
    header("Location:index.php");
    exit;
}


if (isset($_POST['login'])) {

    $username = $_POST["username"];
    $pass = $_POST["password"];

    $cek_username = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    //cek username
    if (mysqli_num_rows($cek_username) === 1) {

        //cek password
        $row = mysqli_fetch_assoc($cek_username);

        if (password_verify($pass, $row['password'])) {
            echo "
            <script>
                alert('Login Berhasil');
            </script>
            ";
            //set session
            $_SESSION["login"] = true;

            // cek remember me
            if (isset($_POST['remember'])) {
                //buat cookie
                setcookie('id', $row['id'], time() + 600);
                setcookie('key', hash('sha256', $row['username']), time() + 600);
            }
            header("Location:index.php");
            exit;
        }
    }
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Halaman Login</title>
</head>

<body>
    <h1>Halaman Login</h1>
    <?php if (isset($error)) : ?>
        <p style="font-style: italic; color:red">Password dan Username salah</p>
    <?php endif; ?>
    <form action="" method="post">
        <ul>
            <li>
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </li>
            <li>
                <label for="password">Password</label>
                <input type="password" name="password" id="password">
            </li>
            <li>
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember Me</label>
            </li>
            <li>
                <button name="login" type="submit">Login</button>
            </li>
        </ul>
    </form>
</body>

</html>
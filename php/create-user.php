<?php
require_once "./connect.php";
session_start();

if (!isset($_SESSION['login']) || $_SESSION['is_admin'] != '1') {
    header('Location: ../login.php');
    die();
}

if (isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['username']) && $_POST['username'] != "" && isset($_POST['password']) && $_POST['password'] != "") {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? $_POST['is_admin'] : '0';

    // check if username already exist
    $query = "SELECT * FROM blog_user WHERE username='$username'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<script>alert("Username sudah ada")</script>';
    } else {
        // create user
        $query = "INSERT INTO blog_user(name, username, password, is_admin) VALUES ('".$name."','".$username."','".$password."','".$is_admin."')";
        $result = mysqli_query($connect,$query);

        if($result) {
            header('Location: ./admin.php');
            die();
        } else {
            echo '<script>alert("Gagal membuat akun")</script>';
        }
    }
}
?>
<form action="" method="POST">
    <label for="">Nama</label>
    <input type="text" name="name">
    <label for="">Username</label>
    <input type="text" name="username">
    <label for="">Password</label>
    <input type="password" name="password">
    <button type="submit">Tambah</button>
</form>

<?php
require_once "../connect.php";
require_once "../FlashMessage.php";
session_start();

if (!isset($_SESSION['login']) || $_SESSION['is_admin'] != '1') {
    header('Location: ../../login.php');
    die();
}

if (isset($_POST['name']) && $_POST['name'] != "" && isset($_POST['username']) && $_POST['username'] != "" && isset($_POST['password']) && $_POST['password'] != "") {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = password_hash(mysqli_real_escape_string($connect, $_POST['password']), PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? $_POST['is_admin'] : '0';

    // check if username already exist
    $query = "SELECT * FROM blog_user WHERE username='$username'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        FlashMessage::set_err('Username sudah ada');
        header('Location: ../../create-user.php');
        die();
    } else {
        // create user
        $query = "INSERT INTO blog_user(name, username, password, is_admin) VALUES ('".$name."','".$username."','".$password."','".$is_admin."')";
        $result = mysqli_query($connect,$query);

        if($result) {
            FlashMessage::set_success('Berhasil tambah user');
            header('Location: ../../admin.php');
            die();
        } else {
            FlashMessage::set_err('Gagal membuat user');
            header('Location: ../../create-user.php');
            die();
        }
    }
} else {
    FlashMessage::set_err('Masukkan semua data');
    header('Location: ../../create-user.php');
    die();
}
?>

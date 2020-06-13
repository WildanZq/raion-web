<?php
require_once "./connect.php";
require_once "./FlashMessage.php";
session_start();

if (isset($_SESSION['login'])) {
    header('Location: ../blog.php');
    die();
}

if (isset($_POST['username']) && $_POST['username'] != "" && isset($_POST['password']) && $_POST['password'] != "") {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    $query = "SELECT * FROM blog_user WHERE username='$username'";
    $result = mysqli_query($connect, $query);

    // if username found
    if($result && mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        $hash = $row['password'];

        // if password match so create session
        if (password_verify($password, $hash)) {
            $id = $row['id'];
            $username = $row['username'];
            $is_admin = $row['is_admin'];

            $_SESSION['login'] = TRUE;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = $is_admin;
            
            header('Location: ../blog.php');
            die();
        } else {
            FlashMessage::set_err('Password salah');
            header('Location: ../login.php');
            die();
        }
    } else {
        FlashMessage::set_err('Username tidak ditemukan');
        header('Location: ../login.php');
        die();
    }
} else {
    FlashMessage::set_err('Masukkan semua data');
    header('Location: ../login.php');
}
?>

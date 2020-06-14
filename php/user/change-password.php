<?php
require_once "../connect.php";
require_once "../FlashMessage.php";
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: ../../login.php');
    die();
}

if (isset($_POST['password']) && $_POST['password'] != "" && isset($_POST['password-new']) && $_POST['password-new'] != "" && isset($_POST['password-confirm']) && $_POST['password-confirm'] != "") {
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $password_new = mysqli_real_escape_string($connect, $_POST['password-new']);
    $password_confirm = mysqli_real_escape_string($connect, $_POST['password-confirm']);
    $id = $_SESSION['id'];

    if ($password_new != $password_confirm) {
        FlashMessage::set_err('Password tidak sama');
        header('Location: ../../setting.php');
        die();
    }
    if (strlen($password_new) < 6) {
        FlashMessage::set_err('Password minimal 6 karakter');
        header('Location: ../../setting.php');
        die();
    }

    $query = "SELECT * FROM blog_user WHERE id='$id'";
    $result = mysqli_query($connect, $query);

    // if username found
    if($result && mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        $hash = $row['password'];

        // if password match so create session
        if (password_verify($password, $hash)) {
            $password_new = password_hash($password_new, PASSWORD_DEFAULT);

            $query = "UPDATE blog_user SET password = '$password_new' WHERE id='$id'";
            $result = mysqli_query($connect,$query);

            if($result) {
                FlashMessage::set_success('Berhasil ubah password');
                header('Location: ../../setting.php');
                die();
            } else {
                FlashMessage::set_err('Gagal ubah password');
                header('Location: ../../setting.php');
                die();
            }
        } else {
            FlashMessage::set_err('Password salah');
            header('Location: ../../setting.php');
            die();
        }
    } else {
        FlashMessage::set_err('Username tidak ditemukan');
        header('Location: ../../setting.php');
        die();
    }
} else {
    FlashMessage::set_err('Masukkan semua data');
    header('Location: ../../setting.php');
    die();
}
?>

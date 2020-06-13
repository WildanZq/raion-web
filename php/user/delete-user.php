<?php
require_once "../connect.php";
require_once "../FlashMessage.php";
session_start();

if (!isset($_SESSION['login']) || $_SESSION['is_admin'] != '1') {
    header('Location: ../../login.php');
    die();
}

if (isset($_GET['id']) && $_GET['id'] != "") {
    $id = $_GET['id'];

    // check if the user itself
    if ($id == $_SESSION['id']) {
        FlashMessage::set_err('Tidak dapat menghapus diri sendiri');
        header('Location: ../../admin.php');
        die();
    }

    // check if user exist
    $query = "SELECT * FROM blog_user WHERE id='$id'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        $query = "DELETE FROM blog_user WHERE id='$id'";
        $result = mysqli_query($connect,$query);

        if($result) {
            FlashMessage::set_success('Berhasil hapus user');
            header('Location: ../../admin.php');
            die();
        } else {
            FlashMessage::set_err('Gagal hapus user');
            header('Location: ../../admin.php');
            die();
        }
    } else {
        FlashMessage::set_err('User tidak ditemukan');
        header('Location: ../../admin.php');
        die();        
    }
} else {
    FlashMessage::set_err('Masukkan semua data');
    header('Location: ../../admin.php');
    die();
}
?>

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

    // check if blog exist
    $query = "SELECT * FROM blog WHERE id='$id'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        $query = "DELETE FROM blog WHERE id='$id'";
        $result = mysqli_query($connect,$query);

        if($result) {
            FlashMessage::set_success('Berhasil hapus blog');
            header('Location: ../../blog.php');
            die();
        } else {
            FlashMessage::set_err('Gagal hapus blog');
            header('Location: ../../blog-detail.php?id='.$_GET['id']);
            die();
        }
    } else {
        FlashMessage::set_err('Blog tidak ditemukan');
        header('Location: ../../blog.php');
        die();        
    }
} else {
    FlashMessage::set_err('Masukkan semua data');
    header('Location: ../../blog.php');
    die();
}
?>

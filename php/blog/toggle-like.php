<?php
require_once "../connect.php";
require_once "../FlashMessage.php";
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: ../../login.php');
    die();
}

if (isset($_GET['id']) && $_GET['id'] != "") {
    $id = $_GET['id'];

    // check if blog exist
    $query = "SELECT blog.id AS blog_id, blog_like.id AS like_id FROM blog
            LEFT JOIN blog_like ON blog_like.blog = blog.id AND blog_like.blog_user = '".$_SESSION['id']."'
            WHERE blog.id = $id";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $query = '';

        // check if not already liked
        if (!isset($row['like_id']) || $row['like_id'] == '') {
            $query = "INSERT INTO blog_like(blog_user, blog) VALUES ('".$_SESSION['id']."', '".$_GET['id']."')";
        } else {
            $query = "DELETE FROM blog_like WHERE id = ".$row['like_id'];
        }

        $result = mysqli_query($connect,$query);

        if($result) {
            FlashMessage::set_success('Berhasil');
            header('Location: ../../blog-detail.php?id='.$_GET['id']);
            die();
        } else {
            FlashMessage::set_err('Gagal');
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

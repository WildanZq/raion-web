<?php
require_once "../connect.php";
require_once "../FlashMessage.php";
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: ../../login.php');
    die();
}

if (isset($_POST['title']) && $_POST['title'] != "" && isset($_POST['content']) && $_POST['content'] != "") {
    $title = mysqli_real_escape_string($connect, $_POST['title']);
    $content = trim($_POST['content']);
    $content = str_replace("\n", '<br/>', $content);
    $content = mysqli_real_escape_string($connect, $content);
    $img = null;
    if (isset($_POST['img'])) {
        $img = mysqli_real_escape_string($connect, $_POST['img']);
    }

    // check if url is image
    if ($img != null) {
        $supported_image = array('gif','jpg','jpeg','png','bmp','svg');

        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

        if (in_array($ext, $supported_image)) {}
        else {
            FlashMessage::set_err('URL tidak supported');
            header('Location: ../../create-blog.php');
            die();
        }
    }

    $query = "INSERT INTO blog(blog_user, title, img, content) VALUES ('".$_SESSION['id']."','".$title."','".$img."','".$content."')";
    $result = mysqli_query($connect,$query);

    if($result) {
        FlashMessage::set_success('Berhasil tambah blog');
        header('Location: ../../blog.php');
        die();
    } else {
        FlashMessage::set_err('Gagal membuat blog');
        header('Location: ../../create-blog.php');
        die();
    }
} else {
    FlashMessage::set_err('Masukkan semua data');
    header('Location: ../../create-blog.php');
    die();
}
?>

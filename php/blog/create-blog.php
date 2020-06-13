<?php
require_once "../connect.php";
require_once "../FlashMessage.php";
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: ../../login.php');
    die();
}

if (isset($_POST['title']) && $_POST['title'] != "" && isset($_POST['content']) && $_POST['content'] != "") {
    $title = $_POST['title'];
    $content = trim($_POST['content']);
    $content = str_replace("\n", '<br/>', $content);
    $img = null;
    if (isset($_POST['img'])) {
        $img = $_POST['img'];
    }

    // check if url is image
    if ($img != null) {
        $url_headers=get_headers($img, 1);
        if(isset($url_headers['Content-Type'])){
            $type = strtolower($url_headers['Content-Type']);

            $valid_image_type=array();
            $valid_image_type['image/png']='';
            $valid_image_type['image/jpg']='';
            $valid_image_type['image/jpeg']='';
            $valid_image_type['image/gif']='';
            $valid_image_type['image/svg']='';
            $valid_image_type['image/svg+xml']='';
            $valid_image_type['image/bmp']='';

            if (!isset($valid_image_type[$type])) {
                FlashMessage::set_err('URL tidak supported');
                header('Location: ../../create-blog.php');
                die();
            }
        } else {
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

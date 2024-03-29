<?php
require_once "./php/FlashMessage.php";
require_once "./php/connect.php";

function getAllBlog($connect) {
    $select_liked = '';
    $join_liked = '';
    if (isset($_SESSION['id']) && $_SESSION['id'] != '') {
        $select_liked = 'blog_like.blog AS liked,';
        $join_liked = "LEFT JOIN blog_like ON blog_like.blog = blog.id AND blog_like.blog_user = '".$_SESSION['id']."'";
    }

    $query = "SELECT blog.id, title, img, content, created_at, name, $select_liked
            CASE
                WHEN likes.id IS NULL THEN 0
                ELSE COUNT(*)
            END AS total_like
            FROM blog
            JOIN blog_user ON blog_user.id = blog.blog_user
            $join_liked
            LEFT JOIN blog_like AS likes ON likes.blog = blog.id
            GROUP BY blog.id
            ORDER BY created_at DESC";
    $result = mysqli_query($connect, $query);

    $r = '';
    if($result) {
        if($total_row = mysqli_num_rows($result)) {
            $count = 0;
            while($row = mysqli_fetch_assoc($result)) {
                $count++;
                $date = new DateTime($row['created_at']);
                $date = $date->format('d M Y');
                $class = 'col-lg-3 col-md-4 col-sm-6';
                $big = '';
                $img = './assets/img/default.jpg';
                if (isset($row['img']) && $row['img'] != '' && $row['img'] != null) {
                    $img = $row['img'];
                }
                $name = 'Deleted User';
                if (isset($row['name']) && $row['name'] != '' && $row['name'] != null) {
                    $name = $row['name'];
                }
                $heart = '♡';
                if (isset($row['liked']) && $row['liked'] != '') {
                    $heart = '♥';
                }
                if ($total_row >= 5) {
                    if ($count == 1) {
                        $class = 'col-md-5';
                        $big = 'big';
                    }
                    if ($count == 2) {
                        $r .= '<div class="col-md-7"><div class="row">';
                    }
                    if ($count >= 2 && $count <= 5) {
                        $class = 'col-sm-6';
                    }
                }
                $r .= '
                <div class="'.$class.'">
                    <a href="blog-detail.php?id='.$row['id'].'" class="card shadow '.$big.'">
                        <img class="card-img-top" src="'.$img.'" alt="Banner Artikel">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h2 class="h5 card-title text-truncate">'.$row['title'].'</h2>
                                <span class="card-heart">
                                    <span class="icon">'.$heart.'</span>
                                    <span class="count">'.$row['total_like'].'</span>
                                </span>
                            </div>
                            <div class="card-label">
                                <span>'.$name.'</span>
                                <span>'.$date.'</span>
                            </div>
                            <div class="text-truncate card-desc">
                                <p>'.$row['content'].'</p>
                            </div>
                        </div>
                    </a>
                </div>
                ';
                if ($total_row >= 5) {
                    if ($count == 3) {
                        $r .= '</div><div class="row">';
                    }
                    if ($count == 5) {
                        $r .= '</div></div>';
                    }
                }
            }
        }
    } else {
        return false;
    }

    return $r;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#272381">
    <meta name="description" content="Raion Community adalah salah satu Lembaga Semi Otonom (LSO) yang berada di lingkungan Fakultas Ilmu Komputer yang bergerak dibidang pengembangan games dan aplikasi mobile.">
    <title>Raion Community</title>
    <link rel="manifest" href="manifest.json">
    <link rel="shortcut icon" href="./assets/icon/favicon.png" type="image/x-icon">
    <link rel="apple-touch-icon" href="./assets/icon/icon-192.png">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/glide.core.min.css">
    <link rel="stylesheet" href="./assets/css/glide.theme.min.css">
    <link rel="stylesheet" href="./assets/css/toastr.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <a class="p-absolute left-0 top-0" href="index.html#home">
        <img class="logo m-main p-fixed" src="./assets/icon/logo.png" alt="Logo" id="logo">
    </a>
    <div class="side-nav-wrapper d-block d-md-none" id="side-nav">
        <div class="side-nav">
            <a href="index.html#home" class="side-nav-item nav-home">Beranda</a>
            <a href="index.html#member" class="side-nav-item">Anggota</a>
            <a href="blog.php" class="side-nav-item active">Blog</a>
            <a href="index.html#about" class="side-nav-item">Tentang</a>
            <?php
            if (isset($_SESSION['login'])) {
                echo '<a href="create-blog.php" class="side-nav-item text-primary">Tulis Artikel</a>';
                echo '<a href="setting.php" class="side-nav-item text-primary">Setting</a>';
                echo '<a href="./php/auth/logout.php" class="side-nav-item text-primary">Keluar</a>';
            } else {
                echo '<a href="login.php" class="side-nav-item text-primary">Masuk</a>';
            }
            ?>
        </div>
    </div>
    <nav class="p-fixed nav-wrapper">
        <div class="d-none d-md-flex">
            <a href="index.html#home" class="btn nav-item shadow mx-1 nav-home">Beranda</a>
            <a href="index.html#member" class="btn nav-item shadow mx-1">Anggota</a>
            <a href="blog.php" class="btn nav-item shadow mx-1 active">Blog</a>
            <a href="index.html#about" class="btn nav-item shadow mx-1">Tentang Kami</a>
            <?php
            if (isset($_SESSION['login'])) {
                echo '<a href="create-blog.php" class="btn nav-item shadow mx-1 btn-secondary">Tulis Artikel</a>';
                $username = $_SESSION['username'];
                echo '
                <button class="btn btn-secondary nav-item mx-1 shadow nav-user dropdown">
                    <span>'.$username.' ▼</span>
                    <div class="menu">
                        <a href="setting.php">Setting</a>
                        <a href="./php/auth/logout.php">Keluar</a>
                    </div>
                </button>
                ';
            } else {
                echo '<a href="login.php" class="btn nav-item shadow mx-1 btn-secondary">Masuk</a>';
            }
            ?>
        </div>
        <button class="btn nav-item shadow navbar-light d-block d-md-none" id="nav-toggler">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <div class="width-controller height-controller p-0 px-md-3 mx-4 mx-lg-5 mt-5 pt-5 blog">
        <h1 class="sub-title thin mb-3 mb-md-4 mt-5 pt-md-4">Terbaru</h1>
        <div class="row">
            <?php echo getAllBlog($connect); ?>
        </div>
    </div>
    <footer class="normal bg-primary d-flex justify-content-md-between justify-content-center align-items-center flex-column-reverse flex-md-row text-white">
        <p class="mb-0 text-center text-md-left">Developed by Marketing Raion Community 2020</p>
        <div class="d-flex mb-2 mb-md-0">
            <a href="https://www.instagram.com/raion_community/" class="icon-wrapper mx-2 instagram"></a>
            <a href="https://www.facebook.com/raioncommunity/" class="icon-wrapper mx-2 facebook"></a>
            <a href="https://twitter.com/RaionCommunity" class="icon-wrapper mx-2 twitter"></a>
            <a href="https://www.youtube.com/channel/UCM_KCSus8eODu2AlOMuIsrg" class="icon-wrapper mx-2 youtube"></a>
        </div>
    </footer>
    <script src="./assets/js/jquery-3.5.1.min.js"></script>
    <script src="./assets/js/nav.js"></script>
    <script src="./assets/js/toastr.min.js"></script>
    <?php
    if (isset($_SESSION['err_message'])) {
        echo '<script>toastr.error("'.FlashMessage::get_err().'")</script>';
    }
    if (isset($_SESSION['success_message'])) {
        echo '<script>toastr.success("'.FlashMessage::get_success().'")</script>';
    }
    ?>
</body>
</html>
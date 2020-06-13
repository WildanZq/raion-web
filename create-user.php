<?php
require_once "./php/FlashMessage.php";

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != '1') {
    header('Location: login.php');
    die();
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
            <a href="blog.php" class="side-nav-item">Blog</a>
            <a href="index.html#about" class="side-nav-item">Tentang</a>
            <a href="create-blog.php" class="side-nav-item text-primary">Tulis Artikel</a>
            <a href="setting.php" class="side-nav-item text-primary">Setting</a>
            <a href="./php/auth/logout.php" class="side-nav-item text-primary">Keluar</a>
        </div>
    </div>
    <nav class="p-fixed nav-wrapper">
        <div class="d-none d-md-flex">
            <a href="index.html#home" class="btn nav-item shadow mx-1 nav-home">Beranda</a>
            <a href="index.html#member" class="btn nav-item shadow mx-1">Anggota</a>
            <a href="blog.php" class="btn nav-item shadow mx-1">Blog</a>
            <a href="index.html#about" class="btn nav-item shadow mx-1">Tentang Kami</a>
            <a href="create-blog.php" class="btn nav-item shadow mx-1 btn-secondary">Tulis Artikel</a>
            <?php
            $username = $_SESSION['username'];
            echo '
            <button class="btn btn-secondary nav-item mx-1 shadow nav-user dropdown">
                <span>'.$username.' ▽</span>
                <div class="menu">
                    <a href="setting.php">Setting</a>
                    <a href="./php/auth/logout.php">Keluar</a>
                </div>
            </button>
            ';
            ?>
        </div>
        <button class="btn nav-item shadow navbar-light d-block d-md-none" id="nav-toggler">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <div class="width-controller p-0 px-md-3 mx-4 mx-lg-5 pt-5 d-flex justify-content-center align-items-center login">
        <div class="card">
            <div class="card-body">
                <h1 class="h4 mb-3 text-center text-primary">Tambah User</h1>
                <form action="./php/user/create-user.php" method="POST">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input class="form-control" type="text" name="name" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input class="form-control" type="text" name="username" id="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="is_admin">Level</label>
                        <select class="form-control" name="is_admin" id="is_admin">
                            <option value="0">Default</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <button class="btn btn-secondary w-100" type="submit">Tambah</button>
                    <a href="./admin.php" class="w-100 text-default text-center d-block py-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
    <footer class="normal bg-primary d-flex justify-content-md-between justify-content-center align-items-center flex-column-reverse flex-md-row text-white mt-5">
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

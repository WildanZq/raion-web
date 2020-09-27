<?php
require_once "./php/FlashMessage.php";

if (!isset($_SESSION['login'])) {
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
                <span>'.$username.' ▼</span>
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
    <div class="width-controller height-controller p-0 px-md-3 mx-4 mx-lg-5 pt-5 mt-md-5">
        <form action="./php/blog/create-blog.php" method="POST" class="mt-5 pt-md-4">
            <div class="form-group">
                <label for="title">Judul Artikel</label>
                <input type="text" name="title" class="form-control" id="title" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="img">URL Gambar</label>
                <input type="text" name="img" class="form-control" id="img" maxlength="200">
                <small id="emailHelp" class="form-text text-muted">Opsional, pastikan URL gambar bisa diakses secara langsung (supported file format: .jpg/.jpeg/.png/.bmp/.gif/.svg)</small>
            </div>
            <div class="form-group">
                <label for="content">Konten</label>
                <textarea name="content" id="content" rows="10" class="form-control" required></textarea>
                <small id="emailHelp" class="form-text text-muted">Klik enter 2x untuk jarak paragraf yang ideal</small>
            </div>
            <div class="d-flex align-items-center">
                <button class="btn btn-secondary" type="submit">Simpan</button>
                <a href="./blog.php" class="text-default px-5 py-2">Batal</a>
            </div>
        </form>
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
    <script>
        toastr.warning('Tulis artikelmu di word terlebih dahulu untuk backup jika terjadi masalah', 'Perhatian!');
    </script>
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

<?php
session_start();
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
            <?php
            if (isset($_SESSION['login'])) {
                echo '<a href="create-blog.php" class="side-nav-item text-primary">Tulis Artikel</a>';
                echo '<a href="setting.php" class="side-nav-item text-primary">Setting</a>';
                echo '<a href="./php/logout.php" class="side-nav-item text-primary">Keluar</a>';
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
            <a href="blog.php" class="btn nav-item shadow mx-1">Blog</a>
            <a href="index.html#about" class="btn nav-item shadow mx-1">Tentang Kami</a>
            <?php
            if (isset($_SESSION['login'])) {
                echo '<a href="create-blog.php" class="btn nav-item shadow mx-1 btn-secondary">Tulis Artikel</a>';
                $username = $_SESSION['username'];
                echo '
                <button class="btn btn-secondary nav-item mx-1 shadow nav-user dropdown">
                    <span>'.$username.' ▽</span>
                    <div class="menu">
                        <a href="setting.php">Setting</a>
                        <a href="./php/logout.php">Logout</a>
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
    <img class="blog-banner" src="./assets/img/default.jpg" alt="Banner Artikel">
    <div class="width-controller p-0 px-md-3 mx-4 mx-lg-5 mt-5 blog">
        <div class="row">
            <div class="col-md-9 content">
                <h1 class="mb-md-4 mb-3">Judul Artikel oia wdoia oiae foaei nfoiae nfoiae ofai neof naeoif aoe foeian foian e</h1>
                <h5 class="mb-md-4 mb-3 blog-detail">Nama Penulis | 20 Juni 2020</h5>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam dignissimos, recusandae error facilis ea pariatur, ab dolores tempore libero similique eos unde saepe totam deserunt earum ad maxime dolore illo! Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci sapiente quis commodi iusto nulla nam voluptas, quae hic porro ratione, labore animi numquam similique, fuga nesciunt aspernatur suscipit! Eius, voluptates! Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nulla natus autem reiciendis error tempora hic, nam, aut cumque eos quod asperiores. Tenetur in sed, eveniet eum ad consequatur itaque explicabo.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam dignissimos, recusandae error facilis ea pariatur, ab dolores tempore libero similique eos unde saepe totam deserunt earum ad maxime dolore illo! Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci sapiente quis commodi iusto nulla nam voluptas, quae hic porro ratione, labore animi numquam similique, fuga nesciunt aspernatur suscipit! Eius, voluptates! Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nulla natus autem reiciendis error tempora hic, nam, aut cumque eos quod asperiores. Tenetur in sed, eveniet eum ad consequatur itaque explicabo.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam dignissimos, recusandae error facilis ea pariatur, ab dolores tempore libero similique eos unde saepe totam deserunt earum ad maxime dolore illo! Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci sapiente quis commodi iusto nulla nam voluptas, quae hic porro ratione, labore animi numquam similique, fuga nesciunt aspernatur suscipit! Eius, voluptates! Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nulla natus autem reiciendis error tempora hic, nam, aut cumque eos quod asperiores. Tenetur in sed, eveniet eum ad consequatur itaque explicabo.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam dignissimos, recusandae error facilis ea pariatur, ab dolores tempore libero similique eos unde saepe totam deserunt earum ad maxime dolore illo! Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci sapiente quis commodi iusto nulla nam voluptas, quae hic porro ratione, labore animi numquam similique, fuga nesciunt aspernatur suscipit! Eius, voluptates! Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nulla natus autem reiciendis error tempora hic, nam, aut cumque eos quod asperiores. Tenetur in sed, eveniet eum ad consequatur itaque explicabo.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam dignissimos, recusandae error facilis ea pariatur, ab dolores tempore libero similique eos unde saepe totam deserunt earum ad maxime dolore illo! Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci sapiente quis commodi iusto nulla nam voluptas, quae hic porro ratione, labore animi numquam similique, fuga nesciunt aspernatur suscipit! Eius, voluptates! Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nulla natus autem reiciendis error tempora hic, nam, aut cumque eos quod asperiores. Tenetur in sed, eveniet eum ad consequatur itaque explicabo.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quam dignissimos, recusandae error facilis ea pariatur, ab dolores tempore libero similique eos unde saepe totam deserunt earum ad maxime dolore illo! Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci sapiente quis commodi iusto nulla nam voluptas, quae hic porro ratione, labore animi numquam similique, fuga nesciunt aspernatur suscipit! Eius, voluptates! Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nulla natus autem reiciendis error tempora hic, nam, aut cumque eos quod asperiores. Tenetur in sed, eveniet eum ad consequatur itaque explicabo.</p>
                <span class="card-heart">
                    <span class="icon">♡</span>
                    <span class="count">12</span>
                </span>
            </div>
            <div class="col-md-3 mt-4 mt-md-0 p-relative">
                <div class="p-sticky blog-suggestion">
                    <h2 class="sub-title thin mb-3 mb-md-4">Terbaru</h2>
                    <a href="blog-detail.php" class="card shadow">
                        <img class="card-img-top" src="./assets/img/default.jpg" alt="Banner Artikel">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h2 class="h5 card-title text-truncate">Judul Artikel</h2>
                                <span class="card-heart">
                                    <span class="icon">♡</span>
                                    <span class="count">12</span>
                                </span>
                            </div>
                            <div class="card-label">
                                <span>Nama Penulis</span>
                                <span>20 Juni 2020</span>
                            </div>
                            <div class="text-truncate card-desc">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus quos beatae obcaecati
                                    quisquam nobis, recusandae ducimus! Voluptatum, deleniti cum quia enim, aliquid commodi quibusdam
                                    placeat at rem molestiae alias nihil.</p>
                            </div>
                        </div>
                    </a>
                    <a href="blog-detail.php" class="card shadow">
                        <img class="card-img-top" src="./assets/img/default.jpg" alt="Banner Artikel">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h2 class="h5 card-title text-truncate">Judul Artikel</h2>
                                <span class="card-heart">
                                    <span class="icon">♡</span>
                                    <span class="count">12</span>
                                </span>
                            </div>
                            <div class="card-label">
                                <span>Nama Penulis</span>
                                <span>20 Juni 2020</span>
                            </div>
                            <div class="text-truncate card-desc">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus quos beatae obcaecati
                                    quisquam nobis, recusandae ducimus! Voluptatum, deleniti cum quia enim, aliquid commodi quibusdam
                                    placeat at rem molestiae alias nihil.</p>
                            </div>
                        </div>
                    </a>
                    <a href="blog-detail.php" class="card shadow">
                        <img class="card-img-top" src="./assets/img/default.jpg" alt="Banner Artikel">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h2 class="h5 card-title text-truncate">Judul Artikel</h2>
                                <span class="card-heart">
                                    <span class="icon">♡</span>
                                    <span class="count">12</span>
                                </span>
                            </div>
                            <div class="card-label">
                                <span>Nama Penulis</span>
                                <span>20 Juni 2020</span>
                            </div>
                            <div class="text-truncate card-desc">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus quos beatae obcaecati
                                    quisquam nobis, recusandae ducimus! Voluptatum, deleniti cum quia enim, aliquid commodi quibusdam
                                    placeat at rem molestiae alias nihil.</p>
                            </div>
                        </div>
                    </a>
                </div>
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
    <script src="./assets/js/nav.js"></script>
</body>
</html>
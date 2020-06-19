<?php
require_once "./php/FlashMessage.php";
require_once "./php/connect.php";

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != '1') {
    header('Location: login.php');
    die();
}

function getAllUser($connect) {
    $query = "SELECT * FROM blog_user";
    $result = mysqli_query($connect, $query);
    $r = '';
    if($result) {
        if(mysqli_num_rows($result)) {
            while($row = mysqli_fetch_assoc($result)) {
                $r .= '<tr>';
                $r .= "<td>{$row['name']}</td>";
                $r .= "<td>{$row['username']}</td>";

                $is_admin = '';
                if ($row['is_admin'] == '1') {
                    $is_admin = 'active';
                }
                $r .= '<td>
                <a class="toggler '.$is_admin.'" href="./php/user/toggle-level.php?id='.$row['id'].'"></a>
                </td>';

                if ($row['id'] == $_SESSION['id']) {
                    $r .= "<td>This is you</td>";
                } else {
                    $r .= '<td><button class="btn btn-danger btn-sm" onclick="redirectTo(\'./php/user/delete-user.php?id='.$row['id'].'\')">✖ Hapus</button></td>';
                }
                $r .= '</tr>';
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
    <link rel="stylesheet" href="./assets/css/dataTables.bootstrap4.min.css">
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
        <a href="create-user.php" class="btn btn-secondary mt-5">+ Tambah User</a>
        <div class="card mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="user-table" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Admin?</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            echo getAllUser($connect);
                            ?>
                        </tbody>
                    </table>
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
    <script src="./assets/js/jquery-3.5.1.min.js"></script>
    <script src="./assets/js/nav.js"></script>
    <script src="./assets/js/toastr.min.js"></script>
    <script src="./assets/js/jquery.dataTables.min.js"></script>
    <script src="./assets/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#user-table').DataTable();
        });

        function redirectTo(path) {
            if (confirm('Hapus User?')) {
                window.location = path;
            }
        }
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

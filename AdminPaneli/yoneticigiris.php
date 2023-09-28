<?php

require_once '../src/assets/php/baglanti.php';
require_once '../src/assets/php/fonksiyonlar.php';

$deger = $db->prepare("SELECT * FROM site_ayarlari");
$deger->execute();
$site = $deger->fetch(PDO::FETCH_ASSOC);

?>
<?php


if (isset($_SESSION['AdminIsim'])) {
    header("location:index.php");
} else { ?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $site['SiteBaslik'] ?></title>
        <link rel="shortcut icon" type="image/png" href="../src/assets/images/logos/site/<?= $site['SiteFavicon'] ?>" />
        <link rel="stylesheet" href="../src/assets/css/styles.min.css" />
    </head>

    <body>
        <!--  Body Wrapper -->
        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
            <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
                <div class="d-flex align-items-center justify-content-center w-100">
                    <div class="row justify-content-center w-100">
                        <div class="col-md-8 col-lg-6 col-xxl-3">
                            <?php

                            $AdminIsim      =   $AdminSifre       = "";
                            $AdminIsimErr   =   $AdminSifreErr    = "";
                            if (isset($_POST['YoneticiGiris'])) {

                                if (empty($_POST['AdminIsim'])) {
                                    $AdminIsimErr = "Admin İsim Alanı boş olmamalıdır.";
                                } else {
                                    $AdminIsim = filtrele($_POST['AdminIsim']);
                                }
                                if (empty($_POST['AdminSifre'])) {
                                    $AdminSifreErr = "Admin Şifre Alanı boş olmamalıdır.";
                                } else {
                                    $Sifre = str_replace(' ', '', $_POST['AdminSifre']);
                                    $AdminSifre = filtrele($Sifre);
                                }
                                if (empty($AdminIsimErr) && empty($AdminSifreErr)) {
                                    $deger = $db->prepare("SELECT * FROM yoneticiler WHERE AdminIsim=?");
                                    $deger->execute([$AdminIsim]);
                                    $admin = $deger->fetch(PDO::FETCH_ASSOC);

                                    if ($admin && password_verify($AdminSifre, $admin['AdminSifre'])) {
                                        foreach ($admin as $key => $value) {
                                            $_SESSION[$key] = $value;
                                        }
                                        header("location:index.php");
                                    } else {
                                        echo '<div class="alert alert-danger text-center" role="alert">
                                            Giriş Gerçekleştirilemedi. Tekrar Deneyiniz!
                                                </div>';
                                    }
                                }
                            }


                            ?>

                            <div class="card mb-0">
                                <?php
                                if (isset($_POST['yoneticiotogiris'])) {
                                    $AdminIsim = 'Admin';
                                    $AdminSifre = 'yoneticiadmin123';
                                }
                                ?>
                                <div class="card-body">
                                    <img src="../src/assets/images/logos/site/<?= $site['SiteResim'] ?>" class="text-nowrap logo-img text-center d-block py-3 w-100" alt="">
                                    <p class="text-center">Futbol Hakkında Her Şey...</p>
                                    <form method="POST">
                                        <button type="submit" name="yoneticiotogiris" class="btn btn-success w-100 mb-3">Yonetici girişi</button>
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Kullanıcı Adı</label>
                                            <input type="text" name="AdminIsim" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?= $AdminIsim ?>">
                                            <label for="" class="text-danger"><?= $AdminIsimErr ?></label>
                                        </div>
                                        <div class="mb-4">
                                            <label for="exampleInputPassword1" class="form-label">Şifre</label>
                                            <input type="password" name="AdminSifre" class="form-control" id="exampleInputPassword1" value="<?= $AdminSifre ?>">
                                            <label for="" class="text-danger"><?= $AdminSifreErr ?></label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                                                <label class="form-check-label text-dark" for="flexCheckChecked">
                                                    Remeber this Device
                                                </label>
                                            </div>
                                            <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
                                        </div>
                                        <button type="submit" name="YoneticiGiris" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Giriş Yap</button>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <p class="fs-4 mb-0 fw-bold">New to Modernize?</p>
                                            <a class="text-primary fw-bold ms-2" href="./authentication-register.html">Create an account</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../src/assets/libs/jquery/dist/jquery.min.js"></script>
        <script src="../src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
<?php
}

?>
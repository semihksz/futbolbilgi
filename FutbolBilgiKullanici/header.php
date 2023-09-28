<?php

require_once 'php/baglanti.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title><?= $site['SiteBaslik'] ?></title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../src/assets/images/logos/site/<?= $site['SiteFavicon'] ?>" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="libs/bootstrap/js/bootstrap.bundle.min.js">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-image" style="background-image: url('../src/assets/images/logos/220390_stadiums-in-istanbul.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%;">
            <div class="container px-5">
                <a class="navbar-brand" href="index.php"><img src="../src/assets/images/logos/site/<?= $site['SiteResim'] ?>" alt="" style="max-width: 250px;"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Anasayfa</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Müsabakalar</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                                <?php
                                foreach ($ligler as $key => $lig) { ?>
                                    <li><a class="dropdown-item" href="ligler.php?LigId=<?= $lig['LigId'] ?>"><img src="../src/assets/images/logos/ligler/<?= $lig['LigResim'] ?>" style="max-width: 20px;" alt=""> <?= $lig['LigIsim'] ?></a></li>
                                <?php }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="contact.html">Takımlar</a></li>
                        <li class="nav-item"><a class="nav-link" href="pricing.html">Futbolcular</a></li>
                        <li class="nav-item"><a class="nav-link" href="faq.html">Hakkımızda</a></li>
                        <li class="nav-item"><a class="nav-link" href="faq.html">İletişim</a></li>

                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Portfolio</a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                                <li><a class="dropdown-item" href="portfolio-overview.html">Portfolio Overview</a></li>
                                <li><a class="dropdown-item" href="portfolio-item.html">Portfolio Item</a></li>
                            </ul>
                        </li> -->
                    </ul>
                </div>
            </div>
        </nav>
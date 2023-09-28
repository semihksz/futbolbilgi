<?php require_once 'header.php'; ?>

<!-- Header-->
<header class="bg-image py-5" style="background-image: url('../src/assets/images/logos/220390_stadiums-in-istanbul.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%;">
    <div class="container px-5">
        <div class="row gx-5 align-items-center justify-content-center">
            <div class="col-lg-8 col-xl-7 col-xxl-6">
                <div class="my-5 text-center text-xl-start">
                    <h1 class="display-5 fw-bolder text-white mb-2">Futbol İstatistik'e Hoşgeldiniz.</h1>
                    <p class="lead fw-normal text-white-50 mb-4">Futbolda dair haberler, bilgiler ve istatistikler için bizi takip etmeyi unutmayın!</p>
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                        <a class="btn btn-primary btn-lg px-4 me-sm-3" href="#features">Get Started</a>
                        <a class="btn btn-outline-light btn-lg px-4" href="#!">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center">
                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="https://dummyimage.com/40x20/ced4da/6c757d" class="d-block w-100" alt="dasdas">
                        </div>
                        <div class="carousel-item">
                            <img src="https://dummyimage.com/40x20/ced4da/6c757d" class="d-block w-100" alt="lhjkj">
                        </div>
                        <div class="carousel-item">
                            <img src="https://dummyimage.com/40x20/ced4da/6c757d" class="d-block w-100" alt="252">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- stadyum resmi ekleme -->
    <!-- <img src="../src/assets/images/logos/220390_stadiums-in-istanbul.png" class="img-fluid w-100" alt="" > -->
</header>
<!-- Features section
<section class="py-5" id="features">
    <div class="container px-5 my-5">
        <div class="row gx-5">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h2 class="fw-bolder mb-0">A better way to start building.</h2>
            </div>
            <div class="col-lg-8">
                <div class="row gx-5 row-cols-1 row-cols-md-2">
                    <div class="col mb-5 h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                        <h2 class="h5">Featured title</h2>
                        <p class="mb-0">Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.</p>
                    </div>
                    <div class="col mb-5 h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-building"></i></div>
                        <h2 class="h5">Featured title</h2>
                        <p class="mb-0">Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.</p>
                    </div>
                    <div class="col mb-5 mb-md-0 h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                        <h2 class="h5">Featured title</h2>
                        <p class="mb-0">Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.</p>
                    </div>
                    <div class="col h-100">
                        <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-toggles2"></i></div>
                        <h2 class="h5">Featured title</h2>
                        <p class="mb-0">Paragraph of text beneath the heading to explain the heading. Here is just a bit more text.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- Blog preview section-->
<section class="py-5">
    <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="text-center">
                    <h2 class="fw-bolder mb-5">2022/2023 Sezonu Oyuncuları</h2>
                </div>
            </div>
        </div>
        <div class="row gx-5">


            <div class="col-lg-6 mb-5">
                <div class="card h-100 shadow border-0">
                    <a class="text-decoration-none link-dark stretched-link" href="takimlar.php">
                        <h6 class="card-title text-center fw-bold mt-3">Gol Krallığı</h6>
                    </a>
                    <?php
                    $deger = $db->query("SELECT * FROM krallar");
                    $deger->execute();
                    $krallar = $deger->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($krallar as $key => $kral) {
                        if ($kral['KralSezon'] == '2022 / 2023' && $kral['KralKategori'] == 'Gol Kralı') { ?>
                            <img class="card-img-top p-3" src="../src/assets/images/logos/takimlar/<?= $kral['KralResim'] ?>" alt="<?= $kral['KralOyuncu'] ?>" />
                    <?php }
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-6 mb-5">
                <div class="card h-100 shadow border-0">
                    <h6 class="card-title text-center fw-bold mt-3">Asist Krallığı</h6>
                    <?php
                    $deger = $db->query("SELECT * FROM krallar");
                    $deger->execute();
                    $krallar = $deger->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($krallar as $key => $kral) {
                        if ($kral['KralSezon'] == '2022 / 2023') {
                            if ($kral['KralKategori'] == 'Asist Kralı') { ?>
                                <a class="text-decoration-none link-dark stretched-link" href="takimlar.php?TakimId=<?= $kral['KralTakim'] ?>">
                                    <img class="card-img-top p-3" src="../src/assets/images/logos/takimlar/<?= $kral['KralResim'] ?>" alt="<?= $kral['KralOyuncu'] ?>" />
                                </a>
                    <?php    }
                        }
                    }
                    ?>
                </div>
            </div>


        </div>
    </div>
</section>
<!-- Testimonial section-->
<div class="py-5 bg-light">
    <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-10 col-xl-7">
                <div class="text-center">
                    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $deger = $db->query("SELECT * FROM sozler");
                            $deger->execute();
                            $sozler = $deger->fetchAll(PDO::FETCH_ASSOC);
                            shuffle($sozler);
                            foreach ($sozler as $key => $soz) {
                            ?>
                                <div class="carousel-item <?= $key === 0 ? 'active' : ''; ?>" data-bs-interval="1000">
                                    <div class="fs-4 mb-4 fst-italic">"<?= $soz['SozMetin'] ?>"</div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <img class="rounded-circle me-3" src="../src/assets/images/sozler/<?= $soz['SozResim'] ?>" alt="<?= $soz['SozIsim'] ?>" />
                                        <div class="fw-bold">
                                            <?= $soz['SozIsim'] ?>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            } ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blog preview section-->
<section class="py-5">
    <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="text-center">
                    <h2 class="fw-bolder mb-5">2022/2023 Sezonu Şampiyon Takımlar</h2>
                </div>
            </div>
        </div>
        <div class="row gx-5">
            <?php
            $deger = $db->query("SELECT * FROM sampiyonlar");
            $deger->execute();
            $sampiyonlar = $deger->fetchAll(PDO::FETCH_ASSOC);

            foreach ($sampiyonlar as $key => $sampiyon) {
                if ($sampiyon['SampiyonSezon'] == '2022 / 2023') { ?>
                    <div class="col-lg-3 mb-5">
                        <div class="card h-100 shadow border-0" style="max-width: 250px;">
                            <h6 class="card-title text-center fw-bold mt-3"><?= $sampiyon['SampiyonLig'] ?></h6>
                            <a class="text-decoration-none link-dark stretched-link" href="takimlar.php?TakimId=<?= $sampiyon['SampiyonTakim'] ?>">
                                <img class="card-img-top p-3" src="../src/assets/images/logos/takimlar/<?= $sampiyon['SampiyonResim'] ?>" alt="<?= $sampiyon['SampiyonTakim'] ?>" />
                            </a>
                        </div>
                    </div>
            <?php }
            }
            ?>

        </div>
    </div>
    <div class="container px-5 my-5">
        <div class="row gx-5 justify-content-center ">
            <div class="col-lg-4 col-xl-4 mt-3">
                <div class="text-center">
                    <h2 class="fw-bolder">- 2022/2023 Sezonu - Şampiyonlar Ligi Şampiyonu</h2>
                </div>
                <div class="card shadow border-0 mx-auto" style="max-width: 250px;">
                    <a class="text-decoration-none link-dark stretched-link" href="takimlar.php?TakimId=<?= $takimıd[7] ?>">
                        <img class="card-img-top p-3" src="../src/assets/images/logos/takimlar/<?= $takimresimleri[7] ?>" alt="..." />
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4 mt-3">
                <div class="text-center">
                    <h2 class="fw-bolder">- 2022/2023 Sezonu - UEFA Avrupa Ligi Şampiyonu</h2>
                </div>
                <div class="card shadow border-0 mx-auto" style="max-width: 250px;">
                    <a class="text-decoration-none link-dark stretched-link " href="takimlar.php?TakimId=<?= $takimıd[14] ?>">
                        <img class="card-img-top p-3" src="../src/assets/images/logos/takimlar/<?= $takimresimleri[14] ?>" alt="..." />
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-xl-4 mt-3">
                <div class="text-center">
                    <h2 class="fw-bolder">- 2022/2023 Sezonu - UEFA Avrupa Konferans Ligi Şampiyonu</h2>
                </div>
                <div class="card shadow border-0 mx-auto" style="max-width: 250px;">
                    <a class="text-decoration-none link-dark stretched-link " href="takimlar.php?TakimId=<?= $takimıd[15] ?>">
                        <img class="card-img-top p-3" src="../src/assets/images/logos/takimlar/<?= $takimresimleri[15] ?>" alt="..." />
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- Call to action-->
    <!-- <aside class="bg-primary bg-gradient rounded-3 p-4 p-sm-5 mt-5">
            <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row text-center text-xl-start">
                <div class="mb-4 mb-xl-0">
                    <div class="fs-3 fw-bold text-white">New products, delivered to you.</div>
                    <div class="text-white-50">Sign up for our newsletter for the latest updates.</div>
                </div>
                <div class="ms-xl-4">
                    <div class="input-group mb-2">
                        <input class="form-control" type="text" placeholder="Email address..." aria-label="Email address..." aria-describedby="button-newsletter" />
                        <button class="btn btn-outline-light" id="button-newsletter" type="button">Sign up</button>
                    </div>
                    <div class="small text-white-50">We care about privacy, and will never share your data.</div>
                </div>
            </div>
        </aside> -->
</section>
</main>


<?php require_once 'footer.php'; ?>
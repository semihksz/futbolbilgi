<?php
define("giriskontrol", true);
require_once 'header.php';
require_once '../src/assets/php/baglanti.php';
require_once '../src/assets/php/fonksiyonlar.php';
?>

<style>
    .custom-button {
        appearance: none;
        background-color: transparent;
        border: 0.125em solid #1A1A1A;
        border-radius: 0.9375em;
        box-sizing: border-box;
        color: #3B3B3B;
        cursor: pointer;
        display: inline-block;
        font-size: 12px;
        line-height: normal;
        margin: 0;
        min-height: 3.75em;
        min-width: 0;
        outline: none;
        padding: 1em 2.3em;
        text-align: center;
        text-decoration: none;
        transition: all 300ms cubic-bezier(.23, 1, 0.32, 1);
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        will-change: transform;
    }

    .custom-button:disabled {
        pointer-events: none;
    }

    .custom-button:hover {
        color: #fff;
        background-color: #fff;
        box-shadow: rgba(0, 0, 0, 0.25) 0 8px 15px;
        transform: translateY(-2px);
    }

    .custom-button:active {
        box-shadow: none;
        transform: translateY(0);
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="p-5">


                    <h5 class="card-title fw-semibold mb-4">Ligler</h5>
                    <?php
                    if (isset($_POST['LigEkle'])) {

                        $LigUlke            =   filtrele($_POST['LigUlke']);
                        $LigIsim            =   filtrele($_POST['LigIsim']);
                        $LigTakimSayisi     =   filtrele($_POST['LigTakimSayisi']);
                        $LigOyuncuSayisi    =   filtrele($_POST['LigOyuncuSayisi']);

                        if (empty($_POST['LigUlke']) || empty($_POST['LigIsim']) || empty($_POST['LigTakimSayisi']) || empty($_POST['LigOyuncuSayisi']) || empty($_FILES['LigResim']['name'])) {
                            echo '<div class="alert alert-danger" role="alert">
                                    Lütfen boş alan bırakmayınız.
                                        </div>';
                        } elseif (!is_string($_POST['LigUlke']) || !is_string($_POST['LigIsim'])) {
                            echo '<div class="alert alert-danger" role="alert">
                                    Lütfen sadece yazı giriniz.
                                        </div>';
                        } elseif (!is_numeric($_POST['LigTakimSayisi']) || !is_numeric($_POST['LigOyuncuSayisi'])) {
                            echo '<div class="alert alert-danger" role="alert">
                                    Lütfen sadece sayısal karakterler giriniz.
                                        </div>';
                        } elseif ($_FILES['LigResim']['error'] == 0) {
                            $izinli_uzanti = ['jpg', 'jpeg', 'png', 'svg'];
                            $dosya_uzantisi = pathinfo($_FILES['LigResim']['name'], PATHINFO_EXTENSION);
                            $izinli_boyut = 2 * 1024 * 1024;
                            if (!in_array($dosya_uzantisi, $izinli_uzanti)) {
                                echo '<div class="alert alert-danger" role="alert">
                                    Lütfen sadece izin verilen dosya uzantılarını yükleyiniz.
                                        </div>';
                            } elseif ($_FILES['LigResim']['size'] > $izinli_boyut) {
                                echo '<div class="alert alert-danger" role="alert">
                                    Lütfen sadece izin verilen boyutlarda dosya yükleyiniz.
                                        </div>';
                            } else {
                                $gecici_isim = $_FILES['LigResim']['tmp_name'];
                                $resim_isim = $_FILES['LigResim']['name'];
                                $rastgele_sayi = rand(1000, 9999);
                                $isim = $rastgele_sayi . $resim_isim;

                                move_uploaded_file($gecici_isim, "../src/assets/images/logos/ligler/$isim");

                                $ekle = $db->prepare("INSERT INTO ligler SET LigUlke=?, LigIsim=?, LigTakimSayisi=?, LigOyuncuSayisi=?, LigResim=?");
                                $ekle->execute([
                                    $LigUlke,
                                    $LigIsim,
                                    $LigTakimSayisi,
                                    $LigOyuncuSayisi,
                                    $isim,
                                ]);
                            }
                            if ($ekle) {
                                header("location:ligler.php");
                            }
                        }
                    }



                    ?>
                    <!-- Button trigger modal -->
                    <button type="submit" class="btn btn-success w-25" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Yeni Lig Ekle</button>
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Yeni Lig Ekle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="" class="form-label ">Resim Ekle</label>
                                            <input class="form-control form-control " id="formFileSm" type="file" name="LigResim">
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label ">Ülke</label>
                                            <input type="text" class="form-control shadow rounded" name="LigUlke" aria-describedby="helpId">
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Lig</label>
                                            <input type="text" class="form-control shadow rounded" name="LigIsim" aria-describedby="helpId">
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Takım Sayısı</label>
                                            <input type="number" class="form-control shadow rounded" name="LigTakimSayisi" aria-describedby="helpId">
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Oyuncu Sayısı</label>
                                            <input type="number" class="form-control shadow rounded" name="LigOyuncuSayisi" aria-describedby="helpId">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" name="LigEkle" class="btn btn-success">Ekle</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal End -->


                    <div class="card-body p-4">

                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle" id="tablo">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">LigId</h6>
                                        </th>

                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Ülke</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Lig</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Lig</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Takım Sayısı</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Oyuncu Sayısı</h6>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $deger = $db->query("SELECT * FROM ligler");
                                    $deger->execute();
                                    $ligler = $deger->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($ligler as $key => $lig) { ?>
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0"><?= $lig['LigId'] ?></h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1"><?= $lig['LigUlke'] ?></h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <img src="../src/assets/images/logos/ligler/<?= $lig['LigResim'] ?>" alt="<?= $lig['LigIsim'] ?>" style="max-width: 80px; max-height: 80px;">
                                            </td>
                                            <td class="border-bottom-0">
                                                <a href="ligleriduzenle.php?LigId=<?= $lig['LigId'] ?>" class="custom-button">
                                                    <h6 class="fw-semibold mb-1"><?= $lig['LigIsim'] ?></h6>
                                                </a>
                                            </td>
                                            <td class="border-bottom-0">
                                                <span class="badge bg-primary rounded-3 fw-semibold"><?= $lig['LigTakimSayisi'] ?></h6>
                                                    </a>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="badge bg-primary rounded-3 fw-semibold"><?= $lig['LigOyuncuSayisi'] ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
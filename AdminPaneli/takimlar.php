<?php
define("giriskontrol", true);
require_once 'header.php';
require_once '../src/assets/php/baglanti.php';
require_once '../src/assets/php/fonksiyonlar.php';
$veri = $db->prepare("SELECT * FROM ligler");
$veri->execute();
$ligler = $veri->fetchAll(PDO::FETCH_ASSOC);

$veri = $db->prepare("SELECT * FROM takimlar");
$veri->execute();
$takimlar = $veri->fetchAll(PDO::FETCH_ASSOC);
$takimsayisi = count($takimlar);


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
                    <h5 class="card-title fw-semibold mb-4">Takımlar</h5>

                    <a href="takimlarekle.php" class="btn btn-success w-25 mb-3">Yeni Takım Ekle</a><br>

                    <!-- Listelenecek olan lig seçimi -->
                    <label for="" class="form-label">Lig Seçiniz</label>
                    <form method="GET">
                        <div class="row">
                            <div class="col-lg-10">
                                <select class="form-select form-select-lg" name="TakimLig">
                                    <option selected value="1">Bir Lig Seçiniz</option>
                                    <?php

                                    foreach ($ligler as $key => $lig) { ?>

                                        <option><?= $lig['LigIsim'] ?></option>
                                    <?php }

                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" name="" class="btn btn-primary">Ara</button>
                            </div>
                        </div>
                    </form>


                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle" id="tablo">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">LigId</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Lig</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Takım Resmi</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Takımlar</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Oyuncu Sayısı</h6>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- get ile bir değer gelmiyorsa veya getten 1 değeri geliyorsa bütün takımları listeleme -->
                                    <!-- ancak getten ligin ismi geliyorsa o isme göre verileri getirme -->
                                    <?php
                                    if (isset($_GET['LigIsim'])) {
                                        //ligler.php sayfasından basılan takım ligine göre takimlar.php sayfasında listeleme yapma
                                        // getten gelen takim ligi değerini alıp boşlukları düzenleyip burada listeledik
                                        $arama = $_GET['LigIsim'];
                                        $arama = str_replace('', ' ', $arama);
                                        $veri = $db->prepare("SELECT * FROM takimlar WHERE TakimLig= ?");
                                        $veri->execute([$arama]);
                                        $takimlar = $veri->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($takimlar as $key => $takim) { ?>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0"><?= $takim['TakimId'] ?></h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1"><?= $takim['TakimLig'] ?></h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <img src="../src/assets/images/logos/takimlar/<?= $takim['TakimResim'] ?>" alt="" style="max-width: 80px; max-height: 80px;">
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="takimlariduzenle.php?TakimId=<?= $takim['TakimId'] ?>" class="custom-button">
                                                        <h6 class="fw-semibold mb-1"><?= $takim['TakimIsim'] ?></h6>
                                                    </a>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-primary rounded-3 fw-semibold"><?= $takim['TakimOyuncuSayisi'] ?></span>
                                                    </div>
                                                </td>

                                            </tr>
                                        <?php }
                                    } elseif (!isset($_GET['TakimLig']) || $_GET['TakimLig'] == "1") {
                                        $veri = $db->prepare("SELECT * FROM takimlar");
                                        $veri->execute();
                                        $takimlar = $veri->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($takimlar as $key => $takim) { ?>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0"><?= $takim['TakimId'] ?></h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1"><?= $takim['TakimLig'] ?></h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <img src="../src/assets/images/logos/takimlar/<?= $takim['TakimResim'] ?>" alt="" style="max-width: 80px; max-height: 80px;">
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="takimlariduzenle.php?TakimId=<?= $takim['TakimId'] ?>" class="custom-button">
                                                        <h6 class="fw-semibold mb-1"><?= $takim['TakimIsim'] ?></h6>
                                                    </a>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-primary rounded-3 fw-semibold"><?= $takim['TakimOyuncuSayisi'] ?></span>
                                                    </div>
                                                </td>

                                            </tr>
                                        <?php }
                                    } elseif (isset($_GET['TakimLig'])) {
                                        //getteki değerin ortasındaki + değişkenini kaldırdık bu sayede hata almadık
                                        $arama = $_GET['TakimLig'];
                                        $arama = str_replace('+', ' ', $arama);

                                        $veri = $db->prepare("SELECT * FROM takimlar WHERE TakimLig= ?");
                                        $veri->execute([$arama]);
                                        $takimlar = $veri->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($takimlar as $key => $takim) { ?>
                                            <tr>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-0"><?= $takim['TakimId'] ?></h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <h6 class="fw-semibold mb-1"><?= $takim['TakimLig'] ?></h6>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <img src="../src/assets/images/logos/takimlar/<?= $takim['TakimResim'] ?>" alt="" style="max-width: 80px; max-height: 80px;">
                                                </td>
                                                <td class="border-bottom-0">
                                                    <a href="takimlariduzenle.php?TakimId=<?= $takim['TakimId'] ?>" class="custom-button">
                                                        <h6 class="fw-semibold mb-1"><?= $takim['TakimIsim'] ?></h6>
                                                    </a>
                                                </td>
                                                <td class="border-bottom-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="badge bg-primary rounded-3 fw-semibold"><?= $takim['TakimOyuncuSayisi'] ?></span>
                                                    </div>
                                                </td>

                                            </tr>
                                    <?php }
                                    } ?>
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
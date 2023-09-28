<?php
define("giriskontrol", true);
require_once 'header.php';
require_once '../src/assets/php/baglanti.php';
require_once '../src/assets/php/fonksiyonlar.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="p-5">
                    <h5 class="card-title fw-semibold mb-4">Ligler</h5>
                    <a href="sampiyonekle.php" class="btn btn-success w-25">Yeni Şampiyon Ekle</a>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle" id="tablo">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Şampiyon Id</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Şampiyon ligi</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Şampiyon Resmi</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Şampiyon Takım</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Şampiyon Sezonu</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $deger = $db->query("SELECT * FROM sampiyonlar");
                                    $deger->execute();
                                    $sampiyonlar = $deger->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($sampiyonlar as $key => $sampiyon) { ?>
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0"><?= $sampiyon['SampiyonId'] ?></h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1"><?= $sampiyon['SampiyonLig'] ?></h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <img src="../src/assets/images/logos//takimlar/<?= $sampiyon['SampiyonResim'] ?>" alt="<?= $sampiyon['SampiyonTakim'] ?>" style="max-width: 80px; max-height: 80px;">
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1"><?= $sampiyon['SampiyonTakim'] ?></h6>
                                            </td>


                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1"><?= $sampiyon['SampiyonSezon'] ?></h6>
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
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
                <h5 class="card-title fw-semibold">Takım Ekle</h5>
                <?php

                //     if (isset($_POST['TakimEkle'])) {
                //         $TakimLig           = filtrele($_POST['TakimLig']);
                //         $TakimIsim          = filtrele($_POST['TakimIsim']);
                //         $TakimOyuncuSayisi  = filtrele($_POST['TakimOyuncuSayisi']);

                //         $isimVarMi = false;
                //         foreach ($takimlar as $takim) {
                //             if ($takim['TakimIsim'] == $TakimIsim) {
                //                 $isimVarMi = true;
                //                 break;
                //             }
                //         }
                //         if ($_POST['TakimLig'] == "1" || empty($_POST['TakimIsim']) || empty($_POST['TakimOyuncuSayisi'])) {
                //             echo '<div class="alert alert-danger" role="alert">
                //         Lütfen boş alan bırakmayınız.
                //             </div>';
                //         } elseif (!is_string($_POST['TakimIsim'])) {
                //             echo '<div class="alert alert-danger" role="alert">
                //         Lütfen sadece yazı karakterleri giriniz!
                //             </div>';
                //         } elseif (!is_numeric($_POST['TakimOyuncuSayisi'])) {
                //             echo '<div class="alert alert-danger" role="alert">
                //         Lütfen sadece sayısal karakterler giriniz!
                //             </div>';
                //         } elseif ($isimVarMi) {
                //             echo '<div class="alert alert-danger" role="alert">
                //         Böyle bir takım bulunmaktadır!
                //             </div>';
                //         } else {
                //             $deger = $db->prepare("INSERT INTO takimlar SET TakimLig=?, TakimIsim=?, TakimOyuncuSayisi=?");
                //             $deger->execute([
                //                 $TakimLig,
                //                 $TakimIsim,
                //                 $TakimOyuncuSayisi,
                //             ]);
                //             if ($deger) {
                //                 echo '<div class="alert alert-success" role="alert">
                // Takım başarı ile eklendi.
                //     </div>';
                //                 header("refresh:2");
                //             }
                //         }
                //     }

                ?>
                <form method="get">
                    <div class="card-header p-4">
                        <div class="mb-3">
                            <label class="form-label">Eklemek İstediğiniz Takım Sayısını Yazınız.</label>
                            <input type="text" name="formsayisi" class="form-control" aria-describedby="helpId">
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="" class="form-label">Eklemek İstediğiniz Ligi Seçiniz.</label>
                                <select class="form-select form-select-lg" name="TakimLig">
                                    <option selected value="1">Bir Lig Seçiniz</option>
                                    <?php

                                    $veri = $db->prepare("SELECT * FROM ligler");
                                    $veri->execute();
                                    $takimlar = $veri->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($takimlar as $key => $takim) { ?>
                                        <option value="<?= $takim['LigIsim'] ?>"><?= $takim['LigIsim'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Form Ekle</button>
                    </div>
                </form>
                <form method="post">
                    <div class="col-lg-8 mx-auto">
                        <div class="card-body p-4">
                            <?php

                            if (isset($_GET['formsayisi'])) {
                                if (empty($_GET['TakimLig']) || empty($_GET['formsayisi']) || $_GET['TakimLig'] == "1") {
                                    echo '<div class="alert alert-danger" role="alert">
                                    Lütfen boş alan bırakmayınız!
                                </div>';
                                } elseif (!is_numeric($_GET['formsayisi'])) {
                                    echo '<div class="alert alert-danger" role="alert">
                                    Lütfen sayısal karakterler giriniz!
                                </div>';
                                } else {
                                    $sayi = filtrele($_GET['formsayisi']);
                                    for ($i = 1; $i <= $sayi; $i++) { ?>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="" class="form-label">Takım Adı <?= $i ?></label>
                                                <input type="text" name="LigIsim<?= $i ?>" class="form-control" placeholder="" aria-describedby="helpId">
                                            </div>
                                            <div class="col mb-3">
                                                <label for="" class="form-label">Oyuncu Sayısı <?= $i ?></label>
                                                <input type="number" name="LigOyuncuSayisi<?= $i ?>" class="form-control" placeholder="" aria-describedby="helpId">
                                            </div>
                                        </div>
                            <?php   }
                                    echo '<button type="submit" class="btn btn-success" name="TakimEkle">Ekle</button>';
                                }
                            }

                            ?>


                        </div>
                    </div>
                </form>
                <?php

                if (isset($_POST['TakimEkle'])) {
                    $sayi = filtrele($_GET['formsayisi']);
                    for ($i = 1; $i <= $sayi; $i++) {
                        if (empty($_POST['LigIsim' . $i]) || empty($_POST['LigOyuncuSayisi' . $i])) {
                            echo '<div class="alert alert-danger" role="alert">
                                    Lütfen boş alan bırakmayınız!
                                </div>';
                        } elseif (!is_string($_POST['LigIsim' . $i])) {
                            echo '<div class="alert alert-danger" role="alert">
                                    Lütfen yazısal karakterler giriniz!
                                </div>';
                        } elseif (!is_numeric($_POST['LigOyuncuSayisi' . $i])) {
                            echo '<div class="alert alert-danger" role="alert">
                                    Lütfen sayısal karakterler giriniz!
                                </div>';
                        } else {
                            for ($i = 1; $i <= $sayi; $i++) {
                                $TakimIsim = filtrele($_POST['LigIsim' . $i]);
                                $TakimOyuncuSayisi = filtrele($_POST['LigOyuncuSayisi' . $i]);
                                $TakimLig = filtrele($_GET['TakimLig']);
                                $ekle = $db->prepare("INSERT INTO takimlar SET TakimLig=?, TakimIsim=?, TakimOyuncuSayisi=?");
                                $ekle->execute([
                                    $TakimLig,
                                    $TakimIsim,
                                    $TakimOyuncuSayisi,
                                ]);
                                if ($ekle) {
                                    header("location:takimlar.php");
                                }
                            }
                        }
                    }
                }

                ?>

            </div>


        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
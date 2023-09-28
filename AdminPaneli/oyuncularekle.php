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
                <h5 class="card-title fw-semibold">Oyuncu Ekle</h5>
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
                            <label class="form-label">Eklemek İstediğiniz Oyuncu Sayısını Yazınız.</label>
                            <input type="text" name="formsayisi" class="form-control" aria-describedby="helpId">
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="" class="form-label">Eklemek İstediğiniz Takımı Seçiniz.</label>
                                <select class="form-select form-select-lg" name="OyuncuTakim">
                                    <option selected value="1">Bir Takım Seçiniz</option>
                                    <?php

                                    $veri = $db->prepare("SELECT * FROM takimlar");
                                    $veri->execute();
                                    $takimlar = $veri->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($takimlar as $key => $takim) { ?>
                                        <option value="<?= $takim['TakimIsim'] ?>"><?= $takim['TakimIsim'] ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Form Ekle</button>
                    </div>
                </form>
                <form method="post" enctype="multipart/form-data">
                    <div class="col-lg-12 mx-auto">
                        <div class="card-body p-4">
                            <?php

                            if (isset($_GET['formsayisi'])) {
                                if (empty($_GET['OyuncuTakim']) || empty($_GET['formsayisi']) || $_GET['OyuncuTakim'] == "1") {
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
                                        <?= $i . ". Oyuncu Bilgileri" . "<br>" ?>
                                        <div class="row">
                                            <div class="col col-md-3 mb-3 ">
                                                <label for="" class="form-label">Oyuncu Adı Soyadı</label>
                                                <input type="text" name="OyuncuIsimSoyisim<?= $i ?>" class="form-control shadow" placeholder="" aria-describedby="helpId">
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="" class="form-label">Oyuncu Uyruk </label>
                                                <input type="text" name="OyuncuUyruk<?= $i ?>" class="form-control shadow" placeholder="" aria-describedby="helpId">
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="" class="form-label">Oyuncu Boy </label>
                                                <input type="text" name="OyuncuBoy<?= $i ?>" class="form-control shadow" placeholder="" aria-describedby="helpId">
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="" class="form-label">Oyuncu Mevki </label>
                                                <input type="text" name="OyuncuMevki<?= $i ?>" class="form-control shadow" placeholder="" aria-describedby="helpId">
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="" class="form-label">Oyuncu Doğum Tarihi </label>
                                                <input type="date" name="OyuncuDogumTarihi<?= $i ?>" class="form-control shadow" placeholder="" aria-describedby="helpId">
                                            </div>
                                            <div class="col col-md-3 mb-3">
                                                <label for="" class="form-label">Oyuncu Resim </label>
                                                <input type="file" name="OyuncuResim<?= $i ?>" class="form-control shadow" placeholder="" aria-describedby="helpId">
                                            </div>
                                        </div>
                                        <hr>
                            <?php   }
                                    echo '<button type="submit" class="btn btn-success w-100" name="OyuncuEkle">Oyuncu Kaydet</button>';
                                }
                            }

                            ?>


                        </div>
                    </div>
                </form>
                <?php


                if (isset($_POST['OyuncuEkle'])) {
                    $sayi = filtrele($_GET['formsayisi']);
                    for ($i = 1; $i <= $sayi; $i++) {
                        $OyuncuIsimSoyisim = filtrele($_POST['OyuncuIsimSoyisim' . $i]);
                        $deger = $db->prepare("SELECT * FROM oyuncular WHERE OyuncuIsimSoyisim=?");
                        $deger->execute([$OyuncuIsimSoyisim]);
                        $oyuncular = $deger->fetchAll(PDO::FETCH_ASSOC);

                        if (empty($_POST['OyuncuIsimSoyisim' . $i]) || empty($_POST['OyuncuUyruk' . $i]) || empty($_POST['OyuncuBoy' . $i]) || empty($_POST['OyuncuMevki' . $i]) || empty($_POST['OyuncuDogumTarihi' . $i])) {
                            echo '<div class="alert alert-danger" role="alert">
                                    Lütfen boş alan bırakmayınız!
                                </div>';
                        } elseif (!is_string($_POST['OyuncuIsimSoyisim' . $i]) || !is_string($_POST['OyuncuUyruk' . $i]) || !is_string($_POST['OyuncuMevki' . $i])) {
                            echo '<div class="alert alert-danger" role="alert">
                                    Lütfen yazısal karakterler giriniz!
                                </div>';
                        } elseif (!is_numeric($_POST['OyuncuBoy' . $i])) {
                            echo '<div class="alert alert-danger" role="alert">
                                    Lütfen sayısal karakterler giriniz!
                                </div>';
                        } else {
                            if ($_FILES['OyuncuResim' . $i]['error'] == 0) {
                                for ($i = 1; $i <= $sayi; $i++) {
                                    $izinli_uzanti = ['jpg', 'jpeg', 'png', 'svg'];
                                    $dosya_uzantisi = pathinfo($_FILES['OyuncuResim' . $i]['name'], PATHINFO_EXTENSION);
                                    $izinli_boyut   =   2 * 1024 * 1024;
                                    if (!in_array($dosya_uzantisi, $izinli_uzanti)) {
                                        echo '<div class="alert alert-danger" role="alert">
                                        Dosya uzantısı izin verilen türde değil!
                                    </div>';
                                    } elseif ($_FILES['OyuncuResim' . $i]['size'] > $izinli_boyut) {
                                        echo '<div class="alert alert-danger" role="alert">
                                        Dosya boyutu izin verilen boyuttan fazla!
                                    </div>';
                                    } elseif ($oyuncusayisi = $deger->rowCount()) {
                                        echo '<div class="alert alert-danger" role="alert">
                                        Böyle bir futbolcu bulunmaktadır.!
                                    </div>';
                                    } else {
                                        $OyuncuTakim            = filtrele($_GET['OyuncuTakim']);
                                        $OyuncuIsimSoyisim      = filtrele($_POST['OyuncuIsimSoyisim' . $i]);
                                        $OyuncuUyruk            = filtrele($_POST['OyuncuUyruk' . $i]);
                                        $OyuncuBoy              = filtrele($_POST['OyuncuBoy' . $i]);
                                        $OyuncuMevki            = filtrele($_POST['OyuncuMevki' . $i]);
                                        $OyuncuDogumTarihi      = filtrele($_POST['OyuncuDogumTarihi' . $i]);
                                        //oyuncu yaşını girilen doğum tarihine göre otomatik hesaplama
                                        $dogumTarihi = $_POST['OyuncuDogumTarihi' . $i];
                                        $bugun = date("Y-m-d");
                                        $Yas = date_diff(date_create($dogumTarihi), date_create($bugun));
                                        $OyuncuYas = strval($Yas->y);

                                        $gecici_isim = $_FILES['OyuncuResim' . $i]['tmp_name'];
                                        $dosya_isim = $_FILES['OyuncuResim' . $i]['name'];
                                        $rastgele_sayi = rand(1000, 9999);
                                        $isim = $rastgele_sayi . $dosya_isim;
                                        move_uploaded_file($gecici_isim, "../src/assets/images/logos/oyuncular/$isim");

                                        $ekle = $db->prepare("INSERT INTO oyuncular SET OyuncuTakim=?, OyuncuIsimSoyisim=?, OyuncuUyruk=?, OyuncuBoy=?, OyuncuYas=?, OyuncuMevki=?, OyuncuDogumTarihi=?, OyuncuResim=?");
                                        $ekle->execute([
                                            $OyuncuTakim,
                                            $OyuncuIsimSoyisim,
                                            $OyuncuUyruk,
                                            $OyuncuBoy,
                                            $OyuncuYas,
                                            $OyuncuMevki,
                                            $OyuncuDogumTarihi,
                                            $isim,
                                        ]);
                                        if ($ekle) {
                                            header("location:oyuncular.php");
                                        }
                                    }
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
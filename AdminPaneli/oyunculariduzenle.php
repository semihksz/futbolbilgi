<?php
define("giriskontrol", true);
require_once 'header.php';
require_once '../src/assets/php/baglanti.php';
require_once '../src/assets/php/fonksiyonlar.php';




?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100 p-5">
                <?php


                if (isset($_POST['OyuncuGuncelle'])) {


                    if (empty($_POST['OyuncuIsimSoyisim']) || empty($_POST['OyuncuUyruk'])  || empty($_POST['OyuncuBoy']) || empty($_POST['OyuncuMevki'])) {
                        echo '<div class="alert alert-danger" role="alert">
                        Lütfen boş alan bırakmayınız!
                    </div>';
                    } elseif (!is_string($_POST['OyuncuIsimSoyisim']) || !is_string($_POST['OyuncuUyruk'])  || !is_string($_POST['OyuncuMevki'])) {
                        echo '<div class="alert alert-danger" role="alert">
                            Lütfen yazısal karakterler giriniz!
                            </div>';
                    } elseif (!is_numeric($_POST['OyuncuBoy'])) {
                        echo '<div class="alert alert-danger" role="alert">
                            Lütfen sayısal karakterler giriniz!
                            </div>';
                    } else {
                        $OyuncuIsimSoyisim  =   filtrele($_POST['OyuncuIsimSoyisim']);
                        $OyuncuUyruk        =   filtrele($_POST['OyuncuUyruk']);
                        $OyuncuBoy          =   filtrele($_POST['OyuncuBoy']);
                        $OyuncuYas          =   filtrele($_POST['OyuncuYas']);
                        $OyuncuMevki        =   filtrele($_POST['OyuncuMevki']);
                        $OyuncuDogumTarihi  =   filtrele($_POST['OyuncuDogumTarihi']);
                        $OyuncuTakim        =   filtrele($_POST['OyuncuTakim']);
                        $OyuncuId           =   filtrele($_POST['OyuncuId']);

                        //oyuncu yaşını girilen doğum tarihine göre otomatik hesaplama
                        $dogumTarihi = $_POST['OyuncuDogumTarihi'];
                        $bugun = date("Y-m-d");
                        $Yas = date_diff(date_create($dogumTarihi), date_create($bugun));
                        $OyuncuYas = strval($Yas->y);



                        $guncelle = $db->prepare("UPDATE oyuncular SET 
                        OyuncuIsimSoyisim   =:OyuncuIsimSoyisim,
                        OyuncuUyruk         =:OyuncuUyruk,
                        OyuncuBoy           =:OyuncuBoy,
                        OyuncuYas           =:OyuncuYas,
                        OyuncuMevki         =:OyuncuMevki,
                        OyuncuDogumTarihi   =:OyuncuDogumTarihi,
                        OyuncuTakim         =:OyuncuTakim WHERE OyuncuId =:OyuncuId
                        ");
                        $guncelle->execute([
                            'OyuncuIsimSoyisim' => $OyuncuIsimSoyisim,
                            'OyuncuUyruk'       => $OyuncuUyruk,
                            'OyuncuBoy'         => $OyuncuBoy,
                            'OyuncuYas'         => $OyuncuYas,
                            'OyuncuMevki'       => $OyuncuMevki,
                            'OyuncuDogumTarihi' => $OyuncuDogumTarihi,
                            'OyuncuTakim'       => $OyuncuTakim,
                            'OyuncuId'          => $OyuncuId,
                        ]);

                        if ($_FILES['OyuncuResim']['error'] == 0) {
                            $izinli_uzanti = ['jpg', 'jpeg', 'png', 'svg'];
                            $dosya_uzantisi = pathinfo($_FILES['OyuncuResim']['name'], PATHINFO_EXTENSION);
                            $izinli_boyut = 2 * 1024 * 1024;
                            if (!in_array($dosya_uzantisi, $izinli_uzanti)) {
                                echo '<div class="alert alert-danger" role="alert">
                            Dosya uzantısı izin verilen türde değil!
                            </div>';
                            } elseif ($_FILES['OyuncuResim']['size'] > $izinli_boyut) {
                                echo '<div class="alert alert-danger" role="alert">
                            Dosya boyutu izin verilen boyuttan fazla!
                            </div>';
                            } else {
                                $gecici_isim = $_FILES['OyuncuResim']['tmp_name'];
                                $dosya_isim =   $_FILES['OyuncuResim']['name'];
                                $rastgele_sayi = rand(1000, 9999);
                                $isim = $rastgele_sayi . $dosya_isim;
                                move_uploaded_file($gecici_isim, "../src/assets/images/logos/oyuncular/$isim");

                                $guncelle = $db->prepare("UPDATE oyuncular SET 
                                OyuncuResim=:OyuncuResim WHERE OyuncuId =:OyuncuId
                                ");
                                $guncelle->execute([
                                    'OyuncuResim' => $isim,
                                    'OyuncuId' => $OyuncuId,
                                ]);
                            }
                        }

                        if ($guncelle) {
                            header("location:oyuncular.php");
                        }
                    }
                }





                ?>
                <form method="post" enctype="multipart/form-data">
                    <?php
                    $veri = $db->prepare("SELECT * FROM oyuncular WHERE OyuncuId={$_GET['OyuncuId']}");
                    $veri->execute();
                    $oyuncular = $veri->fetchAll(PDO::FETCH_ASSOC);
                    $oyuncusayisi = $veri->rowCount();
                    foreach ($oyuncular as $key => $oyuncu) {  ?>
                        <div class="card p-4 shadow-lg">
                            <div class="card-body">
                                <div class="mb-3">
                                    <img src="../src/assets/images/logos/oyuncular/<?= $oyuncu['OyuncuResim'] ?>" class="img-thumbnail border border-dark shadow-lg d-flex justify-content-center mx-auto" style="max-width: 250px; max-height: 250px" alt="<?= $oyuncu['OyuncuIsimSoyisim'] ?>"><br>
                                    <label for="" class="form-label mt-3">Resmi Değiştir</label>
                                    <input class="form-control form-control " id="formFileSm" type="file" name="OyuncuResim">
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" name="OyuncuId" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $oyuncu['OyuncuId'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Oyuncu Takımı</label>
                                    <select class="form-select" name="OyuncuTakim">
                                        <option selected value="<?= $oyuncu['OyuncuTakim'] ?>"><?= $oyuncu['OyuncuTakim'] ?></option>
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
                                <div class="mb-3">
                                    <label for="" class="form-label">Oyuncu Adı Soyadı</label>
                                    <input type="text" name="OyuncuIsimSoyisim" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $oyuncu['OyuncuIsimSoyisim'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Oyuncu Uyruğu</label>
                                    <input type="text" name="OyuncuUyruk" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $oyuncu['OyuncuUyruk'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Oyuncu Boyu</label>
                                    <input type="number" name="OyuncuBoy" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $oyuncu['OyuncuBoy'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Oyuncu Yaşı</label>
                                    <input type="number" disabled name="OyuncuYas" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $oyuncu['OyuncuYas'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Oyuncu Mevkisi</label>
                                    <input type="text" name="OyuncuMevki" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $oyuncu['OyuncuMevki'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Oyuncu Doğum Tarihi</label>
                                    <input type="date" name="OyuncuDogumTarihi" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $oyuncu['OyuncuDogumTarihi'] ?>">
                                </div>
                                <div class="mb-3 d-flex justify-content-center  mx-auto">
                                    <a href="silislemleri.php?OyuncuSil=OyuncuSil&OyuncuId=<?= $oyuncu['OyuncuId'] ?>" class="col-lg-4 btn btn-danger">Oyuncuyu Sil</a>
                                    <button type="submit" class="col-lg-4 btn btn-success ms-3" name="OyuncuGuncelle">Güncelle</a>
                                </div>
                            </div>
                        </div>

                    <?php }
                    ?>

                </form>
            </div>

        </div>
    </div>
</div>
<?php require_once 'footer.php'; ?>
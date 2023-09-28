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
                <?php
                $deger = $db->prepare("SELECT * FROM ligler WHERE LigId={$_GET['LigId']}");
                $deger->execute();
                $lig = $deger->fetch(PDO::FETCH_ASSOC);


                if (isset($_POST['LigGuncelle'])) {
                    $LigId              =   filtrele($_POST['LigId']);
                    $LigUlke            =   filtrele($_POST['LigUlke']);
                    $LigIsim            =   filtrele($_POST['LigIsim']);
                    $LigTakimSayisi     =   filtrele($_POST['LigTakimSayisi']);
                    $LigOyuncuSayisi    =   filtrele($_POST['LigOyuncuSayisi']);

                    if (empty($_POST['LigUlke']) || empty($_POST['LigIsim']) || empty($_POST['LigTakimSayisi']) || empty($_POST['LigOyuncuSayisi'])) {
                        echo "<div class='alert alert-danger' role='alert'>
                         Lütfen Boş Alan Bırakmayınız!
                        </div>";
                    } elseif (!is_string($_POST['LigUlke']) || !is_string($_POST['LigIsim'])) {
                        echo "<div class='alert alert-danger' role='alert'>
                    Lütfen Sadece Yazı Karakterleri Giriniz!
                   </div>";
                    } elseif (!is_numeric($_POST['LigTakimSayisi']) || !is_numeric($_POST['LigOyuncuSayisi'])) {
                        echo "<div class='alert alert-danger' role='alert'>
                    Lütfen Sadece Sayısal Karakterleri Giriniz!
                   </div>";
                    } else {

                        $guncelle = $db->prepare("UPDATE ligler SET
                            LigUlke         =:LigUlke,
                            LigIsim         =:LigIsim,
                            LigTakimSayisi  =:LigTakimSayisi,
                            LigOyuncuSayisi =:LigOyuncuSayisi WHERE LigId=:LigId
                            ");
                        $guncelle->execute([
                            'LigId'             => $LigId,
                            'LigUlke'           => $LigUlke,
                            'LigIsim'           => $LigIsim,
                            'LigTakimSayisi'    => $LigTakimSayisi,
                            'LigOyuncuSayisi'   => $LigOyuncuSayisi,


                        ]);
                        if ($_FILES['LigResim']['error'] == 0) {
                            $izinli_uzanti  =   ['jpg', 'jpeg', 'png', 'svg'];
                            $dosya_uzantisi =   pathinfo($_FILES['LigResim']['name'], PATHINFO_EXTENSION);
                            $izinli_boyut   =   2 * 1024 * 1024;
                            if (empty($_FILES['LigResim'])) {
                                echo "<div class='alert alert-danger' role='alert'>
                                Lütfen Boş Alan Bırakmayınız!
                                </div>";
                            } elseif (!in_array($dosya_uzantisi, $izinli_uzanti)) {
                                echo "<div class='alert alert-danger' role='alert'>
                                Dosya uzantısı izin verilen uzantılardan farklı!
                                </div>";
                            } elseif ($_FILES['LigResim']['size'] > $izinli_boyut) {
                                echo "<div class='alert alert-danger' role='alert'>
                                Dosya boyutu izin verilen boyuttan büyük!
                                </div>";
                            } else {
                                $gecici_isim    =   $_FILES['LigResim']['tmp_name'];
                                $resim_isim     =   $_FILES['LigResim']['name'];
                                $rastgele_sayi  =   rand(1000, 9999);
                                $isim = $rastgele_sayi . $resim_isim;
                                move_uploaded_file($gecici_isim, "../src/assets/images/logos/ligler/$isim");
                                $guncelle = $db->prepare("UPDATE ligler SET
                                    LigResim    =:LigResim WHERE LigId=:LigId
                            ");
                                $guncelle->execute([
                                    'LigId'     => $LigId,
                                    'LigResim'  => $isim,

                                ]);
                            }
                        }
                        if ($guncelle) {
                            echo "<div class='alert alert-success' role='alert'>
                                    Güncelleme Başarılı.
                                            </div>";
                            header("refresh:1.5 ligler.php");
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>
                                Güncelleme Sırasında Bir Hata Oluştu.
                            </div>";
                        }
                    }
                }

                ?>

                <form method="post" enctype="multipart/form-data">
                    <div class="col-lg-2">
                        <a href="ligler.php" type="submit" class="col-lg-6 col-12 btn btn-outline-primary justify-content-start ms-3 mt-3"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
                    </div>
                    <div class="col-lg-8 mx-auto">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <img src="../src/assets/images/logos/ligler/<?= $lig['LigResim'] ?>" class="img-thumbnail border border-dark shadow-lg d-flex justify-content-center mx-auto" alt="<?= $lig['LigIsim'] ?>"><br>
                                <label for="" class="form-label mt-3">Resmi Değiştir</label>
                                <input class="form-control form-control " id="formFileSm" type="file" name="LigResim">
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="LigId" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $_GET['LigId'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Ülke</label>
                                <input type="text" name="LigUlke" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $lig['LigUlke'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Takım</label>
                                <input type="text" name="LigIsim" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $lig['LigIsim'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Takım Sayısı</label>
                                <input type="number" name="LigTakimSayisi" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $lig['LigTakimSayisi'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Oyuncu Sayısı</label>
                                <input type="number" name="LigOyuncuSayisi" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $lig['LigOyuncuSayisi'] ?>">
                            </div>
                            <a href="silislemleri.php?LigSil=LigSil&LigId=<?= $lig['LigId'] ?>" class="btn btn-danger">Ligi Sil</a>
                            <button type="submit" class="btn btn-success" name="LigGuncelle">Güncelle</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
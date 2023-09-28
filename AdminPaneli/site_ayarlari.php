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

                if (isset($_POST['SiteGuncelle'])) {
                    $SiteId          =   filtrele($_POST['SiteId']);
                    $SiteLink        =   filtrele($_POST['SiteLink']);
                    $SiteBaslik      =   filtrele($_POST['SiteBaslik']);
                    $SiteAciklama    =   filtrele($_POST['SiteAciklama']);

                    if (empty($_POST['SiteId']) || empty($_POST['SiteLink']) || empty($_POST['SiteBaslik']) || empty($_POST['SiteAciklama'])) {
                        echo '<div class="alert alert-danger" role="alert">
                            Lütfen boş alan bırakmayınız!
                            </div>';
                    } else {
                        $guncelle = $db->prepare("UPDATE site_ayarlari SET 
                        SiteLink        =:SiteLink,
                        SiteBaslik      =:SiteBaslik,
                        SiteAciklama    =:SiteAciklama WHERE SiteId  =:SiteId
                        ");
                        $guncelle->execute([
                            'SiteLink'      => $SiteLink,
                            'SiteBaslik'    => $SiteBaslik,
                            'SiteAciklama'  => $SiteAciklama,
                            'SiteId'        => $SiteId,
                        ]);

                        //-------------- sitenin favicon ayarları --------------
                        if ($_FILES['SiteFavicon']['error'] == 0) {
                            $izinli_uzanti = ['jpg', 'jpeg', 'png', 'svg'];
                            $dosya_uzanti = pathinfo($_FILES['SiteFavicon']['name'], PATHINFO_EXTENSION);
                            $izinli_boyut = 2 * 1024 * 1024;
                            if (!in_array($dosya_uzanti, $izinli_uzanti)) {
                                echo '<div class="alert alert-danger" role="alert">
                            Dosya uzantısı izin verilen türde değil!
                            </div>';
                            } elseif ($_FILES['SiteFavicon']['size'] > $izinli_boyut) {
                                echo '<div class="alert alert-danger" role="alert">
                                Dosya boyutu izin verilen boyuttan fazla!
                                </div>';
                            } else {
                                $gecici_isim = $_FILES['SiteFavicon']['tmp_name'];
                                $dosya_isim = $_FILES['SiteFavicon']['name'];
                                $rastgele_sayi = rand(1000, 9999);
                                $isim = $rastgele_sayi . $dosya_isim;
                                move_uploaded_file($gecici_isim, "../src/assets/images/logos/site/$isim");
                                $guncelle = $db->prepare("UPDATE site_ayarlari SET 
                                SiteFavicon =:SiteFavicon WHERE SiteId =:SiteId
                                ");
                                $guncelle->execute([
                                    'SiteFavicon' => $isim,
                                    'SiteId' => $SiteId,
                                ]);
                            }
                        }

                        //-------------- sitenin logo ayarları --------------
                        if ($_FILES['SiteResim']['error'] == 0) {
                            $izinli_uzanti = ['jpg', 'jpeg', 'png', 'svg'];
                            $dosya_uzanti = pathinfo($_FILES['SiteResim']['name'], PATHINFO_EXTENSION);
                            $izinli_boyut = 2 * 1024 * 1024;
                            if (!in_array($dosya_uzanti, $izinli_uzanti)) {
                                echo '<div class="alert alert-danger" role="alert">
                            Dosya uzantısı izin verilen türde değil!
                            </div>';
                            } elseif ($_FILES['SiteResim']['size'] > $izinli_boyut) {
                                echo '<div class="alert alert-danger" role="alert">
                                Dosya boyutu izin verilen boyuttan fazla!
                                </div>';
                            } else {
                                $gecici_isim = $_FILES['SiteResim']['tmp_name'];
                                $dosya_isim = $_FILES['SiteResim']['name'];
                                $rastgele_sayi = rand(1000, 9999);
                                $isim = $rastgele_sayi . $dosya_isim;
                                move_uploaded_file($gecici_isim, "../src/assets/images/logos/site/$isim");
                                $guncelle = $db->prepare("UPDATE site_ayarlari SET 
                                SiteResim =:SiteResim WHERE SiteId =:SiteId
                                ");
                                $guncelle->execute([
                                    'SiteResim' => $isim,
                                    'SiteId' => $SiteId,
                                ]);
                            }
                        }

                        if ($guncelle) {
                            header("location:site_ayarlari.php");
                        }
                    }
                }



                ?>


                <form method="post" enctype="multipart/form-data">
                    <div class="card p-4 shadow-lg">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <img src="../src/assets/images/logos/site/<?= $site['SiteFavicon'] ?>" class="img-thumbnail border border-dark shadow-lg d-flex justify-content-center mx-auto" style="max-width: 96px; max-height: 96px;" alt="<?= $site['SiteBaslik'] ?>"><br>
                                    <label for="" class="form-label mt-3">Site Favicon Değiştir</label>
                                    <input class="form-control form-control " id="formFileSm" type="file" name="SiteFavicon">
                                </div>
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <img src="../src/assets/images/logos/site/<?= $site['SiteResim'] ?>" class="img-thumbnail border border-dark shadow-lg d-flex justify-content-center mx-auto" style="max-width: 250px; max-height: 250px;" alt="<?= $site['SiteBaslik'] ?>"><br>
                                    <label for="" class="form-label mt-3">Site Resmi Değiştir</label>
                                    <input class="form-control form-control " id="formFileSm" type="file" name="SiteResim">
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="SiteId" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $site['SiteId'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Site Linki</label>
                                <input type="text" name="SiteLink" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $site['SiteLink'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Site Başlığı</label>
                                <input type="text" name="SiteBaslik" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $site['SiteBaslik'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Site Açıklaması</label>
                                <input type="text" name="SiteAciklama" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $site['SiteAciklama'] ?>">
                            </div>
                            <div class="mb-3 d-flex justify-content-center  mx-auto">
                                <button type="submit" class="col-lg-4 btn btn-success ms-3" name="SiteGuncelle">Güncelle</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php require_once 'footer.php'; ?>
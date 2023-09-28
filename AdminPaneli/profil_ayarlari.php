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

                if (isset($_POST['ProfilGuncelle'])) {

                    $AdminId        =   filtrele($_POST['AdminId']);
                    $AdminIsim      =   filtrele($_POST['AdminIsim']);
                    $SifreTemizle   =   str_replace(' ', '', $_POST['AdminSifre']);
                    $AdminSifre     =   password_hash(filtrele($SifreTemizle), PASSWORD_DEFAULT);

                    if (empty($_POST['AdminIsim'])) {
                        echo '<div class="alert alert-danger" role="alert">
                                Lütfen boş alan bırakmayınız!
                                </div>';
                    } else {
                        if ($_POST['AdminSifre'] == "") {
                            $guncelle = $db->prepare("UPDATE yoneticiler SET 
                        AdminIsim   =:AdminIsim WHERE AdminId =:AdminId
                        ");
                            $guncelle->execute([
                                'AdminIsim' => $AdminIsim,
                                'AdminId' => $AdminId
                            ]);
                        } else {
                            $guncelle = $db->prepare("UPDATE yoneticiler SET 
                            AdminSifre   =:AdminSifre WHERE AdminId =:AdminId
                            ");
                            $guncelle->execute([
                                'AdminSifre' => $AdminSifre,
                                'AdminId' => $AdminId
                            ]);
                        }

                        if ($_FILES['AdminResim']['error'] == 0) {
                            $izinli_uzanti  =   ['jpg', 'jpeg', 'png', 'svg'];
                            $dosya_uzanti   = pathinfo($_FILES['AdminResim']['name'], PATHINFO_EXTENSION);
                            $izinli_boyut   =   2 * 1024 * 1024;
                            if (!in_array($dosya_uzanti, $izinli_uzanti)) {
                                echo '<div class="alert alert-danger" role="alert">
                                Dosya uzantısı izin verilen uzantı türünde değil!
                                </div>';
                            } elseif ($_FILES['AdminResim']['size'] > $izinli_boyut) {
                                echo '<div class="alert alert-danger" role="alert">
                                Dosya uzantısı izin verilen boyuttan fazla!
                                </div>';
                            } else {
                                $gecici_isim = $_FILES['AdminResim']['tmp_name'];
                                $dosya_isim =   $_FILES['AdminResim']['name'];
                                $rastgele_sayi  =   rand(1000, 9999);
                                $isim = $rastgele_sayi . $dosya_isim;
                                move_uploaded_file($gecici_isim, "../src/assets/images/logos/yoneticiler/$isim");
                                $guncelle = $db->prepare("UPDATE yoneticiler SET
                                AdminResim =:AdminResim WHERE AdminId =:AdminId
                                ");
                                $guncelle->execute([
                                    'AdminResim' => $isim,
                                    'AdminId' => $AdminId,
                                ]);
                            }
                        }
                        if ($guncelle) {
                            header("location:profil_ayarlari.php");
                        }
                    }
                }



                ?>


                <form method="post" enctype="multipart/form-data">
                    <div class="card p-4 shadow-lg">
                        <div class="card-body">
                            <div class="mb-3">
                                <img src="../src/assets/images/logos/yoneticiler/<?= $admin['AdminResim'] ?>" class="img-thumbnail border border-dark shadow-lg d-flex justify-content-center mx-auto" style="max-width: 250px; max-height: 250px" alt="<?= $admin['AdminIsim'] ?>"><br>
                                <label for="" class="form-label mt-3">Profil Resmi Değiştir</label>
                                <input class="form-control form-control " id="formFileSm" type="file" name="AdminResim">
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="AdminId" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $admin['AdminId'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Admin Kullanıcı Adı</label>
                                <input type="text" name="AdminIsim" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $admin['AdminIsim'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Admin Sifre Değiştir</label>
                                <input type="text" name="AdminSifre" class="form-control" placeholder="" aria-describedby="helpId" value="">
                            </div>
                            <div class="mb-3 d-flex justify-content-center  mx-auto">
                                <button type="submit" class="col-lg-4 btn btn-success ms-3" name="ProfilGuncelle">Güncelle</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php require_once 'footer.php'; ?>
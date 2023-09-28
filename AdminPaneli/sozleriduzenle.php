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


                if (isset($_POST['SozuGuncelle'])) {
                    $SozIsim    =   filtrele($_POST['SozIsim']);
                    $SozMetin   =   filtrele($_POST['SozMetin']);
                    $SozId      =   filtrele($_POST['SozId']);

                    if (empty($_POST['SozIsim']) || empty($_POST['SozMetin'])) {
                        echo '<div class="alert alert-danger" role="alert">
                        Lütfen boş alan bırakmayınız!
                    </div>
                    ';
                    } else {
                        $guncelle = $db->prepare("UPDATE sozler SET 
                        SozIsim =:SozIsim,
                        SozMetin =:SozMetin WHERE SozId =:SozId
                        ");
                        $guncelle->execute([
                            'SozIsim' => $SozIsim,
                            'SozMetin' => $SozMetin,
                            'SozId' => $SozId,
                        ]);

                        if ($_FILES['SozResim']['error'] == 0) {
                            $izinliuzanti    =  ['jpg', 'jpeg', 'png', 'svg'];
                            $dosyauzantisi  =   pathinfo($_FILES['SozResim']['name'], PATHINFO_EXTENSION);
                            $izinliboyut    =   2 * 1024 * 1024;

                            if (!in_array($dosyauzantisi, $izinliuzanti)) {
                                echo '<div class="alert alert-danger" role="alert">
                                    İzin verilen dosya uzantısı ile aynı türde değil!
                                    </div> ';
                            } elseif ($_FILES['SozResim']['size'] > $izinliboyut) {
                                echo '<div class="alert alert-danger" role="alert">
                                    İzin verilen dosya boyutundan fazla!
                                    </div> ';
                            } else {
                                $geciciisim =   $_FILES['SozResim']['tmp_name'];
                                $dosyaismi  =   $_FILES['SozResim']['name'];
                                $rastgelesayi   =   rand(1000, 9999);
                                $isim = $rastgelesayi . $dosyaismi;
                                move_uploaded_file($geciciisim, "../src/assets/images/sozler/$isim");

                                $guncelle = $db->prepare("UPDATE sozler SET
                                SozResim =:SozResim WHERE SozId =:SozId
                                ");
                                $guncelle->execute([
                                    'SozResim' => $isim,
                                    'SozId' => $SozId,
                                ]);
                            }
                        }


                        if ($guncelle) {
                            header("location:sozler.php");
                        }
                    }
                }


                ?>
                <form method="post" enctype="multipart/form-data">
                    <?php
                    $veri = $db->prepare("SELECT * FROM sozler WHERE SozId={$_GET['SozId']}");
                    $veri->execute();
                    $sozler = $veri->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($sozler as $key => $soz) {  ?>
                        <div class="card p-4 shadow-lg">
                            <div class="card-body">
                                <div class="mb-3">
                                    <img src="../src/assets/images/sozler/<?= $soz['SozResim'] ?>" class="img-thumbnail border border-dark shadow-lg d-flex justify-content-center mx-auto" style="max-width: 250px; max-height: 250px" alt="<?= $soz['SozIsim'] ?>"><br>
                                    <label for="" class="form-label mt-3">Resmi Değiştir</label>
                                    <input class="form-control form-control " id="formFileSm" type="file" name="SozResim">
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" name="SozId" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $soz['SozId'] ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Adı Soyadı</label>
                                <input type="text" name="SozIsim" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $soz['SozIsim'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Söz</label>
                                <input type="text" name="SozMetin" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $soz['SozMetin'] ?>">
                            </div>
                            <div class="mb-3 d-flex justify-content-center  mx-auto">
                                <a href="silislemleri.php?SozSil=SozSil&SozId=<?= $soz['SozId'] ?>" class="col-lg-6 btn btn-danger">Sözü Sil</a>
                                <button type="submit" class="col-lg-6 btn btn-success ms-3" name="SozuGuncelle">Güncelle</a>
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
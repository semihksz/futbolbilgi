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
                $veri = $db->prepare("SELECT * FROM takimlar WHERE TakimId={$_GET['TakimId']}");
                $veri->execute();
                $takimlar = $veri->fetch(PDO::FETCH_ASSOC);

                $TakimLig = $TakimIsim = $TakimOyuncuSayisi = $TakimId = "";
                $TakimLigErr = $TakimIsimErr = $TakimOyuncuSayisiErr = $TakimIdErr = "";

                if (isset($_POST['TakimGuncelle'])) {
                    if (empty($_POST['TakimLig'])) {
                        $TakimLigErr = "Takım Ligini boş bırakmayınız.";
                    } else {
                        $TakimLig           =   filtrele($_POST['TakimLig']);
                    }
                    if (empty($_POST['TakimIsim'])) {
                        $TakimIsimErr = "Takım adını boş bırakmayınız.";
                    } else {
                        $TakimIsim          =   filtrele($_POST['TakimIsim']);
                    }
                    if (empty($_POST['TakimOyuncuSayisi'])) {
                        $TakimOyuncuSayisiErr = "Takım oyuncu sayısını boş bırakmayınız.";
                    } else {
                        $TakimOyuncuSayisi  =   filtrele($_POST['TakimOyuncuSayisi']);
                    }
                    if ($_POST['TakimId']) {
                        $TakimId            =   filtrele($_POST['TakimId']);
                    }
                    if (!is_numeric($_POST['TakimOyuncuSayisi'])) {
                        $TakimOyuncuSayisiErr = "Lütfen Oyuncu Sayısına Sayısal Veriler Giriniz!";
                    }
                    if (empty($TakimIsimErr) && empty($TakimLigErr) && empty($TakimOyuncuSayisiErr)) {
                        $guncelle = $db->prepare("UPDATE takimlar SET
                        TakimLig            =:TakimLig,
                        TakimIsim           =:TakimIsim,
                        TakimOyuncuSayisi   =:TakimOyuncuSayisi WHERE TakimId =:TakimId
                        ");
                        $guncelle->execute([
                            'TakimLig'          => $TakimLig,
                            'TakimIsim'         => $TakimIsim,
                            'TakimOyuncuSayisi' => $TakimOyuncuSayisi,
                            'TakimId'           => $TakimId,
                        ]);

                        if ($_FILES['TakimResim']['error'] == 0) {
                            $izinli_uzanti = ['jpg', 'jpeg', 'png', 'svg'];
                            $dosya_uzantisi = pathinfo($_FILES['TakimResim']['name'], PATHINFO_EXTENSION);
                            $izinli_boyut   =   2 * 1024 * 1024;
                            if (!in_array($dosya_uzantisi, $izinli_uzanti)) {
                                echo "<div class='alert alert-danger' role='alert'>
                                Dosya uzantısı izin verilen uzantılardan farklı!
                                </div>";
                            } elseif ($_FILES['TakimResim']['size'] > $izinli_boyut) {
                                echo "<div class='alert alert-danger' role='alert'>
                                Dosya boyutu izin verilen boyuttan büyük!
                                </div>";
                            } else {
                                $gecici_isim = $_FILES['TakimResim']['tmp_name'];
                                $resim_isim = $_FILES['TakimResim']['name'];
                                $rastgele_sayi = rand(1000, 9999);
                                $isim = $rastgele_sayi . $resim_isim;
                                move_uploaded_file($gecici_isim, "../src/assets/images/logos/takimlar/$isim");

                                $guncelle = $db->prepare("UPDATE takimlar SET 
                                TakimResim =:TakimResim WHERE TakimId=:TakimId
                                ");
                                $guncelle->execute([
                                    'TakimResim' => $isim,
                                    'TakimId' => $TakimId,
                                ]);
                            }
                        }
                        if ($guncelle) {
                            echo "<div class='alert alert-success' role='alert'>
                                Güncelleme işlemi başarılı!
                                </div>";
                            header("refresh:1.5 takimlar.php");
                        }
                    }
                }

                ?>
                <form method="post" enctype="multipart/form-data">
                    <?php
                    $veri = $db->prepare("SELECT * FROM takimlar WHERE TakimId={$_GET['TakimId']}");
                    $veri->execute();
                    $takimlar = $veri->fetchAll(PDO::FETCH_ASSOC);
                    $takimsayisi = $veri->rowCount();
                    foreach ($takimlar as $key => $takim) {  ?>
                        <div class="card p-4 shadow-lg">
                            <div class="card-body">
                                <div class="mb-3">
                                    <img src="../src/assets/images/logos/takimlar/<?= $takim['TakimResim'] ?>" class="img-thumbnail border border-dark shadow-lg d-flex justify-content-center mx-auto" alt="<?= $takim['TakimIsim'] ?>"><br>
                                    <label for="" class="form-label mt-3">Resmi Değiştir</label>
                                    <input class="form-control form-control " id="formFileSm" type="file" name="TakimResim">
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" name="TakimId" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $takim['TakimId'] ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Ülke</label>
                                    <input type="text" name="TakimLig" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $takim['TakimLig'] ?>">
                                    <label for=""><?= $TakimLigErr ?></label>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Takım</label>
                                    <input type="text" name="TakimIsim" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $takim['TakimIsim'] ?>">
                                    <label for=""><?= $TakimIsimErr ?></label>
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Oyuncu Sayısı</label>
                                    <input type="number" name="TakimOyuncuSayisi" class="form-control" placeholder="" aria-describedby="helpId" value="<?= $takim['TakimOyuncuSayisi'] ?>">
                                    <label for=""><?= $TakimOyuncuSayisiErr ?></label>
                                </div>
                                <div class="mb-3 d-flex justify-content-center  mx-auto">
                                    <a href="silislemleri.php?TakimSil=TakimSil&TakimId=<?= $takim['TakimId'] ?>" class="col-lg-4 btn btn-danger">Takımı Sil</a>
                                    <button type="submit" class="col-lg-4 btn btn-success ms-3" name="TakimGuncelle">Güncelle</a>
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
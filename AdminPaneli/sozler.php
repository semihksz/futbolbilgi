<?php
define("giriskontrol", true);
require_once 'header.php';
require_once '../src/assets/php/baglanti.php';
require_once '../src/assets/php/fonksiyonlar.php';
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

                <?php
                if (isset($_POST['SozEkle'])) {
                    $SozIsim    = filtrele($_POST['SozIsim']);
                    $SozMetin   =   filtrele($_POST['SozMetin']);

                    if (empty($_POST['SozIsim']) || empty($_POST['SozMetin'])) {
                        echo '<div class="alert alert-danger" role="alert">
                        Lütfen boş alan bırakmayınız!
                    </div>
                    ';
                    } else {

                        if ($_FILES['SozResim']['error'] == 0) {
                            $izinliuzanti = ['jpg', 'jpeg', 'png', 'svg'];
                            $dosyauzantisi  =   pathinfo($_FILES['SozResim']['name'], PATHINFO_EXTENSION);
                            $izinliboyut    =   2 * 1024 * 1024;
                            if (!in_array($dosyauzantisi, $izinliuzanti)) {
                                echo '<div class="alert alert-danger" role="alert">
                                    Dosya uzantınız izin verilen uzantı türünde değil!
                                    </div> ';
                            } elseif ($_FILES['SozResim']['size'] > $izinliboyut) {
                                echo '<div class="alert alert-danger" role="alert">
                                    Dosya boyutunuz izin verilen boyuttan fazla!
                                    </div> ';
                            } else {
                                $geciciisim     = $_FILES['SozResim']['tmp_name'];
                                $dosyaismi      =   $_FILES['SozResim']['name'];
                                $rastgelesayi   =   rand(1000, 9999);
                                $isim           =   $rastgelesayi . $dosyaismi;
                                move_uploaded_file($geciciisim, "../src/assets/images/sozler/$isim");
                            }
                        }
                        $guncelle = $db->prepare("INSERT INTO sozler SET SozIsim=?, SozMetin=?, SozResim=?");
                        $guncelle->execute([
                            $SozIsim,
                            $SozMetin,
                            $isim,
                        ]);
                    }
                }


                ?>


                <div class="p-5">
                    <h5 class="card-title fw-semibold mb-4">Sözler</h5>
                    <!-- Button trigger modal -->
                    <button type="submit" class="btn btn-success w-25" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Yeni Söz Ekle</button>
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Yeni Söz Ekle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="" class="form-label ">Resim Ekle</label>
                                            <input class="form-control form-control " id="formFileSm" type="file" name="SozResim">
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label ">İsim Soyisim</label>
                                            <input type="text" class="form-control shadow rounded" name="SozIsim" aria-describedby="helpId">
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="form-label">Söz</label>
                                            <textarea class="form-control" name="SozMetin" rows="3"></textarea>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" name="SozEkle" class="btn btn-success">Ekle</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal End -->


                    <div class="card-body p-4">

                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle" id="tablo">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">SozId</h6>
                                        </th>

                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Resim</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">İsim Soyisim</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Söz</h6>
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $deger = $db->query("SELECT * FROM sozler");
                                    $deger->execute();
                                    $sozler = $deger->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($sozler as $key => $soz) { ?>
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0"><?= $soz['SozId'] ?></h6>
                                            </td>

                                            <td class="border-bottom-0">
                                                <img src="../src/assets/images/sozler/<?= $soz['SozResim'] ?>" alt="<?= $soz['SozIsim'] ?>" style="max-width: 80px; max-height: 80px;">
                                            </td>
                                            <td class="border-bottom-0">
                                                <a href="sozleriduzenle.php?SozId=<?= $soz['SozId'] ?>" class="custom-button">
                                                    <h6 class="fw-semibold mb-1"><?= $soz['SozIsim'] ?></h6>
                                                </a>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0"><?= $soz['SozMetin'] ?></h6>
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
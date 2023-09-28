<?php
define("giriskontrol", true);
require_once 'header.php';
require_once '../src/assets/php/baglanti.php';
require_once '../src/assets/php/fonksiyonlar.php';
$veri = $db->prepare("SELECT * FROM ligler");
$veri->execute();
$ligler = $veri->fetchAll(PDO::FETCH_ASSOC);

$veri = $db->prepare("SELECT * FROM takimlar");
$veri->execute();
$takimlar = $veri->fetchAll(PDO::FETCH_ASSOC);
$takimsayisi = count($takimlar);


?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">

                <?php


                if (isset($_POST['SampiyonEkle'])) {
                    $SampiyonLig    =   $_POST['TakimLig'];
                    $SampiyonTakim  =   $_POST['TakimIsim'];
                    $SampiyonResim  =   $_POST['TakimResim'];
                    $SampiyonSezon  =   filtrele($_POST['SampiyonSezon']);

                    if (empty($_POST['SampiyonSezon'])) {
                        echo '<div class="alert alert-danger" role="alert">
                       Lütfen Sezonu Giriniz!
                    </div>';
                    } else {

                        $ekle = $db->prepare("INSERT INTO sampiyonlar SET SampiyonLig=?, SampiyonTakim=?, SampiyonResim=?, SampiyonSezon=?");
                        $ekle->execute([
                            $SampiyonLig,
                            $SampiyonTakim,
                            $SampiyonResim,
                            $SampiyonSezon,
                        ]);

                        if ($ekle) {
                            header("location:sampiyonlar.php");
                        }
                    }
                }



                ?>





                <div class="p-5">
                    <h5 class="card-title fw-semibold mb-4">Takımlar</h5>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle" id="tablo">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Lig</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Takım Resmi</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Takımlar</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">İşlemler</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $veri = $db->prepare("SELECT * FROM takimlar");
                                    $veri->execute();
                                    $takimlar = $veri->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($takimlar as $key => $takim) { ?>
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1"><?= $takim['TakimLig'] ?></h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <img src="../src/assets/images/logos/takimlar/<?= $takim['TakimResim'] ?>" alt="" style="max-width: 80px; max-height: 80px;">
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1"><?= $takim['TakimIsim'] ?></h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <form method="post" enctype="multipart/form-data">
                                                    <h5>Şampiyon Sezonunu Yazınız</h5>
                                                    <input type="text" name="SampiyonSezon" class="form-control mb-3 shadow-lg">
                                                    <input type="hidden" name="TakimLig" value="<?= $takim['TakimLig'] ?>">
                                                    <input type="hidden" name="TakimIsim" value="<?= $takim['TakimIsim'] ?>">
                                                    <input type="hidden" name="TakimResim" value="<?= $takim['TakimResim'] ?>">
                                                    <button type="submit" name="SampiyonEkle" class="btn btn-success">Şampiyon Ekle</button>
                                                </form>
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
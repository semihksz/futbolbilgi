<?php
require_once 'src/assets/php/baglanti.php';

if (isset($_GET['LigSil'])) {
    $LigSil =   $db->prepare("DELETE FROM ligler WHERE LigId={$_GET['LigId']}");
    $LigSil->execute();
    if ($LigSil) {
        header("location:ligler.php");
    }
}

if (isset($_GET['TakimSil'])) {
    $TakimSil = $db->prepare("DELETE FROM takimlar WHERE TakimId={$_GET['TakimId']}");
    $TakimSil->execute();
    if ($TakimSil) {
        header("location:takimlar.php");
    }
}

if (isset($_GET['OyuncuSil'])) {
    $OyuncuSil = $db->prepare("DELETE FROM oyuncular WHERE OyuncuId={$_GET['OyuncuId']}");
    $OyuncuSil->execute();
    if ($OyuncuSil) {
        header("location:oyuncular.php");
    }
}

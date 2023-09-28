<?php


function filtrele($deger)
{
    $bir    =   trim($deger);
    $iki    =   strip_tags($bir);
    $uc     =   htmlspecialchars($iki);
    $sonuc  =   $uc;
    return $sonuc;
}

function tarihdegistir($OyuncuDogumTarihi)
{
    require_once 'baglanti.php';
    $DogumTarihi = date('d/m/Y', strtotime($OyuncuDogumTarihi));
    return $DogumTarihi;
}

function YoneticiOturum()
{
    require_once '../src/assets/php/baglanti.php';
    if (!isset($_SESSION['AdminIsim']) or !isset($_SESSION['AdminSifre'])) {
        header("location:yoneticigiris.php");
        exit;
    } else {
        return true;
    }
}

<?php

$host       =   'localhost';
$dbname     =   'futbolbilgileri';
$username   =   'root';
$password   =   '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=UTF8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $hata) {
    echo $hata->getMessage();
}

$deger = $db->query("SELECT * FROM site_ayarlari");
$deger->execute();
$site = $deger->fetch(PDO::FETCH_ASSOC);


$deger = $db->query("SELECT * FROM takimlar");
$deger->execute();
$takimlar = $deger->fetchAll(PDO::FETCH_ASSOC);
$takimsayisi = $deger->rowCount();
$takimresimleri = [];
$takimıd = [];
$takimlig = [];
for ($i = 1; $i <= $takimsayisi; $i++) {
    $takimresimleri[$i] = $takimlar[$i - 1]['TakimResim'];
    $takimıd[$i] = $takimlar[$i - 1]['TakimId'];
    $takimlig[$i] = $takimlar[$i - 1]['TakimLig'];
}

$deger = $db->query("SELECT * FROM ligler");
$deger->execute();
$ligler = $deger->fetchAll(PDO::FETCH_ASSOC);


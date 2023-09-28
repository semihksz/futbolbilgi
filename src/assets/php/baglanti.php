<?php
ob_start();
session_start();

$host       =   "localhost";
$dbname     =   "futbolbilgileri";
$username   =   "root";
$password   =   "";

try {
    $db =   new PDO("mysql:host=$host;dbname=$dbname;charset=UTF8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $hata) {
    echo $hata->getMessage();
}

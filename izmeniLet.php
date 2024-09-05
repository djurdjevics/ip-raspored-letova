<?php
session_start();
$ime = $_SESSION["ime"];
if (!isset($ime)) {
    header('Location: prijava.php');
}

require "klase/BaznaKonekcija.php";
require "klase/BaznaTabela.php";

$KonekcijaObject = new Konekcija('klase/BaznaParametriKonekcije.xml');
$KonekcijaObject->connect();

if ($KonekcijaObject->konekcijaDB) {
    require "klase/DBLet.php";
    $let = new DBLet($KonekcijaObject, 'let');
    $datum_polaska = $_POST["vremePolaska"];
    $datum_dolaska = $_POST["vremeDolaska"];
    $mesto_polaska = $_POST["mestoPolaska"];
    $mesto_dolaska = $_POST["mestoDolaska"];
    $avion = $_POST["avion"];
    $id = $_POST["id"];

    $let->IzmeniLet($id, $avion, $mesto_dolaska,$mesto_polaska, $datum_dolaska,$datum_polaska);
}
?>

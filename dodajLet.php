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

    require "klase/BaznaTransakcija.php";
    $TransakcijaObject = new Transakcija($KonekcijaObject);
    $TransakcijaObject->ZapocniTransakciju();


    require "klase/DBLet.php";
    $let = new DBLet($KonekcijaObject, 'let');
    $datum_polaska = $_POST["vremePolaska"];
    $datum_dolaska = $_POST["vremeDolaska"];
    $mesto_polaska = $_POST["mestoPolaska"];
    $mesto_dolaska = $_POST["mestoDolaska"];
    $avion = $_POST["avion"];
    // echo "Datum polaska: " . $datum_polaska . "<br>";
    // echo "Datum dolaska: " . $datum_dolaska . "<br>";
    // echo "Mesto polaska: " . $mesto_polaska . "<br>";
    // echo "Mesto dolaska: " . $mesto_dolaska . "<br>";
    // echo "Avion: " . $avion . "<br>";

    $letovi = $let->UcitajKolekcijuSvihLetova();

    require "validacije/LetValidator.php";
    $validator = new LetValidator($letovi);

    $greska1 = "";

    if($validator->proveriBrojLetovaZaDatum($datum_polaska) == false)
        $greska1 = "Maksimalan broj odlaznih letova je dostignut.";

    $greska2 = $let->DodajNoviLet($avion, $mesto_dolaska,$mesto_polaska, $datum_dolaska,$datum_polaska);

    require "klase/DBBrojLetova.php";
    $broj = new BrojLetova($KonekcijaObject, 'broj_letova');
    $greska3 = $broj->PovecajZaJedan();

    $UtvrdjenaGreska=$greska1.$greska2.$greska3;
	$TransakcijaObject->ZavrsiTransakciju($UtvrdjenaGreska);
}
?>

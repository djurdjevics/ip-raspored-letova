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
    $id = $_POST["id"];
    $greska1 = $let->ObrisiLet($id);

    require "klase/DBBrojLetova.php";
    $broj = new BrojLetova($KonekcijaObject, 'broj_letova');
    $greska2 = $broj->SmanjiZaJedan();

    $UtvrdjenaGreska=$greska1.$greska2;
	$TransakcijaObject->ZavrsiTransakciju($UtvrdjenaGreska);
}
?>

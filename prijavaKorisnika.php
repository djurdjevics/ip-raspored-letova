<?php
ob_start();
session_start();
$loginUserName = $_POST['IME'];
$loginPassword = $_POST['SIFRA'];
require 'klase/BaznaKonekcija.php';
require 'klase/BaznaTabela.php';
require 'klase/DBKorisnik.php';

$korisnik = 'NEPOZNAT KORISNIK';
$objKonekcija = new Konekcija('klase/BaznaParametriKonekcije.xml');
$objKonekcija->connect();

if ($objKonekcija->konekcijaDB) {
    $objKorisnik = new DBKorisnik($objKonekcija, 'korisnik');
    $postojiKorisnik = $objKorisnik->DaLiPostojiKorisnik($loginUserName, $loginPassword);
    if ($postojiKorisnik == "DA") {
        $_SESSION["ime"] = $objKorisnik->DajImePrijavljenogKorisnika($loginUserName, $loginPassword);
        $_SESSION["idkorisnika"] = $objKorisnik->DajIDPrijavljenogKorisnika($loginUserName, $loginPassword);
        header ('Location: Pregled.php');
        exit();
    } else {
        header('Location: prijava.php');
        die();
    }
} else {
    echo "Neuspeh konekcije na bazu podataka!";
}
ob_end_flush();
?>
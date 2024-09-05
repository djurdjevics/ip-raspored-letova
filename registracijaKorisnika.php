<?php
ob_start();
session_start();
$ime = $_POST['IME'];
$sifra = $_POST['SIFRA'];
require 'klase/BaznaKonekcija.php';
require 'klase/BaznaTabela.php';
require 'klase/DBKorisnik.php';

$objKonekcija = new Konekcija('klase/BaznaParametriKonekcije.xml');
$objKonekcija->connect();

if ($objKonekcija->konekcijaDB) {
    $objKorisnik = new DBKorisnik($objKonekcija, 'korisnik');
    $objKorisnik->DodajNovogKorisnika($ime, $sifra);
    header('Location: prijava.php');
    exit();
    }
?>
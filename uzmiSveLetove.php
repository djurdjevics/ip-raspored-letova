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
    $let = new DBLet($KonekcijaObject, "let");
    $letovi = $let->UcitajKolekcijuSvihLetova();
    if ($letovi) {
        $data = array();
        while ($row = $letovi->fetch_assoc()) {
            $data[] = $row;
        }
        $json = json_encode($data);
        if ($json) {
            echo $json;
        } else {
            echo "Greška pri kodiranju u JSON format.";
        }
    } else {
        echo "Greška pri učitavanju letova.";
    }
}
?>

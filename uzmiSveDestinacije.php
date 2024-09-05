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
    require "klase/DBDestinacija.php";
    $destinacija = new DBDestinacija($KonekcijaObject, "destinacije");
    $destinacije = $destinacija->UcitajKolekcijuSvihDestinacija();
    if ($destinacije) {
        $data = array();
        while ($row = $destinacije->fetch_assoc()) {
            $data[] = $row;
        }
        $json = json_encode($data);
        if ($json) {
            header("Content-Type: application/json");
            echo $json;
        } else {
            echo "Greška pri kodiranju u JSON format.";
        }
    } else {
        echo "Greška pri učitavanju destinacija.";
    }
}
?>

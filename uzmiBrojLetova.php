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
    require "klase/DBBrojLetova.php";

    $broj = new BrojLetova($KonekcijaObject, "broj_letova");
    $B = $broj->UcitajBrojLetova();

    if ($B) {
        $data = array();
        while ($row = $B->fetch_assoc()) {
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
        echo "Greška pri učitavanju broja letova.";
    }
}
?>

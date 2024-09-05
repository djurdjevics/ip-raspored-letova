<?php
class LetValidator {
    private $letovi;
    private $max_broj_letova;

    public function __construct($letovi) {
        $this->letovi = $letovi;

        // Učitaj maksimalni broj letova iz XML-a
        $xml = simplexml_load_file('klase/PoslovnaPravila.xml');
        $this->max_broj_letova = (int)$xml->maksimalanbrojletova;
    }

    public function proveriBrojLetovaZaDatum($datum_polaska) {
        $broj_odlaznih_letova = 0;
        
        // Prebroj broj odlaznih letova za određeni datum
        foreach ($this->letovi as $trenutni_let) {
            if ($trenutni_let['DATUM_POLASKA'] === $datum_polaska) {
                $broj_odlaznih_letova++;
            }
        }

        // Vraća true ako je moguće dodati novi let, u suprotnom false
        return $broj_odlaznih_letova < $this->max_broj_letova;
    }
}
?>
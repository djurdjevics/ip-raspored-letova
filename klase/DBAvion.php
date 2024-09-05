<?php
class DBAvion extends Tabela 
{
    // ATRIBUTI
    private $bazapodataka;
    private $UspehKonekcijeNaDBMS;

    // public atributi
    public $ID;
    public $Kapacitet;
    public $ModelAviona;

    // METODE

    // konstruktor
    public function vratiID(){
        return $this->ID;
    }
    public function vratiModelAviona(){
        return $this->ModelAviona;
    }
    public function UcitajKolekcijuSvihAviona()
    {
        $SQL = "SELECT ID, MODEL_AVIONA FROM avion";
        return $this->UcitajSvePoUpitu($SQL);
    }

    public function InkrementirajKapacitet($IDAviona)
    {
        // izdvajanje stare vrednosti kapaciteta za taj avion
        $KriterijumFiltriranja = "ID='" . $IDAviona . "'";
        $StaraVrednostKapaciteta = $this->DajVrednostJednogPoljaPrvogZapisa('Kapacitet', $KriterijumFiltriranja, 'Kapacitet');

        // izračunavanje nove vrednosti
        $NovaVrednostKapaciteta = $StaraVrednostKapaciteta + 1;

        // izvršavanje izmene
        $SQL = "UPDATE `Avion` SET Kapacitet=" . $NovaVrednostKapaciteta . " WHERE ID='" . $IDAviona . "'";
        $greska = $this->IzvrsiAktivanSQLUpit($SQL);

        return $greska;
    }

    // ########### TO DO

    public function DajKolekcijuAvionaFiltrirano($filterPolje, $filterVrednost, $nacinFiltriranja, $Sortiranje)
    {
        if ($nacinFiltriranja == "like") {
            $SQL = "SELECT * FROM `Avion` WHERE $filterPolje LIKE '%" . $filterVrednost . "%' ORDER BY $Sortiranje";
        } else {
            $SQL = "SELECT * FROM `Avion` WHERE $filterPolje ='" . $filterVrednost . "' ORDER BY $Sortiranje";
        }
        $this->UcitajSvePoUpitu($SQL);
        return $this->Kolekcija;
    }

    public function DajUkupanBrojSvihAviona($KolekcijaZapisa)
    {
        return $this->BrojZapisa;
    }

    public function DodajNoviAvion()
    {
        $SQL = "INSERT INTO `Avion` (Kapacitet, ModelAviona) VALUES ($this->Kapacitet, '$this->ModelAviona')";
        $greska = $this->IzvrsiAktivanSQLUpit($SQL);

        return $greska;
    }

    public function ObrisiAvion($IdZaBrisanje)
    {
        $SQL = "DELETE FROM `Avion` WHERE ID=" . $IdZaBrisanje;
        $greska = $this->IzvrsiAktivanSQLUpit($SQL);

        return $greska;
    }

    public function IzmeniAvion($IdZaIzmenu, $NoviKapacitet, $NoviModelAviona)
    {
        $SQL = "UPDATE `Avion` SET Kapacitet=" . $NoviKapacitet . ", ModelAviona='" . $NoviModelAviona . "' WHERE ID=" . $IdZaIzmenu;
        $greska = $this->IzvrsiAktivanSQLUpit($SQL);

        return $greska;
    }

    // ostale metode
}
?>

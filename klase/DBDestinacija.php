<?php
class DBDestinacija extends Tabela 
{
    // ATRIBUTI
    private $bazapodataka;
    private $UspehKonekcijeNaDBMS;

    // public atributi
    public $ID;
    public $Naziv;

    // METODE

    // konstruktor

    public function UcitajKolekcijuSvihDestinacija()
    {
        $SQL = "SELECT ID, NAZIV FROM destinacije ORDER BY Naziv ASC";
        return $this->UcitajSvePoUpitu($SQL);
    }

    // ########### TO DO

    public function DajKolekcijuDestinacijaFiltrirano($filterPolje, $filterVrednost, $nacinFiltriranja, $Sortiranje)
    {
        if ($nacinFiltriranja == "like") {
            $SQL = "SELECT * FROM destinacije WHERE $filterPolje LIKE '%" . $filterVrednost . "%' ORDER BY $Sortiranje";
        } else {
            $SQL = "SELECT * FROM destinacije WHERE $filterPolje ='" . $filterVrednost . "' ORDER BY $Sortiranje";
        }
        $this->UcitajSvePoUpitu($SQL);
        return $this->Kolekcija;
    }

    public function DajUkupanBrojSvihDestinacija($KolekcijaZapisa)
    {
        return $this->BrojZapisa;
    }

    public function DodajNovuDestinaciju()
    {
        $SQL = "INSERT INTO `Destinacija` (Naziv) VALUES ('$this->Naziv')";
        $greska = $this->IzvrsiAktivanSQLUpit($SQL);

        return $greska;
    }

    public function ObrisiDestinaciju($IdZaBrisanje)
    {
        $SQL = "DELETE FROM destinacije WHERE ID=" . $IdZaBrisanje;
        $greska = $this->IzvrsiAktivanSQLUpit($SQL);

        return $greska;
    }

    public function IzmeniDestinaciju($IdZaIzmenu, $NoviNaziv)
    {
        $SQL = "UPDATE destinacije SET Naziv='" . $NoviNaziv . "' WHERE ID=" . $IdZaIzmenu;
        $greska = $this->IzvrsiAktivanSQLUpit($SQL);

        return $greska;
    }

    // ostale metode
}
?>

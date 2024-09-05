<?php
class DBLet extends Tabela 
{
    // ATRIBUTI
    private $bazapodataka;
    private $UspehKonekcijeNaDBMS;

    // public atributi
    public $ID;
    public $IDAviona;
    public $MestoDolaska;
    public $MestoPolaska;
    public $VremeDolaska;
    public $VremePolaska;

    // METODE

    // konstruktor

    public function UcitajKolekcijuSvihLetova(){
        $SQL = "SELECT * FROM informacije_leta";
        return $this->UcitajSvePoUpitu($SQL);
    }
    
    public function DodajNoviLet($IDAviona, $MestoDolaska, $MestoPolaska, $VremeDolaska, $VremePolaska){
        $SQL = "CALL dodajLet('$IDAviona', '$MestoDolaska', '$MestoPolaska', '$VremeDolaska', '$VremePolaska')";
        $greska = $this->IzvrsiAktivanSQLUpit($SQL);
        return $greska;
    }

    public function ObrisiLet($IdZaBrisanje){
        $SQL = "CALL obrisiLet($IdZaBrisanje)";
        $greska = $this->IzvrsiAktivanSQLUpit($SQL);
        return $greska;
    }

    public function IzmeniLet($IdZaIzmenu, $NoviIDAviona, $NovoMestoDolaska, $NovoMestoPolaska, $NovoVremeDolaska, $NovoVremePolaska){
        $SQL = "CALL izmeniLet($IdZaIzmenu, $NoviIDAviona, '$NovoMestoDolaska', '$NovoMestoPolaska', '$NovoVremeDolaska', '$NovoVremePolaska')";
        $greska = $this->IzvrsiAktivanSQLUpit($SQL);
        return $greska;
    }
    

}
?>

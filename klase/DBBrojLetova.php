<?php 
    class BrojLetova extends Tabela{
         // ATRIBUTI
        private $bazapodataka;
        private $UspehKonekcijeNaDBMS;
          // public atributi
        public $ID;
        public $broj_letova;

    public function UcitajBrojLetova(){
        $SQL = "SELECT broj_letova FROM broj_letova";
        return $this->UcitajSvePoUpitu($SQL);
    }

    public function PovecajZaJedan(){
        $SQL = "UPDATE broj_letova SET broj_letova = broj_letova + 1";
        $this->IzvrsiAktivanSQLUpit($SQL);
    }

    public function SmanjiZaJedan(){
      $SQL = "UPDATE broj_letova SET broj_letova = broj_letova - 1";
      $this->IzvrsiAktivanSQLUpit($SQL);
    }
}

?>

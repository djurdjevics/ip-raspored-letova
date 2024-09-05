<?php
class DBKorisnik extends Tabela {

    // ATRIBUTI
    public $IDKorisnika; // auto increment u bazi podataka
    public $Ime;
    public $Prezime;
    public $TipKorisnika;

    // metode

    // ------- konstruktor - uzima se iz klase roditelja - Tabela

    // ------- preostale metode

    public function UcitajSveKorisnike() {
        $SQL = "SELECT * FROM korisnik";
        $this->UcitajSvePoUpitu($SQL);
    }

    public function DodajNovogKorisnika($ime, $sifra){
        $SQL = "CALL dodajKorisnika('$ime', '$sifra')";
        $this->IzvrsiAktivanSQLUpit($SQL);
    }
    

    public function DaLiPostojiKorisnik($loginusername, $loginpassword) {
        $postoji = "";
        $SQLKorisnik = "SELECT * FROM `" . $this->OtvorenaKonekcija->KompletanNazivBazePodataka . "`.`korisnik` WHERE IME='" . $loginusername . "' AND SIFRA='" . $loginpassword . "'";
        $this->UcitajSvePoUpitu($SQLKorisnik);
        if ($this->BrojZapisa > 0) {
            $postoji = "DA";
        } else {
            $postoji = "NE";
        }
        return $postoji;
    }

    public function DajImePrijavljenogKorisnika($loginusername, $loginpassword) {
        $korisnik="";
        $SQLKorisnik = "SELECT * FROM `".$this->OtvorenaKonekcija->KompletanNazivBazePodataka."`.`KORISNIK` WHERE IME='".$loginusername."' AND SIFRA='".$loginpassword."'";
        $this->UcitajSvePoUpitu($SQLKorisnik);
        $this->PrebaciKolekcijuUListu($this->Kolekcija);
        if ($this->BrojZapisa>0)
        {
            // postoji zapis
            foreach ($this->ListaZapisa as $VrednostCvoraListe)
            {
                $ime=$VrednostCvoraListe[1];
                
            }
        }  			
        else 
        {
            $ime='NEPOZNAT KORISNIK';
        }
        return $ime;
    }

    // public function DajPrezimePrijavljenogKorisnika($loginusername, $loginpassword) {
    //     $prezime = 'NEPOZNAT KORISNIK';
    //     $SQLKorisnik = "SELECT * FROM `" . $this->OtvorenaKonekcija->KompletanNazivBazePodataka . "`.`KORISNIK` WHERE KORISNICKOIME='" . $loginusername . "' AND SIFRA='" . $loginpassword . "'";
    //     $this->UcitajSvePoUpitu($SQLKorisnik);
    //     if ($this->BrojZapisa > 0) {
    //         foreach ($this->ListaZapisa as $VrednostCvoraListe) {
    //             $prezime = $VrednostCvoraListe[1];
    //         }
    //     }
    //     return $prezime;
    // }

    // public function DajImePrezimePrijavljenogKorisnika($loginusername, $loginpassword) {
    //     $korisnik = 'NEPOZNAT KORISNIK';
    //     $SQLKorisnik = "SELECT * FROM `" . $this->OtvorenaKonekcija->KompletanNazivBazePodataka . "`.`KORISNIK` WHERE KORISNICKOIME='" . $loginusername . "' AND SIFRA='" . $loginpassword . "'";
    //     $this->UcitajSvePoUpitu($SQLKorisnik);
    //     if ($this->BrojZapisa > 0) {
    //         foreach ($this->ListaZapisa as $VrednostCvoraListe) {
    //             $prezime = $VrednostCvoraListe[1];
    //             $ime = $VrednostCvoraListe[2];
    //             $korisnik = $prezime . ' ' . $ime;
    //         }
    //     }
    //     return $korisnik;
    // }

    public function DajIDPrijavljenogKorisnika($loginusername, $loginpassword) {
        $id = 0;
        $SQLKorisnik = "SELECT * FROM `" . $this->OtvorenaKonekcija->KompletanNazivBazePodataka . "`.`KORISNIK` WHERE IME='" . $loginusername . "' AND SIFRA='" . $loginpassword . "'";
        $this->UcitajSvePoUpitu($SQLKorisnik);
        if ($this->BrojZapisa > 0) {
            foreach ($this->ListaZapisa as $VrednostCvoraListe) {
                $id = $VrednostCvoraListe[0];
            }
        }
        return $id;
    }

    public function SnimiNovo() {
        $AktivanSQLUpit = "";
        $this->IzvrsiAktivanSQLUpit($AktivanSQLUpit);
    }

    // brisanje
    public function Obrisi() {
        $AktivanSQLUpit = "DELETE FROM ";
        $this->IzvrsiAktivanSQLUpit($AktivanSQLUpit);
    }

    public function ObrisiSve() {
        $AktivanSQLUpit = "DELETE FROM ";
        $this->IzvrsiAktivanSQLUpit($AktivanSQLUpit);
    }

    public function IzmeniVrednostPolja() {

        // transformisemo datum u formu pogodnu za insert into
        // $DatumskaVrednost=date_create($this->Datum_PoslednjePromene);
        // $DatumUnosa=date_format($DatumskaVrednost,"Y-m-d");

        // konacan upit
        $AktivanSQLUpit = "UPDATE SET ";
        $this->IzvrsiAktivanSQLUpit($AktivanSQLUpit);
    }
}
?>

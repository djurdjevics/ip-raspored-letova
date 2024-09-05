<?php
session_start();
    $ime = $_SESSION["ime"];
    if(!isset($ime)){
        header ('Location: prijava.php');
    }
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en" xml:lang="sr-RS">
<?php include 'delovi/header.php'; ?>
<head>
    <meta charset="utf-8">
    <title>Raspored letova</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Dodavanje Bootstrap JavaScript-a -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
        <div class="col-12 row">
            <div class="col-4">
                <form class="jumbotron">
                    <h1>Unos letova:</h1>
                    <label for="naslov">Unesite vreme polaska:</label>
                    <input type="date" class="form-select form-control" name="vremePolaska" id="vremePolaska"></input>
                    <label for="naslov" class="mt-3">Unesite vreme dolaska:</label>
                    <input type="date" class="form-select form-control" name="vremeDolaska" id="vremeDolaska"></input>
                    <label for="naslov" class="mt-3">Unesite mesto polaska:</label>
                    <select class="form-select form-control" name="mestoPolaska" id="mestoPolaska"></select>
                    <label for="naslov" class="mt-3">Unesite mesto dolaska:</label>
                    <select class="form-select form-control" name="mestoDolaska" id="mestoDolaska"></select>
                    <label for="naslov" class="mt-3">Unesite avion:</label>
                    <select class="form-select form-control" name="avion" id="avion"></select>
                    <label for="naslov" class="mt-3">Broj letova:</label>
                    <input type="number" class="form-select form-control" name="brojLetova" id="brojLetova" readonly></input>
                    <button class="btn btn-primary btn-success mt-3" id="dodaj">Dodaj let</button>
                    <button class="btn btn-primary btn-warning mt-3 ml-3" id="izmeni">Izmeni let</button>
                    <button class="btn btn-primary btn-danger mt-3 ml-3" id="reset">Reset</button>
                    <font face="Trebuchet MS" color="darkblue" class="ml-5"><a href="prijava.php">Odjava</a></font>
                </form>
        </div>
        <div class="col-8">
            <table class="table table-bordered table-striped table-responsive" id="tabela">
                <thead>
                    <tr>
                        <th>ID LETA</th>
                        <th>MESTO POLASKA</th>
                        <th>MESTO DOLASKA</th>
                        <th>VREME POLASKA</th>
                        <th>VREME DOLASKA</th>
                        <th>MODEL</th>
                        <th>KAPACITET</th>
                        <th>OBRIŠI</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</body>
<?php include 'delovi/footer.php'; ?>
<script>
    let id = null;
    let mestoPolaska = null;
    let mestoDolaska = null;
    let vremePolaska = null;
    let vremeDolaska = null;
    let avion = null;
    var table = $('#tabela').DataTable({
  "order": [],
  "scrollY": "400px",
  "paging": false,
  "scrollX": false,
  "scrollCollapse": true,
  "autoWidth": false,
  "responsive": false,
  "select": true,
  "searching": true,
  "fixedColumns": true,
  ajax: {
    url: 'uzmiSveLetove.php',
    type: "POST",
    dataSrc: ""
  },
  columns: [
    { data: "ID"},
    { data: "MESTO_POLASKA" },
    { data: "MESTO_DOLASKA" },
    { data: "DATUM_POLASKA" },
    { data: "DATUM_DOLASKA" },
    { data: "MODEL" },
    { data: "KAPACITET" },
    {
      data: null,
      render: function(data, type, row) {
        return '<button class="btn btn-danger" id="brisanje">OBRIŠI</button>';
      }
    }
  ],
  dom: 'Bfrtip',
  columnDefs: [
    {
      data: null,
      defaultContent: '',
      targets: "_all"
    }
  ]
});

    $(document).ready(function() {
        //////////// -- SVI AVIONI -- POCETAK
        var avionSelect = $("#avion");

        $.get("uzmiSveAvione.php", function(data) {
            data.forEach(element => {
                var option = $("<option></option>").attr("value", element.ID).text(element.MODEL_AVIONA);
                avionSelect.append(option);
                // console.log(element.ID, element.MODEL_AVIONA);

            });
        })
        .fail(function(xhr, status, error) {
            console.error("Greška prilikom dobijanja aviona:", xhr, status, error);
        });
        //////////// -- SVI AVIONI -- KRAJ

        //////////// -- SVE DESTINACIJE -- POCETAK
        var destinacijaPolaska = $("#mestoPolaska");
        var destinacijaDolaska = $("#mestoDolaska");

        $.get("uzmiSveDestinacije.php", function(data) {
            data.forEach(element => {
                var optionPolazak = $("<option></option>").attr("value", element.ID).text(element.NAZIV);
                destinacijaPolaska.append(optionPolazak);
                // console.log(element.ID, element.NAZIV);
            });
            let obrnutiGradovi = data.slice();

            obrnutiGradovi.reverse();

            obrnutiGradovi.forEach(element => {
                var optionDolazak = $("<option></option>").attr("value", element.ID).text(element.NAZIV);
                destinacijaDolaska.append(optionDolazak);
            });
            destinacijaPolaska.on('change', function() {
                var selectedOption = $(this).val();
                destinacijaDolaska.find('option').removeAttr('disabled');

                if (selectedOption !== '') {
                    destinacijaDolaska.find('option[value="' + selectedOption + '"]').attr('disabled', 'disabled');
                }
            });

            destinacijaDolaska.on('change', function() {
                var selectedOption = $(this).val();
                destinacijaPolaska.find('option').removeAttr('disabled');

                if (selectedOption !== '') {
                    destinacijaPolaska.find('option[value="' + selectedOption + '"]').attr('disabled', 'disabled');
                }
            });
        })
        
        //////////// -- SVE DESTINACIJE -- KRAJ
        reset();
    });
    // KLIK NA TABELU
    osveziBrojLetova();
    $("#tabela").on('click', 'tr', function(e){
    e.preventDefault();
    let tabela = table.row($(this).closest("tr")).data();
    id = tabela.ID;
    mestoPolaska = tabela.MESTO_POLASKA;
    mestoDolaska = tabela.MESTO_DOLASKA;
    vremePolaska = tabela.DATUM_POLASKA;
    vremeDolaska = tabela.DATUM_DOLASKA;
    avion = tabela.MODEL;
    let brojMestoPolaska = mestoPolaska.split('(')[1].substring(0, mestoPolaska.split('(')[1].length - 1);
    let brojMestoDolaska = mestoDolaska.split('(')[1].substring(0, mestoDolaska.split('(')[1].length - 1);
    let brojAvion = avion.split('(')[1].substring(0, avion.split('(')[1].length - 1);
    $('#vremePolaska').val(vremePolaska);
    $('#vremeDolaska').val(vremeDolaska);
    $('#mestoPolaska').val(brojMestoPolaska);
    $('#mestoDolaska').val(brojMestoDolaska);
    $("#avion").val(brojAvion);
});
    $("#dodaj").click(function(e){
        e.preventDefault();
        if($("#vremePolaska").val() != "" && $("#vremeDolaska").val() != "" && $("#mestoPolaska").val() != "" && $("#mestoDolaska").val() != "" && $("#avion").val() != "" )
        {
            var vremePolaska = $("#vremePolaska").val();
            var vremeDolaska = $("#vremeDolaska").val();
            var mestoPolaska = $("#mestoPolaska").val();
            var mestoDolaska = $("#mestoDolaska").val();
            var avion = $("#avion").val();
            var id = -1;
            $.ajax({
                url: "dodajLet.php",
                type: "POST",
                data: { vremePolaska: vremePolaska, vremeDolaska: vremeDolaska, mestoPolaska: mestoPolaska, mestoDolaska: mestoDolaska, avion: avion, id: id },
                success: function(data){
                    table.ajax.reload();
                    reset();
                    osveziBrojLetova();
                },
                error: function(xhr, status, error){
                    console.error(xhr);
                }
            });
        }
        else
        {
            alert("Popunite sva polja");
        }
    });
    // BRISANJE LETA
    $('#tabela tbody').on('click', '#brisanje', function() {
        var data = table.row($(this).closest('tr')).data();
        var id = data.ID;
        if(confirm('Da li ste sigurni da želite obrisati let?')) {
            $.ajax({
                url: 'obrisiLet.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    table.ajax.reload();
                    osveziBrojLetova();
                },
                error: function(xhr, status, error) {
                    console.error('Greška prilikom brisanja:', xhr, status, error);
                }
            });
        }
    });
    // IZMENA LETA
    $("#izmeni").click(function(e){
        e.preventDefault();
        if($("#vremePolaska").val() != "" && $("#vremeDolaska").val() != "" && $("#mestoPolaska").val() != "" && $("#mestoDolaska").val() != "" && $("#avion").val() != "" )
        {
            var vremePolaska = $("#vremePolaska").val();
            var vremeDolaska = $("#vremeDolaska").val();
            var mestoPolaska = $("#mestoPolaska").val();
            var mestoDolaska = $("#mestoDolaska").val();
            var avion = $("#avion").val();
            $.ajax({
                url: "izmeniLet.php",
                type: "POST",
                data: { vremePolaska: vremePolaska, vremeDolaska: vremeDolaska, mestoPolaska: mestoPolaska, mestoDolaska: mestoDolaska, avion: avion, id: id },
                success: function(data){
                    table.ajax.reload();
                    reset();
                },
                error: function(xhr, status, error){
                    console.error(xhr);
                }
            });
        }
        else
        {
            alert("Odaberite let iz tabele ili popunite sva polja");
        }
    });
    // RESET
    $("#reset").click(function(e){
        e.preventDefault();
        reset();
    });
    function reset(){
        $("#vremePolaska").val("");
        $("#vremeDolaska").val("");
        $("#mestoPolaska").val("");
        $("#mestoDolaska").val("");
        $("#avion").val("");
        id = null;
    }
    function osveziBrojLetova(){
        $.get('uzmiBrojLetova.php', function(data) {
            $('#brojLetova').val(data[0].broj_letova);
        })
        .fail(function(xhr, status, error) {
            console.error('Greška prilikom preuzimanja broja letova:', xhr, status, error);
        });
    }
</script>
</html>

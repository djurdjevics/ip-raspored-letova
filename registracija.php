<!DOCTYPE html>
<html lang="en">
<?php 
  session_start();
  session_unset(); 
  session_destroy(); 
  include 'delovi/header.php';
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registracija</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .content {
      flex: 1;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <form class="jumbotron" action="" method="post">
          <h2 class="text-center mb-4">Registracija</h2>
          <div class="form-group">
            <label for="ime">Korisničko ime</label>
            <input type="text" class="form-control" id="ime" name="IME" placeholder="Unesite korisničko ime">
          </div>
          <div class="form-group">
            <label for="sifra">Lozinka</label>
            <input type="password" class="form-control" id="sifra" name="SIFRA" placeholder="Unesite lozinku">
          </div>
          <div class="form-group">
            <label for="sifra2">Ponovite lozinku</label>
            <input type="password" class="form-control" id="sifra2" name="SIFRA2" placeholder="Unesite ponovo lozinku">
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary" id="registracija">Registruj se</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  </body>
  <script>
    $("#registracija").on('click', function(e){
      e.preventDefault();
      let sifra1 = $("#sifra").val();
      let sifra2 = $("#sifra2").val();
      if(sifra1 != sifra2){
        alert("Šifre se razlikuju. Probajte ponovo.");
        $("#sifra").val("");
        $("#sifra2").val("");
        return;
      }
      $.post('registracijaKorisnika.php', {
          IME: $("#ime").val(),
          SIFRA: $("#sifra").val()
      })
      alert("Korisnik je uspešno registrovan!");
      window.location.href = "prijava.php";
    })
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 <?php include 'delovi/footer.php'; ?>
</html>

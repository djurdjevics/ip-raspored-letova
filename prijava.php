<!DOCTYPE html>
<html lang="en">

<?php 
  session_start();
  // remove all session variables
  session_unset(); 
  // destroy the session 
  session_destroy(); 


include 'delovi/header.php'; ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prijava</title>
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
        <form class="jumbotron" action="prijavaKorisnika.php" method="post">
          <h2 class="text-center mb-4">Prijava</h2>
          <div class="form-group">
            <label for="ime">Korisničko ime</label>
            <input type="text" class="form-control" id="ime" name="IME" placeholder="Unesite korisničko ime">
          </div>
          <div class="form-group">
            <label for="sifra">Lozinka</label>
            <input type="password" class="form-control" id="sifra" name="SIFRA" placeholder="Unesite lozinku">
          </div>
          <button type="submit" class="btn btn-primary">Prijava</button>
          <button class="btn float-right btn-secondary"id="registracija">Registracija</button>
        </form>
      </div>
    </div>
  </div>
</body>
<script>
    $(document).ready(function() {
      $("#registracija").on('click', function(e) {
        e.preventDefault(); 
        window.location.replace('registracija.php'); 
      });
    });
  </script>
  <?php include 'delovi/footer.php'; ?>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>

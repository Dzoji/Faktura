<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Dohvatanje podataka iz forme
  $ime = $_POST['ime'];
  $prezime = $_POST['prezime'];
  $brojTelefona = $_POST['brojTelefona'];
  $adresa = $_POST['adresa'];
  $grad = $_POST['grad'];
  $email = $_POST['email'];
  $jmbg = $_POST['jmbg'];

  // Povezivanje sa bazom podataka
  $conn = new mysqli("localhost", "root", "", "lanaco");
  if ($conn->connect_error) {
    die("Greška pri povezivanju sa bazom podataka: " . $conn->connect_error);
  }

  // Upis podataka u tabelu
  $query = "INSERT INTO radnik (RadnikId, Ime, Prezime, BrojTelefona, Adresa, Grad, Email, JMBG) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("isssssss", $radnikId, $ime, $prezime, $brojTelefona, $adresa, $grad, $email, $jmbg);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo "Novi radnik je dodan.";
    header("Location: radnik.php");
    exit;
  } else {
    echo "Došlo je do greške prilikom dodavanja radnika";
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-radnik_add.css">
  <title>Dodavanje novog radnika</title>
</head>

<body>
  <div class="form">
    <h1>Dodavanje radnika</h1><br>
    <form action="radnik_add.php" method="post">

      <label for="ime">Ime:</label><br>
      <input type="text" id="ime" name="ime" required><br>

      <label for="prezime">Prezime:</label><br>
      <input type="text" id="prezime" name="prezime" required><br>

      <label for="brojTelefona">Broj telefona:</label><br>
      <input type="number" id="brojTelefona" name="brojTelefona"><br>

      <label for="adresa">Adresa:</label><br>
      <input type="text" id="adresa" name="adresa" required><br>

      <label for="grad">Grad:</label><br>
      <input type="text" id="grad" name="grad" required><br>

      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" required><br>

      <label for="jmbg">JMBG:</label><br>
      <input type="number" id="jmbg" name="jmbg" required><br><br>

      <input type="submit" value="Dodaj radnika">
    </form>
  </div>

  <div class="meni">
    <h2>Meni</h2>
    <nav>
      <ul>
        <li><a href="pocetna.php">Artikal</a></li>
        <li><a href="lager.php">Lager</a></li>
        <li><a href="racun.php">Racun</a></li>
        <li><a href="radnik.php">Radnik</a></li>
      </ul>
    </nav>
    <button><a href="logout.php">Log Out</a></button>
  </div>
</body>

</html>
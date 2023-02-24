<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-registracija.css">
  <title>Registracija</title>
</head>

<body>
  <h1>Registrujte se</h1>
  <form action="registracija.php" method="POST">
    <div>
      <input name="korisnickoIme" type="text" placeholder="Unesite korisnicko ime..." required>
    </div>
    <br>
    <div>
      <input name="sifra" type="password" placeholder="Unesite sifru..." required>
    </div>
    <br>
    <div>
      <input type="submit" value="Registrujte se">
    </div>
  </form>
  <p>Već imate nalog? <a href="index.php">Prijavite se</a></p>
</body>

</html>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $korisnickoIme = htmlspecialchars(strip_tags(trim($_POST['korisnickoIme'])));
  $sifra = htmlspecialchars(strip_tags(trim($_POST['sifra'])));

  if (empty($korisnickoIme) || empty($sifra)) {
    echo "Korisničko ime i šifra su obavezna polja.";
    exit();
  }

  $conn = new mysqli("localhost", "root", "", "lanaco");

  if (!$conn) {
    die("Neuspjesna konekcija: " . mysqli_connect_error());
  }

  $korisnickoIme = mysqli_real_escape_string($conn, $korisnickoIme);
  $sifraHash = password_hash($sifra, PASSWORD_DEFAULT);

  $sql = "INSERT INTO korisnik (KorisnickoIme, Sifra)
    VALUES ('$korisnickoIme', '$sifraHash')";

  if (mysqli_query($conn, $sql)) {
    header("Location: pocetna.php");
    exit;
  } else {
    echo "Greska: " . $sql . "<br>" . mysqli_error($conn);
  }

  mysqli_close($conn);
}

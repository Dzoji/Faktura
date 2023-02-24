<?php

$conn = new mysqli("localhost", "root", "", "lanaco");

if (isset($_POST['sifra']) && isset($_POST['naziv']) && isset($_POST['jedinicaMjere']) && isset($_POST['barKod']) && isset($_POST['pluKod'])) {
  $sifra = $_POST['sifra'];
  $naziv = $_POST['naziv'];
  $jedinicaMjere = $_POST['jedinicaMjere'];
  $barKod = $_POST['barKod'];
  $pluKod = $_POST['pluKod'];


  $query = "INSERT INTO artikal (Sifra, Naziv, JedinicaMjere, Barkod, PLU_KOD) VALUES ('$sifra', '$naziv', '$jedinicaMjere', '$barKod', '$pluKod')";
  $result = mysqli_query($conn, $query);

  if ($result) {
    header("Location: pocetna.php");
  } else {
    echo "Greška: Artikal nije dodat u bazu";
  }
  $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-artikli_add.css">
  <title>Dodavanje novog artikla</title>
</head>

<body>

  <div class="form">
    <h1>Dodaj novi artikal</h1><br>
    <form action="artikli_add.php" method="post">

      <label for="sifra">Sifra:</label><br>
      <input type="text" id="sifra" name="sifra" required><br>

      <label for="naziv">Naziv:</label><br>
      <input type="text" id="naziv" name="naziv" required><br>

      <label for="jedinicaMjere">Jedinica Mjere:</label><br>
      <input type="text" id="jedinicaMjere" name="jedinicaMjere"><br>

      <label for="barKod">Bar Kod:</label><br>
      <input type="text" id="barKod" name="barKod" required><br>

      <label for="pluKod">Plu Kod:</label><br>
      <input type="text" id="pluKod" name="pluKod" required><br><br>

      <input type="submit" value="Dodaj artikal">
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
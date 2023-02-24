<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Dobavljanje podataka iz forme
  $artikalId = $_POST["artikal"];
  $kolicina = $_POST["kolicina"];
  $lokacija = $_POST["lokacija"];

  // Povezivanje sa bazom podataka
  $conn = new mysqli("localhost", "root", "", "lanaco");
  if ($conn->connect_error) {
    die("Greška pri povezivanju sa bazom podataka: " . $conn->connect_error);
  }

  // Upis podataka u tabelu lagera
  $query = "INSERT INTO lager (ArtikalId, RaspolozivaKolicina, Lokacija) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("iis", $artikalId, $kolicina, $lokacija);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo "Artikal je uspješno dodan u lager.";
  } else {
    echo "Došlo je do greške prilikom dodavanja artikla u lager.";
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-lager_add.css">
  <title>Dodavanje lagera</title>
</head>

<body>
  <div class="form">
    <h1>Dodavanje lagera</h1><br>
    <form action="lager_add.php" method="post">

      <label for="artikal">Artikal:</label>
      <select id="artikal" name="artikal">
        <?php
        // dobavljaju se svi artikli iz baze podataka i ispisuju u padajućem meniju
        $conn = new mysqli("localhost", "root", "", "lanaco");
        $query = "SELECT ArtikalId, Naziv FROM artikal";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_array($result)) {
          echo '<option value="' . $row['ArtikalId'] . '">' . $row['Naziv'] . '</option>';
        }
        ?>
      </select><br><br>
      <label for="kolicina">Količina:</label><br>
      <input type="number" id="kolicina" name="kolicina" min="0" step="1.0" required><br>

      <label for="lokacija">Lokacija:</label>
      <input type="text" id="lokacija" name="lokacija" required><br>

      <input type="submit" value="Dodaj u lager">
      <input type="reset" value="Poništi">
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

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
</body>
</html>
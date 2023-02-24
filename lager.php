<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-lager.css">
  <title>Lager</title>
</head>

<body>
<div class="tabela">
<?php
session_start();
$conn = new mysqli("localhost", "root", "", "lanaco");

$rolaId = 0;
if (isset($_SESSION['rolaId'])) {
  $rolaId = $_SESSION['rolaId'];
}


$result = mysqli_query($conn, "SELECT lager.LagerId, artikal.Naziv, lager.RaspolozivaKolicina, lager.Lokacija
FROM lager
JOIN artikal
ON lager.ArtikalId = artikal.ArtikalId");

if (mysqli_num_rows($result) > 0) {
  echo "<table>";
  echo "<tr>";
  echo "<th>Id lagera</th>";
  echo "<th>Naziv artikla</th>";
  echo "<th>Raspoloziva kolicina</th>";
  echo "<th>Naziv lokacije</th>";
  // ako je korisnik admin
  if ($rolaId == 1) {
    echo "<th>Izmjeni</th>";
    echo "<th>Obrisi</th>";
  }
  echo "</tr>";

  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['LagerId'] . "</td>";
    echo "<td>" . $row['Naziv'] . "</td>";
    echo "<td>" . $row['RaspolozivaKolicina'] . "</td>";
    echo "<td>" . $row['Lokacija'] . "</td>";
    // ako je korisnik admin
    if ($rolaId == 1) {
      echo "<td><button class='btnt'><a href='lager_edit.php?id=" . $row['LagerId'] . "'>Izmjeni</a></button></td>";
      echo "<td><button class='btnt'><a href='lager_delete.php?id=" . $row['LagerId'] . "'>Obrisi</a></button></td>";
    }
    echo "</tr>";
  }
  // ako je korisnik admin
  echo "</table>";

  if ($rolaId == 1) {
    echo "<br><button><a href='lager_add.php'>Dodaj novi lager</a></button>";
  }
} else {
  echo "NEMA LAGERA ZA PRIKAZ!";
  // ako je korisnik admin
  if ($rolaId == 1) {
    echo "<br><button><a href='lager_add.php'>Dodaj novi lager</a></button>";
  }
}
$conn->close();
?>
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
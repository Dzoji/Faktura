<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-pocetna.css">
  <title>Pocetna</title>
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

    $query = "SELECT * FROM artikal";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      echo "<table>";
      echo "<tr>";
      echo "<th>Artikal Id</th>";
      echo "<th>Sifra</th>";
      echo "<th>Naziv</th>";
      echo "<th>Jedinica Mjere</th>";
      echo "<th>Bar Kod</th>";
      echo "<th>Plu Kod</th>";
      // ako je korisnik admin
      if ($rolaId == 1) {
        echo "<th>Izmjeni</th>";
      }
      echo "</tr>";

      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['ArtikalId'] . "</td>";
        echo "<td>" . $row['Sifra'] . "</td>";
        echo "<td>" . $row['Naziv'] . "</td>";
        echo "<td>" . $row['JedinicaMjere'] . "</td>";
        echo "<td>" . $row['Barkod'] . "</td>";
        echo "<td>" . $row['PLU_KOD'] . "</td>";
        if ($rolaId == 1) {
          echo "<td><button class='btnt'><a href='artikli_edit.php?id=" . $row['ArtikalId'] . "'>Izmjeni</a></button></td>";
        }
        echo "</tr>";
      }

      echo "</table>";
      if ($rolaId == 1) {
        echo "<br><button><a href='artikli_add.php'>Dodaj novi artikal</a></button>";
      }
    } else {
      echo "NEMA ARTIKALA ZA PRIKAZ!";

      if ($rolaId == 1) {
        echo "<br><button><a href='artikli_add.php'>Dodaj novi artikal</a></button>";
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
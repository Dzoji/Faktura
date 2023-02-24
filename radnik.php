<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-radnik.css">
  <title>Radnik</title>
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

    $query = "SELECT * FROM radnik";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
      echo "<table>";
      echo "<tr>";
      echo "<th>Radnik Id</th>";
      echo "<th>Ime</th>";
      echo "<th>Prezime</th>";
      echo "<th>Broj Telefona</th>";
      echo "<th>Adresa</th>";
      echo "<th>Grad</th>";
      echo "<th>E-mail</th>";
      echo "<th>JMBG</th>";
      // ako je korisnik admin
      if ($rolaId == 1) {
        echo "<th>Izmjeni</th>";
        echo "<th>Obrisi</th>";
      }
      echo "</tr>";

      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['RadnikId'] . "</td>";
        echo "<td>" . $row['Ime'] . "</td>";
        echo "<td>" . $row['Prezime'] . "</td>";
        echo "<td>" . $row['BrojTelefona'] . "</td>";
        echo "<td>" . $row['Adresa'] . "</td>";
        echo "<td>" . $row['Grad'] . "</td>";
        echo "<td>" . $row['Email'] . "</td>";
        echo "<td>" . $row['JMBG'] . "</td>";

        if ($rolaId == 1) {
          echo "<td><button class='btnt'><a href='radnik_edit.php?id=" . $row['RadnikId'] . "'>Izmjeni</a></button></td>";
          echo "<td><button class='btnt'><a href='radnik_delete.php?id=" . $row['RadnikId'] . "'>Obrisi</a></button></td>";
        }
        echo "</tr>";
      }

      echo "</table>";
      if ($rolaId == 1) {
        echo "<br><button><a href='radnik_add.php'>Dodaj novog radnika</a></button>";
      }
    } else {
      echo "NEMA RADNIKA ZA PRIKAZ!";
      if ($rolaId == 1) {
        echo "<br><button><a href='radnik_add.php'>Dodaj novog radnika</a></button>";
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
</body>
</div>

</html>
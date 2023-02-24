<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-racun.css">
  <title>Racuni</title>
</head>

<body>

  <div class="tabela">
    <!-- <h1>Racuni</h1><br> -->
    <?php
    // Povezivanje na bazu podataka
    $conn = new mysqli("localhost", "root", "", "lanaco");

    // Provjera uspješnosti povezivanja
    if ($conn->connect_error) {
      die("Pogreška pri povezivanju s bazom podataka: " . $conn->connect_error);
    }

    $sql = "SELECT
    racun.RacunId,
    racun.DatumRacuna,
    racun.BrojRacuna,
    racun.UkupniIznos,
    racun.IznosPDV,
    racun.IznosBezPDV,
    radnik.Ime,
    radnik.Prezime,
    radnik.BrojTelefona,
    radnik.Adresa,
    radnik.Grad,
    radnik.Email,
    radnik.JMBG,
    GROUP_CONCAT(CONCAT(artikal.Naziv, '') SEPARATOR ', ') AS NaziviArtikala,
    GROUP_CONCAT(racunstavka.Kolicina SEPARATOR '<br>') AS Kolicine,
    GROUP_CONCAT(racunstavka.Cijena SEPARATOR '<br>') AS Cijene,
    SUM(racunstavka.Kolicina) AS UkupnaKolicina,
    SUM(racunstavka.Kolicina * racunstavka.Cijena) AS UkupnaCijena
  FROM
    racun
    INNER JOIN radnik ON racun.RadnikIdIzdao = radnik.RadnikId
    INNER JOIN racunstavka ON racun.RacunId = racunstavka.RacunId
    INNER JOIN artikal ON racunstavka.ArtikalId = artikal.ArtikalId
  GROUP BY racun.RacunId
  ORDER BY racun.RacunId DESC";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
      die('Greška prilikom izvršavanja upita: ' . mysqli_error($conn));
    }

    echo "<table id='racuni'>";
    echo "<tr><th>Racun ID</th><th>Datum kreiranja</th><th>Broj računa</th><th>Radnik koji je izdao račun</th><th>Naziv artikla</th><th>Količina</th><th>Cijena</th><th>Ukupna cijena</th></tr>";


    while ($row = mysqli_fetch_assoc($result)) {
      $naziviArtikala = explode(", ", $row["NaziviArtikala"]);
      $kolicine = explode("<br>", $row["Kolicine"]);
      $cijene = explode("<br>", $row["Cijene"]);

      echo "<tr id='racun_" . $row["RacunId"] . "' onclick='prikaziDetalje(" . $row["RacunId"] . ")'>";
      echo "<td>" . $row["RacunId"] . "</td>";
      // echo "<td>" . $row["DatumRacuna"] . "</td>";
      echo "<td>" . date('d.m.Y.', strtotime($row["DatumRacuna"])) . "</td>";
      echo "<td>" . $row["BrojRacuna"] . "</td>";
      echo "<td>" . $row["Ime"] . " " . $row["Prezime"] . "</td>";
      echo "<td>";
      foreach ($naziviArtikala as $naziv) {
        echo $naziv . "<br>";
      }
      echo "</td>";
      echo "<td>";
      foreach ($kolicine as $kolicina) {
        echo $kolicina . "<br>";
      }
      echo "</td>";
      echo "<td>";
      foreach ($cijene as $cijena) {
        echo number_format((float)$cijena, 2, '.', '') . "<br>";
      }
      echo "</td>";
      echo "<td>" . number_format(floatval($row["UkupnaCijena"]), 2, '.', '.') . "</td>";
      echo "</tr>";
    }

    echo "</table>";

    mysqli_close($conn);
    ?>

    <button><a href="racun_add.php">Dodaj racun</a></button>
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

  <script src="js/script-racun.js"></script>

</body>

</html>
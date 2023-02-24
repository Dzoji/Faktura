<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-racun_add.css">
  <title>Dodaj racun</title>
</head>

<body>


  <div class="form">
    <h1>Dodaj racun</h1><br>
    <form method="post" action="racun_add.php">
      <label for="broj_racuna">Broj računa:</label>
      <input type="text" name="broj_racuna" id="broj_racuna">

      <label for="datum_racuna">Datum računa:</label>
      <input type="date" name="datum" value="<?php echo date('Y-m-d'); ?>"><br><br>
      <!-- <input type="date" name="datum_racuna" id="datum_racuna"><br><br> -->

      <label for="radnik_id_izdao">Radnik koji je izdao račun:</label>
      <select name="radnik_id_izdao" id="radnik_id_izdao">
        <?php
        // Izvršavanje upita za dohvaćanje svih radnika
        $conn = new mysqli("localhost", "root", "", "lanaco");
        $query = "SELECT * FROM radnik";
        $result = mysqli_query($conn, $query);

        // Popunjavanje opcija u select elementu sa podacima iz baze podataka
        while ($row = mysqli_fetch_assoc($result)) {
          echo "<option value='" . $row['RadnikId'] . "'>" . $row['Ime'] . " " . $row['Prezime'] . "</option>";
        }
        mysqli_close($conn);
        ?>
      </select>
      <br><br>

      <hr>
      <br>

      <table id="stavke">
        <thead>
          <tr>
            <th>Artikal</th>
            <th>Količina</th>
            <th>Cijena</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <select name="artikal_id[]" class="artikal_id">
                <?php
                // Izvršavanje upita za dohvaćanje svih artikala iz baze
                $conn = new mysqli("localhost", "root", "", "lanaco");
                $query = "SELECT ArtikalId, Naziv FROM artikal";
                $result = mysqli_query($conn, $query);

                // Prolazak kroz sve redove dobivene iz baze i kreiranje opcija u select elementu
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="' . $row['ArtikalId'] . '">' . $row['Naziv'] . '</option>';
                }
                mysqli_close($conn);
                ?>
              </select>
            </td>
            <td><input type="number" name="kolicina[]" class="kolicina" min="0" step="0.1" required></td>
            <td><input type="number" name="cijena[]" class="cijena" min="0" step="0.1" required></td>
          </tr>
        </tbody>
      </table>

      <button type="button" id="dodaj_stavku">Dodaj stavku</button>
      <button type="reset" id="ponisti">Ponisti</button>
      <br><br>
      <hr>

      <button type="submit" id="potvrdi">Potvrdi kreiranje računa</button>
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

  <script src="js/script-racun_add.js"></script>
</body>

</html>

<?php

// Povezivanje na bazu podataka
$conn = new mysqli("localhost", "root", "", "lanaco");

// Provjera uspješnosti povezivanja
if ($conn->connect_error) {
  die("Pogreška pri povezivanju s bazom podataka: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Provjeravamo da li je korisnik kliknuo na dugme "potvrdi"
  if (isset($_POST['potvrdi'])) {
    // Dodajemo novi redak u HTML tablici sa poljima za novu stavku
    $artikli_query = "SELECT * FROM artikal";
    $artikli_result = mysqli_query($conn, $artikli_query);

    echo "<tr>";
    echo "<td><select name='artikal_id[]' class='artikal_id'>";
    while ($artikal = mysqli_fetch_assoc($artikli_result)) {
      echo "<option value='" . $artikal['Id'] . "'>" . $artikal['Naziv'] . "</option>";
    }
    echo "</select></td>";
    echo "<td><input type='number' name='kolicina[]' class='kolicina'></td>";
    echo "<td><input type='number' name='cijena[]' class='cijena'></td>";
    echo "</tr>";
  }

  // Pripremanje SQL upita za dodavanje detalja računa
  $stmt = $conn->prepare("INSERT INTO racunstavka (RacunId, ArtikalId, Kolicina, Cijena) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("iidd", $racun_id, $artikal_id, $kolicina, $cijena);

  // izračun ukupnog iznosa
  $ukupni_iznos = 0;

  // Prolazak kroz sve stavke računa poslane iz forme i izvršavanje SQL upita za dodavanje detalja računa
  for ($i = 0; $i < count($_POST["artikal_id"]); $i++) {
    $artikal_id = $_POST["artikal_id"][$i];
    $kolicina = $_POST["kolicina"][$i];
    $cijena = $_POST["cijena"][$i];

    $ukupna_cijena = $kolicina * $cijena;
    $ukupni_iznos += $ukupna_cijena;
  }

  // izračun iznosa PDV-a
  $stopa_pdv = 0.17; // 17% PDV-a
  $iznos_pdv = $ukupni_iznos * $stopa_pdv;
  // izračun iznosa bez PDV-a
  $iznos_bez_pdv = $ukupni_iznos - $iznos_pdv;

  // Pripremanje SQL upita za dodavanje računa s izračunatim vrijednostima
  $stmt = $conn->prepare("INSERT INTO racun (BrojRacuna, DatumRacuna, RadnikIdIzdao, UkupniIznos, IznosPDV, IznosBezPDV) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssiddd", $broj_racuna, $datum_racuna, $radnik_id_izdao, $ukupni_iznos, $iznos_pdv, $iznos_bez_pdv);

  // Dohvaćanje podataka poslanih iz forme
  $broj_racuna = $_POST["broj_racuna"];
  $datum_racuna = $_POST["datum_racuna"];
  $radnik_id_izdao = $_POST["radnik_id_izdao"];


  // datum u bazi nije NULL
  if (isset($_POST['datum_racuna']) && strlen($_POST['datum_racuna']) > 0) {
    $datum_racuna = $_POST['datum_racuna'];
  } else {
    // ako je vrijednost null, postaviti defaultnu vrijednost
    $datum_racuna = date('Y-m-d');
  }

  // Izvršavanje SQL upita za dodavanje računa
  if (!$stmt->execute()) {
    die("Pogreška pri dodavanju računa: " . $stmt->error);
  }

  // Dohvaćanje ID dodanog računa
  $racun_id = $stmt->insert_id;

  // Prolazak kroz sve stavke računa poslane iz forme i izvršavanje SQL upita za dodavanje detalja računa
  for ($i = 0; $i < count($_POST["artikal_id"]); $i++) {
    $artikal_id = $_POST["artikal_id"][$i];
    $kolicina = $_POST["kolicina"][$i];
    $cijena = $_POST["cijena"][$i];

    // Pripremanje SQL upita za dodavanje detalja računa
    $stmt = mysqli_stmt_init($conn);
    $query = "INSERT INTO racunstavka (RacunId, ArtikalId, Kolicina, Cijena) VALUES (?, ?, ?, ?)";
    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "iidd", $racun_id, $artikal_id, $kolicina, $cijena);

    // Izvršavanje SQL upita za dodavanje detalja računa
    if (!mysqli_stmt_execute($stmt)) {
      die("Greska pri dodavanju stavke računa: " . mysqli_stmt_error($stmt));
    } else {
      echo "Racun kreiran!";
    }

    // Zatvaranje objekta mysqli_stmt
    mysqli_stmt_close($stmt);
  }

  // Preusmjeravanje na stranicu sa pregledom svih računa
  header("Location: racun.php");
}
exit;

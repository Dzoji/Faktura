<?php
session_start();
$conn = new mysqli("localhost", "root", "", "lanaco");

// ako nije postavljen id, preusmjeriti na lager stranicu
if (!isset($_GET['id'])) {
  header("Location: lager.php");
  exit;
}

$lagerId = $_GET['id'];

$result = mysqli_query($conn, "SELECT lager.LagerId, artikal.Naziv, lager.RaspolozivaKolicina, lager.Lokacija
FROM lager
JOIN artikal
ON lager.ArtikalId = artikal.ArtikalId
WHERE lager.LagerId = '$lagerId'");

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
} else {
  header("Location: lager.php");
  exit;
}

if (isset($_POST['submit'])) {
  $artikalId = mysqli_real_escape_string($conn, $_POST['artikalId']);
  $raspolozivaKolicina = mysqli_real_escape_string($conn, $_POST['raspolozivaKolicina']);
  $lokacija = mysqli_real_escape_string($conn, $_POST['lokacija']);

  $updateQuery = "UPDATE lager
  SET ArtikalId = '$artikalId', RaspolozivaKolicina = '$raspolozivaKolicina', Lokacija = '$lokacija'
  WHERE LagerId = '$lagerId'";

  if (mysqli_query($conn, $updateQuery)) {
    header("Location: lager.php");
    exit;
  } else {
    echo "Došlo je do greške pri izmjeni!";
  }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style-lager_edit.css">
  <title>Izmjeni lager</title>
</head>

<body>
  <div class="form">
    <h1>Izmjeni lager</h1><br>
    <form action="" method="post">

      <div>
        <label for="naziv">Naziv artikla:</label><br>
        <input type="text" id="naziv" name="naziv" value="<?php echo $row['Naziv']; ?>">
      </div>
      <div>
        <label for="lokacija">Lokacija:</label><br>
        <input type="text" id="lokacija" name="lokacija" value="<?php echo $row['Lokacija']; ?>">
      </div>
      <div>
        <label for="raspolozivaKolicina">Raspoloziva kolicina:</label><br>
        <input type="text" id="raspolozivaKolicina" name="raspolozivaKolicina" value="<?php echo $row['RaspolozivaKolicina']; ?>">
      </div>
      <br>
      <div>
        <input type="hidden" name="lagerId" value="<?php echo $lagerId; ?>">
        <input type="submit" name="update" value="Izmjeni">
      </div>
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

<?php
if (isset($_POST['update'])) {
  $lagerId = $_POST['lagerId'];
  $artikalId = $_POST['artikalId'];
  $naziv = $_POST['naziv'];
  $lokacija = $_POST['lokacija'];
  $raspolozivaKolicina = $_POST['raspolozivaKolicina'];

  $conn = new mysqli("localhost", "root", "", "lanaco");

  $sql = "UPDATE lager SET RaspolozivaKolicina='$raspolozivaKolicina', Lokacija='$lokacija' WHERE LagerId='$lagerId'";
  if (mysqli_query($conn, $sql)) {
    header("Location: lager.php");
  } else {
    echo "Greška prilikom izmjene: " . mysqli_error($conn);
  }
  $conn->close();
}
?>
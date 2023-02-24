<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "lanaco");

if (!isset($_GET['id'])) {
  header("Location: pocetna.php");
  exit;
}

$artikalId = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM artikal WHERE ArtikalId = $artikalId");

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
} else {
  header("Location: pocetna.php");
  exit;
}

if (isset($_POST['submit'])) {
  $artikalId = mysqli_real_escape_string($conn, $_POST['artikalId']);
  $sifra = mysqli_real_escape_string($conn, $_POST['sifra']);
  $naziv = mysqli_real_escape_string($conn, $_POST['naziv']);
  $jedinicaMjere = mysqli_real_escape_string($conn, $_POST['jedinicaMjere']);
  $barKod = mysqli_real_escape_string($conn, $_POST['barKod']);
  $pluKod = mysqli_real_escape_string($conn, $_POST['pluKod']);

  $updateQuery = "UPDATE artikal SET Sifra = '$sifra', Naziv = '$naziv', JedinicaMjere = '$jedinicaMjere', Barkod = '$barKod', PLU_KOD = '$pluKod' WHERE ArtikalId = '$artikalId'";

  if (mysqli_query($conn, $updateQuery)) {
    header("Location: pocetna.php");
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
  <link rel="stylesheet" href="css/style-artikli_edit.css">
  <title>Izmjeni artikal</title>
</head>

<body>

  <div class="form">
    <h1>Izmjeni artikal</h1><br>

    <form action="" method="post">

      <div>
        <label for="sifra">Sifra artikla:</label><br>
        <input type="text" id="sifra" name="sifra" value="<?php echo $row['Sifra']; ?>" required><br>
      </div>

      <div>
        <label for="naziv">Naziv artikla:</label><br>
        <input type="text" id="naziv" name="naziv" value="<?php echo $row['Naziv']; ?>" required><br>
      </div>

      <div>
        <label for="jedinicaMjere">Jedinica mjere:</label><br>
        <input type="text" id="jedinicaMjere" name="jedinicaMjere" value="<?php echo $row['JedinicaMjere']; ?>"><br>
      </div>

      <div>
        <label for="barKod">Barkod:</label><br>
        <input type="text" id="barKod" name="barKod" value="<?php echo $row['Barkod']; ?>" required><br>
      </div>

      <div>
        <input type="hidden" id="artikalId" name="artikalId" value="<?php echo $artikalId; ?>">
        <label for="pluKod">PLU_KOD:</label><br>
        <input type="text" id="pluKod" name="pluKod" value="<?php echo $row['PLU_KOD']; ?>" required><br><br>
      </div>

      <input type="submit" name="update" value="Izmjeni artikal">
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
  $artikalId = $_POST['artikalId'];
  $sifra = $_POST['sifra'];
  $naziv = $_POST['naziv'];
  $jedinicaMjere = $_POST['jedinicaMjere'];
  $barKod = $_POST['barKod'];
  $pluKod = $_POST['pluKod'];

  $conn = new mysqli("localhost", "root", "", "lanaco");

  $sql = "UPDATE artikal SET Sifra ='$sifra', Naziv ='$naziv',JedinicaMjere ='$jedinicaMjere', Barkod ='$barKod', PLU_KOD ='$pluKod'   WHERE ArtikalId ='$artikalId'";
  if (mysqli_query($conn, $sql)) {
    header("Location: pocetna.php");
  } else {
    echo "Greška prilikom izmjene: " . mysqli_error($conn);
  }
  $conn->close();
}
?>
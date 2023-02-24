<?php
session_start();
$conn = new mysqli("localhost", "root", "", "lanaco");

// ako nije postavljen id, preusmjeriti na radnik stranicu
if (!isset($_GET['id'])) {
  header("Location: radnik.php");
  exit;
}

$radnikId = $_GET['id'];

$result = mysqli_query($conn, "SELECT * FROM radnik WHERE RadnikId = '$radnikId'");

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
} else {
  header("Location: radnik.php");
  exit;
}

if (isset($_POST['submit'])) {
  $radnikId = mysqli_real_escape_string($conn, $_POST['radnikId']);
  $ime = mysqli_real_escape_string($conn, $_POST['ime']);
  $prezime = mysqli_real_escape_string($conn, $_POST['prezime']);
  $brojTelefona = mysqli_real_escape_string($conn, $_POST['brojTelefona']);
  $adresa = mysqli_real_escape_string($conn, $_POST['adresa']);
  $grad = mysqli_real_escape_string($conn, $_POST['grad']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $jmbg = mysqli_real_escape_string($conn, $_POST['jmbg']);

  $updateQuery = "UPDATE radnik
  SET RadnikId = '$radnikId', Ime = '$ime', Prezime = '$prezime', BrojTelefona = '$brojTelefona', Adresa = '$adresa', Grad = '$grad', Email = '$email', JMBG = '$jmbg' WHERE RadnikId = '$radnikId'";

  if (mysqli_query($conn, $updateQuery)) {
    header("Location: radnik.php");
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
  <link rel="stylesheet" href="css/style-radnik_edit.css">
  <title>Izmjeni radnika</title>
</head>

<body>
  <div class="form">
    <h1>Izmjeni radnika</h1><br>
    <form action="" method="post">

      <div>
        <label for="ime">Ime:</label><br>
        <input type="text" id="ime" name="ime" value="<?php echo $row['Ime']; ?>">
      </div>
      <div>
        <label for="prezime">Prezime:</label><br>
        <input type="text" id="prezime" name="prezime" value="<?php echo $row['Prezime']; ?>">
      </div>
      <div>
        <label for="brojTelefona">Broj telefona:</label><br>
        <input type="number" id="brojTelefona" name="brojTelefona" value="<?php echo $row['BrojTelefona']; ?>">
      </div>

      <div>
        <label for="adresa">Adresa:</label><br>
        <input type="text" id="adresa" name="adresa" value="<?php echo $row['Adresa']; ?>">
      </div>
      <div>
        <label for="grad">Grad:</label><br>
        <input type="text" id="grad" name="grad" value="<?php echo $row['Grad']; ?>">
      </div>
      <div>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $row['Email']; ?>">
      </div>
      <div>
        <label for="jmbg">JMBG:</label><br>
        <input type="text" id="jmbg" name="jmbg" value="<?php echo $row['JMBG']; ?>">
      </div>
      <br>
      <div>
        <input type="hidden" name="radnikId" value="<?php echo $radnikId; ?>">
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
  $radnikId = $_POST['radnikId'];
  $ime = $_POST['ime'];
  $prezime = $_POST['prezime'];
  $brojTelefona = $_POST['brojTelefona'];
  $adresa = $_POST['adresa'];
  $grad = $_POST['grad'];
  $email = $_POST['email'];
  $jmbg = $_POST['jmbg'];

  $conn = new mysqli("localhost", "root", "", "lanaco");

  $sql = "UPDATE radnik SET Ime = '$ime', Prezime = '$prezime', BrojTelefona = '$brojTelefona', Adresa = '$adresa', Grad = '$grad', Email = '$email', JMBG = '$jmbg' WHERE RadnikId='$radnikId'";

  if (mysqli_query($conn, $sql)) {
    header("Location: radnik.php");
  } else {
    echo "Greška prilikom izmjene: " . mysqli_error($conn);
  }
  $conn->close();
}
?>
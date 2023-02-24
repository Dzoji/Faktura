<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style-login.css">
    <title>Login</title>
</head>

<body>
    <h1>Prijavite se</h1>
    <form action="login.php" method="post">
        <div>
            <input name="korisnickoIme" type="text" placeholder="Unesite korisnicko ime..." required>
        </div>
        <br>
        <div>
            <input name="sifra" type="password" placeholder="Unesite sifru..." required>
        </div>
        <br>
        <div>
            <input type="submit" value="Prijavite se">
        </div>
        <p>Nemate nalog? <a href="registracija.php">Registrujte se</a></p>
    </form>

    <?php
    session_start();

    $conn = new mysqli("localhost", "root", "", "lanaco");

    if (isset($_POST['korisnickoIme']) && isset($_POST['sifra'])) {
        $korisnickoIme = htmlspecialchars(strip_tags(trim($_POST['korisnickoIme'])));
        $sifra = htmlspecialchars(strip_tags(trim($_POST['sifra'])));

        $korisnickoIme = mysqli_real_escape_string($conn, $korisnickoIme);

        $query = "SELECT * FROM korisnik WHERE KorisnickoIme='$korisnickoIme'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hash = $row['Sifra'];

            if (password_verify($sifra, $hash)) {
                $_SESSION['rolaId'] = $row['RolaId'];
                setcookie("KorisnickoIme", $korisnickoIme, time() + (86400 * 30), "/");
                header("Location: pocetna.php");
            } else {
                echo "<h2>Neispravno Korisnicko ime ili sifra</h2><h3><a href='promjena_sifre.php'>Zaboravili ste sifru?</a></h3>";
            }
        } else {
            echo "<h2>Neispravno Korisnicko ime ili sifra</h2><h3><a href='promjena_sifre.php'>Zaboravili ste sifru?</a></h3>";
        }
        $conn->close();
    }
    ?>
</body>

</html>
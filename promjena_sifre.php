<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style-promjena_sifre.css">
    <title>Promjena šifre</title>
</head>

<body>
    <h1>Promjena šifre</h1><br>
    <form action="promjena_sifre.php" method="post">
        <label for="korisnickoIme">Korisničko ime:</label>
        <input type="text" id="korisnickoIme" name="korisnickoIme" required><br>

        <label for="novaSifra">Nova šifra:</label>
        <input type="password" id="novaSifra" name="novaSifra" required><br>

        <input type="submit" value="Promijeni šifru" name="promjena">
    </form>

    <?php

    session_start();
    if (isset($_POST['promjena'])) {
        $conn = new mysqli("localhost", "root", "", "lanaco");

        $korisnickoIme = htmlspecialchars($_POST['korisnickoIme']);
        $novaSifra = htmlspecialchars($_POST['novaSifra']);

        if (empty($korisnickoIme) || empty($novaSifra)) {
            echo "<h2>Molimo Vas da unesete sva polja.</h2>";
        } else {
            $novaSifra = password_hash($novaSifra, PASSWORD_DEFAULT);

            $query = "UPDATE korisnik SET Sifra='$novaSifra' WHERE KorisnickoIme='$korisnickoIme'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<h2>Uspješno ste promijenili šifru.</h2><h3><a href='login.php'>Prijavite se</a></h3>";
            } else {
                echo "<h2>Došlo je do greške pri promjeni šifre.</h2>";
            }
        }

        $conn->close();
    }
    ?>
</body>

</html>
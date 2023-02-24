<?php
session_start();

if (isset($_POST['korisnickoIme']) && isset($_POST['sifra'])) {
    $korisnickoIme = htmlspecialchars(strip_tags(trim($_POST['korisnickoIme'])));
    $sifra = htmlspecialchars(strip_tags(trim($_POST['sifra'])));

    if (empty($korisnickoIme) || empty($sifra)) {
        $_SESSION['error'] = "Korisničko ime i šifra su obavezna polja.";
        header("Location: registracija.php");
        exit();
    }

    $conn = new mysqli("localhost", "root", "", "lanaco");

    if ($conn->connect_error) {
        $_SESSION['error'] = "Greška prilikom spajanja na bazu podataka.";
        header("Location: registracija.php");
        exit();
    }

    $sql_query = "
    SELECT 
        `KorisnickoIme`, 
        `Sifra` 
    FROM `korisnik`
    WHERE `KorisnickoIme` = '$korisnickoIme'
            OR `Sifra` = '$sifra'";

    $response = $conn->query($sql_query);

    if ($response->num_rows > 0) {
        $_SESSION['error'] = "Korisničko ime ili šifra su već u upotrebi.";
        header("Location: registracija.php");
        exit();
    } else {
        $sifra = password_hash($sifra, PASSWORD_BCRYPT);
        $sql_query = "
        INSERT INTO `korisnik`
            (`KorisnickoIme`,
            `Sifra`)
        VALUES
            ('$korisnickoIme', 
            '$sifra')";

        if ($conn->query($sql_query) === TRUE) {
            setcookie('korisnickoIme', $korisnickoIme, time() + 3600);
            header("Location: pocetna.php");
            exit();
        } else {
            $_SESSION['error'] = "Greška prilikom registracije.";
            header("Location: registracija.php");
            exit();
        }
    }
}

if (isset($conn)) {
    $conn->close();
}

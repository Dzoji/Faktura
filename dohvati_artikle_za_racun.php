<?php
// Uspostavi vezu s bazom podataka
$conn = new mysqli("localhost", "root", "", "lanaco");

// Provjeri je li uspješna veza s bazom podataka
if (!$conn) {
  die("Greška prilikom spajanja na bazu podataka: " . mysqli_connect_error());
}

// Dohvati sve artikle iz baze podataka
$query = "SELECT ArtikalId, Naziv FROM artikal";
$result = mysqli_query($conn, $query);

// Spremi sve artikle u niz
$artikli = array();
while ($row = mysqli_fetch_assoc($result)) {
  $artikli[] = $row;
}

// Zatvori vezu s bazom podataka
mysqli_close($conn);

// Vrati sve artikle kao JSON odgovor
header("Content-Type: application/json");
echo json_encode($artikli);

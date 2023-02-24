<?php
session_start();

// Briše sve postojeće sesije
session_unset();

// Uništava sesiju
session_destroy();

setcookie("korisnicko_ime", NULL, time() - (86400 * 30), "/");
// Preusmjerava na login stranicu
header("Location: index.php");
exit;
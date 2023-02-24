<?php
session_start();
$conn = new mysqli("localhost", "root", "", "lanaco");

$radnikId = $_GET['id'];

$sql = "DELETE FROM radnik WHERE RadnikId = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $radnikId);
$stmt->execute();

header("Location: radnik.php");
$conn->close();
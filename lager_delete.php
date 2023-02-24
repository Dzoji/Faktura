<?php
session_start();
$conn = new mysqli("localhost", "root", "", "lanaco");

$lagerId = $_GET['id'];

$sql = "DELETE FROM lager WHERE LagerId = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $lagerId);
$stmt->execute();

header("Location: lager.php");
$conn->close();

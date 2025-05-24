<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
  header("location: ./index.php");
}

require_once "./db.php";

$kode = $_GET['kode'];

$stmt = $conn->prepare("DELETE FROM barang WHERE kode=?");
$stmt->bind_param("s", $kode);
$stmt->execute();

header("location: ./index.php");

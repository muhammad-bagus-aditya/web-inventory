<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
  header("location: ./insert.php");
}

require_once "./db.php";

$kode = $_POST['kode'];
$nama = $_POST['nama'];
$stok = $_POST['stok'];
$harga = $_POST['harga'];
$kategori = $_POST['kategori'];

$stmt = $conn->prepare("INSERT INTO barang (kode, nama, stok, harga, kategori) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssiis", $kode, $nama, $stok, $harga, $kategori);
$stmt->execute();

header("location: ./index.php");

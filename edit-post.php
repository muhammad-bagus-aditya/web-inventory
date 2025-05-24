<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
  header("location: ./edit.php?kode=" . $_POST['kode']);
}

require_once "./db.php";

$kode = $_POST['kode'];
$nama = $_POST['nama'];
$stok = $_POST['stok'];
$harga = $_POST['harga'];
$kategori = $_POST['kategori'];

$stmt = $conn->prepare("UPDATE barang SET kode=?, nama=?, stok=?, harga=?, kategori=? WHERE kode=?");
$stmt->bind_param("ssiiss", $kode, $nama, $stok, $harga, $kategori, $kode);
$stmt->execute();

header("location: ./index.php");

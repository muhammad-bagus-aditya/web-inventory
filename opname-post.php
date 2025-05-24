<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
  header("location: ./edit.php?kode=" . $_POST['kode']);
}

require_once "./db.php";

$kode = $_POST['kode'];
$stok = $_POST['stok'];

$kategori = $_POST['kategori'];
$jumlah = $_POST['jumlah'];
$tanggal = $_POST['tanggal'];


if ($kategori == "in") {
  $stok += $jumlah;
} else if ($kategori == "out") {
  $stok -= $jumlah;
} else {
  header("location: ./opname.php?kode=" . $kode);
}

if ($stok <= 0) {
  header('location: ./opname.php?kode=' . $kode);
}

$stmt = $conn->prepare("INSERT INTO transaksi (kategori, jumlah, tanggal, kode_barang) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siss", $kategori, $jumlah, $tanggal, $kode);
$stmt->execute();

$stmt = $conn->prepare("UPDATE barang SET kode=?, stok=? WHERE kode=?");
$stmt->bind_param("sis", $kode, $stok, $kode);
$stmt->execute();

header("location: ./index.php");

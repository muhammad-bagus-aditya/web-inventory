<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
  header("location: ./login.php");
}

require_once "./db.php";

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM admin WHERE email=? AND password=?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if ($user === null) {
  header("location: ./login.php");
}

$_SESSION['user'] = $user;

header("location: ./index.php");

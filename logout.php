<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
  header("location: ./index.php");
}

unset($_SESSION['user']);

header("location: ./login.php");

<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password, "chicks_challenge");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


$categories = array("Clash of Clans","Fortnite","League Of Legends","Runescape");
$status = array("0","1");
$paymethods = array("Paypal","Credit Card","Binance");
?>
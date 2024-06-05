<?php
$servername = "localhost";
$username = "u341021167_kelasc123";
$password = "Kelasc_123";
$dbname = "u341021167_kelasc";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);
 
// Memeriksa koneksi
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
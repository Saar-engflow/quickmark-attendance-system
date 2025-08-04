<?php 
  
  $host = "localhost";
  $dbname = "quickmark_db";
  $username = "root";
  $password = "";

  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
  } catch(PDOException $e) {
      die("Database connection failed: " . $e->getMessage());
  }
?>
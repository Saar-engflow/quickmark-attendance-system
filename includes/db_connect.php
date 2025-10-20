<?php 
  


$host = "localhost";
$user = "root";
$pass = "";
$db = "quickmark_db";

// Create connection
$conn = new mysqli($host, $user, $pass, $db);
if ($conn ->connect_error){
  die("connection failed:" . $conn->connect_error);
}

?>
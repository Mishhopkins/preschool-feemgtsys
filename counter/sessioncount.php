<?php
  $servername="localhost";
  $uname="root";
  $pass="";
  $database="schoolfeesys";

  $conn=mysqli_connect($servername,$uname,$pass,$database);

if(!$conn){
  die("Connection Failed");
}

$sql = "SELECT COUNT(*) as total FROM sessions";
$result = $conn->query($sql);
$count = $result->fetch_assoc()['total'];

echo $count;
?>

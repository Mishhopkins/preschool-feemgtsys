<?php

    $servername="localhost";
    $uname="root";
    $pass="";
    $database="schoolfeesys";

    $conn=mysqli_connect($servername,$uname,$pass,$database);

if(!$conn){
    die("Connection Failed");
}

    $sql = "SELECT * FROM classes";
    $query = $conn->query($sql);
    echo "$query->num_rows";
?>
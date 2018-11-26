<?php
require_once "credentials.php";

$conn = mysqli_connect($servername,$username,"",$dbname);

// Check connection
if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE TABLE $table (
  message VARCHAR (100) NOT NULL,
  user VARCHAR (100) NOT NULL,
  dado BIT,
  roomID INTEGER
)";

if (mysqli_query($conn, $sql)) {
    echo "Table messages created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

$sql1 = "CREATE TABLE $table1(
  roomID INT AUTO_INCREMENT PRIMARY KEY,
  roomName VARCHAR (20) NOT NULL,
  roomPassword VARCHAR (40) NOT NULL,
    UNIQUE (roomName)
)";

if (mysqli_query($conn, $sql1)) {
    echo "Table rooms created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

mysqli_close($conn);


 ?>

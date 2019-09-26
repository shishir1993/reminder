<?php
$host = "localhost";
$userName = "root";
$password = "";
$dbName = "reminder";
// Create database connection
$conn = new mysqli($host, $userName, $password, $dbName);
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$todo = $conn->real_escape_string($_POST['todo']);
$place = $conn->real_escape_string($_POST['place']);
$city = $conn->real_escape_string($_POST['city']);
$month = $conn->real_escape_string($_POST['month']);
$time = $conn->real_escape_string($_POST['time']);
$sql="INSERT INTO todo_list (todo, place, city, month,time) VALUES ('".$todo."','".$place."', '".$city."', '".$month."', '".$time."')";
if(!$result = $conn->query($sql)){
die('There was an error running the query [' . $conn->error . ']');
}
else
{
echo "Thank you!";
}






?>
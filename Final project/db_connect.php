<?php
//Database Connections

$serverName = "localhost";
$dbName = "monsterInformation";

//Asks for validation of user information
$userName = readline("Username: ");
$password = readline("Password: ");


//Create The Connection
$conn = new mysqli($serverName, $userName, $password, $dbName);
if ($conn->connect_error) {
    //Ends the program right away
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

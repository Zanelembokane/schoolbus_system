<?php

function connectToDatabase() {
    $dsn = 'mysql:host=localhost;dbname=bus_system';   
    $username = 'root';
    $password = '';

    try {
        $conn  = new PDO($dsn, $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        return $conn;
    } catch (PDOException $e) {
        throw new Exception("Connection failed: " . $e->getMessage());
    }
}

// Establish the database connection
$conn = connectToDatabase();    

?>
<?php
    if (session_status() === PHP_SESSION_NONE) 
        {
        session_start();
        }

    // connecting database
    $host = "localhost";
    $dbname = "task4_db";
    $dbUser = "root";
    $dbPass = "";

    
    $conn = new mysqli($host, $dbUser, $dbPass, $dbname);
    if ($conn->connect_error) 
        {
        die("Connection failed: " . $conn->connect_error);
        } 

    //for login && register transactions
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
    catch (PDOException $e) 
       {
        die("Connection failed: " . $e->getMessage());
       }
?>  
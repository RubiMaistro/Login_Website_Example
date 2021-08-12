<?php

    try{
        $pdo = new PDO("mysql:host=localhost;", "root", "");

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Attempt create database query execution
        $sql = "CREATE DATABASE demo";
        $pdo->exec($sql);
        //echo "Database created successfully.<br />";

    } catch(PDOException $e){
        die("ERROR: Could not create database. " . $e->getMessage() ."<br />");
    }

?>
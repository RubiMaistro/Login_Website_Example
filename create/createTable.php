<?php

    try{
        $pdo = new PDO("mysql:host=localhost;dbname=demo", "root", "");

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Attempt create table query execution
        $query_create_db = "CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(50) NOT NULL,
            `password` varchar(255) NOT NULL,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `username` (`username`)
        )";

        $pdo->exec($query_create_db);
        //echo "Table created successfully.<br />";

    } catch(PDOException $e){
        die("ERROR: Could not able to execute $sql. " . $e->getMessage() ."<br />");
    }
?>
<?php

    try{
        // Attempt create database query execution
        $sql = "CREATE DATABASE demo";
        $pdo->exec($sql);
        echo "Database created successfully";

        // Attempt create table query execution
        $query_create_db->prepare(
            "CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(50) NOT NULL,
            `password` varchar(255) NOT NULL,
            `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE KEY `username` (`username`)"
        );
        $pdo->exec($query_create_db);
        echo "Table created successfully.";

    } catch(PDOException $e){
        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
    }

    // Close connection
    unset($pdo);

?>
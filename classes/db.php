<?php

/**
 * Database connection script.
 * This script establishes a connection to the MySQL database using PDO.
 */

    // Set the database connection parameters
    $host = 'localhost';
    $db   = 'task_test';
    $user = 'constellation';
    $pass = 'newPassword';
    $charset = 'utf8mb4';

    // Data Source Name (DSN)
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    // Create a PDO instance
    // Use try-catch to handle connection errors
    try {
        // Create a new PDO instance with the specified DSN and credentials
        // Set options for error handling, fetch mode, and prepared statements
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false, 
        ]);
    } catch (PDOException $e) {
        // If the connection fails, catch the exception and display an error message
        error_log("Database connection failed: " . $e->getMessage());
    }
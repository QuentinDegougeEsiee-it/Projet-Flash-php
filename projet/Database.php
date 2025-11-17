<?php

function connectToDBandGetPDOdb(){
    // Corrected PDO connection string (using 'host=' and removing extra semicolon before 'dbname')
    // Assumes the database is named 'projet' and is running on the default MySQL port.
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=site_info", "root", "");
        // Optional: Set PDO attributes for better error handling (recommended)
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // In a real application, you'd log the error instead of displaying it
        die("Database connection failed: " . $e->getMessage());
    }
}

?>
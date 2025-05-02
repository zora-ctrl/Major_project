<?php
// Database credentials
$host = 'localhost';      // Hostname (usually 'localhost' if running locally)
$db   = 'av';    // Database name
$user = 'root';            // Database username (e.g., 'root' for local development)
$pass = '';                // Database password (empty for local development, or your set password)
$charset = 'utf8mb4';      // Character set

// Data Source Name (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Handle errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch associative arrays by default
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Turn off emulation mode for prepared statements
];

// Try to establish a connection to the database
try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // If the connection fails, show an error message
    die('Database connection failed: ' . $e->getMessage());
}
?>

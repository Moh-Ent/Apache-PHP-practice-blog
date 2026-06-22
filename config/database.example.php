<?php
// Copy this file to database.php and fill in your credentials
define('DB_HOST', 'localhost');
define('DB_NAME', 'myapp');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');

function getDB() {
    static $pdo = null;

    if ($pdo === null) {
        try {
            $pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            );
        } catch (PDOException $e) {
            die("Database connection failed.");
        }
    }

    return $pdo;
}

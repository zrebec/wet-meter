<?php
// Connect to SQLite database
function getDbConnection() {
    $dbFile = '/var/www/data/database.sqlite';
    try {
        $pdo = new PDO('sqlite:' . $dbFile);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }
}

// Initalization of the database (creating tables if they do not exist)
function initDatabase() {
    $pdo = getDbConnection();

    $pdo->exec('DROP TABLE IF EXISTS products');
    $pdo->exec('DROP TABLE IF EXISTS records');
    
    // Tabuľka pre produkty
    $pdo->exec('CREATE TABLE IF NOT EXISTS products (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        description TEXT,
        base_weight REAL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )');
    
    // Table for records of usage
    $pdo->exec('CREATE TABLE IF NOT EXISTS records (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        product_id INTEGER,
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        layer_type INTEGER, 
        capacity_level INTEGER,
        weight REAL,
        notes TEXT,
        FOREIGN KEY (product_id) REFERENCES products(id)
    )');
}

// Database initialization
initDatabase();
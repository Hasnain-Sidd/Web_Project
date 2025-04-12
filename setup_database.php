


<?php
// Database connection parameters
// This script is necessary to run as the tables used in this project are not present in the database and this script creates them
$servername = "localhost";
$username = "root";
$password = ""; // Change this back to Has1234# (as that is your default XAMPP MySQL password)

// Create connection without database
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS lost_found_db";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db("lost_found_db");

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    banned TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Users table created successfully<br>";
} else {
    echo "Error creating users table: " . $conn->error . "<br>";
}

// Create lost_items table
$sql = "CREATE TABLE IF NOT EXISTS lost_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    date_lost DATE NOT NULL,
    location VARCHAR(255),
    image VARCHAR(255),
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Lost items table created successfully<br>";
} else {
    echo "Error creating lost items table: " . $conn->error . "<br>";
}

// Create found_items table
$sql = "CREATE TABLE IF NOT EXISTS found_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    date_found DATE NOT NULL,
    location VARCHAR(255),
    image VARCHAR(255),
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)";

if ($conn->query($sql) === TRUE) {
    echo "Found items table created successfully<br>";
} else {
    echo "Error creating found items table: " . $conn->error . "<br>";
}

// Create admin user
$admin_username = "hasnain";
$admin_email = "hasnainhissam56@gmail.com";
$admin_password = password_hash("Has1234#", PASSWORD_DEFAULT);
$admin_fullname = "Hasnain";

// Check if admin user already exists
$check_sql = "SELECT id FROM users WHERE email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $admin_email);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows == 0) {
    // Insert admin user
    $insert_sql = "INSERT INTO users (username, email, password, full_name, is_admin) VALUES (?, ?, ?, ?, 1)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("ssss", $admin_username, $admin_email, $admin_password, $admin_fullname);
    
    if ($insert_stmt->execute()) {
        echo "Admin user created successfully<br>";
    } else {
        echo "Error creating admin user: " . $insert_stmt->error . "<br>";
    }
    $insert_stmt->close();
} else {
    // Update admin user
    $update_sql = "UPDATE users SET is_admin = 1 WHERE email = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("s", $admin_email);
    
    if ($update_stmt->execute()) {
        echo "Admin user updated successfully<br>";
    } else {
        echo "Error updating admin user: " . $update_stmt->error . "<br>";
    }
    $update_stmt->close();
}

$check_stmt->close();
$conn->close();

echo "<br>Database setup completed. You can now <a href='login.php'>login</a> with:<br>";
echo "Email: hasnainhissam56@gmail.com<br>";
echo "Password: Has1234#";
?>
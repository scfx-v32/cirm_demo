<?php
require_once "config.php";

// Define new admin user
$username = "admin";
$password = "admin123"; // You can change this
$role = "admin";

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert admin
$stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
try {
    $stmt->execute([$username, $hashed_password, $role]);
    echo "✅ Admin user created successfully.";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
<?php
require_once "config.php";

// Define new admin user
$nom = "Z";
$prenom = "XY";
$username = "scfxv32";
$password = "Ihe@rtjapan1"; // You can change this
$role = "admin";

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert admin
$stmt = $pdo->prepare("INSERT INTO users (nom, prenom, username, password, role) VALUES (?, ?, ?, ?, ?)");
try {
    $stmt->execute([$nom, $prenom, $username, $hashed_password, $role]);
    echo "✅ Admin user created successfully.";
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
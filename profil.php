<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["user_id"];

$stmt = $pdo->prepare("SELECT username, role FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mon Profil | CiRM</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
    <?php include "nav.php"; ?>
    <?php include "sidebar.php"; ?>

    <main class="p-6 max-w-xl mx-auto bg-white shadow rounded mt-10">
        <h2 class="text-2xl font-bold mb-4">Mon Profil</h2>

        <div class="space-y-3">
            <p><strong>Nom d'utilisateur :</strong> <?= htmlspecialchars($user["username"]) ?></p>
            <p><strong>Rôle :</strong> <?= htmlspecialchars($user["role"]) ?></p>
        </div>

        <!-- Future: Ajouter un bouton "Modifier le mot de passe" ici -->
    </main>
    

</body>
<script>
        $(function() {
            $("#toggleSidebar").on("click", function() {
                $("#sidebar").toggleClass("-translate-x-full");
                
            });
        });
    </script>

</html>
<?php
session_start();
require_once "config.php";
include_once "nav.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$id = $_SESSION["user_id"];

// Fetch full user info with entité name
$stmt = $pdo->prepare("SELECT u.nom, u.prenom, u.username, u.role, e.nom AS entite_nom
                       FROM users u
                       LEFT JOIN entites e ON u.entite_id = e.id
                       WHERE u.id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Password change logic
$success = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current = $_POST["current_password"];
    $new = $_POST["new_password"];
    $confirm = $_POST["confirm_password"];

    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    if (!password_verify($current, $data["password"])) {
        $error = "Mot de passe actuel incorrect.";
    } elseif ($new !== $confirm) {
        $error = "Les nouveaux mots de passe ne correspondent pas.";
    } else {
        $newHashed = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$newHashed, $id]);
        $success = "Mot de passe mis à jour avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Mon Profil | CiRM</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
    <?php include "sidebar.php"; ?>

    <main id="mainContent" class="p-6 max-w-6xl mx-auto mt-10">
        <h2 class="text-3xl font-bold mb-6 text-center">Mon Profil</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 bg-white shadow rounded p-6">
            <!-- Profile Info -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Informations personnelles</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold">Nom</label>
                        <input type="text" value="<?= htmlspecialchars($user["nom"]) ?>" disabled class="w-full px-3 py-2 border rounded bg-gray-100">
                    </div>
                    <div>
                        <label class="block font-semibold">Prénom</label>
                        <input type="text" value="<?= htmlspecialchars($user["prenom"]) ?>" disabled class="w-full px-3 py-2 border rounded bg-gray-100">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block font-semibold">Nom d'utilisateur</label>
                    <input type="text" value="<?= htmlspecialchars($user["username"]) ?>" disabled class="w-full px-3 py-2 border rounded bg-gray-100">
                </div>
                <div class="mt-4">
                    <label class="block font-semibold">Rôle</label>
                    <input type="text" value="<?= htmlspecialchars($user["role"]) ?>" disabled class="w-full px-3 py-2 border rounded bg-gray-100">
                </div>
                <div class="mt-4">
                    <label class="block font-semibold">Entité</label>
                    <input type="text" value="<?= $user["entite_nom"] ? htmlspecialchars($user["entite_nom"]) : '-' ?>" disabled class="w-full px-3 py-2 border rounded bg-gray-100">
                </div>
            </div>

            <!-- Vertical divider -->

            <!-- Change Password -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Changer le mot de passe</h3>

                <?php if ($error): ?>
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4"><?= $error ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4"><?= $success ?></div>
                <?php endif; ?>

                <form method="POST" class="space-y-4">
                    <div>
                        <label class="block font-semibold">Mot de passe actuel</label>
                        <input type="password" name="current_password" required class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block font-semibold">Nouveau mot de passe</label>
                        <input type="password" name="new_password" required class="w-full px-3 py-2 border rounded">
                    </div>
                    <div>
                        <label class="block font-semibold">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="confirm_password" required class="w-full px-3 py-2 border rounded">
                    </div>

                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    </main>


    <?php include "footer.php"; ?>
</body>

</html>
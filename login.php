<?php
session_start();
require_once "config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $username;
        $_SESSION["role"] = $user["role"];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion | CiRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col justify-between">
    <main class="flex-grow flex flex-col items-center justify-center">
        <br><br>
        <img src="/images/logo.png" alt="Casablanca" class="mb-6 h-20 w-auto">
        <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
            <h2 class="text-2xl font-bold mb-6 text-center">Connexion à CiRM</h2>
            <?php if ($error): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700">Nom d'utilisateur</label>
                    <input type="text" name="username" required class="w-full px-3 py-2 border rounded shadow focus:outline-none focus:ring focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700">Mot de passe</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border rounded shadow focus:outline-none focus:ring focus:border-blue-500">
                </div>
                <div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Se connecter</button>
                </div>
            </form>
        </div>
    </main>

    <?php include "footer.php"; ?>


</body>

</html>
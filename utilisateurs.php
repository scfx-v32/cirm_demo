<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: dashboard.php");
    exit();
}

// Handle user deletion
if (isset($_GET["delete"])) {
    $user_id = intval($_GET["delete"]);
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    header("Location: utilisateurs.php");
    exit();
}

include_once "nav.php";

// Filters
$search = $_GET['search'] ?? '';
$filter_entite = $_GET['entite'] ?? '';
$filter_type = $_GET['type'] ?? '';

$where = [];
$params = [];

// Search logic
if (!empty($search)) {
    $where[] = "(u.nom LIKE ? OR u.prenom LIKE ? OR u.username LIKE ? OR u.role LIKE ?)";
    array_push($params, "%$search%", "%$search%", "%$search%", "%$search%");
}

// Entité filter
if (!empty($filter_entite)) {
    $where[] = "u.entite_id = ?";
    $params[] = $filter_entite;
}

// Type de réclamation filter
if (!empty($filter_type)) {
    $where[] = "u.type_id = ?";
    $params[] = $filter_type;
}

// Fetch users with filters
$sql = "SELECT u.id, u.nom, u.prenom, u.username, u.role, e.nom AS entite, u.created_at, tr.libelle AS type_libelle
        FROM users u
        LEFT JOIN entites e ON u.entite_id = e.id
        LEFT JOIN types_reclamation tr ON u.type_id = tr.id";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY u.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch entités for user creation
$entites = $pdo->query("SELECT id, nom FROM entites")->fetchAll(PDO::FETCH_ASSOC);
// Fetch types reclamation for user creation
$types = $pdo->query("SELECT id, entite_id, libelle FROM types_reclamation")->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Utilisateurs | CiRM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-50 min-h-screen flex">
    <?php include "sidebar.php"; ?>

    <div id="mainContent" class="flex-1 p-6 space-y-6 transition-all duration-300">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">Utilisateurs</h1>
            <a href="ajouter_utilisateur.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                ➕ Ajouter un utilisateur
            </a>
        </div>

        <!-- Filters -->
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white p-4 rounded shadow mb-6">
            <input type="text" name="search" placeholder="🔍 Rechercher par nom, prénom, rôle ou username"
                value="<?= htmlspecialchars($search) ?>" class="px-3 py-2 border rounded w-full">

            <select name="entite" class="px-3 py-2 border rounded w-full">
                <option value="">🏢 Entité</option>
                <?php foreach ($entites as $e): ?>
                    <option value="<?= $e['id'] ?>" <?= $filter_entite == $e['id'] ? 'selected' : '' ?>>
                        <?= $e['nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="type" class="px-3 py-2 border rounded w-full">
                <option value="">📂 Type de réclamation</option>
                <?php foreach ($types as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= $filter_type == $t['id'] ? 'selected' : '' ?>>
                        <?= $t['libelle'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>


        <!-- Users Table -->
        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-200 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Nom</th>
                        <th class="px-4 py-3">Prénom</th>
                        <th class="px-4 py-3">Nom d'utilisateur</th>
                        <th class="px-4 py-3">Rôle</th>
                        <th class="px-4 py-3">Entité</th>
                        <th class="px-4 py-3">Type de réclamation</th>
                        <th class="px-4 py-3">Créé le</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center">Aucun utilisateur trouvé.</td>
                        </tr>
                    <?php else: ?>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td class="px-4 py-2 font-semibold text-blue-800">#<?= $u["id"] ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($u["nom"] ?? '—') ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($u["prenom"] ?? '—') ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($u["username"]) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($u["role"]) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($u["entite"] ?? '—') ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($u["type_libelle"] ?? '—') ?></td>
                            <td class="px-4 py-2"><?= $u["created_at"] ?></td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="modifier_utilisateur.php?id=<?= $u["id"] ?>" class="text-yellow-600 hover:underline">Modifier</a>
                                <a href="utilisateurs.php?delete=<?= $u["id"] ?>" class="text-red-600 hover:underline" onclick="return confirm('Supprimer cet utilisateur ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <script>
        $(function() {
            $("#addUserBtn").on("click", function() {
                $("#addUserForm").toggleClass("hidden");
            });
        });
    </script>

    <?php include "footer.php"; ?>

</body>

</html>
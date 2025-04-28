<?php
session_start();
require_once "config.php";
include_once "nav.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION["role"];
$user_id = $_SESSION["user_id"];

// === Filters ===
$filter_status = $_GET["statut"] ?? "";
$filter_entite = $_GET["entite"] ?? "";
$filter_type = $_GET["type"] ?? "";
$search = $_GET["search"] ?? "";

$where = "WHERE 1";
$params = [];

if ($role === "agent") {
    $where .= " AND r.id_entite = (SELECT entite_id FROM users WHERE id = ?)";
    $params[] = $user_id;
}

if ($filter_status !== "") {
    $where .= " AND r.id_statut = ?";
    $params[] = $filter_status;
}
if ($filter_entite !== "") {
    $where .= " AND r.id_entite = ?";
    $params[] = $filter_entite;
}
if ($filter_type !== "") {
    $where .= " AND r.id_type = ?";
    $params[] = $filter_type;
}
if ($search !== "") {
    $where .= " AND (r.objet LIKE ? OR r.detail LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// === Get data ===
$sql = "SELECT r.id, r.objet, r.date_reception, s.libelle AS statut, e.nom AS entite, t.libelle AS type
        FROM requetes r
        JOIN statuts s ON r.id_statut = s.id
        JOIN entites e ON r.id_entite = e.id
        JOIN types_reclamation t ON r.id_type = t.id
        $where ORDER BY r.date_reception DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$requetes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get options for filters
$statuts = $pdo->query("SELECT id, libelle FROM statuts")->fetchAll(PDO::FETCH_ASSOC);
$entites = $pdo->query("SELECT id, nom FROM entites")->fetchAll(PDO::FETCH_ASSOC);
$types = $pdo->query("SELECT id, libelle FROM types_reclamation")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | CiRM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>


<body class="bg-gray-50 min-h-screen flex">


    <?php include "sidebar.php"; ?> <!-- Sidebar menu -->

    <main class="flex-1 p-6 space-y-6">


        <!-- Filters -->
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-white p-4 rounded shadow">
            <input type="text" name="search" placeholder="🔍 Rechercher par objet ou détail" value="<?= htmlspecialchars($search) ?>" class="px-3 py-2 border rounded w-full">

            <select name="statut" class="px-3 py-2 border rounded w-full">
                <option value="">🟡 Statut</option>
                <?php foreach ($statuts as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= $filter_status == $s['id'] ? 'selected' : '' ?>>
                        <?= $s['libelle'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="entite" class="px-3 py-2 border rounded w-full">
                <option value="">🏢 Entité</option>
                <?php foreach ($entites as $e): ?>
                    <option value="<?= $e['id'] ?>" <?= $filter_entite == $e['id'] ? 'selected' : '' ?>>
                        <?= $e['nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="type" class="px-3 py-2 border rounded w-full">
                <option value="">📂 Type</option>
                <?php foreach ($types as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= $filter_type == $t['id'] ? 'selected' : '' ?>>
                        <?= $t['libelle'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>

        <!-- Complaints List -->
        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-200 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Objet</th>
                        <th class="px-4 py-3">Réception</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3">Entité</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php foreach ($requetes as $r): ?>
                        <tr>
                            <td class="px-4 py-2 font-semibold text-blue-800">#<?= $r["id"] ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($r["objet"]) ?></td>
                            <td class="px-4 py-2"><?= $r["date_reception"] ?></td>
                            <td class="px-4 py-2"><?= $r["statut"] ?></td>
                            <td class="px-4 py-2"><?= $r["entite"] ?></td>
                            <td class="px-4 py-2"><?= $r["type"] ?></td>
                            <td class="px-4 py-2">
                                <a href="view_requete.php?id=<?= $r["id"] ?>" class="text-blue-600 hover:underline">Voir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <script>
            $(function() {
                $("#toggleSidebar").on("click", function() {
                    $("#sidebar").toggleClass("-translate-x-full");
                });
            });
        </script>


    </main>

</body>

</html>

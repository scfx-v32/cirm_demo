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
$filter_urgence = $_GET["urgence"] ?? "";
$filter_entite = $_GET["entite"] ?? "";
$filter_type = $_GET["type"] ?? "";
$search = $_GET["search"] ?? "";
$filter_date = $_GET["date"] ?? "";

$where = "WHERE 1";
$params = [];

// Adding the user's role filter
if ($role === "agent") {
    $where .= " AND r.id_entite = (SELECT entite_id FROM users WHERE id = ?)";
    $params[] = $user_id;
}

if ($filter_status !== "") {
    $where .= " AND r.id_statut = ?";
    $params[] = $filter_status;
}
if ($filter_urgence !== "") {
    $where .= " AND r.urgence = ?";
    $params[] = $filter_urgence;
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
if ($filter_date !== "") {
    $where .= " AND r.date_reception = ?";
    $params[] = $filter_date;
}

// === Get data ===
$sql = "SELECT r.id, r.objet, r.date_reception, r.urgence, s.libelle AS statut, e.nom AS entite, t.libelle AS type
        FROM requetes r
        JOIN statuts s ON r.id_statut = s.id
        JOIN entites e ON r.id_entite = e.id
        JOIN types_reclamation t ON r.id_type = t.id
        $where ORDER BY r.id DESC";

$stmt = $pdo->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . implode(" ", $pdo->errorInfo()));
}
if (!$stmt->execute($params)) {
    die("Error executing statement: " . implode(" ", $stmt->errorInfo()));
}
$requetes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get options for filters
$statuts = $pdo->query("SELECT id, libelle FROM statuts")->fetchAll(PDO::FETCH_ASSOC);
$entites = $pdo->query("SELECT id, nom FROM entites")->fetchAll(PDO::FETCH_ASSOC);
$types = $pdo->query("SELECT id, libelle FROM types_reclamation")->fetchAll(PDO::FETCH_ASSOC);

// Map status labels to Tailwind color classes
$status_colors = [
    "requête envoyée" => "bg-yellow-100 text-yellow-800 border-yellow-300",
    "prise en charge" => "bg-blue-100 text-blue-800 border-blue-300",
    "clôturée"        => "bg-green-100 text-green-800 border-green-300"
];

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Dashboard | CiRM</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-50 min-h-screen flex">

    <?php include "sidebar.php"; ?> <!-- Sidebar menu -->

    <!-- Add a wrapper for the main content -->
    <div id="mainContent" class="flex-1 p-6 space-y-6 transition-all duration-300">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">Dashboard</h1>
            <!-- Button to add a new request -->
            <?php if ($role === "dispatcher"): ?>
                <a href="ajouter_requete.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    ➕ &nbsp;Nouvelle Requête
                </a>
            <?php endif; ?>
        </div>

        <!-- Filters -->
        <div>
            <form method="GET" class="flex flex-wrap gap-4 bg-white p-4 rounded shadow items-center">
                <input type="text" name="search" placeholder="🔍 Rechercher par objet ou détail" value="<?= htmlspecialchars($search) ?>" class="px-3 py-2 border rounded w-80">

                <select name="statut" class="px-3 py-2 border rounded w-40">
                    <option value="">🟡 Statut</option>
                    <?php foreach ($statuts as $s): ?>
                        <option value="<?= $s['id'] ?>" <?= $filter_status == $s['id'] ? 'selected' : '' ?>>
                            <?= $s['libelle'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="urgence" class="px-3 py-2 border rounded w-40">
                    <option value="">🚩 Urgence</option>
                    <option value="faible" <?= ($filter_urgence ?? '') === "faible" ? "selected" : "" ?>>Faible</option>
                    <option value="normale" <?= ($filter_urgence ?? '') === "normale" ? "selected" : "" ?>>Normale</option>
                    <option value="urgent" <?= ($filter_urgence ?? '') === "urgent" ? "selected" : "" ?>>Urgent</option>
                </select>

                <select name="entite" class="px-3 py-2 border rounded w-40">
                    <option value="">🏢 Entité</option>
                    <?php foreach ($entites as $e): ?>
                        <option value="<?= $e['id'] ?>" <?= $filter_entite == $e['id'] ? 'selected' : '' ?>>
                            <?= $e['nom'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="type" class="px-3 py-2 border rounded w-40">
                    <option value="">📂 Type</option>
                    <?php foreach ($types as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= $filter_type == $t['id'] ? 'selected' : '' ?>>
                            <?= $t['libelle'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="date" name="date" value="<?= htmlspecialchars($filter_date) ?>" class="px-3 py-2 border rounded w-40">

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Filtrer
                </button>
            </form>
        </div>
        <!-- Complaints List -->
        <div class="bg-white shadow rounded overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-200 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Objet</th>
                        <th class="px-4 py-3">Réception</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3">Urgence</th>
                        <th class="px-4 py-3">Entité</th>
                        <th class="px-4 py-3">Type</th>
                        <th class="px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php if (empty($requetes)): ?>
                        <tr>
                            <td colspan="7" class="px-4 py-2 text-center">Aucune réclamation trouvée.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($requetes as $r): ?>
                            <tr>
                                <td class="px-4 py-2 font-semibold text-blue-800">#<?= $r["id"] ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($r["objet"]) ?></td>
                                <td class="px-4 py-2"><?= $r["date_reception"] ?></td>
                                <td class="px-4 py-2">
                                    <span class="inline-block px-2 py-1 rounded border text-xs font-semibold <?= $status_colors[strtolower($r["statut"])] ?? 'bg-gray-100 text-gray-800 border-gray-300' ?>">
                                        <?= htmlspecialchars($r["statut"]) ?>
                                    </span>
                                </td>
                                <?php
                                // Urgence color mapping
                                $urgence_colors = [
                                    "faible"  => "bg-green-100 text-green-800 border-green-300",
                                    "normale" => "bg-yellow-100 text-yellow-800 border-yellow-300",
                                    "urgent"  => "bg-red-100 text-red-800 border-red-300"
                                ];
                                ?>
                                <td class="px-4 py-2">
                                    <span class="inline-block px-2 py-1 rounded border text-xs font-semibold <?= $urgence_colors[strtolower($r["urgence"])] ?? 'bg-gray-100 text-gray-800 border-gray-300' ?>">
                                        <?= htmlspecialchars(ucfirst($r["urgence"])) ?>
                                    </span>
                                </td>
                                <td class="px-4 py-2"><?= $r["entite"] ?></td>
                                <td class="px-4 py-2"><?= $r["type"] ?></td>
                                <td class="px-4 py-2">
                                    <a href="view_requete.php?id=<?= $r["id"] ?>" class="text-blue-600 hover:underline">Voir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script></script>
    <?php include "footer.php"; ?>
</body>

</html>
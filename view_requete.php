<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["user_id"]) || !isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit();
}

$id = (int)$_GET["id"];
$stmt = $pdo->prepare("
    SELECT 
        r.*, 
        c.nom AS c_nom,
        c.prenom AS c_prenom,
        c.cin AS c_cin,
        c.telephone AS c_telephone,
        c.adresse AS c_adresse,
        u1.nom AS created_by_nom,
        u1.prenom AS created_by_prenom,
        u2.nom AS closed_by_nom,
        u2.prenom AS closed_by_prenom
    FROM requetes r
    LEFT JOIN contrevenants c ON r.id_contrevenant = c.id
    LEFT JOIN users u1 ON r.created_by = u1.id
    LEFT JOIN users u2 ON r.closed_by = u2.id
    WHERE r.id = ?
");
$stmt->execute([$id]);
$requete = $stmt->fetch();

if (!$requete) {
    echo "Réclamation introuvable.";
    exit();
}

// Fetch lists
$requérants = $pdo->query("SELECT id, nom, prenom FROM requerants")->fetchAll();
$entites = $pdo->query("SELECT id, nom FROM entites")->fetchAll();
$types = $pdo->query("SELECT id, libelle FROM types_reclamation")->fetchAll();
$statuts = $pdo->query("SELECT id, libelle FROM statuts")->fetchAll();

// Handle status update
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["new_statut"])) {
    $new_statut = (int)$_POST["new_statut"];
    $current_statut = (int)$requete["id_statut"];

    // Define allowed transitions
    $allowed_transitions = [
        1 => 2, // requête envoyée -> prise en charge
        2 => 3  // prise en charge -> clôturée
    ];

    if ($_SESSION["role"] === "agent" && isset($allowed_transitions[$current_statut]) && $allowed_transitions[$current_statut] === $new_statut) {
        $update_stmt = $pdo->prepare("UPDATE requetes SET id_statut = ? WHERE id = ?");
        $update_stmt->execute([$new_statut, $id]);
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Transition de statut non autorisée.');</script>";
    }
}


include_once "nav.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Détails Réclamation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function confirmValidation() {
            return confirm("Êtes-vous sûr de vouloir valider ce changement de statut ?");
        }
    </script>
</head>

<body class="bg-gray-100 min-h-screen flex">
    <?php include "sidebar.php"; ?>
    <main id="mainContent" class="flex-1 p-6 space-y-6">
        <h1 class="text-2xl font-bold flex items-center space-x-4">
            Détails de la Réclamation
            <?php
            $statut_id = (int)$requete["id_statut"];
            $statut_label = htmlspecialchars(getName($statut_id, $statuts));
            $statut_colors = [
                1 => 'bg-yellow-200 text-yellow-800 border-yellow-400',   // envoyée
                2 => 'bg-green-200 text-green-800 border-green-400',     // prise en charge
                3 => 'bg-orange-200 text-orange-800 border-orange-400',  // clôturée
            ];
            $color_class = $statut_colors[$statut_id] ?? 'bg-gray-200 text-gray-800 border-gray-400';
            ?>
            <div class="ml-4 inline-block px-3 py-1 rounded border text-sm font-semibold <?= $color_class ?>">
                <?= $statut_label ?>
            </div>
        </h1>
        <form method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-6 bg-white p-6 rounded shadow">
            <input class="hidden" disabled>
            <div>
                <label class="block font-semibold">Requérant</label>
                <input type="text" disabled value="<?= htmlspecialchars(getName($requete["id_requerant"], $requérants, 'requerant')) ?>" class="w-full px-3 py-2 border rounded bg-gray-100">
            </div>

            <div>
                <label class="block font-semibold">Canal</label>
                <input type="text" disabled value="<?= htmlspecialchars($requete["canal"]) ?>" class="w-full px-3 py-2 border rounded bg-gray-100">
            </div>

            <div>
                <label class="block font-semibold">Date Réception</label>
                <input type="text" disabled value="<?= $requete["date_reception"] ?>" class="w-full px-3 py-2 border rounded bg-gray-100">
            </div>

            <div>
                <label class="block font-semibold">Urgence</label>
                <input type="text" disabled value="<?= $requete["urgence"] ?>" class="w-full px-3 py-2 border rounded bg-gray-100">
            </div>

            <div class="col-span-2">
                <label class="block font-semibold">Objet</label>
                <input type="text" disabled value="<?= htmlspecialchars($requete["objet"]) ?>" class="w-full px-3 py-2 border rounded bg-gray-100">
            </div>

            <div class="col-span-2">
                <label class="block font-semibold">Détail</label>
                <textarea disabled class="w-full px-3 py-2 border rounded bg-gray-100"><?= htmlspecialchars($requete["detail"]) ?></textarea>
            </div>

            <hr class="col-span-2 my-6 border-gray-300">
            <div class="col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Contrevenant
                    <?= ($requete["c_nom"] || $requete["c_prenom"] || $requete["c_cin"] || $requete["c_telephone"] || $requete["c_adresse"]) ? '' : '(Aucun)' ?>
                </h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-semibold">Nom</label>
                        <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="<?= htmlspecialchars($requete["c_nom"] ?? '') ?>" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold">Prénom</label>
                        <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="<?= htmlspecialchars($requete["c_prenom"] ?? '') ?>" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold">Téléphone</label>
                        <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="<?= htmlspecialchars($requete["c_telephone"] ?? '') ?>" disabled>
                    </div>
                    <div>
                        <label class="block font-semibold">CIN</label>
                        <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="<?= htmlspecialchars($requete["c_cin"] ?? '') ?>" disabled>
                    </div>
                    <div class="col-span-2">
                        <label class="block font-semibold">Adresse</label>
                        <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="<?= htmlspecialchars($requete["c_adresse"] ?? '') ?>" disabled>
                    </div>
                </div>
            </div>

            <hr class="col-span-2 my-6 border-gray-300">

            <div>
                <label class="block font-semibold">Adresse</label>
                <input type="text" disabled value="<?= htmlspecialchars($requete["adresse"]) ?>" class="w-full px-3 py-2 border rounded bg-gray-100">
            </div>

            <div>
                <label class="block font-semibold">Entité</label>
                <input type="text" disabled value="<?= htmlspecialchars(getName($requete["id_entite"], $entites)) ?>" class="w-full px-3 py-2 border rounded bg-gray-100">
            </div>

            <div>
                <label class="block font-semibold">Type</label>
                <input type="text" disabled value="<?= htmlspecialchars(getName($requete["id_type"], $types)) ?>" class="w-full px-3 py-2 border rounded bg-gray-100">
            </div>

            <div class="<?= $color_class ?> p-2 rounded">
                <label class="block font-semibold">Statut</label>
                <?php if ($_SESSION["role"] === "agent"): ?>
                    <?php
                    $current_statut = (int)$requete["id_statut"];
                    $allowed_transitions = [
                        1 => 2, // requête envoyée -> prise en charge
                        2 => 3  // prise en charge -> clôturée
                    ];
                    // For select, color the background according to the current status
                    $select_color_class = $statut_colors[$current_statut] ?? 'bg-gray-200 text-gray-800 border-gray-400';
                    ?>
                    <select name="new_statut" class="w-full px-3 py-2 border rounded <?= $select_color_class ?>">
                        <?php
                        echo '<option value="' . $current_statut . '" class="' . $statut_colors[$current_statut] . '">' . htmlspecialchars(getName($current_statut, $statuts)) . '</option>';
                        if (isset($allowed_transitions[$current_statut])) {
                            $next_statut = $allowed_transitions[$current_statut];
                            echo '<option value="' . $next_statut . '" class="' . $statut_colors[$next_statut] . '">' . htmlspecialchars(getName($next_statut, $statuts)) . '</option>';
                        }
                        ?>
                    </select>
                <?php else: ?>
                    <input type="text" disabled value="<?= htmlspecialchars(getName($requete["id_statut"], $statuts)) ?>" class="w-full px-3 py-2 border rounded <?= $color_class ?>">
                <?php endif; ?>
            </div>

            <div class="col-span-2">
                <label class="block font-semibold">Document</label>
                <?php if ($requete["document_path"]): ?>
                    <a href="<?= htmlspecialchars($requete["document_path"]) ?>" target="_blank" class="text-blue-600 underline">Voir le document</a>
                <?php else: ?>
                    <p class="text-gray-500 italic">Aucun document fourni.</p>
                <?php endif; ?>
            </div>
            <div class="col-span-2 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold">Ajoutée par</label>
                    <input type="text" disabled
                        value="<?= htmlspecialchars(trim(($requete["created_by_nom"] ?? '') . ' ' . ($requete["created_by_prenom"] ?? ''))) ?>"
                        class="w-full px-3 py-2 border rounded bg-gray-100">
                </div>
                <?php if ((int)$requete["id_statut"] === 3): // 3 = clôturée 
                ?>
                    <div>
                        <label class="block font-semibold">Clôturée par</label>
                        <input type="text" disabled
                            value="<?= htmlspecialchars(trim(($requete["closed_by_nom"] ?? '') . ' ' . ($requete["closed_by_prenom"] ?? ''))) ?>"
                            class="w-full px-3 py-2 border rounded bg-gray-100">
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-span-2 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold">Date Réception</label>
                    <input type="text" disabled
                        value="<?= htmlspecialchars($requete["date_reception"]) ?>"
                        class="w-full px-3 py-2 border rounded bg-gray-100">
                </div>
                <?php if ((int)$requete["id_statut"] === 3): // 3 = clôturée 
                ?>
                    <div>
                        <label class="block font-semibold">Date clôture</label>
                        <input type="text" disabled
                            value="<?= htmlspecialchars($requete["date_cloture"] ?? '') ?>"
                            class="w-full px-3 py-2 border rounded bg-gray-100">
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-span-2 flex justify-end space-x-4">
                <?php if ($_SESSION["role"] === "agent"): ?>
                    <button type="submit" onclick="return confirmValidation()" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Valider
                    </button>
                <?php endif; ?>
                <a href="dashboard.php" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                    Retour
                </a>
            </div>
        </form>
    </main>
    <?php include "footer.php"; ?>
</body>

</html>

<?php
function getName($id, $list, $type = null)
{
    foreach ($list as $item) {
        if ($item["id"] == $id) {
            if ($type === 'requerant' && isset($item["nom"], $item["prenom"])) {
                return $item["nom"] . ' ' . $item["prenom"];
            }
            return $item["nom"] ?? $item["libelle"];
        }
    }
    return "N/A";
}
?>
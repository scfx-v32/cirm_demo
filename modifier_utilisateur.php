<?php
ob_start(); // Start output buffering
require_once "config.php";
session_start();
include_once "nav.php";

if (!isset($_GET['id'])) {
    header("Location: utilisateurs.php");
    exit();
}

$id = $_GET['id'];

// Fetch existing user
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur introuvable.";
    exit();
}

// Fetch entités
$entites = $pdo->query("SELECT * FROM entites")->fetchAll();

// Fetch types_reclamation if user is agent
$types = [];
if ($user['role'] === 'agent' && $user['entite_id']) {
    $stmt = $pdo->prepare("SELECT id, libelle FROM types_reclamation WHERE entite_id = ?");
    $stmt->execute([$user['entite_id']]);
    $types = $stmt->fetchAll();
}

// Handle POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $username = $_POST["username"];
    $role = $_POST["role"];
    $entite_id = $_POST["hidden_entite_id"] ?: $_POST["entite_id"] ?: null;
    $type_id = $_POST["type_id"] ?: null;

    $sql = "UPDATE users SET nom = ?, prenom = ?, username = ?, role = ?, entite_id = ?, type_id = ?";
    $params = [$nom, $prenom, $username, $role, $entite_id, $type_id];

    if (!empty($_POST["password"])) {
        $sql .= ", password = ?";
        $params[] = password_hash($_POST["password"], PASSWORD_DEFAULT);
    }

    $sql .= " WHERE id = ?";
    $params[] = $id;

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header("Location: utilisateurs.php?updated=1");
    exit();
}

?>


<!-- HTML PART (unchanged except action & dynamic values) -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier Utilisateur | CiRM</title>    
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(function() {
        function handleRoleChange() {
            const role = $('select[name="role"]').val();
            const entiteSelect = $('select[name="entite_id"]');
            const typeContainer = $('#typeContainer');
            const typeSelect = $('#type_id');

            if (role === 'admin') {
                entiteSelect.val('13').prop('disabled', true);
                $('#hidden_entite_id').val('13');
                typeContainer.hide();
                typeSelect.val('');
            } else if (role === 'dispatcher') {
                entiteSelect.val('20').prop('disabled', true);
                $('#hidden_entite_id').val('20');
                typeContainer.hide();
                typeSelect.val('');
            } else if (role === 'agent') {
                entiteSelect.prop('disabled', false);
                $('#hidden_entite_id').val(entiteSelect.val());
                typeContainer.show();
                // Load types_reclamation
                const entiteId = entiteSelect.val();
                if (entiteId) {
                    $.post('ajax_handler.php', {
                        action: 'get_types_by_entite',
                        entite_id: entiteId
                    }, function(response) {
                        if (response.success) {
                            typeSelect.empty().append('<option value="">-- Sélectionner un type --</option>');
                            response.types.forEach(t => {
                                const selected = <?= json_encode($user['type_id']) ?> == t.id ? 'selected' : '';
                                typeSelect.append(`<option value="${t.id}" ${selected}>${t.libelle}</option>`);
                            });
                        }
                    }, 'json');
                }
            } else {
                entiteSelect.prop('disabled', false);
                $('#hidden_entite_id').val(entiteSelect.val());
                typeContainer.hide();
                typeSelect.val('');
            }
        }

        // On load + role change
        handleRoleChange();
        $('select[name="role"]').on('change', handleRoleChange);

        // When entité changes under agent
        $('select[name="entite_id"]').on('change', function() {
            $('#hidden_entite_id').val($(this).val());
            if ($('select[name="role"]').val() === 'agent') {
                const entiteId = $(this).val();
                $('#type_id').empty().append('<option value="">-- Chargement... --</option>');
                $.post('ajax_handler.php', {
                    action: 'get_types_by_entite',
                    entite_id: entiteId
                }, function(response) {
                    if (response.success) {
                        $('#type_id').empty().append('<option value="">-- Sélectionner un type --</option>');
                        response.types.forEach(t => {
                            $('#type_id').append(`<option value="${t.id}">${t.libelle}</option>`);
                        });
                    }
                }, 'json');
            }
        });
    });
</script>


</head>

<body class="bg-gray-50 min-h-screen flex">
    <?php include "sidebar.php"; ?>

    <div id="mainContent" class="flex-1 p-6 transition-all duration-300 flex justify-center">
        <div class="w-full max-w-2xl space-y-6">
            <h1 class="text-3xl font-bold">Modifier Utilisateur</h1>

            <div class="bg-white shadow rounded p-6">
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="hidden_entite_id" id="hidden_entite_id" value="<?= $user['entite_id'] ?? '' ?>">
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block mb-1 font-semibold">Nom</label>
                            <input type="text" name="nom" value="<?= htmlspecialchars($user['nom']) ?>" required class="w-full px-3 py-2 border rounded">
                        </div>

                        <div class="w-1/2">
                            <label class="block mb-1 font-semibold">Prénom</label>
                            <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom']) ?>" required class="w-full px-3 py-2 border rounded">
                        </div>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Nom d'utilisateur</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required class="w-full px-3 py-2 border rounded">
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Mot de passe (laisser vide si inchangé)</label>
                        <input type="password" name="password" class="w-full px-3 py-2 border rounded">
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Rôle</label>
                        <select name="role" required class="w-full px-3 py-2 border rounded">
                            <option value="">-- Sélectionner un rôle --</option>
                            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="dispatcher" <?= $user['role'] === 'dispatcher' ? 'selected' : '' ?>>Dispatcher</option>
                            <option value="agent" <?= $user['role'] === 'agent' ? 'selected' : '' ?>>Agent</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Entité</label>
                        <select name="entite_id" id="entite" class="w-full px-3 py-2 border rounded">
                            <option value="">-- Aucune --</option>
                            <?php foreach ($entites as $e): ?>
                                <option value="<?= $e['id'] ?>" <?= $user['entite_id'] == $e['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($e['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="typeContainer" style="display: none;">
                        <label class="block mb-1 font-semibold">Type de réclamation</label>
                        <select name="type_id" id="type_id" class="w-full px-3 py-2 border rounded">
                            <option value="">-- Sélectionner un type --</option>
                            <?php foreach ($types as $t): ?>
                                <option value="<?= $t['id'] ?>" <?= $user['type_id'] == $t['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($t['libelle']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <div class="flex gap-2">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Valider les modifications
                        </button>
                        <a href="utilisateurs.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        
    </script>

    <?php include "footer.php"; ?>
</body>

</html>
<?php
ob_start();
require_once "config.php";
session_start();
include_once "nav.php";

// Fetch entités for the dropdown
$entites = $pdo->query("SELECT * FROM entites")->fetchAll();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];
    $entite_id = $_POST['hidden_entite_id'] ?: $_POST["entite_id"] ?: null;
    $type_id = $_POST["type_id"] ?: null;

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (nom, prenom, username, password, role, entite_id, type_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $username, $hashed, $role, $entite_id, $type_id]);

    header("Location: utilisateurs.php?added=1");
    exit();
}

include_once "nav.php";

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Nouvel Utilisateur | CiRM</title>
    <link rel="favicon" href="favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function loadEntite(id) {
                $.get('ajax_handler.php', {
                    action: 'get_entite_by_id',
                    id: id
                }, function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        $('#entiteSelect').html(`<option value="${data.entite.id}">${data.entite.nom}</option>`);
                        $('#entiteSelect').prop('disabled', true);
                    }
                });
            }

            function loadTypes(entiteId) {
                $.post('ajax_handler.php', {
                    action: 'get_types_by_entite',
                    entite_id: entiteId
                }, function(response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        let options = '<option value="">-- Sélectionner un type --</option>';
                        data.types.forEach(function(type) {
                            options += `<option value="${type.id}">${type.libelle}</option>`;
                        });
                        $('#typeSelect').html(options);
                        $('#typesReclamationBlock').removeClass('hidden');
                    } else {
                        $('#typeSelect').html('');
                        $('#typesReclamationBlock').addClass('hidden');
                    }
                });
            }

            $('select[name="role"]').on('change', function() {
                const role = $(this).val();

                if (role === 'admin') {
                    loadEntite(13);
                    $('#typesReclamationBlock').addClass('hidden');
                    $('#hidden_entite_id').val('13');
                } else if (role === 'dispatcher') {
                    loadEntite(20);
                    $('#typesReclamationBlock').addClass('hidden');
                    $('#hidden_entite_id').val('20');
                } else if (role === 'agent') {
                    $('#entiteSelect').prop('disabled', false);
                    $('#entiteSelect').html(`<?php foreach ($entites as $e): ?><option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nom']) ?></option><?php endforeach; ?>`);
                    $('#typesReclamationBlock').addClass('hidden');
                } else {
                    $('#entiteSelect').prop('disabled', false);
                    $('#typesReclamationBlock').addClass('hidden');
                }
            });

            $('#entiteSelect').on('change', function() {
                const selectedEntite = $(this).val();
                const role = $('select[name="role"]').val();

                if (role === 'agent' && selectedEntite) {
                    loadTypes(selectedEntite);
                } else {
                    $('#typesReclamationBlock').addClass('hidden');
                }
            });
        });
    </script>

</head>

<body class="bg-gray-50 min-h-screen flex">
    <?php include "sidebar.php"; ?>

    <div id="mainContent" class="flex-1 p-6 transition-all duration-300 flex justify-center">
        <div class="w-full max-w-2xl space-y-6">
            <h1 class="text-3xl font-bold">Nouvel Utilisateur</h1>

            <div class="bg-white shadow rounded p-6">
                <form method="POST" action="ajouter_utilisateur.php" class="space-y-4">
                    <input type="hidden" name="hidden_entite_id" id="hidden_entite_id" value="">
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label class="block mb-1 font-semibold">Nom</label>
                            <input type="text" name="nom" required class="w-full px-3 py-2 border rounded">
                        </div>

                        <div class="w-1/2">
                            <label class="block mb-1 font-semibold">Prénom</label>
                            <input type="text" name="prenom" required class="w-full px-3 py-2 border rounded">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-1 font-semibold">Nom d'utilisateur</label>
                        <input type="text" name="username" required class="w-full px-3 py-2 border rounded">
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Mot de passe</label>
                        <input type="password" name="password" required class="w-full px-3 py-2 border rounded">
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Rôle</label>
                        <select name="role" required class="w-full px-3 py-2 border rounded">
                            <option value="">-- Sélectionner un rôle --</option>
                            <option value="admin">Admin</option>
                            <option value="dispatcher">Dispatcher</option>
                            <option value="agent">Agent</option>
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-semibold">Entité</label>
                        <select id="entiteSelect" name="entite_id" class="w-full px-3 py-2 border rounded">
                            <option value="">-- Aucune --</option>
                            <?php foreach ($entites as $e): ?>
                                <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- This block is hidden unless role = agent -->
                    <div id="typesReclamationBlock" class="hidden">
                        <label class="block mb-1 font-semibold">Type de réclamations</label>
                        <select name="type_id" id="typeSelect" class="w-full px-3 py-2 border rounded">
                            <option value="">-- Sélectionner un type --</option>
                            <!-- Options loaded dynamically -->
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                            Créer
                        </button>
                        <a href="utilisateurs.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            Annuler
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <br>

    <script>
        
    </script>

    <?php include "footer.php"; ?>

</body>

</html>

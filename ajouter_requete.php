<?php
ob_start();
session_start();
require_once "config.php";
include_once "nav.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Insert new requête with contrevenant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_requete'])) {
    try {
        // Validate required fields
        if (empty($_POST['id_requerant'])) {
            throw new Exception("Un requérant doit être sélectionné ou créé.");
        }

        // Start transaction
        $pdo->beginTransaction();

        // 1. Insert contrevenant
        $stmt = $pdo->prepare("INSERT INTO contrevenants 
            (nom, prenom, cin, telephone, adresse) 
            VALUES (?, ?, ?, ?, ?)");

        $stmt->execute([
            $_POST['c_nom'],
            $_POST['c_prenom'],
            $_POST['c_cin'] ?? null,
            $_POST['c_telephone'],
            $_POST['c_adresse']
        ]);
        $id_contrevenant = $pdo->lastInsertId();

        // 2. Prepare requête data
        $objet = $_POST["objet"];
        $detail = $_POST["detail"];
        $canal = $_POST["canal"];
        $date_reception = $_POST["date_reception"];
        $urgence = $_POST["urgence"];
        $id_requerant = (int)$_POST["id_requerant"];
        $id_entite = !empty($_POST["id_entite"]) ? (int)$_POST["id_entite"] : null;
        $id_type = !empty($_POST["id_type"]) ? (int)$_POST["id_type"] : null;
        $adresse = $_POST["adresse"];
        $document_path = null;

        // Verify requérant exists
        $stmt = $pdo->prepare("SELECT id FROM requerants WHERE id = ?");
        $stmt->execute([$id_requerant]);
        if (!$stmt->fetch()) {
            throw new Exception("Le requérant sélectionné n'existe pas.");
        }

        // File upload handling
        if (isset($_FILES['document']) && $_FILES['document']['error'] === 0) {
            $allowed = ['pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg'];
            $ext = strtolower(pathinfo($_FILES["document"]["name"], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                throw new Exception("Type de fichier non autorisé. Formats acceptés: PDF, DOC, DOCX, JPG, PNG, JPEG.");
            }

            $fileName = time() . '_' . basename($_FILES["document"]["name"]);
            $targetPath = 'uploads/' . $fileName;

            if (!move_uploaded_file($_FILES["document"]["tmp_name"], $targetPath)) {
                throw new Exception("Échec du téléchargement du document.");
            }
            $document_path = $targetPath;
        }

        // 3. Insert requete with contrevenant ID
        $stmt = $pdo->prepare("INSERT INTO requetes 
            (objet, detail, canal, date_reception, urgence, id_requerant, id_contrevenant, id_entite, id_type, adresse, document_path, id_statut, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, ?)");

        $stmt->execute([
            $objet,
            $detail,
            $canal,
            $date_reception,
            $urgence,
            $id_requerant,
            $id_contrevenant,
            $id_entite,
            $id_type,
            $adresse,
            $document_path,
            $_SESSION["user_id"]
        ]);

        // Commit transaction
        $pdo->commit();

        ob_end_clean();
        header("Location: dashboard.php?added=1");
        exit();
    } catch (Exception $e) {
        // Rollback on error
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        $error = $e->getMessage();
    }
}

// Fetch dropdown data
$requérants = $pdo->query("SELECT id, nom, prenom FROM requerants")->fetchAll();
$entites = $pdo->query("SELECT id, nom FROM entites")->fetchAll();
$types = $pdo->query("SELECT id, entite_id, libelle FROM types_reclamation")->fetchAll();
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter Réclamation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex">
    <?php include "sidebar.php"; ?>

    <main id="mainContent" class="flex-1 p-6 space-y-6">
        <h1 class="text-2xl font-bold text-gray-800">Nouvelle Réclamation</h1>

        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-2 gap-6 bg-white p-6 rounded shadow">
            <?php if (!empty($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded col-span-2 mb-4">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <!-- Requérant + modal -->
            <div class="space-y-4">
                <label class="block font-semibold">Requérant <span class="text-red-500">*</span></label>
                <div class="flex gap-2">
                    <select name="id_requerant" id="id_requerant" class="w-full border px-3 py-2 rounded" required>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($requérants as $r): ?>
                            <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['nom'] . ' ' . $r['prenom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" id="openModal" class="bg-blue-600 text-white px-4 py-2 rounded">+</button>
                </div>
            </div>

            <div>
                <label class="block font-semibold">Canal <span class="text-red-500">*</span></label>
                <select name="canal" class="w-full border px-3 py-2 rounded" required>
                    <option value="Présentiel">Présentiel</option>
                    <option value="Téléphone">Téléphone</option>
                    <option value="Courrier">Courrier</option>
                </select>
            </div>

            <div>
                <label class="block font-semibold">Date de Réception <span class="text-red-500">*</span></label>
                <input type="date" name="date_reception" class="w-full border px-3 py-2 rounded" required max="<?= date('Y-m-d') ?>">
            </div>

            <div>
                <label class="block font-semibold">Urgence <span class="text-red-500">*</span></label>
                <select name="urgence" class="w-full border px-3 py-2 rounded" required>
                    <option value="Normale">Normale</option>
                    <option value="Haute">Haute</option>
                    <option value="Faible">Faible</option>
                </select>
            </div>

            <div class="col-span-2">
                <label class="block font-semibold">Objet <span class="text-red-500">*</span></label>
                <input type="text" name="objet" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="col-span-2">
                <label class="block font-semibold">Détail</label>
                <textarea name="detail" rows="4" class="w-full border px-3 py-2 rounded"></textarea>
            </div>

            <hr class="col-span-2 my-6 border-gray-300">

            <div class="col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations du Contrevenant</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-semibold">Nom </span></label>
                        <input type="text" name="c_nom" class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold">Prénom</label>
                        <input type="text" name="c_prenom" class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold">Téléphone </label>
                        <input type="text" name="c_telephone" class="w-full border px-3 py-2 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold">CIN</label>
                        <input type="text" name="c_cin" class="w-full border px-3 py-2 rounded">
                    </div>
                    <div class="col-span-2">
                        <label class="block font-semibold">Adresse</label>
                        <input type="text" name="c_adresse" class="w-full border px-3 py-2 rounded">
                    </div>
                </div>
            </div>

            <hr class="col-span-2 my-6 border-gray-300">


            <div>
                <label class="block font-semibold">Adresse <span class="text-red-500">*</span></label>
                <input type="text" name="adresse" class="w-full border px-3 py-2 rounded">
            </div>

            <div>
                <label class="block font-semibold">Entité <span class="text-red-500">*</span></label>
                <select name="id_entite" id="entiteSelect" class="w-full border px-3 py-2 rounded">
                    <option value="">-- Choisir --</option>
                    <?php foreach ($entites as $e): ?>
                        <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block font-semibold">Type</label>
                <select id="typeSelect" name="id_type" class="w-full border px-3 py-2 rounded">
                    <option value="">-- Choisir --</option>
                    <!-- Dynamic options will be filled via AJAX -->
                </select>
            </div>


            <div></div>

            <div class="col-span-2">
                <label class="block font-semibold">Document (PDF, Word, Image)</label>
                <input type="file" name="document" accept=".pdf,.doc,.docx,.jpg,.png,.jpeg" class="w-full border px-3 py-2 rounded">
            </div>

            <div class="col-span-2 flex gap-4 justify-end">
                <button type="submit" name="submit_requete" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded">Valider</button>
                <a href="dashboard.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded">Annuler</a>
            </div>
        </form>

        <!-- Modal -->
        <div id="requerantModal" class="fixed inset-0 bg-black/50 z-50 hidden flex justify-center items-center">
            <form id="addRequerantForm" class="bg-white p-8 rounded-lg shadow-lg space-y-6 w-full max-w-xl">
                <h2 class="text-2xl font-bold text-gray-800">Ajouter un Requérant</h2>

                <div class="flex gap-6">
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom<span class="text-red-500">*</span></label>
                        <input type="text" name="r_nom" required class="w-full px-4 py-2 border rounded">
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom<span class="text-red-500">*</span></label>
                        <input type="text" name="r_prenom" required class="w-full px-4 py-2 border rounded">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CIN</label>
                    <input type="text" name="r_cin" class="w-full px-4 py-2 border rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone<span class="text-red-500">*</span></label>
                    <input type="text" name="r_telephone" class="w-full px-4 py-2 border rounded">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse<span class="text-red-500">*</span></label>
                    <textarea name="r_adresse" rows="3" class="w-full px-4 py-2 border rounded resize-none"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" id="closeModal" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ajouter</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#entiteSelect').on('change', function() {
                const entiteId = $(this).val();
                $('#typeSelect').html('<option value="">Chargement...</option>');
                if (entiteId) {
                    $.post('ajax_handler.php', {
                        action: 'get_types_by_entite',
                        entite_id: entiteId
                    }, function(response) {
                        let options = '<option value="">-- Choisir --</option>';
                        if (response.success && response.types.length > 0) {
                            response.types.forEach(type => {
                                options += `<option value="${type.id}">${type.nom || type.libelle}</option>`;
                            });
                        } else {
                            options = '<option value="">Aucun type disponible</option>';
                        }
                        $('#typeSelect').html(options);
                    }, 'json');
                } else {
                    $('#typeSelect').html('<option value="">-- Choisir --</option>');
                }
            });
        });
    </script>

    <script>
        $(function() {

            // Requérant Modal Handling
            $('#addRequerantForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const formData = form.serialize() + '&add_requerant=1';

                $.post('ajax_handler.php', formData, function(res) {
                    if (res.success) {
                        console.log("Requérant ajouté, ID:", res.id);

                        // Refresh the dropdown options
                        $.get('ajax_handler.php?action=get_requerants', function(data) {
                            console.log("Données reçues pour dropdown:", data);
                            $('#id_requerant').html('<option value="">-- Sélectionner --</option>' + data);
                            $('#id_requerant').val(res.id);
                            console.log("Dropdown mis à jour, sélectionné:", $('#id_requerant').val());
                        }).fail(function() {
                            alert("Erreur lors de la récupération des requérants.");
                        });

                        $('#requerantModal').addClass('hidden');
                        form[0].reset();
                    } else {
                        alert("Erreur : " + res.message);
                    }
                }, 'json').fail(function(xhr, status, error) {
                    console.error("Erreur serveur - veuillez réessayer.", error);
                    alert("Erreur serveur - veuillez réessayer.");
                });
            });
            // Rest of your existing JavaScript...
            $('#closeModal').on('click', function() {
                $('#requerantModal').addClass('hidden');
            });

            $('#openModal').on('click', function() {
                $('#requerantModal').removeClass('hidden');
            });


        });
    </script>
    <?php include "footer.php"; ?>
</body>

</html>
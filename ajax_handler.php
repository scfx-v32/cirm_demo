<?php
require_once "config.php";

// Handle GET for requerants dropdown
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_requerants') {
    $requerants = $pdo->query("SELECT id, CONCAT(nom, ' ', prenom) as full_name FROM requerants ORDER BY nom");
    $options = '';
    foreach ($requerants as $r) {
        $options .= '<option value="'.$r['id'].'">'.htmlspecialchars($r['full_name']).'</option>';
    }
    echo $options;
    exit;
}

// Handler for adding requerant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_requerant'])) {
    $stmt = $pdo->prepare("INSERT INTO requerants (nom, prenom, cin, telephone, adresse) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['r_nom'],
        $_POST['r_prenom'],
        $_POST['r_cin'],
        $_POST['r_telephone'],
        $_POST['r_adresse']
    ]);
    $id = $pdo->lastInsertId();

    echo json_encode([
        "success" => true,
        "id" => $id,
        "nom" => $_POST['r_nom'],
        "prenom" => $_POST['r_prenom']
    ]);
    exit;
}

// Handler for fetching types_reclamation by entite_id
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'get_types_by_entite') {
    $entite_id = $_POST['entite_id'];

    $stmt = $pdo->prepare("SELECT id, libelle FROM types_reclamation WHERE entite_id = ?");
    $stmt->execute([$entite_id]);
    $types = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "types" => $types
    ]);
    exit;
}

// New handler to fetch a specific entité by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_entite_by_id') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT id, nom FROM entites WHERE id = ?");
    $stmt->execute([$id]);
    $entite = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($entite) {
        echo json_encode(["success" => true, "entite" => $entite]);
    } else {
        echo json_encode(["success" => false, "message" => "Entité not found"]);
    }
    exit;
}

echo json_encode(["success" => false, "message" => "Invalid request"]);
exit;

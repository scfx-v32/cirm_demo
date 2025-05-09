<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<aside id="sidebar" class="fixed top-16 transform transition-transform duration-300 w-64 bg-blue-700 text-white flex flex-col h-screen flex-shrink-0 z-10 hidden">
    <div class="flex flex-col">
        <br>
        <a href="dashboard.php" class="px-6 py-4 hover:bg-blue-800 w-full">🏠 Tableau de Bord</a>

        <?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin"): ?>
            <a href="utilisateurs.php" class="px-6 py-4 hover:bg-blue-800 w-full">👥 Utilisateurs</a>
            <a href="dashboard.php" class="px-6 py-4 hover:bg-blue-800 w-full">📂 Réclamations</a>
        <?php elseif ($_SESSION["role"] === "dispatcher"): ?>
            <a href="ajouter_requete.php" class="px-6 py-4 hover:bg-blue-800 w-full">➕ Nouvelle Réclamation</a>
            <a href="dashboard.php" class="px-6 py-4 hover:bg-blue-800 w-full">📂 Réclamations</a>
        <?php elseif ($_SESSION["role"] === "agent"): ?>
            <a href="dashboard.php" class="px-6 py-4 hover:bg-blue-800 w-full">📂 Mes Réclamations</a>
        <?php endif; ?>
        <a href="profil.php" class="px-6 py-4 hover:bg-blue-800 w-full">👤 Mon Profil</a>

    </div>
</aside>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#toggleSidebar').on('click', function () {
            $('#sidebar').toggleClass('-translate-x-full');
        });
    });
</script>

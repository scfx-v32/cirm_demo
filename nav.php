<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>CiRM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-100">

    <header class="bg-blue-600 text-white p-4 flex justify-between items-center shadow">
        <button id="toggleSidebar" class="text-white text-2xl focus:outline-none mr-4 ">
            ☰ &nbsp; CiRM
        </button>

        <!-- PROFILE DROPDOWN -->
        <div class="relative inline-block text-left">
            <button id="profileToggle" class="inline-flex items-center justify-center rounded-md bg-white text-blue-600 px-4 py-2 text-sm font-medium shadow hover:bg-gray-100 focus:outline-none">
                👤 <?= htmlspecialchars($_SESSION["username"]) ?> ▼
            </button>

            <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-[9999]">
                <a href="profil.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon Profil</a>
                <a href="logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100">Déconnexion</a>
            </div>
        </div>
    </header>

    <script>
        $(function() {
            $("#profileToggle").on("click", function(e) {
                e.preventDefault();
                e.stopPropagation();
                $("#profileMenu").toggleClass("hidden");
            });

            $(document).on("click", function(e) {
                if (!$(e.target).closest("#profileMenu, #profileToggle").length) {
                    $("#profileMenu").addClass("hidden");
                }
            });

            $("#toggleSidebar").on("click", function() {
                $("#sidebar").toggleClass("hidden");
            });



        });
    </script>


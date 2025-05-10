<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>CiRM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        header {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        #mainContent {
            margin-top: 60px; /* Adjust based on the height of your header */
            padding: 20px;
        }
        #mainContent input, #mainContent select, #mainContent textarea {
            background-color: #f3f4f6;
            /* Slightly darker background */
        }
    </style>
</head>

<body class="bg-gray-100">

    <header class="bg-blue-600 text-white p-3 flex justify-between items-center shadow">
        <button id="toggleSidebar" class="p-3 text-white text-2xl hover:bg-blue-700 focus:outline-none mr-4 ">
            ☰ &nbsp; CiRM
        </button>

        <!-- PROFILE DROPDOWN -->
        <div class="relative inline-block text-left">
            <span>(<?= htmlspecialchars($_SESSION["role"]) ?>)</span>
            &emsp;
            <button id="profileToggle" class="inline-flex items-center justify-center rounded-md bg-white text-blue-600 px-4 py-2 text-sm font-medium shadow hover:bg-gray-100 focus:outline-none">
                👤 <?= htmlspecialchars($_SESSION["username"]) ?>  ▼
            </button>

            <div id="profileMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-[9999]">
                <a href="profil.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md">Mon Profil</a>
                <a href="logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100 rounded-md">Déconnexion</a>
            </div>
        </div>
    </header>

    <br/>

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
                $("#sidebar").toggleClass("-translate-x-full");
                $("#mainContent").toggleClass("ml-64");
            });
        });
    </script>
</body>
</html>

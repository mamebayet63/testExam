<?php
require_once "../bd.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../testConnexion/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - Bibliothèque</title>
    <link rel="stylesheet" href="indexT.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .hero {
            background: #f8f9fa;
            padding: 2rem 0;
            text-align: center;
        }

        .container {
            max-width: 800px;
        }

        .hero h1 {
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .section {
            margin: 2rem 0;
        }

        .section h2 {
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }

        .section p {
            font-size: 1rem;
            line-height: 1.5;
            color: #343a40;
        }

        .section img {
            width: 100%;
            height: auto;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <!-- En-tête -->
        <header class="sticky-top bg-white">
        <div class="row d-flex justify-content-between align-items-center mt-2">
            <div class="col-4">
                <ul>
                    <a href="index3.php" class="text-decoration-none text-black"><li class="mx-3">Accueil</li></a>
                    <a href="MesLivres.php" class="text-decoration-none  text-black"><li class="mx-3">Livres</li></a>
                    <a href="propos.php" class="text-decoration-none text-black"><li class="mx-3">Qui sommes nous</li></a>
                </ul>
            </div>
            <div class="col-1">
                <img src="image/1-removebg-preview.png" alt="" class="w-75 h-75">
            </div>
            <div class="col-3">
                <form class="d-flex" method="GET" action="">
                    <input class="form-control me-2 monSearch" type="search" name="search" placeholder="Recherche par titre" aria-label="Search" value="<?= htmlspecialchars($searchTerm) ?>">
                    <button class="monSearch bg-primary text-white" type="submit"><i class="ri-search-2-line"></i></button>
                </form>
            </div>
            <div class="col-1">
                <a href="profil.php"><img src="image/<?= $user['profil'] ?>" alt=""></a>
            </div>
        </div>
        <div class="row d-flex">
            <hr>
        </div>
    </header>


        <!-- Section Héro -->
        <section class="hero">
            <div class="container text-center">
                <h1>À propos de notre Bibliothèque</h1>
                <p>Découvrez qui nous sommes et ce que nous faisons</p>
            </div>
        </section>

        <!-- Section Notre Mission -->
        <section class="section">
            <div class="container">
                <img src="image/mission.jpg" alt="Notre Mission">
                <h2>Notre Mission</h2>
                <p>
                    Notre mission est de fournir un accès facile et convivial à une vaste collection de livres couvrant une multitude de domaines. Que vous soyez passionné par la littérature, la science, l'histoire, la géographie, ou encore les technologies de l'information, notre bibliothèque est conçue pour répondre à vos besoins intellectuels et curieux.
                </p>
            </div>
        </section>

        <!-- Section Nos Collections -->
        <section class="section">
            <div class="container">
                <img src="image/collections.jpg" alt="Nos Collections">
                <h2>Nos Collections</h2>
                <p>
                    Nous nous efforçons de maintenir une collection diversifiée et actualisée qui inclut :
                </p>
                <ul>
                    <li><strong>Romans</strong> : Des classiques intemporels aux best-sellers contemporains.</li>
                    <li><strong>Informatique</strong> : Ressources pour les étudiants, les professionnels et les passionnés de technologie.</li>
                    <li><strong>Géographie</strong> : Découverte des paysages, cultures et phénomènes naturels du monde entier.</li>
                    <li><strong>Histoire</strong> : Exploration des événements et personnages qui ont façonné notre monde.</li>
                    <li><strong>Mathématiques et Sciences</strong> : Textes académiques et populaires pour tous les niveaux de compréhension.</li>
                    <li><strong>Chimie</strong> : Du fondamental au complexe, des ressources pour les étudiants et les chercheurs.</li>
                </ul>
            </div>
        </section>

        <!-- Section Notre Engagement -->
        <section class="section">
            <div class="container">
                <img src="image/engagement.jpg" alt="Notre Engagement">
                <h2>Notre Engagement</h2>
                <p>
                    Nous nous engageons à offrir un environnement accueillant et inclusif pour tous nos utilisateurs. Notre équipe est dévouée à vous aider à trouver les ressources dont vous avez besoin et à rendre votre expérience dans notre bibliothèque aussi enrichissante que possible.
                </p>
            </div>
        </section>

        <!-- Pied de page -->
        <footer class="bg-dark text-white py-4">
            <div class="container text-center">
                <p>&copy; 2024 Bibliothèque. Tous droits réservés.</p>
                <p>Suivez-nous sur les réseaux sociaux :</p>
                <div class="d-flex justify-content-center">
                    <a href="#" class="text-white mx-2"><i class="ri-facebook-fill"></i></a>
                    <a href="#" class="text-white mx-2"><i class="ri-twitter-fill"></i></a>
                    <a href="#" class="text-white mx-2"><i class="ri-instagram-fill"></i></a>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

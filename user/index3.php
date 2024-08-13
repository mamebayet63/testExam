<?php
require_once "../bd.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../testConnexion/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

$searchTerm = '';
$searchResults = [];

if ($pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM abonne WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($_GET['search'])) {
            $searchTerm = $_GET['search'];
            $searchStmt = $pdo->prepare("SELECT * FROM livre WHERE titre LIKE :searchTerm");
            $searchStmt->execute([':searchTerm' => '%' . $searchTerm . '%']);
            $searchResults = $searchStmt->fetchAll();
        } else {
            $popularBooksStmt = $pdo->query("SELECT * FROM livre ORDER BY popularite DESC LIMIT 5");
            $popularBooks = $popularBooksStmt->fetchAll();

            $newBooksStmt = $pdo->query("SELECT * FROM livre ORDER BY date_ajout DESC LIMIT 5");
            $newBooks = $newBooksStmt->fetchAll();

            $categoriesStmt = $pdo->query("SELECT * FROM categorie");
            $categories = $categoriesStmt->fetchAll();
        }
    } catch (PDOException $e) {
        echo "Requête échouée: " . $e->getMessage();
    }
} else {
    echo "Impossible d'exécuter la requête.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Bibliothèque</title>
    <link rel="stylesheet" href="indexT.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style personnalisé si nécessaire */
    </style>
    
</head>
<body >
<div class="container-fluid">
    <!-- En-tête -->
    <header class="sticky-top bg-white">
        <div class="row d-flex justify-content-between align-items-center mt-2">
            <div class="col-4 fw-normal">
                <ul>
                    <a href="index3.php" class="text-decoration-none text-black"><li class="mx-3">Accueil</li></a>
                    <a href="MesLivres.php" class="text-decoration-none  text-black"><li class="mx-3">Livres</li></a>
                    <a href="propos2.php" class="text-decoration-none text-black"><li class="mx-3">Qui sommes nous</li></a>
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
            <h1>Bienvenue à la Bibliothèque</h1>
            <p>Découvrez un monde de connaissances</p>
        </div>
    </section>

    <!-- Affichage des résultats de recherche -->
    <?php if ($searchTerm): ?>
        <section class="my-4">
            <div class="container">
                <h2 class="mb-4">Résultats de recherche pour "<?= htmlspecialchars($searchTerm) ?>"</h2>
                <div class="row">
                    <?php if (count($searchResults) > 0): ?>
                        <?php foreach ($searchResults as $book): ?>
                            <div class="col-md-2 mb-3">
                                <div class="card">
                                    <img src="image/<?= $book['images']; ?>" class="card-img-top" alt="<?= $book['titre']; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $book['titre']; ?></h5>
                                        
                                        <a href="detail.php?indice=<?= $book['id_livre']; ?>" class="btn btn-primary">En savoir plus</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Aucun résultat trouvé.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php else: ?>
        <!-- Catégories de livres -->
        <section class="my-4">
            <div class="container">
                <h2 class="mb-4">Catégories</h2>
                <div class="row">
                    <?php foreach ($categories as $categorie) : ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $categorie["nom"] ?></h5>
                                    <p class="card-text"><?= $categorie["descriptions"] ?></p>
                                    <a class="btn btn-primary mt-3" href="categorie.php?indices=<?= $categorie['id_categorie'] ?>">En savoir plus</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Livres populaires -->
        <section class="my-4">
            <div class="container">
                <h2 class="mb-4">Livres Populaires</h2>
                <div class="row d-flex justify-content-between">
                    <?php foreach ($popularBooks as $book) : ?>
                        <div class="col-md-2 mb-3">
                            <img src="image/<?= $book['images']; ?>" class="monImage w-100" alt="<?= $book['titre']; ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title mt-2"><?= $book['titre']; ?></h5>
                                <a class="btn btn-primary mt-3" href="detail.php?indice=<?= $book['id_livre'] ?>">En savoir plus</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Nouveautés -->
        <section class="my-4">
            <div class="container">
                <h2 class="mb-4">Nouveautés</h2>
                <div class="row d-flex justify-content-between">
                    <?php foreach ($newBooks as $book) : ?>
                        <div class="col-md-2 mb-3">
                            <img src="image/<?= $book['images']; ?>" class="monImage w-100" alt="<?= $book['titre']; ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title mt-2"><?= $book['titre']; ?></h5>
                                <a class="btn btn-primary mt-3" href="detail.php?indice=<?= $book['id_livre'] ?>">En savoir plus</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
   
    <div class="row my-5 ">
                <iframe src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d123458.41837954767!2d-17.47279287156153!3d14.764772197549291!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e6!4m3!3m2!1d14.791475199999999!2d-17.3277184!4m5!1s0xec173c21564c333%3A0x504d9e7bb5384f5a!2secole%20221!3m2!1d14.723441999999999!2d-17.4527246!5e0!3m2!1sfr!2ssn!4v1722438426939!5m2!1sfr!2ssn" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

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

<?php
require_once "../bd.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../testConnexion/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

if ($pdo !== null) {
    try {
        // Récupérer toutes les catégories
        $categoriesStmt = $pdo->query("SELECT * FROM categorie");
        $categories = $categoriesStmt->fetchAll();

        // Préparer un tableau pour stocker les livres par catégorie
        $livresParCategorie = [];

        // Récupérer les livres pour chaque catégorie
        foreach ($categories as $categorie) {
            $categorie_id = $categorie['id_categorie'];
            $livresStmt = $pdo->prepare("SELECT * FROM livre WHERE categorie_id = :categorie_id");
            $livresStmt->execute([':categorie_id' => $categorie_id]);
            $livresParCategorie[$categorie_id] = $livresStmt->fetchAll();
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
    <title>Livres par Catégorie</title>
    <link rel="stylesheet" href="indexT.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .carousel-item {
            display: flex;
            justify-content: center;
        }
        .carousel-item img {
            max-width: 100%;
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


    <!-- Section des livres par catégorie -->
    <section class="my-4">
        <div class="container">
            <?php foreach ($categories as $categorie) : ?>
                <h2 class="mb-4 text-center"><?= $categorie['nom'] ?></h2>
                <div id="carousel-<?= $categorie['id_categorie'] ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (isset($livresParCategorie[$categorie['id_categorie']])) : ?>
                            <?php foreach (array_chunk($livresParCategorie[$categorie['id_categorie']], 5) as $index => $livresChunk) : ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <div class="row">
                                        <?php foreach ($livresChunk as $livre) : ?>
                                            <div class="col-md-2 mb-3">
                                                <img src="image/<?= $livre['images']; ?>" class="monImage w-100" alt="<?= $livre['titre']; ?>">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title mt-2"><?= $livre['titre']; ?></h5>
                                                    <a class="btn btn-primary mt-3" href="detail.php?indice=<?= $livre['id_livre'] ?>">En savoir plus</a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>Aucun livre trouvé dans cette catégorie.</p>
                        <?php endif; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carousel-<?= $categorie['id_categorie'] ?>" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-<?= $categorie['id_categorie'] ?>" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            <?php endforeach; ?>
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

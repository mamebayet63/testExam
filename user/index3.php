<?php
require_once "../bd.php";
if ($pdo !== null) {
    try {
        $popularBooks = $pdo->query("SELECT * FROM livre ORDER BY popularite DESC LIMIT 5")->fetchAll();
        $newBooks = $pdo->query("SELECT * FROM livre ORDER BY date_ajout DESC LIMIT 5")->fetchAll();
        $categories = $pdo->query("SELECT * FROM categorie")->fetchAll();
    } catch (PDOException $e) {
        echo "Requete Echoué: " . $e->getMessage();
    }
} else {
    echo "Impossible d'executer la requete.";
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Bibliothèque</title>
    <link rel="stylesheet" href="indexT.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       
    </style>
</head>

<body>
<div class="container-fluid">
    <!-- En-tête -->
    <header>
            <div class="row d-flex justify-content-between align-items-center mt-2">
                <div class="col-4 ">
                    <ul>
                        <li class="mx-3">Accueil</li>
                        <li class="mx-3">Livres</li>
                        <li class="mx-3">Compte</li>
                        <li class="mx-3">Compte</li>
                    </ul>
                </div>
                <div class="col-1 ">
                    <img src="image/1-removebg-preview.png " alt="" class="w-75 h-75">
                </div>
                <div class="col-3 ">
                    <input type="text" class="monSearch mx-5">
                </div>
            </div>
            <div class="row d-flex  ">
                <hr>
            </div>
    </header>

    <!-- Section Héro -->
    <section class="hero">
        <div class="container text-center">
            <h1>Bienvenue à la Bibliothèque</h1>
            <p>Découvrez un monde de connaissances</p>
            <div class="row">
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Rechercher un livre..." aria-label="Rechercher">
                    <button class="btn btn-outline-primary" type="submit">Rechercher</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Barre de recherche -->
    <section class="my-4">
        <div class="container">
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Rechercher un livre..." aria-label="Rechercher">
                <button class="btn btn-outline-primary" type="submit">Rechercher</button>
            </form>
        </div>
    </section>
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
                            <a class="btn btn-primary mt-3" href="categorie.php?indices=<?= $categorie['id_categorie'] ?>" >En savoir plus</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <!-- Ajoutez d'autres catégories ici -->
            </div>
        </div>
    </section>

    <!-- Livres populaires -->
    <section class="my-4">
        <div class="container">
            <h2 class="mb-4">Livres Populaires</h2>
            <div class="row  d-flex justify-content-between">
                <?php foreach ($popularBooks as $book) : ?>
                    <div class="col-md-2 mb-3">
                            <img src="image/<?= $book['images']; ?>" class="     monImage" alt="<?= $book['titre']; ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title mt-2"><?= $book['titre']; ?></h5>
                                <!-- <p class="card-text"><?= $book['descriptions']; ?></p> -->
                                <a class="btn btn-primary mt-3" href="detail.php?indice=<?= $book['id_livre'] ?>" >En savoir plus</a>
                            </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

  

    <!-- Nouveautés/ Livres populaires -->
    <section class="my-4">
        <div class="container ">
            <h2 class="mb-4">Nouveautés</h2>
            <div class="row d-flex justify-content-between">
             <?php foreach ($newBooks as $book) : ?>
                <div class="col-md-2 mb-3">
                            <img src="image/<?= $book['images']; ?>" class="     monImage" alt="<?= $book['titre']; ?>">
                            <div class="card-body text-center">
                                <h5 class="card-title mt-2"><?= $book['titre']; ?></h5>
                                <!-- <p class="card-text"><?= $book['descriptions']; ?></p> -->
                                <!-- <a href="#" class="btn btn-primary mt-3">En savoir plus</a> -->
                                <a class="btn btn-primary mt-3" href="detail.php?indice=<?= $book['id_livre'] ?>" >En savoir plus</a>
                            </div>
                    </div>
                <?php endforeach; ?>
                <!-- Ajoutez d'autres livres ici -->
            </div>
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

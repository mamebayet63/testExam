<?php
require_once("../bd.php");
$indices = null;
if (isset($_GET["indices"]) && is_numeric($_GET["indices"])) {
    $indices = $_GET["indices"];
} else {
    echo "Impossible d'accéder aux données avec cet identifiant.";
    die();
}

if ($pdo !== null) {
    try {
        // Sélection du livre en fonction de l'identifiant
        $livre = $pdo->query("SELECT * FROM livre WHERE categorie_id=$indices")->fetch(PDO::FETCH_ASSOC);
        $categorie_id = $livre['categorie_id'];

        // Sélection des livres appartenant à la même catégorie
        $similaires = $pdo->query("SELECT * FROM livre WHERE categorie_id=$categorie_id")->fetchAll();
        $monCategorie = $pdo->query("SELECT * FROM categorie WHERE id_categorie=$categorie_id")->fetchAll();
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
    <title>categorie</title>
    <link rel="stylesheet" href="indexT.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style personnalisé si nécessaire */
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- En-tête -->
        <header>
            <div class="row d-flex justify-content-between align-items-center mt-2">
                <div class="col-4">
                    <ul>
                        <li class="mx-3">Accueil</li>
                        <li class="mx-3">Livres</li>
                        <li class="mx-3">Compte</li>
                        <li class="mx-3">Contact</li>
                    </ul>
                </div>
                <div class="col-1">
                    <img src="image/1-removebg-preview.png" alt="" class="w-75 h-75">
                </div>
                <div class="col-3">
                    <input type="text" class="monSearch mx-5">
                </div>
            </div>
            <div class="row d-flex">
                <hr>
            </div>
        </header>

        <div class="container">
            <div class="row mt-3">
                <h1 class="text-center"><?php foreach ($monCategorie as $mon) : ?>
                    <div class="col-2">
                        <h1 class="mt-2 text-center"><?= $mon['nom']; ?></h1>
                    </div>
                <?php endforeach; ?></h1>
            </div>
            <div class="row mt-3">
                <?php foreach ($similaires as $sim) : ?>
                    <div class="col-2">
                        <img src="image/<?= $sim['images']; ?>" class="w-100" alt="">
                        <h5 class="mt-2 text-center"><?= $sim['titre']; ?></h5>
                        <a class="btn btn-secondary" href="detail.php?indice=<?= $sim['id_livre'] ?>">Voir Détails</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>

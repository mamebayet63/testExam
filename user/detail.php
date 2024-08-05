<?php
require_once("../bd.php");
$indice = null;
if (isset($_GET["indice"]) && is_numeric($_GET["indice"])) {
    $indice = $_GET["indice"];
} else {
    echo "Impossible d'accéder aux données avec cet identifiant.";
    die();
}

if ($pdo !== null) {
    try {
        $livre = $pdo->query("SELECT * FROM livre WHERE id_livre=$indice")->fetch(PDO::FETCH_ASSOC);
        $categorie_id = $livre['categorie_id'];
        $similaires = $pdo->query("SELECT * FROM livre WHERE categorie_id=$categorie_id AND id_livre != $indice LIMIT 5")->fetchAll();
        $monCategorie = $pdo->query("SELECT * FROM categorie WHERE id_categorie=$categorie_id")->fetchAll();
    } catch (PDOException $e) {
        echo "Requête échouée: " . $e->getMessage();
    }
} else {
    echo "Impossible d'exécuter la requête.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details livres</title>
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

            <div class="container">
                <div class="row mt-4 ">
                    <div class="col-3">
                        <img src="image/<?= $livre['images']; ?>" class="w-100" alt="">
                    </div>
                    <div class="col-7 mx-3">
                        <div class="row ">
                            <h1>Titre : <?= $livre['titre']; ?></h1>
                        </div>
                        <div class="row mt-2 ">
                            <h3>Catégorie : <?php foreach ($monCategorie as $mon) : ?>
                   
                        <?= $mon['nom']; ?>
                <?php endforeach; ?></h3>
                        </div>
                        <div class="row mt-3">
                            <p><?= $livre['descriptions']; ?></p>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                 <a class="btn btn-primary mt-3" href="../emprunt/emprunt.php?indice=<?= $livre['id_livre'] ?>" >Emprunter</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <h1 class="text-center">Livres Similaires</h1>
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

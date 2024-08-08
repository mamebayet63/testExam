<?php
require_once("../bd.php");

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../testConnexion/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
$indices = null;
if (isset($_GET["indices"]) && is_numeric($_GET["indices"])) {
    $indices = (int)$_GET["indices"];
} else {
    echo "Impossible d'accéder aux données avec cet identifiant.";
    die();
}

if ($pdo !== null) {
    try {
        // Sélection du livre en fonction de l'identifiant
        $stmt = $pdo->prepare("SELECT * FROM livre WHERE categorie_id = :indices");
        $stmt->execute(['indices' => $indices]);
        $livre = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($livre) {
            $categorie_id = $livre['categorie_id'];

            // Sélection des livres appartenant à la même catégorie
            $stmt_similaires = $pdo->prepare("SELECT * FROM livre WHERE categorie_id = :categorie_id");
            $stmt_similaires->execute(['categorie_id' => $categorie_id]);
            $similaires = $stmt_similaires->fetchAll();

            $stmt_categorie = $pdo->prepare("SELECT * FROM categorie WHERE id_categorie = :categorie_id");
            $stmt_categorie->execute(['categorie_id' => $categorie_id]);
            $monCategorie = $stmt_categorie->fetchAll();
        } else {
            echo "Aucun livre trouvé pour cet identifiant de catégorie.";
            die();
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
    <title>Catégorie</title>
    <link rel="stylesheet" href="indexT.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Style personnalisé si nécessaire */
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

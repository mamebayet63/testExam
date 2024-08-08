<?php
require_once "../bd.php";
$proprietaires = $pdo->query("SELECT * FROM categorie")->fetchAll();

// Nombre d'abonnés par page
$abonnesParPage = 6;
// Récupération de la page courante depuis l'URL (défaut : 1)
$pageCourante = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calcul de l'offset
$offset = ($pageCourante - 1) * $abonnesParPage;

// Initialisation des variables de recherche
$searchEmail = isset($_GET['search']) ? $_GET['search'] : '';

if ($pdo !== null) {
    try {
        // Requête pour récupérer les abonnés de la page courante avec recherche par email
        $query = $pdo->prepare("SELECT * FROM livre WHERE titre LIKE :titre LIMIT :offset, :limit");
        $query->bindValue(':titre', "%$searchEmail%", PDO::PARAM_STR);
        $query->bindValue(':offset', $offset, PDO::PARAM_INT);
        $query->bindValue(':limit', $abonnesParPage, PDO::PARAM_INT);
        $query->execute();
        $abonnes = $query->fetchAll();

        // Requête pour récupérer le nombre total d'abonnés
        $totalQuery = $pdo->prepare("SELECT COUNT(*) FROM livre WHERE titre LIKE :titre");
        $totalQuery->bindValue(':titre', "%$searchEmail%", PDO::PARAM_STR);
        $totalQuery->execute();
        $totalAbonnes = $totalQuery->fetchColumn();
        $nombrePages = ceil($totalAbonnes / $abonnesParPage);
    } catch (PDOException $e) {
        echo "Requete Echoué: " . $e->getMessage();
    }
} else {
    echo "Impossible d'executer la requete.";
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tableau des livres</title>
    <link rel="stylesheet" href="livre.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>

<div class="container-fluid">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Bibliotheque</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-primary" aria-current="page" href="Tlivre2.php">Livres</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="../abonne/Tabonne.php">abonnés</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link " aria-disabled="true" href="../emprunt/Temprunt.php">Emprunt</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
</div>
<body class="">
    <div class="container">
        <div class="d-flex gap-3 align-items-center mt-4">
            <a href="addLivre.php"><button class="btn btn-primary">Nouveau</button></a>
            <h2 class="mx-2">Listes des livres</h2>
        </div>
       <div class="row">
            <div class="col-6">
            <div class="mt-4">
            <form class="d-flex" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Recherche par titre" aria-label="Search" value="<?= htmlspecialchars($searchEmail) ?>">
                <button class="btn btn-outline-success" type="submit">Recherche</button>
            </form>
        </div>
            </div>
       </div>
        <?php if (!empty($abonnes)) : ?>
            <div class="row">
                <div class="col-10 mt-4">
                    <table class="table table-striped">
                        <tr>
                        <th scope="col">image</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Auteur</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">categorie</th>
                            <th scope="col">Disponible</th>
                            <th scope="col">Actions</th>
                        </tr>
                        <?php foreach ($abonnes as $k => $abonne) : ?>
                            <tr>
                                <td><img src="../user/image/<?= $abonne['images'] ?>" class="monImage" alt=""></td>
                                <td><?= $abonne['titre'] ?></td>
                                <td><?= $abonne['auteur'] ?></td>
                                <td><?= $abonne['isbn'] ?></td>
                                <td>
                                    <?php
                                    foreach ($proprietaires as  $proprietaire) {
                                        if ($abonne['categorie_id'] === $proprietaire['id_categorie']) {
                                            echo $proprietaire['nom'];
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?= $abonne['disponible'] ?></td>
                               
                                <td>
                                    <a href="modifLivre.php?indice=<?= $abonne['id_livre'] ?>" style="color:blue;text-decoration:none;font-size:20px"><i class="ri-edit-box-line"></i></a>
                                    <a style="color:red;text-decoration:none;font-size:20px;cursor:pointer" data-bs-toggle="modal" data-bs-target="#staticBackdrop<?= $k ?>"><i class="ri-delete-bin-7-fill"></i></a>
                                </td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop<?= $k ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel<?= $k ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h3 class="text-center">Confirmer la suspension</h3>
                                            <div class="d-flex gap-3 justify-content-center">
                                                <a href="deleteLivre.php?indice=<?= $abonne['id_livre'] ?>"><button class="btn bg-danger text-white">Suspendre</button></a>
                                                <button class="btn bg-primary text-white" data-bs-dismiss="modal">Annuler</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                    <?php if ($pageCourante > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $pageCourante - 1 ?>&search=<?= urlencode($searchEmail) ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $nombrePages; $i++): ?>
                        <li class="page-item <?= $i == $pageCourante ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($searchEmail) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($pageCourante < $nombrePages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $pageCourante + 1 ?>&search=<?= urlencode($searchEmail) ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php else : ?>
            <p class="mt-3">Aucun abonné trouvé...</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

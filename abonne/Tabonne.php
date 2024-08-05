<?php
require_once "../bd.php";

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
        $query = $pdo->prepare("SELECT * FROM abonne WHERE email LIKE :email LIMIT :offset, :limit");
        $query->bindValue(':email', "%$searchEmail%", PDO::PARAM_STR);
        $query->bindValue(':offset', $offset, PDO::PARAM_INT);
        $query->bindValue(':limit', $abonnesParPage, PDO::PARAM_INT);
        $query->execute();
        $abonnes = $query->fetchAll();

        // Requête pour récupérer le nombre total d'abonnés
        $totalQuery = $pdo->prepare("SELECT COUNT(*) FROM abonne WHERE email LIKE :email");
        $totalQuery->bindValue(':email', "%$searchEmail%", PDO::PARAM_STR);
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
    <title>Tableau des abonnés</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>

<body class="">
    <div class="container">
        <div class="d-flex gap-3 align-items-center mt-4">
            <a href="../forms/vehicule.php"><button class="btn btn-primary">Nouveau</button></a>
            <a href="../listes/listProprio.php"><button class="btn btn-primary">Retour</button></a>
            <h2 class="mx-2">Listes des abonnés</h2>
        </div>
       <div class="row">
            <div class="col-6">
            <div class="mt-4">
            <form class="d-flex" method="GET" action="">
                <input class="form-control me-2" type="search" name="search" placeholder="Recherche par email" aria-label="Search" value="<?= htmlspecialchars($searchEmail) ?>">
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
                            <th scope="col">Nom</th>
                            <th scope="col">Prenom</th>
                            <th scope="col">Email</th>
                            <th scope="col">Adresse</th>
                            <th scope="col">Téléphone</th>
                            <th scope="col">Statut</th>
                            <th scope="col">Actions</th>
                        </tr>
                        <?php foreach ($abonnes as $k => $abonne) : ?>
                            <tr>
                                <td><?= $abonne['nom'] ?></td>
                                <td><?= $abonne['prenom'] ?></td>
                                <td><?= $abonne['email'] ?></td>
                                <td><?= $abonne['adresse'] ?></td>
                                <td><?= $abonne['telephone'] ?></td>
                                <td class="<?= $abonne['statut'] == 'actif' ? 'status-actif' : 'status-suspendu' ?>">
                                    <?= $abonne['statut'] ?>
                                </td>
                                <td>
                                    <a href="../forms/formUpdate/TmodifVehicule.php?indice=<?= $abonne['id_abonnee'] ?>" style="color:blue;text-decoration:none;font-size:20px"><i class="ri-edit-box-line"></i></a>
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
                                                <a href="suspendre.php?indice=<?= $abonne['id_abonnee'] ?>"><button class="btn bg-danger text-white">Suspendre</button></a>
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

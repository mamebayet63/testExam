<?php
require_once "../bd.php";

// Mettre à jour l'état des emprunts
$today = date('Y-m-d'); // Date actuelle au format YYYY-MM-DD
$updateQuery = "UPDATE emprunt SET etat = 'échus' WHERE date_retour < :today AND etat <> 'échu'";

try {
    $stmt = $pdo->prepare($updateQuery);
    $stmt->bindValue(':today', $today);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Échec de la mise à jour: " . $e->getMessage();
}

// Récupérer les emprunts après mise à jour
$searchPrénom = isset($_GET['prénom']) ? $_GET['prénom'] : '';
$searchNom = isset($_GET['nom']) ? $_GET['nom'] : '';

$query = "SELECT emprunt.*, abonne.prenom, abonne.nom, livre.titre 
          FROM emprunt
          JOIN abonne ON emprunt.abonne_id = abonne.id_abonnee
          JOIN livre ON emprunt.livre_id = livre.id_livre
          WHERE 1=1";

if ($searchPrénom) {
    $query .= " AND abonne.prenom LIKE :prenom";
}

if ($searchNom) {
    $query .= " AND abonne.nom LIKE :nom";
}

try {
    $stmt = $pdo->prepare($query);

    if ($searchPrénom) {
        $stmt->bindValue(':prenom', "%$searchPrénom%");
    }

    if ($searchNom) {
        $stmt->bindValue(':nom', "%$searchNom%");
    }

    $stmt->execute();
    $emprunts = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Requête échouée: " . $e->getMessage();
}
?>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tableau des livres</title>
    <link rel="stylesheet" href="emprunt.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="">
    <div class="container">
        <div class="d-flex gap-3 align-items-center mt-4">
           
            <a href="../listes/listProprio.php"><button class="btn btn-primary">Retour</button></a>
            <h2 class="mx-2">Listes des Emprunts</h2>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="mt-4">
                    <form class="d-flex" method="GET" action="">
                        <input class="form-control me-2" type="text" name="prénom" placeholder="Prénom" aria-label="Prénom" value="<?= htmlspecialchars($searchPrénom) ?>">
                        <input class="form-control me-2" type="text" name="nom" placeholder="Nom" aria-label="Nom" value="<?= htmlspecialchars($searchNom) ?>">
                        <button class="btn btn-outline-success" type="submit">Recherche</button>
                    </form>
                </div>
            </div>
        </div>
        <?php if (!empty($emprunts)) : ?>
            <div class="row">
                <div class="col-10 mt-4">
                    <table class="table text-center">
                        <tr class="table-active" >
                            <th scope="col">Abonné</th>
                            <th scope="col">Livre</th>
                            <th scope="col">Date d'emprunt</th>
                            <th scope="col">Date de retour</th>
                            <th scope="col">État</th>
                            <th scope="col">Action</th>
                        </tr>
                        <?php foreach ($emprunts as $emprunt) : ?>
                            <tr>
                                <td><?= htmlspecialchars($emprunt['prenom']) . ' ' . htmlspecialchars($emprunt['nom']) ?></td>
                                <td><?= htmlspecialchars($emprunt['titre']) ?></td>
                                <td><?= htmlspecialchars($emprunt['date_emprunt']) ?></td>
                                <td><?= htmlspecialchars($emprunt['date_retour']) ?></td>
                                
                                <td class="d-flex justify-content-center">
                                <div class="row text-center
                                <?= 
                                    $emprunt['etat'] === 'en cours' ? 'etat-en-cours' :
                                    ($emprunt['etat'] === 'retourné' ? 'etat-termine' :
                                    ($emprunt['etat'] === 'echus' ? 'etat-echeu' : '')
                                ) ?>
                                ">
                                    <?= htmlspecialchars($emprunt['etat']) ?>
                                    </div>
                                </td>
                                
                                <td>
                                    <a href="updateEmprunt.php?indice=<?= htmlspecialchars($emprunt['id_emprunt']) ?>" class="btn btn-link">Terminé</a>
                                </td>

                            </tr>
                          
                            
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        <?php else : ?>
            <p class="mt-3">Aucun emprunt trouvé...</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

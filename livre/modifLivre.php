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
        $categories = $pdo->query("SELECT * FROM categorie")->fetchAll();
    } catch (PDOException $e) {
        echo "Requête échouée: " . $e->getMessage();
    }
} else {
    echo "Impossible d'exécuter la requête.";
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulaire Modif Livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h2>Modifier un livre</h2>
                <form action="Update.php" method="post">
                    <div class="form-group mb-2">
                        <input type="hidden" class="form-control" name="id_livre" value="<?= $indice ?>" />
                    </div>
                    <div class="form-group mb-2">
                        <label for="titre" class="mb-2">Titre</label>
                        <input type="text"  value="<?= $livre["titre"]; ?>" name="titre" placeholder="Entrer le titre" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="auteur" class="mb-2">Auteur</label>
                        <input type="text"  value="<?= $livre["auteur"]; ?>" name="auteur" placeholder="Entrer l'auteur" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="isbn" class="mb-2">ISBN</label>
                        <input type="text" value="<?= $livre["isbn"]; ?>" name="isbn" placeholder="Entrer l'ISBN" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="disponible" class="mb-2">Disponible</label>
                        <input type="text" value="<?= $livre["disponible"]; ?>" name="disponible" placeholder="Disponible" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="descriptions" class="mb-2">Description</label>
                        <input type="text" value="<?= $livre["descriptions"]; ?>" name="descriptions" placeholder="Description" class="form-control">
                    </div>
                    <div class="form-group mb-4">
                        <label for="categorie" class="mb-2">Catégorie</label>
                        <select name="categorie" class="form-select">
                            <option value="">Sélectionnez la catégorie</option>
                            <?php foreach ($categories as $categorie) : ?>
                                <?php if ($categorie['id_categorie'] === $livre['id_categorie']) : ?>
                                    <option value="<?= $categorie["id_categorie"] ?>" selected>
                                        <?= $categorie["nom"] ?>
                                    </option>
                                <?php else : ?>
                                    <option value="<?= $categorie["id_categorie"] ?>">
                                        <?= $categorie["nom"] ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
            <div class="col-6 mt-5">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

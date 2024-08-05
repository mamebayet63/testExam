<?php
require_once("../bd.php");

$indice = null;
$indice_abonne = 2;

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
        $emprunteur = $pdo->query("SELECT * FROM abonne WHERE id_abonnee=$indice_abonne")->fetch(PDO::FETCH_ASSOC);
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
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php if ($livre["disponible"] > 0 && $emprunteur["statut"] === "actif") : ?>
            <?php 
                extract($_POST);
                $insert_Data = 'INSERT INTO emprunt (abonnee_id,livre_id,date_emprunt,date_retour,etat)  
                VALUE (:abonnee_id,:auteur,:isbn,:categorie_id,:descs,:images)';
                $envoi_Data = $pdo->prepare($insert_Data);
                $envoi_Data->execute([
                    ':titre'=>$titre,
                    ':auteur'=>$auteur,
                    ':isbn'=>$isbn,
                    ':categorie_id'=>$categorie,
                    ':descs'=>$descs,
                    ':images'=>$images
                ]);
                
            ?>
        <?php else : ?>
            <p class="mt-3">
                <?php if ($livre["disponible"] == 0) : ?>
                    Le livre n'est pas disponible.
                <?php else : ?>
                    Vous êtes suspendu.
                <?php endif; ?>
            </p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

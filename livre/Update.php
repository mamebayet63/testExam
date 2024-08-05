<?php
require_once "../bd.php";
extract($_POST);

if ($pdo !== null) {
    try {
        $updateDate = "UPDATE livre SET 
                          titre = :titre, 
                          auteur = :auteur, 
                          isbn = :isbn, 
                          disponible = :disponible, 
                          descriptions = :descriptions, 
                          categorie_id = :categorie 
                       WHERE id_livre = :id";
        $requete = $pdo->prepare($updateDate);
        $requete->execute([
            ':titre' => $titre,
            ':auteur' => $auteur,
            ':isbn' => $isbn,
            ':disponible' => $disponible,
            ':descriptions' => $descriptions,
            ':categorie' => $categorie,
            ':id' => $id_livre // Assurez-vous que cette variable est bien définie dans $_POST
        ]);
        header("location: Tlivre2.php");
    } catch (PDOException $e) {
        echo "Requete Echoué: " . $e->getMessage();
    }
} else {
    echo "Impossible d'executer la requete.";
}
?>

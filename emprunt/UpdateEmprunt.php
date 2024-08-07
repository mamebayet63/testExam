<?php
require_once "../bd.php";

if (isset($_GET['indice'])) {
    $empruntId = $_GET['indice'];

    try {
        // Préparer la requête pour mettre à jour l'état
        $updateQuery = "UPDATE emprunt SET etat = 'retourné' WHERE id_emprunt = :id_emprunt";
        $stmt = $pdo->prepare($updateQuery);
        $stmt->bindValue(':id_emprunt', $empruntId);
        $stmt->execute();

        // Redirection vers la page principale après la mise à jour
        header('Location: Temprunt.php'); // Remplacez ce chemin par le chemin correct vers votre page
        exit;
    } catch (PDOException $e) {
        echo "Échec de la mise à jour: " . $e->getMessage();
    }
} else {
    echo "ID d'emprunt non spécifié.";
}
?>

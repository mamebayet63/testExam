<?php
require_once "../bd.php";

if (isset($_GET['indice'])) {
    $empruntId = $_GET['indice'];

    try {
        // Démarrer une transaction
        $pdo->beginTransaction();

        // Préparer la requête pour mettre à jour l'état de l'emprunt
        $updateEmpruntQuery = "UPDATE emprunt SET etat = 'retourné' WHERE id_emprunt = :id_emprunt";
        $stmt = $pdo->prepare($updateEmpruntQuery);
        $stmt->bindValue(':id_emprunt', $empruntId);
        $stmt->execute();

        // Récupérer les informations de l'emprunt pour savoir quel livre et quel abonné sont concernés
        $selectEmpruntQuery = "SELECT livre_id, abonne_id FROM emprunt WHERE id_emprunt = :id_emprunt";
        $stmt = $pdo->prepare($selectEmpruntQuery);
        $stmt->bindValue(':id_emprunt', $empruntId);
        $stmt->execute();
        $emprunt = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($emprunt) {
            // Mettre à jour le nombre de livres disponibles
            $updateLivreQuery = "UPDATE livre SET disponible = disponible + 1 WHERE id_livre = :livre_id";
            $stmt = $pdo->prepare($updateLivreQuery);
            $stmt->bindValue(':livre_id', $emprunt['livre_id']);
            $stmt->execute();

            // Mettre à jour le statut de l'abonné
            $updateAbonneQuery = "UPDATE abonne SET statut = 'actif' WHERE id_abonnee = :abonne_id";
            $stmt = $pdo->prepare($updateAbonneQuery);
            $stmt->bindValue(':abonne_id', $emprunt['abonne_id']);
            $stmt->execute();

            // Commit de la transaction
            $pdo->commit();

            // Redirection vers la page principale après la mise à jour
            header('Location: Temprunt.php'); // Remplacez ce chemin par le chemin correct vers votre page
            exit;
        } else {
            // Annulation de la transaction si l'emprunt n'est pas trouvé
            $pdo->rollBack();
            echo "Emprunt non trouvé.";
        }
    } catch (PDOException $e) {
        // Annulation de la transaction en cas d'erreur
        $pdo->rollBack();
        echo "Échec de la mise à jour: " . $e->getMessage();
    }
} else {
    echo "ID d'emprunt non spécifié.";
}
?>

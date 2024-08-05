<?php
require_once "../bd.php";

// Vérifie si les variables nécessaires sont présentes dans $_GET
if (isset($_GET['indice'])) {
    $id_abonnee = $_GET['indice'];
    $suspendu = 'suspendu';  // Définir le statut que tu veux attribuer

    if ($pdo !== null) {
        try {
            // Prépare la requête SQL
            $updateDate = "UPDATE abonne SET statut = :suspendu WHERE id_abonnee = :id_abonnee";
            $requete = $pdo->prepare($updateDate);

            // Exécute la requête avec les paramètres appropriés
            $requete->execute([
                ':suspendu' => $suspendu,
                ':id_abonnee' => $id_abonnee
            ]);

            // Redirige vers la page de liste des abonnés
            header("Location: Tabonne.php");
            exit();
        } catch (PDOException $e) {
            // Affiche une erreur si la requête échoue
            echo "Requête échouée: " . $e->getMessage();
        }
    } else {
        echo "Impossible d'exécuter la requête.";
    }
} else {
    echo "ID de l'abonné non spécifié.";
}

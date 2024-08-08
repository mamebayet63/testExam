<?php
require_once("../bd.php");
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../testConnexion/login.php");
    exit();
}

$indice = null;
$indice_abonne = $_SESSION['user_id'];

if (isset($_GET["indice"]) && is_numeric($_GET["indice"])) {
    $indice = $_GET["indice"];
} else {
    echo "Impossible d'accéder aux données avec cet identifiant.";
    die();
}

if ($pdo !== null) {
    try {
        $livre = $pdo->query("SELECT * FROM livre WHERE id_livre=$indice")->fetch(PDO::FETCH_ASSOC);
        $emprunteur = $pdo->query("SELECT * FROM abonne WHERE id_abonnee=$indice_abonne")->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Requête échouée: " . $e->getMessage();
        die();
    }
} else {
    echo "Impossible d'exécuter la requête.";
    die();
}

if ($livre["disponible"] > 0 && $emprunteur["statut"] === "actif") {
    $date_emprunt = date('Y-m-d');
    $date_retour = date('Y-m-d', strtotime($date_emprunt . ' + 14 days'));
    $etat = "en cours";

    try {
        // Début de la transaction
        $pdo->beginTransaction();

        // Insérer l'emprunt dans la table
        $insert_Data = 'INSERT INTO emprunt (abonne_id, livre_id, date_emprunt, date_retour, etat)  
                        VALUES (:abonne_id, :livre_id, :date_emprunt, :date_retour, :etat)';
        $envoi_Data = $pdo->prepare($insert_Data);
        $envoi_Data->execute([
            ':abonne_id' => $indice_abonne,
            ':livre_id' => $indice,
            ':date_emprunt' => $date_emprunt,
            ':date_retour' => $date_retour,
            ':etat' => $etat
        ]);

        // Mettre à jour le nombre de livres disponibles
        $update_livre = 'UPDATE livre SET disponible = disponible - 1 WHERE id_livre = :id_livre';
        $stmt = $pdo->prepare($update_livre);
        $stmt->execute([':id_livre' => $indice]);

        // Mettre à jour le statut de l'abonné
        $update_abonne = 'UPDATE abonne SET statut = "suspendu" WHERE id_abonnee = :id_abonnee';
        $stmt = $pdo->prepare($update_abonne);
        $stmt->execute([':id_abonnee' => $indice_abonne]);

        // Commit de la transaction
        $pdo->commit();

        echo "Emprunt ajouté avec succès. Votre statut a été mis à jour.";
    } catch (PDOException $e) {
        // Annulation de la transaction en cas d'erreur
        $pdo->rollBack();
        echo "Requête échouée: " . $e->getMessage();
    }
} else {
    if ($livre["disponible"] == 0) {
        echo "Le livre n'est pas disponible.";
    } else {
        echo "Vous êtes suspendu.";
    }
}
?>

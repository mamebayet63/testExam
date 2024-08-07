<?php
require_once "../bd.php";
extract($_POST);
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
if ($pdo !== null) {
    try {
        $updateDate = "UPDATE abonne SET 
                          nom = :nom, 
                          prenom = :prenom, 
                          email = :email, 
                          mot_de_passe = :mot_de_passe, 
                          adresse = :adresse, 
                          telephone = :telephone 
                       WHERE id_abonnee = :user_id";
        $requete = $pdo->prepare($updateDate);
        $requete->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mot_de_passe' => $mot_de_passe,
            ':adresse' => $adresse,
            ':telephone' => $telephone,
            ':user_id' => $user_id // Assurez-vous que ce paramètre correspond bien à celui utilisé dans la requête
        ]);
        header("location: ");
    } catch (PDOException $e) {
        echo "Requete Echoué: " . $e->getMessage();
    }
} else {
    echo "Impossible d'executer la requete.";
}
?>

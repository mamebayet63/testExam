<?php
require_once('../bd.php');
extract($_POST);

$insert_Data = 'INSERT INTO abonne (nom, prenom, email, telephone, mot_de_passe, adresse, profil)  
VALUES (:nom, :prenom, :email, :telephone, :mot_de_passe, :adresse, :profil)';
$envoi_Data = $pdo->prepare($insert_Data);

$envoi_Data->execute([
    ':nom' => $nom,
    ':prenom' => $prenom,
    ':email' => $email,
    ':telephone' => $telephone,
    ':mot_de_passe' => $mot_de_passe,
    ':adresse' => $adresse,
    ':profil' => $profil
]);

header("Location: ");
?>

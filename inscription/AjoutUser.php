<?php
    require_once('../bd.php');
    extract($_POST);
    $insert_Data = 'INSERT INTO abonne (nom,prenom,email,mot_de_passe,adresse,telephone)  
    VALUE (:nom,:prenom,:mail,:mot_de_passe,:adresse,:telephone)';
    $envoi_Data = $pdo->prepare($insert_Data);
    $envoi_Data->execute([
        ':nom'=>$nom,
        ':prenom'=>$prenom,
        ':mail'=>$mail,
        ':mot_de_passe'=>$mot_de_passe,
        ':adresse'=>$adresse,
        ':telephone'=>$telephone
    ]);
    
    header("");
?>
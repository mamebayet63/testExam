<?php
    require_once('../bd.php');
    extract($_POST);
    $insert_Data = 'INSERT INTO livre (titre,auteur,isbn,categorie_id,descriptions,images)  
    VALUE (:titre,:auteur,:isbn,:categorie_id,:descs,:images)';
    $envoi_Data = $pdo->prepare($insert_Data);
    $envoi_Data->execute([
        ':titre'=>$titre,
        ':auteur'=>$auteur,
        ':isbn'=>$isbn,
        ':categorie_id'=>$categorie,
        ':descs'=>$descs,
        ':images'=>$images
    ]);
    
    header("location: Tlivre2.php");
    ?>
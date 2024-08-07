<?php
require_once "../bd.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
if ($pdo !== null) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM abonne WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Requete Echoué: " . $e->getMessage();
    }
} else {
    echo "Impossible d'executer la requete.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profil</title>
    <link rel="stylesheet" href="indexT.css">
    <link rel="stylesheet" href="profil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div class="container-fluid">
<header>
            <div class="row d-flex justify-content-between align-items-center mt-2">
                <div class="col-4 ">
                    <ul>
                        <li class="mx-3">Accueil</li>
                        <li class="mx-3">Livres</li>
                        <li class="mx-3">Compte</li>
                        <li class="mx-3">Compte</li>
                    </ul>
                </div>
                <div class="col-1 ">
                    <img src="image/1-removebg-preview.png " alt="" class="w-75 h-75">
                </div>
                <div class="col-2 ">
                    <input type="text" class="monSearch mx-5 w-100">
                </div>
                <div class="col-1">
                    <a href="profil.php"><img src="image/<?= $user['profil'] ?>" alt=""></a>
                </div>
                
            </div>
            <div class="row d-flex  ">
                <hr>
            </div>
</header>

  
    <section class="section-1 ">
        <div class="section-1-container">
            <div class="section-1-right mt-5">
                <div class="section-1-right-container bg-primar my-5">
                    <div class="row w-100 d-flex justify-content-between ">
                        <div class="col-10">
                            <div class="row">
                            <div class="col-3">
                                <img class="profil-img w-100" src="image/<?= $user['profil'] ?>" alt="">
                            </div>
                            <div class="col-5">
                                <h2 class="fw-bold mt-3"><?= $user['prenom'] ?> <?= $user['nom'] ?></h2>
                                <span class="fw-bolder">email : <?= $user['email'] ?> <br></span>
                                <span class="fw-bolder">telephone : <?= $user['telephone'] ?> <br></span>
                                <span class="fw-bolder">adresse : <?= $user['adresse'] ?> <br></span>
                                <span class=" fw-bolder"> staut : 
                                <span  class=" fw-bolder <?= $user['statut'] == 'actif' ? 'status-actif' : 'status-suspendu' ?>">
                               <?= $user['statut'] ?></span>
                               </span>
                            </div>
                            </div>
                        </div>
                            <div class="col-1 ">
                            <a href="modifProfil.php"> <button type="button" class="btn btn-primary">modifier</button></a>
                            </div>
                    </div>
                       
                   
                   
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



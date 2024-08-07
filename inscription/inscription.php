<?php
session_start();
require_once("../bd.php");
if ($pdo !== null) {
    try {
        $proprietaires = $pdo->query("SELECT * FROM categorie")->fetchAll();
    } catch (PDOException $e) {
        echo "Requete Echoué: " . $e->getMessage();
    }
} else {
    echo "Impossible d'executer la requete.";
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formulaire Propriétaires</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
    </style>
    <link href="
https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.min.css
" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-black text-white" style="font-family: Poppins, sans-serif">
    <div class="container">
        <div class="row">
            <div class="col-10">
            <div class="container my-5 ">
            <h2 class="my-3 text-center">S'inscrire</h2>
        <form class="" action="AjoutUser.php" method="post">
            <div class="row  my-3">
                <div class="form-group col-md-6">
                    <label for="inputField1">nom</label>
                    <input type="text"  name="nom"  class="form-control" id="inputField1" placeholder="Nom">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputField2">prenom</label>
                    <input type="text"  name="prenom" class="form-control" id="inputField2" placeholder="Prenom">
                </div>
            </div>
            <div class="row my-3">
                <div class="form-group col-md-6">
                    <label for="inputField3">email</label>
                    <input type="text"  name="email" class="form-control" id="inputField3" placeholder="+221 77 777 77 77">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputField2">telephone</label>
                    <input type="text"  name="telephone" class="form-control" id="inputField2" placeholder="Prenom">
                </div>
            </div>
            <div class="row my-3">
                <div class="form-group col-md-6">
                    <label for="inputField3">mot de passe</label>
                    <input type="text" name="mot_de_passe" class="form-control" id="inputField3" placeholder="...">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputField3">Adresse</label>
                    <input type="text" name="adresse" class="form-control" id="inputField3" placeholder="...">
                </div>
            </div>
            <div class="row my-3">
                <div class="form-group col-md-12">
                    <label for="inputField3">Profil</label>
                    <input type="file"  name="profil" class="form-control" id="inputField3" placeholder="">
                </div>
            </div>
            <button type="submit" class="bn31">Soumettre</button>
        </form>
        </div>
            </div>
            <div class="col-6 mt-5">
                <?php if (!empty($_SESSION)) : ?>
                    <div class="alert alert-danger col-12" role="alert">
                        <h2>Erreur</h2>
                        <ul class="mt-4">
                            <?php if (isset($_SESSION['err_code']) && !empty($_SESSION['err_code'])) : ?>
                                <li><?= $_SESSION['err_code'] ?></li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['err_nom'])  && !empty($_SESSION['err_nom'])) : ?>
                                <li><?= $_SESSION['err_nom'] ?></li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['err_prenom'])  && !empty($_SESSION['err_prenom'])) : ?>
                                <li><?= $_SESSION['err_prenom'] ?></li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['err_tel']) && !empty($_SESSION['err_tel'])) : ?>
                                <li><?= $_SESSION['err_tel'] ?></li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['err_email'])  && !empty($_SESSION['err_email'])) : ?>
                                <li><?= $_SESSION['err_email'] ?></li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['err_conf_email'])  && !empty($_SESSION['err_conf_email'])) : ?>
                                <li> <?= $_SESSION['err_conf_email'] ?></li>
                            <?php endif; ?>
                            <?php
                            unset($_SESSION["err_code"]);
                            unset($_SESSION["err_nom"]);
                            unset($_SESSION["err_prenom"]);
                            unset($_SESSION["err_tel"]);
                            unset($_SESSION["err_email"]);
                            unset($_SESSION['err_conf_email'])
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/style.css">
    <title>S'inscrire</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Montserrat;
        }
    </style>
  
</head>
<body>
    <div class="container-fluid">
        <div class="row d-flex justify-content-between">
            <div class="col-6">
                <div class="container my-5">
                    <h2 class="my-3 text-center">S'inscrire</h2>
                    <form action="ajoutUser.php" method="post" onsubmit="return validateForm()">
                        <div class="row my-3">
                            <div class="form-group col-md-6">
                                <label for="inputField1">Nom</label>
                                <input type="text" name="nom" class="form-control" id="inputField1" placeholder="Nom" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputField2">Prénom</label>
                                <input type="text" name="prenom" class="form-control" id="inputField2" placeholder="Prénom" required>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="form-group col-md-6">
                                <label for="inputField3">Téléphone</label>
                                <input type="tel" name="telephone" class="form-control" id="inputField3" placeholder="+221 77 777 77 77" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputField4">Adresse</label>
                                <input type="text" name="adresse" class="form-control" id="inputField4" placeholder="Dakar" required>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="form-group col-md-6">
                                <label for="inputField5">Email</label>
                                <input type="email" name="email" class="form-control" id="inputField5" placeholder="exemple@gmail.com" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputField5">profil</label>
                                <input type="file" name="profil" class="form-control" id="inputField5" placeholder="exemple@gmail.com" required>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="form-group col-md-12">
                                <label for="inputField6">Mot de passe</label>
                                <input type="password" name="mot_de_passe" class="form-control" id="inputField6" placeholder="**********" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                    <span>ou <a href="../testConnexion/login.php">Se connecter</a></span>
                </div>
            </div>
            <div class="col-5 d-flex justify-content-center">
                <img src="../user/image/1-removebg-preview.png" class="w-75 h-75" alt="">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

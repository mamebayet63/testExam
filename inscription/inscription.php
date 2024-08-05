<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-3">
        <div class="form-container">
            <h2 class="text-center mb-4">Inscription</h2>
            <form id="registrationForm" method="post" action="AjoutUser.php">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullName">Nom </label>
                            <input type="text" class="form-control" id="fullName" name="nom" placeholder="John Doe" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullName">prenom</label>
                            <input type="text" class="form-control" id="fullName" name="prenom" placeholder="John Doe" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="mot_de_passe" placeholder="••••••••" required minlength="8">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="confirmPassword">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="••••••••" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone">Numéro de téléphone (Optionnel)</label>
                            <input type="tel" class="form-control" id="phone" name="telephone" placeholder="+33 6 12 34 56 78">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address">Adresse</label>
                            <input type="text" class="form-control" id="address" name="adresse" placeholder="123 rue Exemple, 75000 Paris" required>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birthDate">Date de naissance (Optionnel)</label>
                            <input type="date" class="form-control" id="birthDate" name="birthDate">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Adresse email</label>
                            <input type="email" class="form-control" id="email" name="mail" placeholder="johndoe@example.com" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success btn-block">S'inscrire</button>
                    </div>
                    <div class="col-md-3">
                        <button type="reset" class="btn btn-danger btn-block">Annuler</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="row d-flex justify-content-center">
        <div class="col-6">
        <div class="container mt-5">
        <div class="form-container ">
            <h2 class="text-center mb-4">Connexion</h2>
            <form id="loginForm" method="post" action="login.php">
                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@gmail.com" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="text" class="form-control" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="btn btn-success btn-block">Se connecter</button>
                <a href="register.html" class="btn btn-link btn-block">Créer un compte</a>
            </form>
        </div>
    </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
</body>
</html>

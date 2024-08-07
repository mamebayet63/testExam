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

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>modif profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h2>Modifier mon profil</h2>
                <form action="updateUser.php" method="post">
                    <div class="form-group mb-2">
                        <input type="hidden" class="form-control" name="user_id" value="<?= $user_id ?>" />
                    </div>
                    <div class="form-group mb-2">
                        <label for="titre" class="mb-2">nom</label>
                        <input type="text"  value="<?= $user["nom"]; ?>" name="nom" placeholder="Entrer votre nom" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="auteur" class="mb-2">prenom</label>
                        <input type="text"  value="<?= $user["prenom"]; ?>" name="prenom" placeholder="Entrer le prenom" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="isbn" class="mb-2">email</label>
                        <input type="text" value="<?= $user["email"]; ?>" name="email" placeholder="Entrer l'email" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="mot_de_passe" class="mb-2">mot_de_passe</label>
                        <input type="text" value="<?= $user["mot_de_passe"]; ?>" name="mot_de_passe" placeholder="mot_de_passe" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="adresse" class="mb-2">adresse</label>
                        <input type="text" value="<?= $user["adresse"]; ?>" name="adresse" placeholder="adresse" class="form-control">
                    </div>
                    <div class="form-group mb-2">
                        <label for="telephone" class="mb-2">telephone</label>
                        <input type="text" value="<?= $user["telephone"]; ?>" name="telephone" placeholder="telephone" class="form-control">
                    </div>
                   
                   
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
            <div class="col-6 mt-5">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<?php
session_start(); // Démarre la session

// Inclure le fichier de connexion à la base de données
require_once('../bd.php');
// Récupération des données du formulaire
$email = $_POST['email'];
$password = $_POST['password'];

try {
    // Préparer la requête SQL pour éviter les injections SQL
    $stmt = $pdo->prepare("SELECT id_abonnee, mot_de_passe FROM abonne WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Vérifier si l'utilisateur existe
    if ($stmt->rowCount() === 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $userId = $user['id_abonnee'];
        $hashedPassword = $user['mot_de_passe'];

        // Vérifier le mot de passe
        if (password_verify($password, $hashedPassword)) {
            // Authentifier l'utilisateur
            $_SESSION['user_id'] = $userId;
            $_SESSION['email'] = $email;
            header("Location: dashboard.php"); // Redirige vers la page d'accueil ou tableau de bord
            exit();
        } else {
            // Mot de passe incorrect
            $error = "Mot de passe incorrect.";
        }
    } else {
        // Email non trouvé
        $error = "Email non trouvé.";
    }
} catch (PDOException $e) {
    $error = "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur de Connexion</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
        <a href="login.html" class="btn btn-primary">Retour à la connexion</a>
    </div>
</body>
</html>

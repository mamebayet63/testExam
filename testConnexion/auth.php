<?php
require_once "../bd.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($pdo !== null) {
        try {
            // Préparer et exécuter la requête pour obtenir les informations de l'utilisateur
            $stmt = $pdo->prepare("SELECT * FROM abonne WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifier si l'utilisateur existe et si le mot de passe est correct
            if ($user && $password===$user['mot_de_passe']) {
                // Démarrer la session et stocker les informations de l'utilisateur
                $_SESSION['user_id'] = $user['id_abonnee'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // Rediriger l'utilisateur vers la bonne interface en fonction de son rôle
                if ($user['role'] == 'admin') {
                    header("Location: ../livre/Tlivre2.php");
                } else {
                    header("Location: ../user/index3.php");
                }
                exit();
            } else {
                // Rediriger vers la page de connexion avec un message d'erreur
                header("Location: login.php?error=Email ou mot de passe incorrect.");
                exit();
            }
        } catch (PDOException $e) {
            // Rediriger vers la page de connexion avec un message d'erreur en cas d'erreur de base de données
            header("Location: login.php?error=Erreur de connexion à la base de données.");
            exit();
        }
    } else {
        // Rediriger vers la page de connexion avec un message d'erreur si la connexion à la base de données échoue
        header("Location: login.php?error=Impossible de se connecter à la base de données.");
        exit();
    }
}
?>

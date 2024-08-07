<?php
session_start();
require_once("../bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($pdo !== null) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM abonne WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ($password===$user['mot_de_passe']) {
                    $_SESSION['user_id'] = $user['id_abonnee'];
                    $_SESSION['email'] = $user['email'];
                    header("Location: ../user/index3.php");
                    exit();
                } else {
                    header("Location: login.php?error=Mot de passe incorrect");
                    exit();
                }
            } else {
                header("Location: login.php?error=Email incorrect");
                exit();
            }
        } catch (PDOException $e) {
            echo "Requête échouée: " . $e->getMessage();
        }
    } else {
        echo "Impossible d'exécuter la requête.";
    }
} else {
    header("Location: login.php");
    exit();
}
?>

<?php
require_once "../bd.php";
if (!isset($_GET['indice']) || !is_numeric($_GET['indice'])) {
    echo "Veuillez dabord renseigner des donnes valides </br>";
    echo '<a href="../../listes/listProprio.php">Retour</a>';
    return;
}
$indice = $_GET['indice'];
if ($pdo !== null) {
    try {
        $stmt = $pdo->prepare("DELETE FROM livre WHERE id_livre = :id");
        $stmt->execute([':id' => $indice]);

        header("location: Tlivre2.php");
    } catch (PDOException $e) {
        echo "Requete Echoué: " . $e->getMessage();
    }
} else {
    echo "Impossible d'executer la requete.";
}

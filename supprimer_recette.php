<?php
    require_once('templates/base.php');

if (isset($_GET['id'])) {
    $recette_id = $_GET['id'];
    $user_id = $_SESSION['user']['id'];

    // Vérifier si l'utilisateur est bien le propriétaire de la recette
    $query = "SELECT * FROM recipes WHERE id = :id AND user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $recette_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Suppression de la recette
        $delete_query = "DELETE FROM recipes WHERE id = :id";
        $delete_stmt = $pdo->prepare($delete_query);
        $delete_stmt->bindParam(':id', $recette_id, PDO::PARAM_INT);
        $delete_stmt->execute();
        header("Location: mesRecettes.php"); // Rediriger vers "Mes recettes"
        exit();
    } else {
        echo "Erreur : Vous ne pouvez pas supprimer cette recette.";
    }
} else {
    echo "Erreur : Aucune recette spécifiée.";
}
?>

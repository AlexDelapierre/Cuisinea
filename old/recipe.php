<?php
 
   //Requête SQL avec PDO pour récupérer une recette en fonction de l'ID 
  function getRecipeById(PDO $pdo, int $id) {
    $query = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch();
  }

  // fonction pour chemin vers image par défaut si pas d'image présente pour la recette récupéré en base de données
  function getRecipeImage(string|null $image) {
    if ($image === null ) {
      return _ASSETS_IMG_PATH_.'recipe_default.jpg';
    } else {
      return _RECIPES_IMG_PATH_.$image;
    };
  }

  //Requête SQL avec PDO pour récupérer toutes les recettes ordonnées par id dans l'ordre descendant
  function getRecipes(PDO $pdo, int $limit = null) {
    $sql = 'SELECT * FROM recipes ORDER BY id DESC';
    
    if($limit) {
      $sql .= ' LIMIT :limit';
    }

    $query = $pdo->prepare($sql);

    if($limit) {
      $query->bindParam(':limit', $limit, PDO::PARAM_INT);
    }

    $query->execute();
    return $query->fetchAll(); 
  }

  function getRecipesWithPagination(PDO $pdo, $limit = 6, $offset = 0) {
    $sql = 'SELECT * FROM recipes ORDER BY id DESC LIMIT :limit OFFSET :offset';
    $query = $pdo->prepare($sql);
    $query->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
    $query->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(); 
  }

  function getTotalRecipes($pdo) {
    $query = $pdo->query('SELECT COUNT(*) FROM recipes');
    return (int) $query->fetchColumn();
  }

  // Requête SQL pour ajouter une recette
  function saveRecipe(PDO $pdo, int $user_id, int $category, string $title, string $description, string $ingredients, string $instructions, string|null $image) {
    $sql = "INSERT INTO `recipes` (`user_id`, `category_id`, `title`, `description`, `ingredients`, `instructions`, `image`) VALUES (:user_id, :category_id, :title, :description, :ingredients, :instructions, :image);";
    $query = $pdo->prepare($sql);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindParam(':category_id', $category, PDO::PARAM_INT);
    $query->bindParam(':title', $title, PDO::PARAM_STR);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':ingredients', $ingredients, PDO::PARAM_STR);
    $query->bindParam(':instructions', $instructions, PDO::PARAM_STR);
    $query->bindParam(':image', $image, PDO::PARAM_STR);
    return $query->execute();
  } 

  // Requête SQL pour modifier une recette
  function updateRecipe(PDO $pdo, int $recipe_id, int $user_id, int $category_id, string $title, string $description, string $ingredients, string $instructions, string|null $image) {
    // Préparer la requête SQL pour mettre à jour la recette
    $sql = "UPDATE `recipes` SET 
            `category_id` = :category_id, 
            `title` = :title, 
            `description` = :description, 
            `ingredients` = :ingredients, 
            `instructions` = :instructions, 
            `image` = :image
            WHERE `id` = :id AND `user_id` = :user_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $recipe_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':ingredients', $ingredients, PDO::PARAM_STR);
    $stmt->bindParam(':instructions', $instructions, PDO::PARAM_STR);
    $stmt->bindParam(':image', $image, PDO::PARAM_STR);
    return $stmt->execute();
}

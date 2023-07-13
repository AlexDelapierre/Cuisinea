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
<?php 

  // fonction pour chemin vers image par défaut si pas d'image présente pour la recette récupéré en base de données
  function getRecipeImage(string|null $image) {
    if ($image === null ) {
      return _ASSETS_IMG_PATH_.'recipe_default.jpg';
    } else {
      return _RECIPES_IMG_PATH_.$image;
    };
  }
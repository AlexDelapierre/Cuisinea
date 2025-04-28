<?php
  // 1. Affichage des erreurs pour le développement
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  // 2. Définition des constantes
  define('_RECIPES_IMG_PATH_', 'uploads/recipes/'); 
  define('_ASSETS_IMG_PATH_', 'assets/images/'); 
  define('_HOME_RECIPES_LIMIT_', 3); 
  define('_RECIPES_PAGE_RECIPES_LIMIT_', 6); 

  // 3. Menu principal
  $mainMenu = [
    'index.php' => 'Accueil',
    'recettes.php' =>'Nos recettes',
    'ajout_modification_recette.php' => 'Ajout/modif recette'
   ];
  
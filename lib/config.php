<?php
  // 1. Gestion de l'affichage des erreurs selon l'environnement

  // Détecter si on est en local (localhost ou 127.0.0.1)
  $isLocal = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1']);

  if ($isLocal) {
      ini_set('display_errors', 1);
      error_reporting(E_ALL);
  } else {
      ini_set('display_errors', 0);
      error_reporting(0);
  }

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
  
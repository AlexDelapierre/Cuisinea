<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use App\Service\FileUploader;
use App\Utils\Slugify;

class RecetteController
{
  private $pdo;
  private $recetteRepository;
  private $fileUploader;

  public function __construct(\PDO $pdo)
  {
      $this->pdo = $pdo;
      $this->recetteRepository = new RecetteRepository($pdo);
      $this->fileUploader = new FileUploader();
  }

  public function add(): void
  {
      $recipe = [
          'title' => '',
          'description' => '',
          'ingredients' => '',
          'instructions' => '',
          'category_id' => '',
      ];

      $categories = getCategories($this->pdo);
      $errors = [];
      $messages = [];

      if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveRecipe'])) {
          $fileName = null;

          if (!empty($_FILES['file']['tmp_name'])) {
              $checkImage = getimagesize($_FILES['file']['tmp_name']);
              if ($checkImage !== false) {
                  $slugify = new Slugify();
                  $fileName = uniqid() . '-' . $slugify->generate($_FILES['file']['name']);
                  $this->fileUploader->upload($_FILES['file']['tmp_name'], $fileName);
              } else {
                  $errors[] = 'Le fichier doit être une image';
              }
          }

          if (empty($errors)) {
              $saved = $this->recetteRepository->save(
                  $_SESSION['user']['id'],
                  $_POST['category'],
                  $_POST['title'],
                  $_POST['description'],
                  $_POST['ingredients'],
                  $_POST['instructions'],
                  $fileName
              );

              if ($saved) {
                  header('Location: /mes-recettes');
                  exit();
              } else {
                  $errors[] = 'La recette n\'a pas été enregistrée';
              }
          }

          // Réinjecter les données saisies en cas d’erreur
          $recipe = [
              'title' => $_POST['title'] ?? '',
              'description' => $_POST['description'] ?? '',
              'ingredients' => $_POST['ingredients'] ?? '',
              'instructions' => $_POST['instructions'] ?? '',
              'category_id' => $_POST['category'] ?? '',
          ];
      }

      require_once __DIR__ . '/../../templates/recette/add.php';
  }
}

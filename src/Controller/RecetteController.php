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

    public function edit(int $id): void
    {
        // Vérifier que l'utilisateur est le propriétaire de la recette
        $recipe = $this->recetteRepository->find($id);

        if (!$recipe || $recipe['user_id'] !== $_SESSION['user']['id']) {
            // Si la recette n'existe pas ou si l'utilisateur n'est pas le propriétaire, rediriger
            header('Location: /mes-recettes');
            exit();
        }

        // Récupérer les catégories
        $categories = getCategories($this->pdo);
        
        $errors = [];
        $messages = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveRecipe'])) {
            $fileName = $recipe['image']; // On garde l'image existante par défaut

            // Traitement du fichier uploadé
            if (!empty($_FILES['file']['tmp_name'])) {
                $checkImage = getimagesize($_FILES['file']['tmp_name']);
                if ($checkImage !== false) {
                    // Créer un nom de fichier unique
                    $slugify = new Slugify();
                    $fileName = uniqid() . '-' . $slugify->generate($_FILES['file']['name']);
                    // Déplacer le fichier vers le dossier approprié
                    $this->fileUploader->upload($_FILES['file']['tmp_name'], $fileName);
                } else {
                    $errors[] = 'Le fichier doit être une image';
                }
            }

            // Si aucune erreur, mettre à jour la recette
            if (empty($errors)) {
                $updated = $this->recetteRepository->update(
                    $id,
                    $_SESSION['user']['id'],
                    $_POST['category'],
                    $_POST['title'],
                    $_POST['description'],
                    $_POST['ingredients'],
                    $_POST['instructions'],
                    $fileName
                );

                if ($updated) {
                    $messages[] = 'La recette a bien été modifiée';
                    header('Location: /mes-recettes');
                    exit();
                } else {
                    $errors[] = 'La recette n\'a pas été modifiée';
                }
            } else {
                // Réinjecter les données en cas d'erreurs
                $recipe = [
                    'id' => $id,
                    'title' => $_POST['title'] ?? $recipe['title'],
                    'description' => $_POST['description'] ?? $recipe['description'],
                    'ingredients' => $_POST['ingredients'] ?? $recipe['ingredients'],
                    'instructions' => $_POST['instructions'] ?? $recipe['instructions'],
                    'category_id' => $_POST['category'] ?? $recipe['category_id'],
                    'image' => $fileName,
                ];
            }
        }

        // Affichage de la page de modification
        require_once __DIR__ . '/../../templates/recette/edit.php';
    }

    public function delete(): void
    {
        // Vérifier si un ID de recette est passé en GET
        if (isset($_GET['id'])) {
            $recette_id = $_GET['id'];
            $user_id = $_SESSION['user']['id'];

            // Vérifier si l'utilisateur est bien le propriétaire de la recette
            $query = "SELECT * FROM recipes WHERE id = :id AND user_id = :user_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $recette_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // Suppression de la recette
                $delete_query = "DELETE FROM recipes WHERE id = :id";
                $delete_stmt = $this->pdo->prepare($delete_query);
                $delete_stmt->bindParam(':id', $recette_id, PDO::PARAM_INT);
                $delete_stmt->execute();

                // Rediriger vers "Mes recettes"
                header("Location: /mes-recettes");
                exit();
            } else {
                // Si l'utilisateur n'est pas propriétaire de la recette
                $_SESSION['errors'][] = "Erreur : Vous ne pouvez pas supprimer cette recette.";
            }
        } else {
            $_SESSION['errors'][] = "Erreur : Aucune recette spécifiée.";
        }

        // Si erreur, rediriger vers la page "Mes recettes" avec un message d'erreur
        header("Location: /mes-recettes");
        exit();
    }

}

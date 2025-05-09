<?php

namespace App\Repository;

use PDO;

class RecetteRepository
{
  private $pdo;

  public function __construct(PDO $pdo)
  {
      $this->pdo = $pdo;
  }

  /**
   * Sauvegarder une nouvelle recette dans la base de données
   *
   * @param int $userId
   * @param int $categoryId
   * @param string $title
   * @param string $description
   * @param string $ingredients
   * @param string $instructions
   * @param string|null $image
   * @return bool
   */
  public function save(int $userId, int $categoryId, string $title, string $description, string $ingredients, string $instructions, ?string $image): bool
  {
      $query = "INSERT INTO recipes (user_id, category_id, title, description, ingredients, instructions, image, created_at) 
                VALUES (:user_id, :category_id, :title, :description, :ingredients, :instructions, :image, NOW())";
      
      $stmt = $this->pdo->prepare($query);
      $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
      $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
      $stmt->bindParam(':description', $description, PDO::PARAM_STR);
      $stmt->bindParam(':ingredients', $ingredients, PDO::PARAM_STR);
      $stmt->bindParam(':instructions', $instructions, PDO::PARAM_STR);
      $stmt->bindParam(':image', $image, PDO::PARAM_STR);

      return $stmt->execute();
  }

  /**
   * Récupérer toutes les recettes d'un utilisateur
   *
   * @param int $userId
   * @return array
   */
  public function getAllByUser(int $userId): array
  {
      $query = "SELECT * FROM recipes WHERE user_id = :user_id ORDER BY created_at DESC";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Récupérer une recette par son ID
   *
   * @param int $recetteId
   * @return array|null
   */
  public function getById(int $recetteId): ?array
  {
      $query = "SELECT * FROM recipes WHERE id = :id";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindParam(':id', $recetteId, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  /**
   * Mettre à jour une recette
   *
   * @param int $recetteId
   * @param int $userId
   * @param int $categoryId
   * @param string $title
   * @param string $description
   * @param string $ingredients
   * @param string $instructions
   * @param string $image
   * @return bool
   */
  public function update(int $recetteId, int $userId, int $categoryId, string $title, string $description, string $ingredients, string $instructions, string $image): bool
  {
      $query = "UPDATE recipes 
                SET category_id = :category_id, title = :title, description = :description, ingredients = :ingredients, instructions = :instructions, image = :image
                WHERE id = :id AND user_id = :user_id";
      
      $stmt = $this->pdo->prepare($query);
      $stmt->bindParam(':id', $recetteId, PDO::PARAM_INT);
      $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
      $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
      $stmt->bindParam(':description', $description, PDO::PARAM_STR);
      $stmt->bindParam(':ingredients', $ingredients, PDO::PARAM_STR);
      $stmt->bindParam(':instructions', $instructions, PDO::PARAM_STR);
      $stmt->bindParam(':image', $image, PDO::PARAM_STR);

      return $stmt->execute();
  }

  /**
   * Supprimer une recette
   *
   * @param int $recetteId
   * @param int $userId
   * @return bool
   */
  public function delete(int $recetteId, int $userId): bool
  {
      $query = "DELETE FROM recipes WHERE id = :id AND user_id = :user_id";
      $stmt = $this->pdo->prepare($query);
      $stmt->bindParam(':id', $recetteId, PDO::PARAM_INT);
      $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
      
      return $stmt->execute();
  }
}

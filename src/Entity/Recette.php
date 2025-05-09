<?php

namespace App\Entity;

class Recette
{
  private ?int $id = null;
  private int $userId;
  private int $categoryId;
  private string $title;
  private string $description;
  private string $ingredients;
  private string $instructions;
  private ?string $image = null;
  private ?\DateTime $createdAt = null;

  public function getId(): ?int
  {
      return $this->id;
  }

  public function setId(int $id): self
  {
      $this->id = $id;
      return $this;
  }

  public function getUserId(): int
  {
      return $this->userId;
  }

  public function setUserId(int $userId): self
  {
      $this->userId = $userId;
      return $this;
  }

  public function getCategoryId(): int
  {
      return $this->categoryId;
  }

  public function setCategoryId(int $categoryId): self
  {
      $this->categoryId = $categoryId;
      return $this;
  }

  public function getTitle(): string
  {
      return $this->title;
  }

  public function setTitle(string $title): self
  {
      $this->title = $title;
      return $this;
  }

  public function getDescription(): string
  {
      return $this->description;
  }

  public function setDescription(string $description): self
  {
      $this->description = $description;
      return $this;
  }

  public function getIngredients(): string
  {
      return $this->ingredients;
  }

  public function setIngredients(string $ingredients): self
  {
      $this->ingredients = $ingredients;
      return $this;
  }

  public function getInstructions(): string
  {
      return $this->instructions;
  }

  public function setInstructions(string $instructions): self
  {
      $this->instructions = $instructions;
      return $this;
  }

  public function getImage(): ?string
  {
      return $this->image;
  }

  public function setImage(?string $image): self
  {
      $this->image = $image;
      return $this;
  }

  public function getCreatedAt(): ?\DateTime
  {
      return $this->createdAt;
  }

  public function setCreatedAt(?\DateTime $createdAt): self
  {
      $this->createdAt = $createdAt;
      return $this;
  }
}

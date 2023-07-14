<?php

//Requête SQL avec PDO pour récupérer toutes les catégories 
  function getCategories(PDO $pdo) {
    $sql = 'SELECT * FROM categories';   
    $query = $pdo->prepare($sql);
    $query->execute();
    return $query->fetchAll(); 
  }
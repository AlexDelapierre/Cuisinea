<?php
  require_once('templates/header.php');
  require_once('lib/recipe.php');

  //Requête SQL avec PDO pour récupérer une recette en fonction de l'ID 
  $pdo = new PDO('mysql:dbname=cuisinea;host=localhost;charset=utf8mb4', 'root', '');
  $id = $_GET['id'];

  $query = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
  $query->bindParam(':id', $id, PDO::PARAM_INT);
  $query->execute();
  $recipe = $query->fetch();

  // Image par défaut si pas d'image présente pour la recette récupéré en base de données
  if ($recipe['image'] === null ) {
    $imagePath = _ASSETS_IMG_PATH_.'recipe_default.jpg';
  } else {
    $imagePath = _RECIPES_IMG_PATH_.$recipe['image'];
  };
  
?>

<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
  <div class="col-10 col-sm-8 col-lg-6">
    <img src="<?= $imagePath; ?>" class="d-block mx-lg-auto img-fluid" alt="<?= $recipe['title']; ?>" width="700"
      height="500" loading="lazy">
  </div>
  <div class="col-lg-6">
    <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3"><?= $recipe['title']; ?></h1>
    <p class="lead"><?= $recipe['description']; ?></p>

  </div>
</div>

<?php
  require_once('templates/footer.php');
?>
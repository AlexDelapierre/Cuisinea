<?php
  require_once('templates/base.php');
  require_once('lib/tools.php');
  require_once('lib/recipe.php');
  require_once('templates/header.php');

  // (int) sert à caster la variable (pour la transformer automatiquement en int).
  $id = (int)$_GET['id'];

  //Requête SQL avec PDO pour récupérer une recette en fonction de l'ID 
  $recipe = getRecipeById($pdo, $id);

  // Condition pour vérifier que la requête fetch renvoie true, donc que la recette existe bien  
  if ($recipe) {
    $ingredients = linesToArray($recipe['ingredients']);
    $instructions = linesToArray($recipe['instructions']);
  
?>

<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
  <div class="col-10 col-sm-8 col-lg-6">
    <img src="<?= getRecipeImage($recipe['image']); ?>" class="d-block mx-lg-auto img-fluid"
      alt="<?= $recipe['title']; ?>" width="700" height="500" loading="lazy">
  </div>
  <div class="col-lg-6">
    <h1 class="display-5 fw-bold lh-1 mb-3"><?= $recipe['title']; ?></h1>
    <p class="lead"><?= $recipe['description']; ?></p>
  </div>
</div>

<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
  <h2>Ingrédients</h2>
  <ul class="list-group">
    <?php foreach ($ingredients as $key => $ingredient) { ?>
    <li class="list-group-item"><?=$ingredient;?></li>
    <?php } ?>
  </ul>
</div>

<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
  <h2>Instructions</h2>
  <ol class="list-group list-group-numbered">
    <?php foreach ($instructions as $key => $instruction) { ?>
    <li class="list-group-item"><?=$instruction;?></li>
    <?php } ?>
  </ol>
</div>

<?php } else { ?>
<div class="row text-center">
  <h1>Recette introuvable</h1>
</div>
<?php  } ?>

<?php
  require_once('templates/footer.php');
?>
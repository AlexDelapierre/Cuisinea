<?php
  require_once('templates/base.php');
  require_once('templates/header.php');
  require_once('lib/recipe.php');

  $recipes = getRecipes($pdo, _HOME_RECIPES_LIMIT_);

  if(isset($_SESSION['user']['message'])){
    // echo $_SESSION['user']['message'];
    $messages[] = $_SESSION['user']['message'];

     foreach ($messages as $message) { ?>
      <div class="alert alert-success">
        <?=$message;?>
      </div>
      <?php } 
  }   
?>

<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
  <div class="col-10 col-sm-8 col-lg-6">
    <img src="assets/images/logo-cuisinea.jpg" class="d-block mx-lg-auto img-fluid" alt="Logo Cuisinea" width="350"
      loading="lazy">
  </div>
  <div class="col-lg-6">
    <h1 class="display-5 fw-bold lh-1 mb-3">Cuisinea - Recettes faciles</h1>
    <p class="lead">Découvrez notre site de recettes de cuisine, une source d'inspiration pour tous les
      passionnés de gastronomie. Explorez une collection diversifiée de recettes délicieuses, des plats traditionnels
      aux créations innovantes, accompagnées d'instructions claires et faciles à suivre. Que vous soyez novice en
      cuisine ou chef expérimenté, notre site est là pour vous guider vers des expériences gustatives exceptionnelles.
    </p>
    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
      <a href="recettes.php" class="btn btn-primary">Voir nos recettes</a>
    </div>
  </div>
</div>

<div class="row">

  <?php foreach ($recipes as $key => $recipe) { 
    include('templates/recipe_partial.php');
   }; ?>

</div>

<?php
  require_once('templates/footer.php');
?>
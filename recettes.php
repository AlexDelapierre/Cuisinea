<?php
  define('_RECIPES_IMG_PATH_', 'uploads/recipes/'); 
  
  $recipes = [
    ['title' => 'Mousse au chocolat', 'description' => 'Mousse quick example text to build on the card title and make up the bulk of the card\'s content.', 'image' => '1-chocolate-au-mousse.jpg'],
    ['title' => 'Gratin dauphinois', 'description' => 'Gratin quick example text to build on the card title and make up the bulk of the card\'s content.', 'image' => '2-gratin-dauphinois.jpg'],
    ['title' => 'Salade de chèvre', 'description' => 'Salade quick example text to build on the card title and make up the bulk of the card\'s content.', 'image' => '3-salade.jpg'],    
  ];

  require_once('templates/header.php');
?>

<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
  <h1>Liste des recettes</h1>
</div>

<div class="row">

  <?php foreach ($recipes as $key => $recipe) { 
    include('templates/recipe_partial.php');
   }; ?>

</div>

<?php
  require_once('templates/footer.php');
?>
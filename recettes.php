<?php
  require_once('templates/base.php');
  require_once('lib/recipe.php');
  require_once('templates/header.php');

  // Nombre de recettes par page
  // $recipesPerPage = _RECIPES_PAGE_RECIPES_LIMIT_;
  $recipesPerPage = 6;

  // Quelle est la page actuelle ?
  $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
  if ($currentPage < 1) {
    $currentPage = 1;
  }
  
  // Calculer l'offset
  $offset = ($currentPage - 1) * $recipesPerPage;
  
  // Récupérer les recettes pour la page en cours
  $recipes = getRecipesWithPagination($pdo, $recipesPerPage, $offset);
  
  // Récupérer le nombre total de recettes pour savoir combien de pages il faut
  $totalRecipes = getTotalRecipes($pdo);
  $totalPages = ceil($totalRecipes / $recipesPerPage);

  // Calculer les numéros de pages à afficher (max 10 pages)
  $startPage = max(1, $currentPage - 5); // Commencer 5 pages avant, mais ne pas descendre sous 1
  $endPage = min($totalPages, $currentPage + 4); // Finir 5 pages après, mais ne pas dépasser le nombre total de pages
  
  // $recipes = getRecipes($pdo);
?>

<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
  <h1>Liste des recettes</h1>
</div>

<div class="row">
  <?php foreach ($recipes as $key => $recipe) { 
    include('templates/recipe_partial.php');
   }; ?>
</div>

Pagination

<?php
/*
<div style="margin-top: 20px; display: flex; justify-content: center;">
  <?php if ($currentPage > 1): ?>
    <a href="recettes.php?page=<?= $currentPage - 1 ?>">« Page précédente</a>
  <?php endif; ?>

  <?php if ($currentPage < $totalPages): ?>
    <a href="recettes.php?page=<?= $currentPage + 1 ?>" style="margin-left: 10px;">Page suivante »</a>
  <?php endif; ?>
</div>
*/
?>


<div style="margin-top: 20px; display: flex; justify-content: center;">
  <?php if ($currentPage > 1): ?>
    <a href="recettes.php?page=<?= $currentPage - 1 ?>" class="pagination-link">«</a>
  <?php endif; ?>
  <?php  
    // Affichage des numéros de pages
    for ($page = $startPage; $page <= $endPage; $page++): ?>
      <a href="recettes.php?page=<?= $page ?>" class="pagination-link" style="<?= $page == $currentPage ? 'font-weight: bold;' : '' ?>">
        <?= $page ?>
      </a>
  <?php endfor; ?>
  <?php if ($currentPage < $totalPages): ?>
    <a href="recettes.php?page=<?= $currentPage + 1 ?>" class="pagination-link">»</a>
  <?php endif; ?>

  <?php
  /*
  <?php if ($currentPage < $totalPages): ?>
      <a href="recettes.php?page=<?= $currentPage + 1 ?>" style="margin-left: 10px;">Suivante »</a>
      <a href="recettes.php?page=<?= $totalPages ?>" style="margin-left: 10px;">Dernière »</a>
    <?php endif; ?>
  */
  ?>

</div>

<?php
  require_once('templates/footer.php');
?>
<div class="col-12 col-md-4 my-2">
  <div class="card">
    <img src="<?=getRecipeImage($recipe['image']); ?>" class="card-img-top" alt="<?= $recipe['title']; ?>">
    <div class="card-body">
      <h2 class="card-title"><?= $recipe['title']; ?></h2>
      <p class="card-text"><?= $recipe['description']; ?></p>
      <div class="card-buttons">
        <a href="recette.php?id=<?= $recipe['id']; ?>" class="btn btn-primary">Voir la recette</a>
      </div>
    </div>
  </div>
</div>
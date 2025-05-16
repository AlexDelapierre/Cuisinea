<?php
  require_once('templates/base.php');
  require_once('lib/tools.php');
  require_once('lib/recipe.php');
  require_once('lib/category.php');

  if (isset($_GET['id'])) {
    $recette_id = $_GET['id'];
    $user_id = $_SESSION['user']['id'];

    // Vérifier si l'utilisateur est bien le propriétaire de la recette
    $query = "SELECT * FROM recipes WHERE id = :id AND user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $recette_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    // Récupérer le résultat sous forme de tableau
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si des résultats ont été trouvés
    if ($result) {
      $recipe = [
          'id' => $result['id'],
          'title' => $result['title'],
          'description' => $result['description'],
          'ingredients' => $result['ingredients'],
          'instructions' => $result['instructions'],
          'category_id' => $result['category_id'],
          'image' => $result['image'],  // Garder l'image existante si aucune nouvelle image n'est uploadée
      ];
    }
  } else {
      echo "Aucune recette trouvée pour cet utilisateur.";
  }

  $categories = getCategories($pdo);

  if(isset($_POST['saveRecipe'])) {
    $fileName = $recipe['image']; // On garde l'image existante par défaut

    //Si un fichier à été envoyé
    if(isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] != '') {
      // La méthode getImagesize va retourner false si le fichier n'est pas une image
      $checkImage = getimagesize($_FILES['file']['tmp_name']);
      if ($checkImage !== false) {
        // On crée un nom de fichier unique grâce à la fonction php uniqid() et on nettoie le nom du fichier avec slugify()
        $fileName = uniqid().'-'.slugify($_FILES['file']['name']);

        // On déplace le fichier du dossier temporaire vers le dossier upload/recipes 
        move_uploaded_file($_FILES['file']['tmp_name'], _RECIPES_IMG_PATH_.$fileName);

      } else {
        // Sinon on affiche un message d'erreur
        $errors[] = 'Le fichier doit être une image';    
      }
    };

    // Si pas d'erreurs, on procède à la mise à jour de la recette
    if (!isset($errors)) {
      $recipeUpdate = updateRecipe($pdo, $recipe['id'], $_SESSION['user']['id'], $_POST['category'], $_POST['title'], $_POST['description'], $_POST['ingredients'], $_POST['instructions'], $fileName);      
      
      if($recipeUpdate) {
        $messages[] = 'La recette a bien été modifiée'; 
        // Rediriger vers la page Mes recettes 
        header('Location: mesRecettes.php');    
        exit(); // On arrête l'exécution du script 
      } else {
        $errors[] = 'La recette n\'a pas été modifiée';
      };
    }else {
      // Récupérer les données saisies par l'utilisateur pour les réafficher
      $recipe = [
          'title' => $_POST['title'],
          'description' => $_POST['description'],
          'ingredients' => $_POST['ingredients'],
          'instructions' => $_POST['instructions'],
          'category_id' => $_POST['category'],
      ];
    };  
  }
  require_once('templates/header.php'); 
?>
<div class="container py-4">
  <!-- Titre centré avec un peu d'espace en haut -->
  <div class="text-center mb-4">
        <h1 class="display-4">Modifier une recette</h1>
  </div>
  
  <?php require_once('lib/alerte.php'); ?>

  <!-- enctype permet l'envoie de fichier -->
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="title" class="form-label">Titre</label>
      <input type="text" name="title" id="title" class="form-control" value="<?=$recipe['title'];?>">
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea name="description" id="description" cols="30" rows="5"
        class="form-control"><?=$recipe['description'];?></textarea>
    </div>
    <div class="mb-3">
      <label for="ingredients" class="form-label">Ingredients</label>
      <textarea name="ingredients" id="ingredients" cols="30" rows="5"
        class="form-control"><?=$recipe['ingredients'];?></textarea>
    </div>
    <div class="mb-3">
      <label for="instructions" class="form-label">Instructions</label>
      <textarea name="instructions" id="instructions" cols="30" rows="5"
        class="form-control"><?=$recipe['instructions'];?></textarea>
    </div>
    <div class="mb-3">
      <label for="category" class="form-label">Catégorie</label>
      <select name="category" id="category" class="form-select">

        <?php foreach ($categories as $category) { ?>
        <option value="<?=$category['id'];?>"
          <?php if ($recipe['category_id'] == $category['id']) { echo 'selected="selected"'; } ?>><?=$category['name'];?>
        </option>
        <?php } ?>

      </select>
    </div>

    <?php if (!empty($result['image'])): ?>
    <div class="mb-3">
      <p>Image actuelle :</p>
      <img src="<?= _RECIPES_IMG_PATH_ . $result['image']; ?>" alt="Image actuelle" style="max-width: 200px;">
    </div>
    <?php endif; ?>
    
    <div class="mb-3">
      <label for="file" class="form-label">Image</label>
      <input type="file" name="file" id="file">
    </div>
    <input type="submit" value="Modifier" name="saveRecipe" class="btn btn-primary">
  </form>
</div>
<?php
  require_once('templates/footer.php');
?>
<?php
  require_once('templates/base.php');
  require_once('lib/tools.php');
  require_once('lib/recipe.php');
  require_once('lib/category.php');

  // Vérifier si l'utilisateur est connecté 
  if (!isset($_SESSION['user'])) {
    // L'utilisateur n'est pas connecté : on garde en mémoire la page qu'il voulait
    $_SESSION['redirect_after_login'] = 'mesRecettes.php';
    // Rediriger vers la page de login
    header('Location: login.php');    
    exit(); // On arrête l'exécution du script  
    }

  require_once('templates/header.php');

  // Récupérer les recettes de l'utilisateur
  $user_id = $_SESSION['user']['id'];
  $query = "SELECT * FROM recipes WHERE user_id = :user_id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->execute();
  $recettes = $stmt->fetchAll();

  // debug($recettes);
?>

<div class="container py-5">
    <!-- Titre centré avec un peu d'espace en haut -->
    <div class="text-center mb-4">
        <h1 class="display-4">Mes recettes</h1>
    </div>

    <!-- Bouton centré sous le titre -->
    <div class="text-center mb-4">
        <a href="ajouter_recette.php" class="btn btn-primary btn-lg">Ajouter une nouvelle recette</a>
    </div>

    <!-- Liste des recettes de l'utilisateur avec des cartes -->
    <div class="row">
        <?php if (empty($recettes)): ?>
            <p>Aucune recette trouvée. Ajoute-en une !</p>
        <?php else: ?>
            <?php foreach ($recettes as $recette): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <!-- Image de la recette (si disponible) -->
                        <img src="<?= !empty($recette['image']) ? _RECIPES_IMG_PATH_.$recette['image'] : 'default-image.jpg' ?>" class="card-img-top" alt="Image de la recette">

                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($recette['title']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($recette['description']); ?></p>
                            <a href="recette.php?id=<?= $recette['id']; ?>" class="btn btn-info btn-sm">Afficher</a>
                            <a href="modifier_recette.php?id=<?= $recette['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="supprimer_recette.php?id=<?= $recette['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?')">Supprimer</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Ajout de Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-GLhlTQ8iRABWoA9tG6pXk96pG8hLZl9OO8f/9EkM3CS0m0OeH7wU7V8cVb6z5Cvs" crossorigin="anonymous"></script>

</body>
</html>


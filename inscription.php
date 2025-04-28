<?php
  require_once('templates/base.php');
  require_once('lib/user.php');

  $errors = [];
  $messages = [];

  if (isset($_POST['addUser'])) {
    
  $newUser = addUser($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password']); 
  
    if ($newUser) {
      // Si il y a un nouvel utilisateur inscrit, on ouvre une session et on stocke les données de 
      // l'utilisateur dedant pour pouvoir y accéder ensuite depuis toutes les pages.
      $_SESSION['user'] = ['email' => $_POST['email'], 'last_name' => $_POST['last_name'], 'first_name' => $_POST['first_name']];  
      // On enregistre le message de remerciement dans la session pour pouvoir y acceder depuis index.php
      $_SESSION['user'] = ['message' => 'Merci pour votre inscription'];
      // $messages[] = 'Merci pour votre inscription';
      // Ensuite l'utilisateur connecté est redirigé vers la page d'accueil
      header('Location: index.php');
      exit(); // On arrête l'exécution du script 
    } else {
      $errors[] = 'Une erreur s\'est produite lors de votre inscription';
    };
  }
  require_once('templates/header.php'); 
?>

<h1>Inscription</h1>

<?php foreach ($messages as $message) { ?>
<div class="alert alert-success">
  <?=$message;?>
</div>
<?php } ?>

<?php foreach ($errors as $error) { ?>
<div class="alert alert-danger">
  <?=$error;?>
</div>
<?php } ?>

<form method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="first_name" class="form-label">Prénom</label>
    <input type="first_name" name="first_name" id="first_name" class="form-control">
  </div>

  <div class="mb-3">
    <label for="last_name" class="form-label">Nom</label>
    <input type="last_name" name="last_name" id="last_name" class="form-control">
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control">
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Mot de passe</label>
    <input type="password" name="password" id="password" class="form-control">
  </div>

  <input type="submit" value="Inscription" name="addUser" class="btn btn-primary">
</form>

<?php
  require_once('templates/footer.php');
?>
<?php
require_once('templates/base.php');
require_once('lib/user.php');

if (isset($_POST['loginUser'])) {

  $user = verifyUserLoginPassword($pdo, $_POST['email'], $_POST['password']); 

  if ($user) {
    // Si le  mot de passe de l'utilisateur est vérifié, on ouvre une session avec les données de l'utilisateur
    $_SESSION['user'] = ['id' => $user['id'], 'email' => $user['email'], 'last_name' => $user['last_name'], 'first_name' => $user['first_name']];
    
    // Maintenant on regarde s'il y a une redirection en attente
    if (isset($_SESSION['redirect_after_login'])) {
      $redirectUrl = $_SESSION['redirect_after_login'];
      unset($_SESSION['redirect_after_login']); // Nettoyer la session
      header('Location: ' . $redirectUrl);
      exit(); // On arrête l'execution du script
    }
    
    // Sinon, redirection par défaut
    header('location: index.php');
  } else {
    $errors[] = 'Email ou mot de passe incorrect';
  };
}

require_once('templates/header.php');

?>

<h1>Connexion</h1>

<?php require_once('lib/alerte.php'); ?>

<form method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" name="email" id="email" class="form-control">
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Mot de passe</label>
    <input type="password" name="password" id="password" class="form-control">
  </div>

  <input type="submit" value="Connexion" name="loginUser" class="btn btn-primary">
</form>

<?php
  require_once('templates/footer.php');
?>
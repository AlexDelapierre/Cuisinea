<?php 
  
  if (!isset($errors)) {
    $errors = [];
  }
  if (!isset($messages)) {
    $messages = [];
  }

  foreach ($messages as $message) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="max-width: 80vw; margin: auto;">
      <strong><?=$message;?></strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['user']['message']);  ?>
  <?php } ?>

  <?php foreach ($errors as $error) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="max-width: 80vw; margin: auto;">
      <strong><?=$error;?></strong> 
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php } ?>
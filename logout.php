<?php
require 'lib/session.php';

session_destroy();
unset($_SESSION);

// Pour rediriger l'utilisateur vers le formulaire de login
header('location: index.php');
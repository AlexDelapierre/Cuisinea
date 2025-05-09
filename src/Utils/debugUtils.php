<?php

namespace App\Utils;

// fonction de debugage personnalisée
function debug($var) {
  echo '<pre>';
  var_dump($var);
  echo '</pre>';
  die; 
}
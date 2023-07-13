<?php

// fonction pour transformer une chaîne de caractère avec saut de ligne en tableau 
function linesToArray(string $string) {
  return explode(PHP_EOL, $string);
}
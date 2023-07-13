<?php

// fonction pour exploser une string en un tableau avec les retours à la ligne
function linesToArray(string $string) {
  return explode(PHP_EOL, $string);
}
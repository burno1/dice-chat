<?php
 function verify_field($texto){
  $texto = trim($texto);
  $texto = stripslashes($texto);
  $texto = htmlspecialchars($texto);
  $texto = strip_tags($texto);
  $texto = preg_replace ('/<[^>]*>/', ' ', $texto);
  return $texto;
}

?>

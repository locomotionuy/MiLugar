<?php 
function limpiar($s) 
{ 
$s= str_replace('á', 'a', $s); 
$s= str_replace('é', 'e', $s); 
$s= str_replace('í', 'i', $s); 
$s= str_replace('ó', 'o', $s); 
$s= str_replace('ú', 'u', $s); 
$s= str_replace('ü', 'u', $s); 
$s= str_replace('ñ', 'n', $s); 
$s= str_replace(',', '', $s); 
$s= str_replace(' ', '', $s);
$s= str_replace('(', '_', $s);
$s= str_replace(')', '_', $s);
return $s; 
}
?>
<?php 
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

function Conectarse() 
{ 
   if (!($link=mysql_connect("localhost","dimensio_admin","Marcelin.22?"))) 
   { 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mysql_select_db("dimensio_base",$link)) 
   { 
      echo "Error seleccionando la base de datos."; 
      exit(); 
   }
	
	mysql_query("SET NAMES 'utf8'");
   return $link; 
} 
$link=Conectarse(); 

?>
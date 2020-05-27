<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>
<?php
include 'inc-ubicaciones.php';

$index = 0;
foreach($lista_ubicaciones as $ubicacion){
	
	//echo $ubicacion[0].'<br>';
	if ($index > 0) echo $index.' "'.$ubicacion[0].', '.$ubicacion[1].'"<br>';
	$index++;
}

?>
<body>
</body>
</html>
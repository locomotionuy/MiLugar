<?php 
include '../inc-conn.php';

$nuevo_orden = $_REQUEST['nuevo_orden'];

$orden = 1;//esta va a ser la foto de portada
$key = 0; 
$cant = count($nuevo_orden);
//$array = array_reverse($nuevo_orden);

while ($key < $cant) {
	
	// el array tiene estos valores: foto_3
	$spliteado = explode("_", $nuevo_orden[$key]);
	$id = $spliteado[1]; //es el id de la foto
	try 
	{
		$sql = "UPDATE fotos SET orden='".$orden."' WHERE id = '".$id."'";
		$conn->exec($sql);
	}
	catch(PDOException $e)
    {
		$error = $sql . "<br>" . $e->getMessage();
    }
	$key++;	
	$orden++;
}

echo "listo";

?>

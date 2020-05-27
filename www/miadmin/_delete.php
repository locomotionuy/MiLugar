<?php 
include 'inc-conn.php';
  
// Tabal y sección
$mod = 'Propiedades';
$tabla = 'propiedades';

// Thumbnail
$config_thumbs = true;

// Carpeta
$gallery_dir = "fotos";

include 'inc-header.php';


$inmobiliaria = $_GET['inmobiliaria'];

$stmt = $conn->prepare("SELECT * FROM $tabla WHERE inmobiliaria=$inmobiliaria");
$stmt->execute();
while( $datos = $stmt->fetch() ) 
{
	echo '<br>'.$id;
	$id = $datos["id"];
	
	$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=$id");
	$stmt->execute();
	while( $datos2 = $stmt->fetch() ) 
	{
		unlink("../uploads/fotos/".$datos2["foto"]);
		if($config_thumbs==true) unlink("../uploads/".$gallery_dir."/thumbs/".$datos2["foto"]);
	}

	$sql = "DELETE FROM fotos WHERE id_referencia=$id";
	$conn->exec($sql);

	$sql = "DELETE FROM $tabla WHERE id=$id";
	$conn->exec($sql);



}


	/*try 
	{
		$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=$id");
		$stmt->execute();
		while( $datos = $stmt->fetch() ) 
		{
			unlink("../uploads/fotos/".$datos["foto"]);
			if($config_thumbs==true) unlink("../uploads/".$gallery_dir."/thumbs/".$datos["foto"]);
		}

		$sql = "DELETE FROM fotos WHERE id_referencia=$id";
		$conn->exec($sql);
		
		$sql = "DELETE FROM $tabla WHERE id=$id";
		$conn->exec($sql);
		
		$borrado_ok = 1;
	}
	catch(PDOException $e)
	{
		$borrado_error = "Hubo un error: ".$e->getMessage();
	}*/


?>


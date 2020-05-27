<?php 
include 'inc-conn.php';

//include 'inc-header.php';

$id = $_GET['id'];
try 
{
	$stmt1 = $conn->prepare("SELECT * FROM propiedades WHERE inmobiliaria=$id and milugar=1 AND dimension=0");
	$stmt1->execute();
	while( $datos1 = $stmt1->fetch() ) 
	{
		$id_propiedad_borrar = $datos1['id'];
		echo '<br> id_propiedad_borrar: '.$id_propiedad_borrar;
		$stmt2b = $conn->prepare("SELECT * FROM fotos WHERE id_referencia='$id_propiedad_borrar' and tipo!='logo'");
		$stmt2b->execute();
		while( $datos2b = $stmt2b->fetch() ) 
		{
			/*echo '<br> foto: '.$datos2b["foto"];*/
			$url_explode = explode("/",$datos2b["foto"]);
			if($url_explode[2] == 'milugar.com.uy'){
				echo '<br> foto: '.$datos2b["foto"];
				unlink($datos2b["foto"]);
				unlink($datos2b["foto_thumb"]);
			}
		}
		$sql2b = "DELETE FROM fotos WHERE id_referencia='$id_propiedad_borrar' and tipo!='logo'";
		$conn->exec($sql2b);
	}
	$stmt2b = $conn->prepare("SELECT * FROM fotos WHERE id_referencia='$id' and tipo='logo'");
	$stmt2b->execute();
	while( $datos2b = $stmt2b->fetch() ) 
	{
			echo '<br> foto: '.$datos2b["foto"];
			unlink($datos2b["foto"]);
	}
	$sql2b = "DELETE FROM fotos WHERE id_referencia='$id' and tipo='logo'";
	$conn->exec($sql2b);
	$sql2 = "DELETE FROM propiedades WHERE inmobiliaria=$id and milugar=1 AND dimension=0";
	$conn->exec($sql2);
	$sql2 = "DELETE FROM usuarios WHERE id=$id";
	$conn->exec($sql2);
	
}
catch(PDOException $e)
{
	$borrado_error = "Hubo un error: ".$e->getMessage();
}

	
?>
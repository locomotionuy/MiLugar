
<?php 
include 'inc-conn.php';
try 
	{
	$stmt = $conn->prepare("SELECT * FROM fotos WHERE url='http://casasweb.com/fotos/' && tipo='foto' ORDER BY id ASC");
	$stmt->execute();
	while( $datos = $stmt->fetch() ) 
	{
		$id = $datos["id"];
		$id_referencia = $datos["id_referencia"];
		$existe = false;
		//echo 'referencia: '.$id_referencia;
		try 
			{
			$stmt2 = $conn->prepare("SELECT * FROM propiedades WHERE id=$id_referencia LIMIT 1");
			$stmt2->execute();
			while( $datos2 = $stmt2->fetch() ) 
			{
				$existe = true;
				$arr = explode(":",$datos["foto"],2);
				if($arr[0]=='http'){
					$arr_thumb = explode(":",$datos["foto_thumb"],2);
					$foto = 'https:'.$arr[1];
					$foto_thumb = 'https:'.$arr_thumb[1];
					echo ' <br>id_referencia: '.$datos['id_referencia'];
					//echo '<img src="'.$foto.'" width="120" alt=""/>';
					try {
						$sql = "UPDATE fotos SET 
						foto='$foto',
						url='https://casasweb.com/fotos/',
						foto_thumb='$foto_thumb'
						WHERE id='$id' LIMIT 1 ";
						$conn->exec($sql);
					}
					catch(PDOException $e)
					{
						echo "Hubo un error: ".$e->getMessage();
					}
				}
			}

			if($existe==false){
				echo '<br>esa propiedad no existe mas... '.$id_referencia;
				//paso iintermedio
				/*try {
					$sql = "UPDATE fotos SET 
					nombre='-'
					WHERE id='$id' LIMIT 1 ";
					$conn->exec($sql);
				}
				catch(PDOException $e)
				{
					echo "Hubo un error: ".$e->getMessage();
				}*/
				$borrarFoto = "DELETE FROM fotos WHERE id=$id && nombre='-' LIMIT 1 ";
				$conn->exec($borrarFoto);
			}

		}
		catch(PDOException $e)
		{
			echo "Hubo un error: ".$e->getMessage();
		}
	}
}
catch(PDOException $e)
{
	echo "Hubo un error: ".$e->getMessage();
}

?>

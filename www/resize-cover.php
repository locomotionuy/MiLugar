<?php 
include 'inc-conn.php';

$tabla = 'propiedades';
$dir_fotos_thumbs = 'uploads/fotos/thumbs/';
$dir_fotos = 'uploads/fotos/';
$dir_fotos_destination = 'uploads/fotos/1024/';
$sql = "SELECT * FROM $tabla WHERE publicado=1 ORDER BY id DESC";	

$query = $conn->prepare($sql);
$query->execute();

$model = array();
while($rows = $query->fetch())
{
  $model[] = $rows;
}
foreach($model as $row)
{
	$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." ORDER BY orden ASC LIMIT 1");
	$stmt->execute();
	while( $imagen = $stmt->fetch() ) 
	{
		$resized_image = $dir_fotos_destination.$imagen["foto"]; 
		$actual_image = $dir_fotos.$imagen["foto"]; 
		//echo '<img src="'.$dir_fotos_thumbs.$imagen["foto"].'"/>';
		if (!file_exists($resized_image)) {					
			list( $width,$height ) = getimagesize( $actual_image);
			$newwidth = 1024;
			$newheight = 512;
			$thumb = imagecreatetruecolor( $newwidth, $newheight );
			$source = imagecreatefromjpeg( $actual_image );
			imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			imagejpeg( $thumb, $resized_image, 65 ); 
		}
		echo "foto actul ".$actual_image;
	}
}
?>
	
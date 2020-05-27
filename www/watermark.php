
<?php 
header('content-type: image/jpeg');  
include 'inc-conn.php';

$sql = "SELECT * FROM fotos WHERE tipo='360' ORDER BY foto DESC LIMIT 1";	

$query = $conn->prepare($sql);
$query->execute();
$path_watermark = 'uploads/watermark/watermark.jpg';
$path = 'uploads/fotos/';
$model = array();
while($rows = $query->fetch())
{
	
	$foto = $rows['foto'];
	echo 'foto: '.$foto;
	$path = 'uploads/fotos/'.$foto;
	
	
 
$watermark = imagecreatefromjpeg('uploads/watermark/watermark.jpg');  
$watermark_width = imagesx($watermark);  
$watermark_height = imagesy($watermark);  
$image = imagecreatetruecolor($watermark_width, $watermark_height);  
$image = imagecreatefromjpeg($path);  
$size = getimagesize($path);  
//$dest_x = $size[0] - $watermark_width;  
//$dest_y = $size[1] - $watermark_height;  
	
$dest_x = ($new_width/2); //watermark left
$dest_y = ($new_height - $heightWM); //watermark bottom
	
	
imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, 100);  
imagejpeg($image);  
imagedestroy($image);  
imagedestroy($watermark);  
	
	
}



?>

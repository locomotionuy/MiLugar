<?php 
$errors = array();
$extension = array("jpeg","jpg","png","PNG","JPG","JPEG");
$UploadFolder = "../uploads/".$gallery_dir;


$temp = $_FILES["imagen"]["tmp_name"];
$name = $_FILES["imagen"]["name"];

$UploadOk = true;
$ext = pathinfo($name, PATHINFO_EXTENSION);

if(in_array($ext, $extension) == false)
{
	$UploadOk = false;
	array_push($errors, $name." es un formato incorrecto de imagen.");
}

if($UploadOk == true){

	$name = "logo_".$entrada_id.date("ymds").".".$ext;
	$information = getimagesize($temp);
	$width=$information[0];
	$height=$information[1];
	ini_set ('gd.jpeg_ignore_warning', 1);

	if($width > $image_w)
	{
		if( $image_w >= $width && $image_h >= $height ) $ratio = 1;
		elseif( $width > $height ) $ratio = $image_w / $width;
		else $ratio = $image_h / $height;
		$new_width = round( $width * $ratio );
		$new_height = round( $height * $ratio );
	}
	else
	{
		$new_width = $width;
		$new_height = $height;
	}
	$path = $UploadFolder."/".$name;

	if($ext == "jpg" || $ext == "jpeg" || $ext == "JPEG" || $ext == "JPG") {
		$tmp=imagecreatetruecolor($new_width,$new_height);
		$src=imagecreatefromjpeg($temp); 
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagejpeg($tmp, $path);

	} 
	else if($ext == "png" || $ext == "PNG") {	
		$src=imagecreatefrompng($temp);
		$tmp=imagecreatetruecolor($new_width,$new_height);
		imagealphablending($tmp, false);
		imagesavealpha($tmp,true);
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		imagepng($tmp, $path);
	}

	$url = "https://".$_SERVER['SERVER_NAME']."/uploads/".$gallery_dir."/".$name;

	imagedestroy($tmp);
	imagedestroy($src);
	$sqlImg = "INSERT INTO fotos (foto,foto_thumb,id_referencia,tipo) VALUES ('$url','$url','$entrada_id','logo')";
	$conn->exec($sqlImg);

}
?>
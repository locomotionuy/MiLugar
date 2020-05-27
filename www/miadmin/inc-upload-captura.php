<?php 
$errors = array();
$extension = array("jpeg","jpg","png","PNG","JPG","JPEG");
$UploadFolder = "../uploads/".$gallery_dir;
$UploadFolderThumb = "../uploads/".$gallery_dir."/thumbs";

$orden = 1;

foreach($_FILES["foto"]["tmp_name"] as $key2=>$tmp2_name){
	$temp2 = $_FILES["foto"]["tmp_name"][$key2];
	$name2 = $_FILES["foto"]["name"][$key2];

	if(empty($temp2)) break;

	$UploadOk = true;
	$ext = pathinfo($name2, PATHINFO_EXTENSION);

	if(in_array($ext, $extension) == false)
	{
		$UploadOk = false;
		array_push($errors, $name2." es un formato incorrecto de imagen.");
	}

	if($UploadOk == true){

		$name2 = $key2.$entrada_id.date("ymds")."_2d.".$ext;
		$information = getimagesize($temp2);
		$width=$information[0];
		$height=$information[1];
		ini_set ('gd.jpeg_ignore_warning', 1);
		
		$new_height = $height;
		$new_width = $width;
		$new_th_height = $height;
		$new_th_width = $width;

		if($width>=$height)//foto horizontal o cuadrada
		{
			$new_width = $image_w_2d;
			$new_height = intval( $height * $new_width / $width );
			$new_th_width = $th_image_w;
			$new_th_height = intval( $height * $new_th_width / $width );
		}else//foto vertical
		{
			$new_height = $image_h_2d;
			$new_width = intval( $width * $new_height / $height );
			$new_th_height = $th_image_h;
			$new_th_width = intval( $width * $new_th_height / $height );
		}

		/*if($width > $image_w_2d)
		{
			if( $image_w_2d >= $width && $image_h_2d >= $height ) $ratio = 1;
			elseif( $width > $height ) $ratio = $image_w_2d / $width;
			else $ratio = $image_h_2d / $height;
			$new_width = round( $width * $ratio );
			$new_height = round( $height * $ratio );
		}
		else
		{
			$new_width = $width;
			$new_height = $height;
		}*/
		$path2 = $UploadFolder."/".$name2;
		$path2Thumb = $UploadFolder."/thumbs/".$name2;
	
		if($ext == "jpg" || $ext == "jpeg" || $ext == "JPEG" || $ext == "JPG") {
			$tmp2=imagecreatetruecolor($new_width,$new_height);
			$src2=imagecreatefromjpeg($temp2); 
			imagecopyresampled($tmp2, $src2, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			if($config_thumbs == true){
				$thumb = imagecreatetruecolor( $new_th_width, $new_th_height );
				imagecopyresampled( $thumb, $tmp2, 0, 0, 0, 0, $new_th_width, $new_th_height, $new_width, $new_height );
			}
			imagejpeg($tmp2, $path2,75);
			if($config_thumbs == true){
				imagejpeg($thumb, $path2Thumb,75);
				imagedestroy($thumb);
			}
		} 
		else if($ext == "png" || $ext == "PNG") {	
			$src2=imagecreatefrompng($temp2);
			$tmp2=imagecreatetruecolor($new_width,$new_height);
			imagealphablending($tmp2, false);
			imagesavealpha($tmp2,true);
			imagecopyresampled($tmp2, $src2, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagepng($tmp2, $path2);
		}
		
		$url = "https://".$_SERVER['SERVER_NAME']."/uploads/".$gallery_dir."/".$name2;
		$url_thumb = "https://".$_SERVER['SERVER_NAME']."/uploads/".$gallery_dir."/thumbs/".$name2;	
		
		if(isset($soporte_mensajes))
		{
			$tipo_soporte = 'soporte_mensajes';
		}
		else
		{
			$tipo_soporte = 'soporte';
		}
		
		imagedestroy($tmp2);
		imagedestroy($src2);
		$sqlImg = "INSERT INTO fotos (foto,foto_thumb,id_referencia,tipo,seccion,orden) 
		VALUES ('$url','$url_thumb','$entrada_id','$tipo_soporte','propiedades','$orden')";
		$conn->exec($sqlImg);
		$orden++;

	}
}
?>
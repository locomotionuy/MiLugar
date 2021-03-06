<?php 
$errors = array();
$extension = array("jpeg","jpg","png","PNG","JPG","JPEG");
$UploadFolder = "../uploads/".$gallery_dir;
$UploadFolderThumb = "../uploads/".$gallery_dir."/thumbs";

$orden = 1;
$nombres = $_POST["nombre_foto"];

foreach($_FILES["imagen"]["tmp_name"] as $key=>$tmp_name){
	$temp = $_FILES["imagen"]["tmp_name"][$key];
	$name = $_FILES["imagen"]["name"][$key];

	if(empty($temp)) break;

	$UploadOk = true;
	$ext = pathinfo($name, PATHINFO_EXTENSION);

	if(in_array($ext, $extension) == false)
	{
		$UploadOk = false;
		array_push($errors, $name." es un formato incorrecto de imagen.");
	}

	if($UploadOk == true){

		$name = $key.$entrada_id.date("ymds").".".$ext;
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
		$pathThumb = $UploadFolder."/thumbs/".$name;
	
		if($ext == "jpg" || $ext == "jpeg" || $ext == "JPEG" || $ext == "JPG") {
			$tmp=imagecreatetruecolor($new_width,$new_height);
			$src=imagecreatefromjpeg($temp); 
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			
			$thumb = imagecreatetruecolor( $th_image_w, $th_image_h );
			imagecopyresampled( $thumb, $tmp, 0, 0, 0, 0, $th_image_w, $th_image_h, $new_width, $new_height );
				
			imagejpeg($tmp, $path,75);
			imagejpeg($thumb, $pathThumb,75);
			imagedestroy($thumb);
		} 
		else if($ext == "png" || $ext == "PNG") {	
			$src=imagecreatefrompng($temp);
			$tmp=imagecreatetruecolor($new_width,$new_height);
			imagealphablending($tmp, false);
			imagesavealpha($tmp,true);
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagepng($tmp, $path);

			$thumb = imagecreatetruecolor( $th_image_w, $th_image_h );
			imagecopyresampled( $thumb, $tmp, 0, 0, 0, 0, $th_image_w, $th_image_h, $new_width, $new_height );

			imagepng($thumb, $pathThumb);
			imagedestroy($thumb);
		}
	
		$url = "https://".$_SERVER['SERVER_NAME']."/uploads/".$gallery_dir."/".$name;
		$url_thumb = "https://".$_SERVER['SERVER_NAME']."/uploads/".$gallery_dir."/thumbs/".$name;	
		
		imagedestroy($tmp);
		imagedestroy($src);
		$sqlImg = "INSERT INTO fotos (foto,foto_thumb,id_referencia,tipo,seccion,orden,nombre) 
		VALUES ('$url','$url_thumb','$entrada_id','360','propiedades',$orden,'".$nombres[$key]."')";
		$conn->exec($sqlImg);
		$orden++;

	}
}
?>
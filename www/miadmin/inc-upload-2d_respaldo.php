<?php 
$errors = array();
$extension = array("jpeg","jpg","png","PNG","JPG","JPEG");
$UploadFolder = "../uploads/".$gallery_dir;
$UploadFolderThumb = "../uploads/".$gallery_dir."/thumbs";

$orden = 1;
$nombres = $_POST["nombre_foto"];

foreach($_FILES["foto"]["tmp_name"] as $key=>$tmp_name){
	$temp = $_FILES["foto"]["tmp_name"][$key];
	$name = $_FILES["foto"]["name"][$key];

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

		if($width > $image_w_2d)
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
		}
		$path = $UploadFolder."/".$name;
		$pathThumb = $UploadFolder."/thumbs/".$name;
	
		if($ext == "jpg" || $ext == "jpeg" || $ext == "JPEG" || $ext == "JPG") {
			$tmp=imagecreatetruecolor($new_width,$new_height);
			$src=imagecreatefromjpeg($temp); 
			imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			
			if($config_thumbs == true){
				$thumb = imagecreatetruecolor( $th_image_w, $th_image_h );
				imagecopyresampled( $thumb, $tmp, 0, 0, 0, 0, $th_image_w, $th_image_h, $new_width, $new_height );
				
//				/* -------- WATERMARK --------- */
//				$path_watermark = '../uploads/watermark/watermark'.$usuario_id.'.jpg';
//				if(!file_exists($path_watermark)) $path_watermark = '../uploads/watermark/watermark.jpg';
//				$watermark = imagecreatefromjpeg($path_watermark);
//				list( $widthWM, $heightWM  ) = getimagesize($path_watermark);
//
//				$watermark_left = ($new_width/2); //watermark left
//				$watermark_bottom = ($new_height - $heightWM); //watermark bottom
//				imagecopy($tmp, $watermark, 0, $watermark_bottom, 0, 0, $new_width, $new_height); //merge image
//				
//				/* -------- END WATERMARK --------- */
			}
			imagejpeg($tmp, $path,75);
			if($config_thumbs == true){
				imagejpeg($thumb, $pathThumb,75);
				imagedestroy($thumb);
				//imagedestroy($watermark);
			}
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
		$url_thumb = "https://".$_SERVER['SERVER_NAME']."/uploads/".$gallery_dir."/thumbs/".$name;	
		
		imagedestroy($tmp);
		imagedestroy($src);
		$sqlImg = "INSERT INTO fotos (foto,foto_thumb,id_referencia,tipo,seccion,orden,nombre) 
		VALUES ('$url','$url_thumb','$entrada_id','foto','propiedades',$orden,'".$nombres[$key]."')";
		$conn->exec($sqlImg);
		$orden++;

	}
}
?>
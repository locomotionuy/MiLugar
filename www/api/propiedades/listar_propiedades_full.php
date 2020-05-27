<?php 

include_once '../config/database.php';
include_once '../objects/propiedades.php';
include_once '../validate_token.php';
 
$database = new Database();
$db = $database->getConnection();
if($token){
    try {
		$propiedades = new Propiedades($db);
		$stmt = $propiedades->listar_propiedades($inmobiliaria);
		$num = $stmt->rowCount();
		//error_log('num: '.$num);
		if($num>0){

			$propiedadess_arr=array();
			$LocalidadArray=array();
			
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				extract($row);
				$NombreLocalidad = $IdLocalidad;
				//echo $IdLocalidad;
				$LocalidadArray = explode(", ",$IdLocalidad);
				if(count($LocalidadArray) == 2){
					$depto = $LocalidadArray[0];
					$ciudad = $LocalidadArray[1];
					$index=0;
					foreach ($propiedades->lista_ubicaciones as $li)
					{
						if($li[0]==$depto && $li[1]==$ciudad){
							$IdLocalidad = $index;
							break;
						}
						$index++;
					}
				}else{
					$IdLocalidad = 0;
				}
				$propiedades_item=array(
					"id" => $id,
					"url" => 'https://milugar.com.uy/file.php?id='.$id,
					"IdTipoInmueble" => $IdTipoInmueble,
					"NombreTipoInmueble" => $NombreTipoInmueble,
					"IdTipoOperacion" => $IdTipoOperacion,
					"NombreTipoOperacion" => $NombreTipoOperacion,
					"IdLocalidad" => $IdLocalidad,
					"NombreLocalidad" => $NombreLocalidad,
					"titulo" => html_entity_decode($titulo),
					"descripcion" => html_entity_decode($descripcion),
					"Precio" => $Precio,
					//"Calle" => $Calle,
					//"Esquina" => $Esquina,
					"SuperficieTotal" => $SuperficieTotal,
					"SuperficieConstruida" => $SuperficieConstruida,
					"GastosComunesMonto" => $GastosComunesMonto,
					"IdUnidadGastosComunes" => $IdUnidadGastosComunes,
					"IdUnidadPrecio" => $IdUnidadPrecio,
					"IdDormitorios" => $IdDormitorios,
					"IdBanios" => $IdBanios,
					"garage" => $garage,
					"latitud" => $latitud,
					"longitud" => $longitud,
					//"video" => $video,
					"garantia" => $garantia,
					"amueblado" => $amueblado,
					"estado" => $estado,
					//"orientacion" => $orientacion,
					//"IdOrientacion" => $IdOrientacion,
					"aire_acondicionado" => $aire_acondicionado,
					"mascotas" => $mascotas,
					"fecha" => $fecha,
					"fecha_modificado" => $fecha_modificado,
					"parrillero" => $parrillero,
					"azotea" => $azotea,
					"jardin" => $jardin,
					"vivienda_social" => $vivienda_social,
					"barrio_privado" => $barrio_privado,
					"publicado" => $publicado,
					"vendida" => $vendida,
					"Imagenes" => $Imagenes_array,
					"Imagenes360" => $Imagenes360_array
					//"Mensajes" => $Mensajes
				);

				array_push($propiedadess_arr, $propiedades_item);
			}

			http_response_code(200);
			echo json_encode(array("cantidad" => $num , "propiedades" => $propiedadess_arr));

		}else{
			http_response_code(200);
			echo json_encode("No tiene propiedades.");
		}


    }
 
	catch (Exception $e){
		http_response_code(401);
		echo json_encode(array(
			"message" => "Accesso denegado.",
			"error" => $e->getMessage()
		));
	}
}
 
else{
 
    http_response_code(401);
    echo json_encode(array("error" => "Falta token."));
}


?>
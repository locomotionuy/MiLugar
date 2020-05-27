<?php

include_once '../config/database.php';
include_once '../objects/propiedades.php';
include_once '../validate_token.php';
 
$database = new Database();
$db = $database->getConnection();
$propiedad = new Propiedades($db);

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);
 
$propiedad->id = $decoded["id"];
$propiedad->inmobiliaria = $inmobiliaria;


if($propiedad->id!=null){
	if($propiedad->inmobiliaria!=null){
		
		$leer = $propiedad->leer_propiedad();
		
		if(!$leer){
		
			http_response_code(500);
			echo json_encode(array("error" => $propiedad->errores));

		}else{
			$propiedad_arr = array(
				"id" =>  $propiedad->id,
				"IdTipoInmueble" => $propiedad->IdTipoInmueble,
				"NombreTipoInmueble" => $propiedad->NombreTipoInmueble,
				"IdTipoOperacion" => $propiedad->IdTipoOperacion,
				"NombreTipoOperacion" => $propiedad->NombreTipoOperacion,
				"IdLocalidad" => $propiedad->IdLocalidad,
				"NombreLocalidad" => $propiedad->NombreLocalidad,
				"titulo" => $propiedad->titulo,
				"descripcion" => $propiedad->descripcion,
				"Precio" => $propiedad->Precio,
				"Calle" => $propiedad->Calle,
				"Esquina" => $propiedad->Esquina,
				"SuperficieTotal" => $propiedad->SuperficieTotal,
				"SuperficieConstruida" => $propiedad->SuperficieConstruida,
				"GastosComunesMonto" => $propiedad->GastosComunesMonto,
				"IdUnidadGastosComunes" => $propiedad->IdUnidadGastosComunes,
				"IdUnidadPrecio" => $propiedad->IdUnidadPrecio,
				"IdDormitorios" => $propiedad->IdDormitorios,
				"IdBanios" => $propiedad->IdBanios,
				"garage" => $propiedad->garage,
				"latitud" => $propiedad->latitud,
				"longitud" => $propiedad->longitud,
				//"mapa" => $propiedad->mapa,
				"video" => $propiedad->video,
				"garantia" => $propiedad->garantia,
				"amueblado" => $propiedad->amueblado,
				"estado" => $propiedad->estado,
				"orientacion" => $propiedad->orientacion,
				"IdOrientacion" => $propiedad->IdOrientacion,
				"aire_acondicionado" => $propiedad->aire_acondicionado,
				"mascotas" => $propiedad->mascotas,
				"fecha" => $propiedad->fecha,
				"parrillero" => $propiedad->parrillero,
				"azotea" => $propiedad->azotea,
				"jardin" => $propiedad->jardin,
				"vivienda_social" => $propiedad->vivienda_social,
				"barrio_privado" => $propiedad->barrio_privado,
				"publicado" => $propiedad->publicado,
				"vendida" => $propiedad->vendida,
				"Imagenes" => $propiedad->Imagenes_array,
				"Imagenes360" => $propiedad->Imagenes360_array,
				"Mensajes" => $propiedad->Mensajes
			);

			http_response_code(200);
			echo json_encode($propiedad_arr);
		}
	}
	else{
		http_response_code(404);
		echo json_encode(array("error" => "Falta token."));
	}
}
 
else{
    http_response_code(404);
    echo json_encode(array("error" => "Falta id de propiedad."));
}
?>
<?php

include_once '../config/database.php';
include_once '../objects/propiedades.php';
include_once '../validate_token.php';
 
$database = new Database();
$db = $database->getConnection();
 
$propiedades = new Propiedades($db);

//$propiedades->id = isset($decoded['id']) ? $decoded['id'] : die();

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);

if(!empty($decoded["id"])){
	
	$propiedades->id = $decoded["id"];

	$propiedades->IdDormitorios = '0';
	$propiedades->IdBanios = '0';
	$propiedades->garage = '0';
	
	$propiedades->inmobiliaria = $inmobiliaria;
	if($permisos == 3) $propiedades->publicado = "0";
	else if(isset($decoded['publicado'])) $propiedades->publicado = $decoded['publicado']; 
	else  $propiedades->publicado = "0"; 
	
	$propiedades->IdTipoInmueble = $decoded["IdTipoInmueble"];
	$propiedades->IdTipoOperacion = $decoded["IdTipoOperacion"];
	$propiedades->IdLocalidad = $decoded["IdLocalidad"];
	$propiedades->Precio = $decoded["Precio"];
	$propiedades->IdDormitorios = $decoded["IdDormitorios"];
	$propiedades->IdBanios = $decoded["IdBanios"];
	$propiedades->garage = $decoded["garage"];
	
	$propiedades->longitud = $decoded["longitud"];
	$propiedades->latitud = $decoded["latitud"];
	//$propiedades->fecha = date("d/m/Y");
	
	if(isset($decoded["titulo"])) $propiedades->titulo = $decoded["titulo"]; else $propiedades->titulo="";
	if(isset($decoded["Calle"])) $propiedades->Calle = $decoded["Calle"]; else $propiedades->Calle="";
	if(isset($decoded["Esquina"])) $propiedades->Esquina = $decoded["Esquina"]; else $propiedades->Esquina="";
	if(isset($decoded["SuperficieTotal"])) $propiedades->SuperficieTotal = $decoded["SuperficieTotal"]; else $propiedades->SuperficieTotal="";
	if(isset($decoded["SuperficieConstruida"])) $propiedades->SuperficieConstruida = $decoded["SuperficieConstruida"]; else $propiedades->SuperficieConstruida="";
	
		
	if(isset($decoded["GastosComunesMonto"])) $propiedades->GastosComunesMonto = $decoded["GastosComunesMonto"];	
	else $propiedades->GastosComunesMonto="";
	
	if($decoded["IdUnidadGastosComunes"]!='U$S') $propiedades->IdUnidadGastosComunes = '$';	
	else $propiedades->IdUnidadGastosComunes='U$S';
	if($decoded["IdUnidadPrecio"]!='UYU') $propiedades->IdUnidadPrecio = 'USD';	
	else $propiedades->IdUnidadPrecio="UYU";

	$propiedades->Imagenes[] = $decoded["Imagenes"];
	$propiedades->Imagenes360[] = $decoded["Imagenes360"];
		/*
	if(isset($decoded['mapa'])) {
		$mapaSimple = explode('"', $decoded['mapa']);
		$propiedades->mapa = $mapaSimple[1];
	}*/
	if(isset($decoded['video'])) {
		$videoSimple = explode('watch?v=', $decoded['video']);
		$propiedades->video = $videoSimple[1];
	}
	
	if(isset($decoded["descripcion"])){
		$descripcionSimple= str_replace("'", "\'", $decoded['descripcion']); 
		$propiedades->descripcion = str_replace('"', '\"',$descripcionSimple);
	} 
	else $propiedades->descripcion="";
	
	
	if(isset($decoded["garantia"])) $propiedades->garantia = $decoded["garantia"]; else $propiedades->garantia="";
	if(isset($decoded["aire_acondicionado"])) $propiedades->aire_acondicionado = $decoded["aire_acondicionado"]; else $propiedades->aire_acondicionado="0";
	if(isset($decoded['amueblado'])) { $propiedades->amueblado = $decoded['amueblado']; } else { $propiedades->amueblado = "0"; }
	if(isset($decoded['orientacion'])) { $propiedades->orientacion = $decoded['orientacion']; } else { $propiedades->orientacion = "0"; }
	if(isset($decoded['estado'])) { $propiedades->estado = $decoded['estado']; } else { $propiedades->estado = "0"; }
	if(isset($decoded['mascotas'])) { $propiedades->mascotas = $decoded['mascotas']; } else { $propiedades->mascotas = "0"; }
	if(isset($decoded['parrillero'])) { $propiedades->parrillero = $decoded['parrillero']; } else { $propiedades->parrillero = "0"; }
	if(isset($decoded['azotea'])) { $propiedades->azotea = $decoded['azotea']; } else { $propiedades->azotea = "0"; }
	if(isset($decoded['jardin'])) { $propiedades->jardin = $decoded['jardin']; } else { $propiedades->jardin = "0"; }
	if(isset($decoded['vivienda_social'])) { $propiedades->vivienda_social = $decoded['vivienda_social']; } else { $propiedades->vivienda_social = "0"; }	
	if(isset($decoded['barrio_privado'])) { $propiedades->barrio_privado = $decoded['barrio_privado']; } else { $propiedades->barrio_privado = "0"; }	
	//if(isset($decoded['publicado'])) { $propiedades->publicado = $decoded['publicado']; } else { $propiedades->publicado = "0"; }	
	

	if($inmobiliaria!== false){
		if($propiedades->editar_propiedad()){
			http_response_code(201);
			echo json_encode(array("success" => "La propiedad fue editada con éxito."));
		}

		else{
			http_response_code(503);
			echo json_encode(array("error" => "Error. No se pudo editar la propiedad."));
		}
	}else
	{
		http_response_code(503);
		echo json_encode(array("error" => "Error. No hay inmobiliaria."));
	}
	
}else{
	http_response_code(503);
	echo json_encode(array("error" => "Error. Falta especificar el id de la propiedad."));
}


?>
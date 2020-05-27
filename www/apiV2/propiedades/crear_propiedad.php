<?php
include_once '../config/database.php';
include_once '../objects/propiedades.php';
include_once '../objects/usuario.php';
include_once '../validate_token.php';
 
$database = new Database();
$db = $database->getConnection();
 
$propiedades = new Propiedades($db);
$user = new User($db);
$headers = getallheaders();
$user->codigo_integradora = $headers["codigo_integradora"];

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);

//error_log(var_dump($decoded));
//foreach($_FILES as $key=>$tmp_name){
	//error_log("temp: ".json_encode($tmp_name["name"]"]));//esto tambien funciona
//}
//echo 'coso decodeado desde crear_propiedad.php: '.var_dump($decoded);

if($user->integradoraExists()){	
	error_log('integradora en crear propiedad: '.$user->integradora);
}
else{
    http_response_code(400);
    echo json_encode(array("error" => "Falta codigo de integradora en el header."));
}
/*
if(
    !empty($decoded["IdTipoInmueble"]) &&
    !empty($decoded["IdTipoOperacion"]) &&
    !empty($decoded["IdLocalidad"]) &&
    !empty($decoded["Precio"])
){
	$propiedades->IdDormitorios = '0';
	$propiedades->IdBanios = '0';
	$propiedades->garage = '0';
	
	$propiedades->inmobiliaria = $inmobiliaria;
	//error_log('crear propiedad.php - permisos: '.$permisos);
	if($permisos == '3') $propiedades->publicado = "0";
	else if(isset($decoded['publicado'])) $propiedades->publicado = $decoded['publicado']; 
	else  $propiedades->publicado = "0"; 
	
	$propiedades->IdTipoInmueble = $decoded["IdTipoInmueble"];
	$propiedades->IdTipoOperacion = $decoded["IdTipoOperacion"];
	$propiedades->IdLocalidad = $decoded["IdLocalidad"];
	//$propiedades->Localidad = $decoded["Localidad"];
	$propiedades->Precio = $decoded["Precio"];
	
	$propiedades->IdDormitorios = $decoded["IdDormitorios"];
	$propiedades->IdBanios = $decoded["IdBanios"];
	$propiedades->garage = $decoded["garage"];
	$propiedades->fecha = date("d/m/Y");
	
	if(isset($decoded["titulo"])) $propiedades->titulo = $decoded["titulo"]; else $propiedades->titulo="";
	if(isset($decoded["Calle"])) $propiedades->Calle = $decoded["Calle"]; else $propiedades->Calle="";
	if(isset($decoded["Esquina"])) $propiedades->Esquina = $decoded["Esquina"]; else $propiedades->Esquina="";
	if(isset($decoded["SuperficieTotal"])) $propiedades->SuperficieTotal = $decoded["SuperficieTotal"]; else $propiedades->SuperficieTotal="";
	if(isset($decoded["SuperficieConstruida"])) $propiedades->SuperficieConstruida = $decoded["SuperficieConstruida"]; else $propiedades->SuperficieConstruida="";
	if(isset($decoded["GastosComunesMonto"])) $propiedades->GastosComunesMonto = $decoded["GastosComunesMonto"]; else $propiedades->GastosComunesMonto="";
	
	if($decoded["IdUnidadGastosComunes"]!='U$S') $propiedades->IdUnidadGastosComunes = '$';	
	else $propiedades->IdUnidadGastosComunes='U$S';
	if($decoded["IdUnidadPrecio"]!='UYU') $propiedades->IdUnidadPrecio = 'USD';	
	else $propiedades->IdUnidadPrecio="UYU";

	if(isset($decoded['Imagenes'])) $propiedades->Imagenes[] = $decoded["Imagenes"];
	if(isset($decoded['Imagenes360'])) $propiedades->Imagenes360[] = $decoded["Imagenes360"];
		
	if(isset($decoded['mapa'])) {
		$mapaSimple = explode('"', $decoded['mapa']);
		if(count($mapaSimple)>1) $propiedades->mapa = $mapaSimple[1];
	}
	if(isset($decoded['latitud'])) $latitud = $decoded['latitud']; else $latitud = "";
	if(isset($decoded['longitud'])) $longitud = $decoded['longitud']; else $longitud = "";
	
	if(isset($decoded['video'])) {
		$videoSimple = explode('watch?v=', $decoded['video']);
		if(count($videoSimple)>1) $propiedades->video = $videoSimple[1];
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
		
	
	$response = array();
	if($inmobiliaria!== false){
		if($propiedades->crear_propiedad()){
			//http_response_code(201);
			array_push($response , array("success" => "La propiedad fue subida con éxito."));
			array_push($response , array("Codigo propiedad" => $propiedades->entrada_id));
			if(count($propiedades->errores) > 0) array_push($response, array("errores" =>$propiedades->errores));
			echo json_encode($response);
		}
		else{
			//http_response_code(503);
			echo json_encode(array("message" => "No se pudo crear la propiedad.",
								   "errores" => $propiedades->errores));
		}
	}
}
 
else{
    http_response_code(400);
    echo json_encode(array("error" => "No se pudo crear la propiedad, faltan datos."));
}*/
?>
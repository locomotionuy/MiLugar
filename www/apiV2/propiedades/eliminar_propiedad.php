<?php
 
include_once '../config/database.php';
include_once '../objects/propiedades.php';
include_once '../validate_token.php';
 
$database = new Database();
$db = $database->getConnection();
 
$propiedades = new Propiedades($db);

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);
 
if($inmobiliaria!== false){
	if(!isset($decoded['id'])){
		http_response_code(503);
		echo json_encode(array("error" => "Falta código de propiedad."));
	}
	else{
		$propiedades->id = $decoded['id'];
		$propiedades->inmobiliaria = $inmobiliaria;
		if($propiedades->eliminar_propiedad()){
			http_response_code(200);
			echo json_encode(array("success" => "Propiedad eliminada correctamente."));
		}

		else{
			http_response_code(503);
			echo json_encode(array("error" => $propiedades->errores));
		}
	}
	}
else{
	http_response_code(503);
	echo json_encode(array("error" => "Credenciales incorrectas."));
}
 
?>
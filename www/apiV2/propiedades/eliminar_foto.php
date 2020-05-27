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
	$propiedades->id = $decoded['id'];
	$propiedades->foto = $decoded['foto'];
	$propiedades->inmobiliaria = $inmobiliaria;
	if($propiedades->eliminar_foto()){
		http_response_code(200);
		echo json_encode(array("success" => "Foto eliminada correctamente."));
	}

	else{
		http_response_code(503);
		echo json_encode(array("error" => $propiedades->errores));
	}
}
else{
	http_response_code(503);
	echo json_encode(array("error" => "Credenciales incorrectas."));
}
 
?>
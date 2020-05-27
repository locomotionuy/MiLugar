<?php 

include_once '../config/database.php';
include_once '../objects/propiedades.php';
include_once '../validate_token.php';
 
$database = new Database();
$db = $database->getConnection();

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);
 
if($token){
	$propiedades = new Propiedades($db);
	$propiedades->id = $decoded['id'];
	$propiedades->inmobiliaria = $inmobiliaria;
	if($propiedades->leer_consulta()){
		echo json_encode($propiedades->Mensajes);
	}else if($propiedades->errores){
		echo json_encode(array("error" => $propiedades->errores));
	}

}
else{
    http_response_code(401);
    echo json_encode(array("error" => "Falta token."));
}


?>
<?php 

include_once '../config/database.php';
include_once '../objects/propiedades.php';
include_once '../validate_token.php';
 
$database = new Database();
$db = $database->getConnection();
 
if($token){
		
	$propiedades = new Propiedades($db);
	$propiedades->inmobiliaria = $inmobiliaria;
	if($propiedades->listar_consultas()){

		$num = count($propiedades->Mensajes);
		//if($num>0)
			echo json_encode(array("cantidad" => $num , "consultas" => $propiedades->Mensajes));
		/*else 
			echo json_encode(array("cantidad" => 0));*/
	}

}
 
else{
 
    http_response_code(401);
    echo json_encode(array("error" => "Falta token."));
}


?>
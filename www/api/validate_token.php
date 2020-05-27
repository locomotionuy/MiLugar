<?php 

// required headers
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

include_once 'objects/usuario.php';
$user = new User($db);
$headers = getallheaders();
//$user->codigo_integradora = $headers["codigo_integradora"];

/*foreach($headers as $key=>$val){
 // echo $key . ': ' . $val . '<br>';
	error_log( $key . ': ' . $val );
}*/
/*
if($user->integradoraExists()){	
	$integradora = $user->integradora;*/
	if (isset($headers['Authorization'])) {
		$tokenObject = explode(' ', $headers['Authorization']);
		if (count($tokenObject) == 2) {
			$token = $tokenObject[1];
		}
	}
	//$token = $tokenValue;
	$jwt=isset($token) ? $token : "";
	if($jwt){
		
		try {
			$decoded = JWT::decode($jwt, $key, array('HS256'));
			$array = json_decode(json_encode($decoded),true);
			$inmobiliaria = $array["data"]["id"];
			$permisos = $array["data"]["permisos"];
		}
	
		catch (Exception $e){
			$inmobiliaria = false;
			http_response_code(401);
			echo json_encode(array("message" => "Accesso denegado."));
		}
	}
	
	else{
		$inmobiliaria = false;
		http_response_code(401);
		echo json_encode(array("error" => "Falta token."));
	}
	/*
}else{
	$integradora = false;
	http_response_code(401);
	echo json_encode(array("error" => "Falta codigo de integradora."));
}
*/

?>

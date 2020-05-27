<?php 

include_once 'config/database.php';
include_once 'objects/usuario.php';
 
$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$headers = getallheaders();

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);

$user->usuario = $decoded["usuario"];
$user->pass = $decoded["pass"];
$user->codigo_integradora = $headers["codigo_integradora"];
error_log( '$user->codigo_integradora: ' . $user->codigo_integradora );

include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

if($user->integradoraExists()){	
    error_log('integradora en login: '.$user->integradora);
	if($user->usuarioExists()){	
		$token = array(
		"data" => array(
				"id" => $user->id,
				"usuario" => $user->usuario,
				"permisos" => $user->permisos
		    )
		);
		
		http_response_code(200);
	
		$jwt = JWT::encode($token, $key);
		echo json_encode(
			array(
				"message" => "Login exitoso.",
				"nombre" => $user->nombre,
				//"id" => $user->id,
				"token" => $jwt
			)
		);
	}
	else{
		http_response_code(401);
		echo json_encode(array("error" => "Email o contraseña incorrectos."));
	//    echo json_encode(array("error" => "Email o contraseña incorrectos." , "usuario" => $user->usuario , "pass" => $user->pass));

	}
}else{
	http_response_code(401);
	echo json_encode(array("error" => "Falta codigo de integradora."));
}
?>
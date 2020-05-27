<?php 

include_once '../config/database.php';
include_once '../objects/propiedades.php';
//include_once '../validate_integradora.php';
include_once '../validate_token.php';
 
$database = new Database();
$db = $database->getConnection();
//if($integradora){
	if($token){
		try {
			$propiedades = new Propiedades($db);
			$stmt = $propiedades->listar_propiedades($inmobiliaria);
			$num = $stmt->rowCount();
			error_log('num: '.$num);
			if($num>0){

				$propiedadess_arr=array();
				$LocalidadArray=array();
				
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					extract($row);
					$NombreLocalidad = $IdLocalidad;
					//echo $IdLocalidad;
					$LocalidadArray = explode(", ",$IdLocalidad);
					$IdLocalidad = 0;
					if(count($LocalidadArray) == 2){
						$depto = mb_strtolower($LocalidadArray[0]);
						$ciudad = mb_strtolower($LocalidadArray[1]);
						$index=0;
						foreach ($propiedades->lista_ubicaciones as $li)
						{
							if(mb_strtolower($li[0])==$depto && mb_strtolower($li[1])==$ciudad){
								$IdLocalidad = $index;
								break;
							}
							$index++;
						}
					}else{
						$IdLocalidad = 'no existe';
					}
					$propiedades_item=array(
						"id" => $id,
						"IdTipoInmueble" => $IdTipoInmueble,
						"IdTipoOperacion" => $IdTipoOperacion,
						"IdLocalidad" => $IdLocalidad,
						"NombreLocalidad" => $NombreLocalidad,
						"titulo" => html_entity_decode($titulo),
						"descripcion" => html_entity_decode($descripcion),
						"UnidadPrecio" => $IdUnidadPrecio,
						"Precio" => $Precio,
						"publicado" => $publicado,
						"vendida" => $vendida
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
/*}
else{

	http_response_code(401);
	echo json_encode(array("error" => "Falta integradora."));
}	

*/
?>
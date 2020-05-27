<?php 

include_once 'config/core.php';

$headers = getallheaders();
error_log("codigo_integradora: ".$headers['codigo_integradora']);
$codigo_integradora = $headers['codigo_integradora'];

if (isset($headers['codigo_integradora'])) {
	
}

function integradoraExists(){

    $query = "SELECT * FROM integradoras WHERE activo=1 && codigo = '$codigo_integradora' LIMIT 1";
    $stmt = $this->conn->prepare( $query );
    

    $stmt->execute();
    while( $row = $stmt->fetch() ) 
    {
        $existe = true;
        //print_r($stmt);
        //echo 'La propiedad existe!!! id: '.$row['id'];
        if($row['inmobiliaria'] != $this->inmobiliaria){
            array_push($this->errores , "La propiedad no pertenece a este usuario.");
            //echo 'La propiedad no pertenece a este usuario!!!';
            return false;
        } 
    }
    
    $stmt->bindParam(1, $this->usuario);
    $stmt->execute();

    $num = $stmt->rowCount();

    if($num>0){
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(sha1($this->pass) == $row['pass']){
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->permisos = $row['permisos'];
            //error_log('permisos '.$row['permisos']);
            return true;
        }else{
            return false;
        }			
    }
    return false;
}

if($jwt){
	
    $inmobiliaria = false;
    http_response_code(401);
    echo json_encode(array("message" => "Accesso denegado."));

}
 
else{
	$inmobiliaria = false;
    http_response_code(401);
    echo json_encode(array("error" => "Falta codigo integradora."));
}
?>

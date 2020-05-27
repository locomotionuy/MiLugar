<?php

class User{
 
    private $conn;
	private $table_name = "usuarios";
	private $table_integradora = "integradoras";
 
    public $id;
    public $usuario;
	public $pass;
	
	public $codigo_integradora;
	public $integradora;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
	function usuarioExists(){

		$query = "SELECT * FROM " . $this->table_name . " WHERE milugar=1 && usuario = ? LIMIT 0,1";
		$stmt = $this->conn->prepare( $query );
		
		$stmt->bindParam(1, $this->usuario);
		$stmt->execute();

		$num = $stmt->rowCount();

		if($num>0){
			
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if(sha1($this->pass) == $row['pass']){
				$this->id = $row['id'];
				$this->nombre = $row['nombre'];
				$this->permisos = $row['permisos'];
				return true;
			}else{
				return false;
			}			
		}
		return false;
	}

	function integradoraExists(){
		//error_log( '$user->codigo_integradora: ' . $this->codigo_integradora );
		$query = "SELECT * FROM " . $this->table_integradora . " WHERE activo=1 && codigo = ? LIMIT 0,1";
		error_log( '$user->codigo_integradora: ' . $this->table_integradora );
		$stmt = $this->conn->prepare( $query );		
		$stmt->bindParam(1, $this->codigo_integradora);
		$stmt->execute();
		$num = $stmt->rowCount();
		if($num>0){
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->integradora = $row['usuario'];
			return true;			
		}
		return false;
	}

}
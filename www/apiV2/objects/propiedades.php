<?php

class Propiedades{
 
    private $conn;
    private $table_propiedades = "propiedades";
	private $table_mensajes = "mensajes";
	private $table_fotos = "fotos";
	private $table_integradoras = "integradoras";
 
	public $codigo_integradora;
	public $id;
	public $IdTipoInmueble;
	public $NombreTipoInmueble;
	public $IdTipoOperacion;
	public $NombreTipoOperacion;
	public $IdLocalidad;
	public $NombreLocalidad;
    public $titulo;
    public $descripcion;
    public $Precio;
    public $Calle;
    public $Esquina;
	public $inmobiliaria;
	public $SuperficieTotal;
	public $SuperficieConstruida;
	public $GastosComunesMonto;
	public $IdUnidadGastosComunes;
	public $IdUnidadPrecio;
	public $IdDormitorios;
	public $IdBanios;
	public $garage;
	public $mapa;
	public $latitud;
	public $longitud;
	public $video;
	public $garantia;
	public $amueblado;
	public $estado;
	public $orientacion;
	public $idOrientacion;
	public $aire_acondicionado;
	public $mascotas;
	public $fecha;
	public $parrillero;
	public $azotea;
	public $jardin;
	public $vivienda_social;
	public $barrio_privado;
	public $publicado;	
	
	public $lista_inmuebles;
	public $lista_orientaciones;
	public $lista_operaciones;
    public $lista_ubicaciones;
	
	public $Imagenes;
	public $Imagenes360;
	public $foto;
	
	public $Mensajes;
	
	private $extension = array("jpeg","jpg","png","PNG","JPG","JPEG");
	private $UploadFolder = "../../uploads/fotos";
	private $UploadFolderThumb = "../../uploads/fotos/thumbs";

	// Grande 360
	private $image_w360 = '4096';
	private $image_h360 = '2048';
	// Grande 2d
	private $image_w_2d = '1280';
	private $image_h_2d = '720';
	// Thumb
	private $th_image_w = '520';
	private $th_image_h = '260';
	private $config_thumbs = true;
	
	public $entrada_id;
	public $errores;
 
    public function __construct($db){
        $this->conn = $db;
		include_once "../../inc/inc-listas.php";
		include_once "../../inc/inc-functions.php";
		include_once "../../inc/inc-ubicaciones.php";
		$this->lista_inmuebles = $lista_inmuebles;
		$this->lista_orientaciones = $lista_orientaciones;
		$this->lista_operaciones = $lista_operaciones;
		$this->lista_ubicaciones = $lista_ubicaciones;
	}

	function integradoraExists(){
		$query = "SELECT * FROM " . $this->table_integradoras . " WHERE activo=1 && codigo = ? LIMIT 0,1";
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
	
	function listar_propiedades($id_inmobiliaria){
		$query = "SELECT * FROM " . $this->table_propiedades . " WHERE inmobiliaria = $id_inmobiliaria && milugar=1 ORDER BY id DESC ";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	
	function crear_propiedad(){
		
		$this->orientacion = $this->lista_orientaciones[$this->orientacion][0];
		$this->IdLocalidad = $this->lista_ubicaciones[$this->IdLocalidad][0].', '.$this->lista_ubicaciones[$this->IdLocalidad][1];
		
		try 
		{
			$sql = "INSERT INTO $this->table_propiedades
			( 
			titulo,
			IdTipoInmueble,
			IdTipoOperacion,
			IdLocalidad,
			Calle,
			Esquina,
			mapa,
			latitud,
			longitud,
			video,
			Precio,
			SuperficieConstruida,
			SuperficieTotal,
			IdDormitorios,
			IdBanios,
			garage,
			GastosComunesMonto,
			descripcion,
			IdUnidadPrecio,
			IdUnidadGastosComunes,	
			inmobiliaria,
			amueblado,
			orientacion,
			aire_acondicionado,
			estado,
			mascotas,
			parrillero,
			azotea,
			jardin,
			vivienda_social,
			barrio_privado,
			garantia,
			fecha,
			publicado,
			milugar
			)
			values 
			(
			'$this->titulo',
			'$this->IdTipoInmueble',
			'$this->IdTipoOperacion',
			'$this->IdLocalidad',
			'$this->Calle',
			'$this->Esquina',
			'$this->mapa',
			'$this->latitud',
			'$this->longitud',
			'$this->video',
			'$this->Precio',
			'$this->SuperficieConstruida',
			'$this->SuperficieTotal',
			'$this->IdDormitorios',
			'$this->IdBanios',
			'$this->garage',
			'$this->GastosComunesMonto',
			'$this->descripcion',
			'$this->IdUnidadPrecio',
			'$this->IdUnidadGastosComunes',		
			'$this->inmobiliaria',
			'$this->amueblado',
			'$this->orientacion',
			'$this->aire_acondicionado',
			'$this->estado',
			'$this->mascotas',
			'$this->parrillero',
			'$this->azotea',
			'$this->jardin',
			'$this->vivienda_social',
			'$this->barrio_privado',
			'$this->garantia',
			'$this->fecha',
			'$this->publicado',
			'1'
			)";

			$this->conn->exec($sql);
			$this->entrada_id = $this->conn->lastInsertId();
			
			$this->errores = array();
			$orden = 1;
			ini_set ('gd.jpeg_ignore_warning', 1);
			//error_log('Imagenessss: '.count($this->Imagenes));
			//error_log('Image 1: '.count($this->Imagenes[0]));
			if($this->Imagenes && count($this->Imagenes) > 0){
				foreach($this->Imagenes as $images){
					
					foreach($images as $image){

						if(empty($image['foto'])) continue;
						
						$image['foto'] = preg_replace('/\s+/', '', $image['foto']);

						$ext = pathinfo($image['foto'], PATHINFO_EXTENSION);
						if(in_array($ext, $this->extension) == false){
							array_push($this->errores, $image['foto']." es un formato incorrecto de imagen.");
							continue;
						} 
						else
						{
							$name = 'api2d_'.$orden.$this->entrada_id.date("ymds").".".$ext;
							$path = '../../uploads/fotos/'.$name;
							$pathThumb = '../../uploads/fotos/thumbs/'.$name;

							$information = getimagesize($image['foto']);
							$width=$information[0];
							$height=$information[1];
							
							$ratio = $width/$height;
							
							$new_height = $height;
							$new_width = $width;
							$new_th_height = $height;
							$new_th_width = $width;
							
							if($width>=$this->image_w_2d && $height>=$this->image_h_2d)//primero chequeo si la foto es más grande de lo permitido. sino queda igual
							{
								if($width>=$height)//foto horizontal o cuadrada
								{
									$new_width = $this->image_w_2d;
									$new_height = intval( $height * $new_width / $width );
									$new_th_width = $this->th_image_w;
									$new_th_height = intval( $height * $new_th_width / $width );
								}else//foto vertical
								{
									$new_height = $this->image_h_2d;
									$new_width = intval( $width * $new_height / $height );
									$new_th_height = $this->th_image_h;
									$new_th_width = intval( $width * $new_th_height / $height );
								}
							}
							
	/*						
private $image_w_2d = '1280';
private $image_h_2d = '720';
private $th_image_w = '520';
private $th_image_h = '260';
		*/					

							if($ext == "jpg" || $ext == "jpeg" || $ext == "JPEG" || $ext == "JPG") {
								$tmp=imagecreatetruecolor($new_width,$new_height);
								$src=imagecreatefromjpeg($image['foto']); 
								imagecopyresampled($tmp, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

								if($this->config_thumbs == true){
									$thumb = imagecreatetruecolor( $new_th_width, $new_th_height );
									imagecopyresampled( $thumb, $tmp, 0, 0, 0, 0, $new_th_width, $new_th_height, $new_width, $new_height );
								}
								imagejpeg($tmp, $path,75);
								if($this->config_thumbs == true){
									imagejpeg($thumb, $pathThumb,75);
									imagedestroy($thumb);
								}
							}
							usleep(10000);
							imagedestroy($tmp);
							imagedestroy($src);
							
							$url = 'https://'.$_SERVER['SERVER_NAME'].'/uploads/fotos/'.$name;
							$url_thumb = 'https://'.$_SERVER['SERVER_NAME'].'/uploads/fotos/thumbs/'.$name;	
							
							$url = preg_replace('/\s+/', '', $url);
							$url_thumb = preg_replace('/\s+/', '', $url_thumb);
													
							$sqlImg = "INSERT INTO $this->table_fotos (foto,foto_thumb,id_referencia,tipo,seccion,orden,nombre) 
							VALUES ('$url','$url_thumb',$this->entrada_id,'foto','propiedades',$orden,'".$image['nombre']."')";

							try {
								$this->conn->exec($sqlImg);
								$orden++;
							}
							catch(PDOException $e)
							{
								array_push($this->errores,$e->getMessage());
								return false;
							}
						}
					}
				}
			}
			
			if($this->Imagenes360 && count($this->Imagenes360) > 0 ){
						//print_r($this->Imagenes360);
				foreach($this->Imagenes360 as $images){

					foreach($images as $image){
						if(empty($image['foto'])) continue;

						$ext = pathinfo($image['foto'], PATHINFO_EXTENSION);
						if(in_array($ext, $this->extension) == false){
							array_push($this->errores, $image['foto']." es un formato incorrecto de imagen.");
							continue;
						} 
						else
						{
							$name = 'api360_'.$orden.$this->entrada_id.date("ymds").".".$ext;
							$path = '../../uploads/fotos/'.$name;
							$pathThumb = '../../uploads/fotos/thumbs/'.$name;

							$information = getimagesize($image['foto']);
							$width=$information[0];
							$height=$information[1];
							
							if($width<$this->image_w360 or $height<$this->image_h360){
								array_push($this->errores, $image['foto']." es muy chica. Tamaño mínimo de foto 360: ".$this->image_w360."px x ".$this->image_h360."px.");
								continue;
							}
							
							$ratio = $width/$height;
							if($ratio != 2){
								array_push($this->errores, $image['foto']." no tiene la proporción correcta (2x1).");
								continue;
							} 
							
							$th_image_h = $this->th_image_w / $ratio;

							if($ext == "jpg" || $ext == "jpeg" || $ext == "JPEG" || $ext == "JPG") {
								$tmp=imagecreatetruecolor($this->image_w360,$this->image_h360);
								$src=imagecreatefromjpeg($image['foto']); 
								imagecopyresampled($tmp, $src, 0, 0, 0, 0, $this->image_w360, $this->image_h360, $width, $height);

								if($this->config_thumbs == true){
									$thumb = imagecreatetruecolor( $this->th_image_w, $th_image_h );
									imagecopyresampled( $thumb, $tmp, 0, 0, 0, 0, $this->th_image_w, $th_image_h, $this->image_w360, $this->image_h360 );
								}
								imagejpeg($tmp, $path,75);
								if($this->config_thumbs == true){
									imagejpeg($thumb, $pathThumb,75);
									imagedestroy($thumb);
								}
							} 

							$url = "https://".$_SERVER['SERVER_NAME']."/uploads/fotos/".$name;
							$url_thumb = "https://".$_SERVER['SERVER_NAME']."/uploads/fotos/thumbs/".$name;	
							
							$url = preg_replace('/\s+/', '', $url);
							$url_thumb = preg_replace('/\s+/', '', $url_thumb);
							
							usleep(10000);

							imagedestroy($tmp);
							imagedestroy($src);
							$sqlImg = "INSERT INTO $this->table_fotos (foto,foto_thumb,id_referencia,tipo,seccion,orden,nombre) 
							VALUES ('$url','$url_thumb',$this->entrada_id,'360','propiedades',$orden,'".$image['nombre']."')";
							
							try{
								$this->conn->exec($sqlImg);
								$orden++;
							}
							catch(PDOException $e)
							{
								array_push($this->errores,$e->getMessage());
								return false;
							}
						}
					}
				}
			}
		}
		catch(PDOException $e)
		{
			array_push($this->errores,$e->getMessage());
			return false;
		}
		//if(count($this->errores)>0) return false;
		return true;
	}
	
	function editar_propiedad(){
		
		$correcto = false;
		
		$query = "SELECT * FROM " . $this->table_propiedades . " WHERE id = $this->id LIMIT 1";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		while($rows = $stmt->fetch())
		{
			if($rows['inmobiliaria'] != $this->inmobiliaria){
				$correcto = false;
				$this->errores = 'La propiedad no pertenece a este inmobiliaria.';
				return false;
			}
			else{
				$correcto = true;
				$query = "UPDATE " . $this->table_propiedades . " SET ";

				$this->orientacion = $this->lista_orientaciones[$this->orientacion][0];
				$this->IdLocalidad = $this->lista_ubicaciones[$this->IdLocalidad][0].', '.$this->lista_ubicaciones[$this->IdLocalidad][1];

				if(isset($this->IdTipoInmueble)) $query .= " IdTipoInmueble = $this->IdTipoInmueble ,";
				if(isset($this->IdTipoOperacion)) $query .= " IdTipoOperacion = $this->IdTipoOperacion ,";
				if(isset($this->IdLocalidad)) $query .= " IdLocalidad = '$this->IdLocalidad' ,";
				if(isset($this->titulo)) $query .= " titulo = '$this->titulo' ,";
				if(isset($this->descripcion)) $query .= " descripcion = '$this->descripcion' ,";
				if(isset($this->Calle)) $query .= " Calle = '$this->Calle' ,";
				if(isset($this->Esquina)) $query .= " Esquina = '$this->Esquina' ,";
				if(isset($this->Precio)) $query .= " Precio = '$this->Precio' ,";
				if(isset($this->SuperficieTotal)) $query .= " SuperficieTotal = '$this->SuperficieTotal' ,";
				if(isset($this->SuperficieConstruida)) $query .= " SuperficieConstruida = '$this->SuperficieConstruida' ,";
				if(isset($this->GastosComunesMonto)) $query .= " GastosComunesMonto = '$this->GastosComunesMonto' ,";
				if(isset($this->IdUnidadGastosComunes)) $query .= " IdUnidadGastosComunes = '$this->IdUnidadGastosComunes' ,";
				if(isset($this->IdUnidadPrecio)) $query .= " IdUnidadPrecio = '$this->IdUnidadPrecio' ,";
				if(isset($this->IdDormitorios)) $query .= " IdDormitorios = '$this->IdDormitorios' ,";
				if(isset($this->IdBanios)) $query .= " IdBanios = '$this->IdBanios' ,";
				if(isset($this->garage)) $query .= " garage = '$this->garage' ,";
				//if(isset($this->mapa)) $query .= " mapa = '$this->mapa' ,";
				if(isset($this->latitud)) $query .= " latitud = '$this->latitud' ,";
				if(isset($this->longitud)) $query .= " longitud = '$this->longitud' ,";
				if(isset($this->video)) $query .= " video = '$this->video' ,";
				if(isset($this->garantia)) $query .= " garantia = '$this->garantia' ,";
				if(isset($this->amueblado)) $query .= " amueblado = $this->amueblado ,";
				if(isset($this->orientacion)) $query .= " orientacion = '$this->orientacion' ,";
				if(isset($this->aire_acondicionado)) $query .= " aire_acondicionado = $this->aire_acondicionado ,";
				if(isset($this->mascotas)) $query .= " mascotas = $this->mascotas ,";
				if(isset($this->parrillero)) $query .= " parrillero = $this->parrillero ,";
				if(isset($this->azotea)) $query .= " azotea = $this->azotea ,";
				if(isset($this->jardin)) $query .= " jardin = $this->jardin ,";
				if(isset($this->vivienda_social)) $query .= " vivienda_social = $this->vivienda_social ,";
				if(isset($this->barrio_privado)) $query .= " barrio_privado = $this->barrio_privado ,";
				if(isset($this->publicado)) $query .= " publicado = $this->publicado ,";
				if(isset($this->vendida)) $query .= " vendida = $this->vendida ,";
				if(isset($this->estado)) $query .= " estado = '$this->estado' ,";

				$query = substr_replace($query ,"", -1);

				$query .= " WHERE id = $this->id LIMIT 1";
				//echo $query."<br>";

				try 
				{
					$this->conn->exec($query);
					return true;
				}
				catch(PDOException $e)
				{
					$this->errores = $e->getMessage();
					return false;
				}
			}

		}
		return false;
		
	}
	
	function leer_propiedad(){
		
		$this->errores = array();
		
		$query = "SELECT * FROM " . $this->table_propiedades . " p WHERE p.id = ? LIMIT 0,1";
		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if($this->inmobiliaria!=$row['inmobiliaria']){
			array_push($this->errores,'Esta propiedad no pertenece a esa inmobiliaria');
			return false;
			//break;
		}else{

			$this->orientacion=$row['orientacion'];
			$index=0;
			foreach ($this->lista_orientaciones as $li)
			{
				if($li[0] == $row['orientacion']) {
					$this->IdOrientacion = $index;
					break;
				}
				$index++;
			}
			$this->IdTipoInmueble = intval($row['IdTipoInmueble']);
			error_log('IdTipoInmueble '.$this->IdTipoInmueble);
			foreach ($this->lista_inmuebles as $li)
			{
				//error_log('$li[0] '.$li[0]);
				if($li[0]==$this->IdTipoInmueble){
					$this->NombreTipoInmueble = $li[1];
					error_log('ENCONTRO NombreTipoInmueble: '.$li[1]);
					break;
				}
			}

			$this->IdTipoOperacion = $row['IdTipoOperacion'];
			foreach ($this->lista_operaciones as $li)
			{
				if($li[0]==$row['IdTipoOperacion']){
					$this->NombreTipoOperacion = $li[1];
					break;
				}
			}
	/*en la base se guarda el nombre en la columna IdLocadidad. cagadas... pero bua. */
			$this->NombreLocalidad = $row['IdLocalidad'];
			$LocalidadArray = explode(", ",$row['IdLocalidad']);
			$depto = $LocalidadArray[0];
			$ciudad = $LocalidadArray[1];
			$index=0;
			foreach ($this->lista_ubicaciones as $li)
			{
				if($li[0]==$depto && $li[1]==$ciudad){
					$this->IdLocalidad = $index;
					break;
				}
				$index++;
			}

			$this->titulo = $row['titulo'];
			$this->descripcion = $row['descripcion'];
			$this->Calle = $row['Calle'];
			$this->Esquina = $row['Esquina'];
			$this->Precio = $row['Precio'];
			$this->SuperficieTotal=$row['SuperficieTotal'];
			$this->SuperficieConstruida=$row['SuperficieConstruida'];
			$this->GastosComunesMonto=$row['GastosComunesMonto'];
			$this->IdUnidadGastosComunes=$row['IdUnidadGastosComunes'];
			$this->IdUnidadPrecio=$row['IdUnidadPrecio'];
			$this->IdDormitorios=$row['IdDormitorios'];
			$this->IdBanios=$row['IdBanios'];
			$this->garage=$row['garage'];
			//$this->mapa=$row['mapa'];
			$this->latitud=$row['latitud'];
			$this->longitud=$row['longitud'];
			$this->video=$row['video'];
			$this->garantia=$row['garantia'];
			$this->amueblado=$row['amueblado'];
			$this->estado=$row['estado'];
			$this->aire_acondicionado=$row['aire_acondicionado'];
			$this->mascotas=$row['mascotas'];
			$this->fecha=$row['fecha'];
			$this->parrillero=$row['parrillero'];
			$this->azotea=$row['azotea'];
			$this->jardin=$row['jardin'];
			$this->vivienda_social=$row['vivienda_social'];
			$this->barrio_privado=$row['barrio_privado'];
			$this->publicado=$row['publicado'];
			$this->vendida=$row['vendida'];

			$this->Imagenes_array = array();
			$query = "SELECT * FROM " . $this->table_fotos . " WHERE id_referencia = $this->id && tipo='foto' ORDER BY orden ASC ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();

			while($rows = $stmt->fetch())
			{
				$Imagen = array();
				$Imagen['foto'] = $rows['foto'];
				$Imagen['nombre'] = $rows['nombre'];
				array_push($this->Imagenes_array , $Imagen);
			}
			$this->Imagenes360_array = array();
			$query = "SELECT * FROM " . $this->table_fotos . " WHERE id_referencia = $this->id && tipo='360' ORDER BY orden ASC ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			while($rows = $stmt->fetch())
			{
				$Imagen = array();
				$Imagen['foto'] = $rows['foto'];
				$Imagen['nombre'] = $rows['nombre'];
				array_push($this->Imagenes360_array , $Imagen);
			}

			$this->Mensajes = array();
			$query = "SELECT * FROM " . $this->table_mensajes . " WHERE id_referencia = $this->id ";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			while($rows = $stmt->fetch())
			{
				$Mensaje = array();
				$Mensaje['id'] = $rows['id'];
				$Mensaje['email'] = $rows['email'];
				$Mensaje['nombre'] = $rows['nombre'];
				$Mensaje['telefono'] = $rows['telefono'];
				$Mensaje['consulta'] = $rows['consulta'];
				$Mensaje['fecha'] = $rows['fecha'];
				$Mensaje['leido'] = $rows['leido'];
				array_push($this->Mensajes , $Mensaje);
			}
			return true;
		}
		return false;
	}
	
	function eliminar_propiedad(){
		
		$this->errores = array();
		$existe = false;
		$stmt = $this->conn->prepare("SELECT * FROM " .$this->table_propiedades. " WHERE id=".$this->id." LIMIT 1");
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
		if(!$existe){
			array_push($this->errores , "Codigo de propiedad no existe.");
			return false;
		}else{
				
			$query = "DELETE FROM " . $this->table_propiedades . " WHERE id=$this->id LIMIT 1";
			$this->conn->exec($query);
			//echo $query."<br>";
			
			$stmt = $this->conn->prepare("SELECT * FROM '$this->table_fotos' WHERE id_referencia=$this->id && tipo!='logo' ");
			$stmt->execute();
			while( $row = $stmt->fetch() ) 
			{
				//echo '<br>foto: '.$row['foto'];
				$idBorrar = $row['id'];
				if(strpos($row['foto'], 'dimension') === false or strpos($row['foto'], 'milugar') === false){
					//echo 'Esta en nuestro servdor';
					unlink($row["foto"]);
					unlink($row["foto_thumb"]);
				} 
				$sql = "DELETE FROM '$this->table_fotos' WHERE id_referencia=$this->id && id=$idBorrar ";
				//echo $sql;
				$this->conn->exec($sql);
			}
			return true;
		}
		
		return false;

	}
	
	function eliminar_foto(){
		
		$this->errores = array();
		$existe = false;
		$stmt = $this->conn->prepare("SELECT * FROM " .$this->table_propiedades. " WHERE id=".$this->id." LIMIT 1");
		$stmt->execute();
		while( $row = $stmt->fetch() ) 
        {
			$existe = true;
			if($row['inmobiliaria'] != $this->inmobiliaria){
				array_push($this->errores , "La foto no pertenece a este usuario.");
				return false;
			} 
		}
		if(!$existe){
			array_push($this->errores , "Codigo de propiedad no existe.");
			return false;
		}else{
			$existe = false;
			$stmt = $this->conn->prepare("SELECT * FROM " .$this->table_fotos. " WHERE id_referencia=$this->id && tipo!='logo' && foto='$this->foto' LIMIT 1 ");
			$stmt->execute();
			while( $row = $stmt->fetch() ) 
			{
				$existe = true;
				if(strpos($row['foto'], 'dimension') === false or strpos($row['foto'], 'milugar') === false){
					//echo $row["foto"];
					unlink(str_replace(' ', '', $row["foto"]));
					unlink(str_replace(' ', '', $row["foto_thumb"]));
				} 
				$sql = "DELETE FROM ".$this->table_fotos." WHERE id_referencia=$this->id && tipo!='logo' && foto='$this->foto' LIMIT 1 ";
				if($this->conn->exec($sql))	return true;
				else {
					//echo $sql."<br>";
					array_push($this->errores , "Hubo un error.");
					return false;
				}
			}
			if(!$existe){
				array_push($this->errores , "URL de foto no existe o no pertenece a esa propiedad.");
				return false;
			}
		}
		
		return false;

	}
	
	function listar_consultas(){
		$this->Mensajes = array();
		$query = "SELECT * FROM " . $this->table_mensajes . " WHERE inmobiliaria = $this->inmobiliaria ORDER BY id DESC";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		while($rows = $stmt->fetch())
		{
			$Mensaje = array();
			$Mensaje['email'] = $rows['email'];
			$Mensaje['nombre'] = $rows['nombre'];
			$Mensaje['telefono'] = $rows['telefono'];
			$Mensaje['consulta'] = $rows['consulta'];
			$Mensaje['fecha'] = $rows['fecha'];
			$Mensaje['leido'] = $rows['leido'];
			$Mensaje['id_propiedad'] = $rows['id_referencia'];
			array_push($this->Mensajes , $Mensaje);
		}
		return true;
	}
	
	function leer_consulta(){
		$this->Mensajes = array();
		$query = "SELECT * FROM " . $this->table_mensajes . " WHERE id = $this->id LIMIT 1";
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
		while($row = $stmt->fetch())
		{
			if($row['inmobiliaria'] == $this->inmobiliaria){
				$this->Mensajes['id'] = $row['id'];
				$this->Mensajes['email'] = $row['email'];
				$this->Mensajes['nombre'] = $row['nombre'];
				$this->Mensajes['telefono'] = $row['telefono'];
				$this->Mensajes['consulta'] = $row['consulta'];
				$this->Mensajes['fecha'] = $row['fecha'];
				$this->Mensajes['leido'] = true;
				$this->Mensajes['id_propiedad'] = $row['id_referencia'];
				
				$query = "UPDATE " . $this->table_mensajes . " SET leido=true WHERE id = $this->id LIMIT 1";
				
				try 
				{
					$this->conn->exec($query);
					return true;
				}
				catch(PDOException $e)
				{
					$this->errores = $e->getMessage();
					return false;
				}
				
			}else{
				$this->errores = 'La consulta no pertenece a esta inmobiliaria.';
				return false;
				break;
			}
		}
		return true;
	}
}
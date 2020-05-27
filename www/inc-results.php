<?php 
require 'inc/inc-paginator.php';

$tabla = 'propiedades';
$sinresultados = "Búsqueda sin resultados.";

if(isset($_GET["buscar"]))
{
	// Buscador principal
	if(isset($_GET['operacion'])) { $operacion = $_GET['operacion']; }
	if(isset($_GET['tipo'])) { $tipo = $_GET['tipo']; }
	if(isset($_GET['ubicacion'])) { $ubicacion = $_GET['ubicacion']; }	
	
	// Avanzado
	if(isset($_GET['dormitorios'])) { $dormitorios = $_GET['dormitorios']; }
	if(isset($_GET['banios'])) { $banios = $_GET['banios']; }
	if(isset($_GET['moneda'])) { $moneda = $_GET['moneda']; } else { $moneda = ""; }
	if(isset($_GET['estado'])) { $estado = $_GET['estado']; } else { $estado = ""; }
	if(isset($_GET['sup_construida'])) { $sup_construida = $_GET['sup_construida']; }
	if(isset($_GET['sup_total'])) { $sup_total = $_GET['sup_total']; }
	if(isset($_GET['orientacion'])) { $garage = $_GET['orientacion']; }
	if(isset($_GET['garantia'])) { $garage = $_GET['garantia']; }
	
	if(isset($_GET['precio_min']) and $_GET['precio_min']!="") {
		$str_precio = str_replace(".", "", $_GET['precio_min']);
		$precio_min = intval($str_precio);
	} 
	if(isset($_GET['precio_max']) and $_GET['precio_max']!="") {
		$str_precio = str_replace(".", "", $_GET['precio_max']);
		$precio_max = intval($str_precio);
	}
	
	// Checkboxes
	if(isset($_GET['garage'])) { $garage = $_GET['garage']; } else { $garage = ""; }
	if(isset($_GET['amueblado'])) { $amueblado = $_GET['amueblado']; } else { $amueblado = ""; }
	if(isset($_GET['barrio_privado'])) { $barrio_privado = $_GET['barrio_privado']; } else { $barrio_privado = ""; }
	if(isset($_GET['vivienda_social'])) { $vivienda_social = $_GET['vivienda_social']; } else { $vivienda_social = ""; }
	if(isset($_GET['jardin'])) { $jardin = $_GET['jardin']; } else { $jardin = ""; }
	if(isset($_GET['parrillero'])) { $parrillero = $_GET['parrillero']; } else { $jardin = ""; }
	
	// EMPIEZA 1er SELECT (WHERE MONEDA ES $)
	$sql = "SELECT * FROM ( ( SELECT * FROM $tabla WHERE IdUnidadPrecio='UYU' ";
	
	// EN CONSULTA IGUAL A $ SI LA MONEDA ES U$S
	if($moneda=="USD")
	{
		if(isset($precio_min) and $precio_min!=="") { $precio_min2 = round($precio_min * $config_cotizacion); $sql .= " and Precio >= '$precio_min2' "; }
		if(isset($precio_max) and $precio_max!=="") { $precio_max2 = round($precio_max * $config_cotizacion); $sql .= " and Precio <= '$precio_max2' "; }
		/*if(isset($precio_min) and $precio_min!=="") $sql .= " and Precio >= '$precio_min' ";
		if(isset($precio_max) and $precio_max!=="") $sql .= " and Precio <= '$precio_max' ";*/
	}
	else
	{
		if(isset($precio_min) and $precio_min!=="") $sql .= " and Precio >= '$precio_min' ";
		if(isset($precio_max) and $precio_max!=="") $sql .= " and Precio <= '$precio_max' ";
	}
	
	// Tipo inmueble Array(Casa, Apto, Terreno)
	if(isset($tipo) and $tipo!=="")
		{
		$i = 1;
		if (count($tipo) > 1) $sql .= " and ("; else  $sql .= " and ";
		foreach ($tipo as $row_tipo)
		{
			if($i == 1) $sql .= " IdTipoInmueble='$row_tipo' ";
			if($i !== 1) $sql .= " or IdTipoInmueble='$row_tipo' ";
			$i ++;
		}
		if (count($tipo) > 1) $sql .= ") ";
	}
	
	// Ubicacion Array((Montevideo, Pocitos),(Montevideo, Cordon))	
	if(isset($ubicacion) and $ubicacion!=="")
	{
		$i = 1;
		if (count($ubicacion) > 1) $sql .= " and ("; else  $sql .= " and ";
		foreach ($ubicacion as $row_ubicacion)
		{
			if($i == 1) $sql .= " IdLocalidad='$row_ubicacion' ";
			if($i !== 1) $sql .= " or IdLocalidad='$row_ubicacion' ";
			$i ++;
		}
		if (count($ubicacion) > 1) $sql .= ") ";
	}
	
	// Estado (Impecable, buena estado, estrenar, etc)
	if(isset($estado) and $estado!=="")
	{
		$i = 1;
		if (count($estado) > 1) $sql .= " and ("; else  $sql .= " and ";
		foreach ($estado as $row_estado)
		{
			if($i == 1) $sql .= " estado='$row_estado' ";
			if($i !== 1) $sql .= " or estado='$row_estado' ";
			$i ++;
		}
		if (count($estado) > 1) $sql .= ") ";
	}
	
	// IGUALACIONES SIMPLES
	if(isset($dormitorios) and $dormitorios!=="") $sql .= " and IdDormitorios=$dormitorios ";
	if(isset($banios) and $banios!=="") $sql .= " and IdBanios=$banios ";
	if(isset($sup_construida) and $sup_construida!=="") $sql .= " and SuperficieConstruida='$sup_construida' ";
	if(isset($sup_total) and $sup_total!=="") $sql .= " and SuperficieTotal='$sup_total' ";
	if(isset($orientacion) and $orientacion!=="") $sql .= " and orientacion='$orientacion' ";
	if(isset($garantia) and $garantia!=="") $sql .= " and garantia='$garantia' ";
	if(isset($garage) and $garage!=="") $sql .= " and garage='$garage' ";
	if(isset($amueblado) and $amueblado!=="") $sql .= " and amueblado='$amueblado' ";
	if(isset($barrio_privado) and $barrio_privado!=="") $sql .= " and barrio_privado='$barrio_privado' ";
	if(isset($vivienda_social) and $vivienda_social!=="") $sql .= " and vivienda_social='$vivienda_social' ";	
	if(isset($jardin) and $jardin!=="") $sql .= " and jardin='$jardin' ";
	if(isset($parrillero) and $parrillero!=="") $sql .= " and parrillero='$parrillero' ";
	$sql .= " AND IdTipoOperacion='$operacion' ";
	$sql .= " AND publicado=1 ";
	$sql .= " AND milugar=1 ";
	
	//////////////////////////////////////////// $ -> UNION <- U$S ////////////////////////////////////////////
	$sql .= " ) UNION ( ";
	
	// EMPIEZA 2° SELECT (WHERE MONEDA ES USD)
	$sql .= " SELECT * FROM $tabla WHERE IdUnidadPrecio='USD' ";
	
	// EN CONSULTA IGUAL A USD SI LA MONEDA ES UYU
	if($moneda=="UYU")
	{
		if(isset($precio_min) and $precio_min!=="") { $precio_min3 = round($precio_min / $config_cotizacion); $sql .= " and Precio >= '$precio_min3' "; }
		if(isset($precio_max) and $precio_max!=="") { $precio_max3 = round($precio_max / $config_cotizacion); $sql .= " and Precio <= '$precio_max3' "; }
	}
	else
	{
		if(isset($precio_min) and $precio_min!=="") $sql .= " and Precio >= '$precio_min' ";
		if(isset($precio_max) and $precio_max!=="") $sql .= " and Precio <= '$precio_max' ";
	}
	
	// Tipo inmueble Array(Casa, Apto, Terreno)
	if(isset($tipo) and $tipo!=="")
		{
		$i = 1;
		if (count($tipo) > 1) $sql .= " and ("; else  $sql .= " and ";
		foreach ($tipo as $row_tipo)
		{
			if($i == 1) $sql .= " IdTipoInmueble='$row_tipo' ";
			if($i !== 1) $sql .= " or IdTipoInmueble='$row_tipo' ";
			$i ++;
		}
		if (count($tipo) > 1) $sql .= ") ";
	}
	
	// Ubicacion Array((Montevideo, Pocitos),(Montevideo, Cordon))	
	if(isset($ubicacion) and $ubicacion!=="")
	{
		$i = 1;
		if (count($ubicacion) > 1) $sql .= " and ("; else  $sql .= " and ";
		foreach ($ubicacion as $row_ubicacion)
		{
			if($i == 1) $sql .= " IdLocalidad='$row_ubicacion' ";
			if($i !== 1) $sql .= " or IdLocalidad='$row_ubicacion' ";
			$i ++;
		}
		if (count($ubicacion) > 1) $sql .= ") ";
	}
	
	// Estado (Impecable, buena estado, estrenar, etc)
	if(isset($estado) and $estado!=="")
	{
		$i = 1;
		if (count($estado) > 1) $sql .= " and ("; else  $sql .= " and ";
		foreach ($estado as $row_estado)
		{
			if($i == 1) $sql .= " estado='$row_estado' ";
			if($i !== 1) $sql .= " or estado='$row_estado' ";
			$i ++;
		}
		if (count($estado) > 1) $sql .= ") ";
	}
	
	// IGUALACIONES SIMPLES
	if(isset($dormitorios) and $dormitorios!=="") $sql .= " and IdDormitorios=$dormitorios ";
	if(isset($banios) and $banios!=="") $sql .= " and IdBanios=$banios ";
	if(isset($sup_construida) and $sup_construida!=="") $sql .= " and SuperficieConstruida='$sup_construida' ";
	if(isset($sup_total) and $sup_total!=="") $sql .= " and SuperficieTotal='$sup_total' ";
	if(isset($orientacion) and $orientacion!=="") $sql .= " and orientacion='$orientacion' ";
	if(isset($garantia) and $garantia!=="") $sql .= " and garantia='$garantia' ";
	if(isset($garage) and $garage!=="") $sql .= " and garage='$garage' ";
	if(isset($amueblado) and $amueblado!=="") $sql .= " and amueblado='$amueblado' ";
	if(isset($barrio_privado) and $barrio_privado!=="") $sql .= " and barrio_privado='$barrio_privado' ";
	if(isset($vivienda_social) and $vivienda_social!=="") $sql .= " and vivienda_social='$vivienda_social' ";
	if(isset($jardin) and $jardin!=="") $sql .= " and jardin='$jardin' ";

	if(isset($parrillero) and $parrillero!=="") $sql .= " and parrillero='$parrillero' ";	
	$sql .= " AND IdTipoOperacion='$operacion'";
	$sql .= " AND publicado=1";
	$sql .= " AND milugar=1";

	// ORDENAR POR DEFECTO
	if(!isset($_GET["order"]) or $_GET["order"]==0) $sql .= " ) ) AS i ORDER BY fecha DESC ";

	// ORDENAR POR PRECIO MAYOR PRIMERO
	if(isset($_GET["order"]) and $_GET["order"]==1) $sql .= " ) ) AS i ORDER BY Precio DESC ";
	
	// ORDENAR POR PRECIO MENOR PRIMERO
	if(isset($_GET["order"]) and $_GET["order"]==2) $sql .= " ) ) AS i ORDER BY Precio ASC ";
}
elseif (isset($_GET["inmobiliaria"])) 
{
	$sql = "SELECT * FROM $tabla WHERE inmobiliaria=".$_GET["inmobiliaria"]." AND publicado=1 AND milugar='1' ORDER BY id DESC ";	
	$sinresultados = "Esta inmobiliaria no ha subido propiedades aún.";
}
else
{
	$sql = "SELECT * FROM $tabla WHERE milugar='1' AND publicado=1 ORDER BY fecha DESC ";	
}

$pagination = new PDO_Pagination($conn);
$pagination->rowCount($sql);
$pagination->config(20, 24);

// LIMIT PARA PAGINADOR
$sql .= " LIMIT $pagination->start_row, $pagination->max_rows";

$query = $conn->prepare($sql);
$query->execute();

$model = array();
while($rows = $query->fetch())
{
  $model[] = $rows;
}
?>

<div class="results-info">
  <div class="count">
    <?php if($mod=="home") { echo $texto_ultimos_resultados; } else { echo $texto_resultados; } // else { echo $resultados.$texto_resultados; }
	?>
    : <?php echo $pagination->total; ?> </div>
  <div class="order"> 
    <script>
	function form_submit(var1)
	{
		  $('#adv_form').append('<input type="hidden" name="order" value="'+var1+'" />');
		  $("#adv_form").submit(); 
	}
    </script>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
      <select name="ordenar" onclick="if(this.value != <?php  if(isset($_GET["order"])) echo $_GET["order"]; else echo "0"; ?>) { form_submit(this.value) }" >
        <option value='0' <?php  if(!isset($_GET["order"]) or $_GET["order"]=="0") echo 'selected="selected"'?> ><?php echo $texto_orden_ingresos ?></option>
        <option value='1' <?php  if(isset($_GET["order"]) and $_GET["order"]=="1") echo 'selected="selected"'?> ><?php echo $texto_orden_may_precio ?></option>
        <option value='2' <?php  if(isset($_GET["order"]) and $_GET["order"]=="2") echo 'selected="selected"'?> ><?php echo $texto_orden_men_precio ?></option>
      </select>
    </form>
  </div>
</div>
<?php 
if(count($model)==0) echo "<br><br>".$sinresultados."<br><br>";
else{
	foreach($model as $row)
	{
		$inmueble = $lista_inmuebles[$row['IdTipoInmueble']-1][1];
		$operacion = $lista_operaciones[$row['IdTipoOperacion']-1][1];
		$tipovendida = $lista_operaciones[$row['IdTipoOperacion']-1][4];
	?>
<div class="result"><a class="wrap" href="file.php?id=<?php echo $row['id'] ?>">


  
  
  <div class="foto" style=" background-image:url(<?php 
				$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." ORDER BY orden ASC LIMIT 1");
				$stmt->execute();
				while( $imagen = $stmt->fetch() ) 
				{
					// Check if file exists
/*					$handle = @fopen($imagen["foto_thumb"], 'r');
					if($handle)
					{
						echo $imagen["foto_thumb"];
					}
					else
					{
						echo "images/sinfoto.jpg";
					}*/
					
					echo $imagen["foto_thumb"];
					//if(file_exists($imagen["foto_thumb"])) echo $imagen["foto_thumb"];
					//else if(file_exists($imagen["foto"])) echo $imagen["foto"];
					$tipo_foto = $imagen["tipo"];
				}
				?>)">
                <?php if($row['vendida']==1) echo '<div class="vendida"><i class="fas fa-handshake"></i>'.$tipovendida.'</div>'; ?>
			<?php if ($tipo_foto=='360') { ?>
            <div class="ready"><img src="images/360ready.png" alt="360Ready" /></div>
            <?php }?>
  </div>
  <div class="result_dato">
    <div class="precio">
      <?php if($row['IdUnidadPrecio']=="UYU" or $row['IdUnidadPrecio']=="$") echo "$"; else echo "U\$S"; ?>
      <?php  echo number_format($row['Precio'], 0, '', '.'); ?>
      </div>
    <div class="info"><?php echo $inmueble.' en '.$operacion; ?><br />
      <?php echo $row['IdLocalidad'] ?><br />
      <?php echo $row['SuperficieConstruida'] ?>m² Cons. - <?php echo $texto_label_dorms ?>: <?php if($row['IdDormitorios']==99) echo '+ de 4'; else echo $row['IdDormitorios']; ?> - <?php echo $texto_label_banio ?>: <?php if($row['IdBanios']==99) echo '+ de 4'; else echo $row['IdBanios']; ?> </div>
    <div class="favorite <?php
			if(isset($_COOKIE['favoritos']))
			{
				$favoritos_array = unserialize($_COOKIE['favoritos']);

				foreach($favoritos_array as $key => $valor)
				{
					if($valor==$row['id'])
					{
						echo "saved";
					}
				}
			}
			?>" id="<?php echo $row['id'] ?>"><i class="fas fa-heart"></i></div>
    <div class="result_dato_logo"> 
    
    <img src="<?php 
                $stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia='".$row['inmobiliaria']."' and tipo='logo' ORDER BY principal DESC LIMIT 1");
                $stmt->execute();
                while( $imagen = $stmt->fetch() ) 
                {
                    echo $imagen["foto"];
                }
                ?>" alt="Inmobiliaria" /> 
                
                </div>
  </div>
  </a> </div>
<?php 
	}
}
?>
<div class="pagination">
<?php
$pagination->pages("btn");
?>
</div>

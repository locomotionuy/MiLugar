<?php 
include '../inc-conn.php';
include 'inc-header.php'; 


$mod = 'Propiedades';
$tabla = 'propiedades';
?>
<script src="js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
	selector: 'textarea',
	height: 200,
	menubar: false,
	extended_valid_elements : "a[class|name|href|target|title|onclick|rel],script[type|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]",
	//convert_fonts_to_spans : false,
	invalid_elements: "font",
    paste_auto_cleanup_on_paste : true,
	paste_remove_styles: true,
	paste_remove_styles_if_webkit: true,
	paste_strip_class_attributes: "all",
	paste_as_text: true,
	plugins: ['autolink lists link textcolor paste visualblocks code'],
  	toolbar: ' undo redo | link code bold italic | alignleft aligncenter alignright alignjustify | forecolor fontsizeselect | removeformat',
		fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt'
		//toolbar: ' undo redo |  bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat'
	/* 	mobile: {
    theme: 'mobile'
  }*/
});
</script>
<?php 

// Grande para fotos 2d
$image_w_2d = '1280';
$image_h_2d = '720';
// Grande para fotos 360
$image_w = '4096';
$image_h = '2048';
// Thumbnail
$config_thumbs = true;
$th_image_w = '520';
$th_image_h = '260';
// Carpeta
$gallery_dir = "fotos";
$add_imagenes = 12;

//include 'inc-header.php';

if(isset($_GET['id']))
{
	$id = $_GET['id'];
}

// Galerias
if(isset($_GET['borrar_image_id']))
{
	$id = $_GET['borrar_image_id'];
	$stmt = $conn->prepare("SELECT * FROM fotos WHERE id=".$id);
	$stmt->execute();
	while( $row = $stmt->fetch() ) 
	{
		unlink($row["foto"]);
		unlink($row["foto_thumb"]);
	}
	$sql = "DELETE FROM fotos WHERE id=$id";
	$conn->exec($sql);
}

if(isset($_POST['publicar']))
{
	//$titulo = htmlspecialchars($_POST['titulo']);
	$titulo= str_replace("'", "\'", $_POST['titulo']); 
	//$titulo = mysqli_real_escape_string($conn , $_POST['titulo']);
	//echo " titulo: ".$titulo;
	$IdTipoInmueble = $_POST['IdTipoInmueble'];
	$IdTipoOperacion = $_POST['IdTipoOperacion'];
	if(isset($_POST['IdLocalidad'])) { $IdLocalidad = $_POST['IdLocalidad']; } else { $IdLocalidad = " "; }
	$Calle = $_POST['Calle'];
	$Esquina = $_POST['Esquina'];
	
	/*$mapaSimple = explode('"', $_POST['mapa']);
	if($mapaSimple[0] == "<iframe src=" ) $mapa = $mapaSimple[1];
  else $mapa = $_POST['mapa'];*/
  
  $latitud = $_POST['latitud'];
  $longitud = $_POST['longitud'];
	
	$videoSimple = explode('watch?v=', $_POST['video']);
	if($videoSimple[0] == "https://www.youtube.com/" ) $video = $videoSimple[1];
	else $video = $_POST['video'];
	
	$IdUnidadPrecio = $_POST['IdUnidadPrecio'];
	$Precio = $_POST['Precio'];
	$SuperficieConstruida = $_POST['SuperficieConstruida'];
	$SuperficieTotal = $_POST['SuperficieTotal'];
	$IdDormitorios = $_POST['IdDormitorios'];
	$IdBanios = $_POST['IdBanios'];
	$garage = $_POST['garage'];
	$IdUnidadGastosComunes = $_POST['IdUnidadGastosComunes'];	
	$GastosComunesMonto = $_POST['GastosComunesMonto'];
	$garantia = implode(",",$_POST['garantia']);
	//$descripcion = $_POST['descripcion'];
	//$str = str_replace('"','\'',$str)
	$descripcion= str_replace("'", "\'", $_POST['descripcion']); 
	$descripcion = str_replace('"', '\"',$descripcion);
	//$descripcion = mysql_real_escape_string($_POST['descripcion']);
	//echo "Describpcion ".$descripcion;
	if(isset($_POST['amueblado'])) { $amueblado = $_POST['amueblado']; } else { $amueblado = "0"; }
	if(isset($_POST['aire_acondicionado'])) { $aire_acondicionado = $_POST['aire_acondicionado']; } else { $aire_acondicionado = "0"; }
	if(isset($_POST['orientacion'])) { $orientacion = $_POST['orientacion']; } else { $orientacion = "0"; }
	if(isset($_POST['estado'])) { $estado = $_POST['estado']; } else { $estado = "0"; }
	if(isset($_POST['mascotas'])) { $mascotas = $_POST['mascotas']; } else { $mascotas = "0"; }
	if(isset($_POST['parrillero'])) { $parrillero = $_POST['parrillero']; } else { $parrillero = "0"; }
	if(isset($_POST['azotea'])) { $azotea = $_POST['azotea']; } else { $azotea = "0"; }
	if(isset($_POST['jardin'])) { $jardin = $_POST['jardin']; } else { $jardin = "0"; }
	if(isset($_POST['vivienda_social'])) { $vivienda_social = $_POST['vivienda_social']; } else { $vivienda_social = "0"; }	
	if(isset($_POST['barrio_privado'])) { $barrio_privado = $_POST['barrio_privado']; } else { $barrio_privado = "0"; }	
	if($usuario_permisos == '3') $publicado = "0";
	else if(isset($_POST['publicado'])) { $publicado = $_POST['publicado']; } else { $publicado = "0"; }	
  
	try 
	{
		$sql = "UPDATE $tabla SET 
		titulo='$titulo',
		IdTipoInmueble='$IdTipoInmueble',
		IdTipoOperacion='$IdTipoOperacion',
		IdLocalidad='$IdLocalidad',
		Calle='$Calle',
		Esquina='$Esquina',
		latitud=$latitud,
		longitud=$longitud,
		video='$video',
		IdUnidadPrecio='$IdUnidadPrecio',
		Precio='$Precio',
		SuperficieTotal='$SuperficieTotal',
		SuperficieConstruida='$SuperficieConstruida',
		IdDormitorios='$IdDormitorios',
		IdBanios='$IdBanios',
		garage='$garage',
		IdUnidadGastosComunes='$IdUnidadGastosComunes',
		GastosComunesMonto='$GastosComunesMonto',
		descripcion='$descripcion',
		amueblado='$amueblado',
		aire_acondicionado='$aire_acondicionado',
		orientacion='$orientacion',
		estado='$estado',
		mascotas='$mascotas',
		parrillero='$parrillero',
		azotea='$azotea',
		jardin='$jardin',
		vivienda_social='$vivienda_social',
		barrio_privado='$barrio_privado',
		garantia='$garantia',
		publicado='$publicado' 		
		WHERE id='$id'";
		
		$conn->exec($sql);
		
		$entrada_id = $id;
		
		$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$id." ORDER BY orden ASC");
		$stmt->execute();
		while( $foto = $stmt->fetch() ) 
		{
			$nombre = $_POST["nombre_".$foto['id']];
			$idFoto = $foto['id'];
			$sqlNombres = "UPDATE fotos SET nombre='$nombre' WHERE id='$idFoto'";
			$conn->exec($sqlNombres);
		}		
			
		if(isset($_FILES['foto']['name']))
		{
			include 'inc-upload-2d.php';		
		}
				
		if(isset($_FILES['imagen']['name']))
		{
			include 'inc-upload-edit.php';		
		}
		$enviado = 1;
    }
	catch(PDOException $e)
    {
		$error = $sql . "<br>" . $e->getMessage();
    }
}
?>

<div class="body">
  <div class="center">
      <div class="content">
        <ul class="titulo-secciones">
          <li><a href="index.php">Principal</a></li>
          <li><a href="<?php echo $tabla ?>.php"><?php echo $mod ?></a></li>
          <li><a href="<?php echo $tabla ?>-editar.php?id=<?php echo $row['id'] ?>">Editar</a></li>
          <li class="back"><a href="javascript:goBack()"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
        </ul>
        <?php if(isset($enviado)):?>
        <ul class="respuesta enviado">
          <li>Datos actualizados con éxito.</li>
          <li><a href="<?php echo $tabla ?>-upload.php"><i class="fas fa-file-upload"></i> Subir más <?php echo $mod ?>.</a></li>
          <li><a href="<?php echo $tabla ?>.php">Volver a <?php echo $mod ?>.</a></li>
        </ul>
        <?php elseif(isset($error)):?>
        <ul class="respuesta error">
          <li>Hubo un error, intentalo de nuevo.</li>
          <li><?php echo $error; ?></li>
        </ul>
        <?php endif;?>
        <div id="upload">
          <?php 
		$stmt = $conn->prepare("SELECT * FROM $tabla WHERE id=".$id);
		$stmt->execute();
		while( $row = $stmt->fetch() ) 
        {
        ?>
          <?php /*?><div class="codigo"> <span>
            <div class="texto_insercion"> Copia el código para incorporar el Visor 360 de esta propiedad en tu Web: </div>
            <input type="text" id="codigo_insercion" value='&lt;script type="text/javascript" src="https://dimension360.com.uy/js/dimension360.min.js" id="<?php echo $row['id'] ?>" height="500"&gt;&lt;/script&gt;'/>
            <div class="tooltip">
              <button onclick="codigo_function()" onmouseout="outFunc()"> <span class="tooltiptext" id="myTooltip">Copiar código de inserción</span> Copiar código </button>
            </div>
            </span> 
            <script>
function codigo_function() {
  var copyText = document.getElementById("codigo_insercion");
  copyText.select();
  document.execCommand("copy");
  
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Código copiado";
}

function outFunc() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copiar código";
}
</script> 
          </div><?php */?>
          <div id="uploading">
            <div id="subiendo"> SUBIENDO PUBLICACIÓN<br>
              <i class="fas fa-spinner fa-pulse"></i> </div>
          </div>
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>?id=<?php echo $row['id'] ?>" method="post" enctype="multipart/form-data">
            <fieldset>
              <label><i class="fas fa-check-square"></i>Publicado:</label>
              <div class="checkbox">
                <input type="checkbox" name="publicado" <?php if ($row['publicado']==1 or $row['publicado']==" ") { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-newspaper"></i> Titulo (máx 35)</label>
              <input maxlength="35" name="titulo" type="text" value="<?php echo $row['titulo'] ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-home"></i> Tipo de inmueble:</label>
              <select name="IdTipoInmueble">
                <?php 
				// El array esta en el inc-header.php
				foreach ($lista_inmuebles as $lista_inmueble)
				{
					echo '<option value="'.$lista_inmueble[0].'"';
					if($lista_inmueble[0]==$row['IdTipoInmueble']) echo 'selected="selected"';
					echo '>'.$lista_inmueble[1].'</option>'; 
				}
			 ?>
              </select>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-exchange-alt"></i> Tipo de operación:</label>
              <select name="IdTipoOperacion" onchange="mostrar_input(this)">
                <?php 
				// El array esta en el inc-header.php
				foreach ($lista_operaciones as $lista_operacion)
				{
					echo '<option value="'.$lista_operacion[0].'"';
					if($lista_operacion[0]==$row['IdTipoOperacion']) echo 'selected="selected"';
					echo '>'.$lista_operacion[1].'</option>'; 
				}
			    ?>
              </select>
            </fieldset>
			  
			  
            <fieldset <?php if($row['IdTipoOperacion']==2) echo 'class="none"'; ?> id="amueblado">
              <label><i class="fas fa-home"></i> Amueblado:</label>
              <div class="checkbox">
                <input type="checkbox" name="amueblado" <?php if ($row['amueblado']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-map-marked-alt"></i> Ubicación:</label>
              <div class="wrap_ubicacion">
                <select name="IdLocalidad" class="ubicacion" id="ubicacion" multiple="multiple">
                  <?php 
            foreach ($lista_ubicaciones as $lista_ubicacion)
            {
                echo '<option ';
				if($lista_ubicacion[0].", ".$lista_ubicacion[1]==$row['IdLocalidad']) echo 'selected="selected"';
                echo '>'.$lista_ubicacion[0].", ".$lista_ubicacion[1].'</option>'; 
            }
            ?>
                </select>
              </div>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-road"></i> Calle:</label>
              <input name="Calle" type="text" value="<?php echo $row['Calle'] ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-sign"></i> Esquina:</label>
              <input name="Esquina" type="text" value="<?php echo $row['Esquina'] ?>"/>
            </fieldset>
           <fieldset class="info">
            <label><i class="fas fa-map-marked-alt"></i> Latitud:</label>
            <input name="latitud" type="text" value="<?php echo $row['latitud'];?>" placeholder="ejemplo: -34.905727" />
            <i id="info_mapa" onClick="mostrarTuto(1)" class="fas fa-question-circle"></i>
            <div id="div_info_mapa" >
                <h3 style="margin-bottom:5px;">¿Dónde buscar latitud y longitud en Google Maps?</h3>
                <img src="../images/mapaTuto.gif" width="100%">
            </div>
          </fieldset>
            
          <fieldset class="info">
            <label><i class="fas fa-map-marked-alt"></i> Longitud:</label>
            <input name="longitud" type="text" value="<?php echo $row['longitud'];?>" placeholder="ejemplo: -56.139168" />
          </fieldset>
            <fieldset>
              <label><i class="fab fa-youtube"></i> Video youtube:</label>
              <input name="video" type="text" value="<?php echo 'https://www.youtube.com/watch?v='.$row['video'];?>" placeholder="ejemplo: https://www.youtube.com/watch?v=0pPXOq87atY" />
            </fieldset>
            <fieldset>
              <label><i class="fas fa-dollar-sign"></i> Precio:</label>
              <select name="IdUnidadPrecio" class="input15 blue_text">
                <option <?php if($row['IdUnidadPrecio']=='USD') echo 'selected'; ?> value='USD'>U$S</option>
                <option <?php if($row['IdUnidadPrecio']=='UYU') echo 'selected'; ?> value='UYU'>$</option>
              </select>
              <input name="Precio" type="text" class="input50" value="<?php echo $row['Precio'] ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-square"></i> Superfice const. m²:</label>
              <input name="SuperficieConstruida" type="text" value="<?php echo $row['SuperficieConstruida'] ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="far fa-square"></i> Superfice total m²:</label>
              <input name="SuperficieTotal" type="text" value="<?php echo $row['SuperficieTotal'] ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-bed"></i> Dormitorios:</label>
              <div class="campo_numeros"> <a href="javascript:cambiar_num('restar','dormitorio')" class="btn_restar"><i class="fas fa-minus-circle"></i></a>
                <div class="input_numero">
                  <input type="text" value="<?php echo $row['IdDormitorios'] ?>" name="IdDormitorios" readonly id="dormitorio"/>
                </div>
                <a href="javascript:cambiar_num('sumar','dormitorio')" class="btn_sumar"><i class="fas fa-plus-circle"></i></a> </div>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-bath"></i> Baños:</label>
              <div class="campo_numeros"> <a href="javascript:cambiar_num('restar','bano')" class="btn_restar"><i class="fas fa-minus-circle"></i></a>
                <div class="input_numero">
                  <input type="text" value="<?php echo $row['IdBanios'] ?>" name="IdBanios" readonly id="bano"/>
                </div>
                <a href="javascript:cambiar_num('sumar','bano')" class="btn_sumar"><i class="fas fa-plus-circle"></i></a> </div>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-car"></i> Garages:</label>
              <div class="campo_numeros"> <a href="javascript:cambiar_num('restar','garages')" class="btn_restar"><i class="fas fa-minus-circle"></i></a>
                <div class="input_numero">
                  <input type="text" value="<?php echo $row['garage'] ?>" name="garage" readonly id="garages"/>
                </div>
                <a href="javascript:cambiar_num('sumar','garages')" class="btn_sumar"><i class="fas fa-plus-circle"></i></a> </div>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-dollar-sign"></i> Gastos Comunes Monto:</label>
              <select name="IdUnidadGastosComunes" class="input15 blue_text">
                <option <?php if($row['IdUnidadGastosComunes']=='U\$S' || $row['IdUnidadGastosComunes']=='U$S') echo 'selected'; ?> value='U$S'>U$S</option>
                <option <?php if($row['IdUnidadGastosComunes']=='\$' || $row['IdUnidadGastosComunes']=='$') echo 'selected'; ?> value='$'>$</option>
              </select>
              <input name="GastosComunesMonto" type="text" class="input50" value="<?php echo $row['GastosComunesMonto'] ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-compass"></i>Orientación:</label>
              <select name="orientacion" onchange="mostrar_input(this)">
                <?php 
                    // El array esta en el inc-header.php
                    foreach ($lista_orientaciones as $lista_orientacion)
                    {
                        echo '<option value="'.$lista_orientacion[0].'"';
						if($lista_orientacion[0]==$row['orientacion']) echo 'selected="selected"';
                        echo '>'.$lista_orientacion[1].'</option>'; 
                    }
                    ?>
              </select>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-home"></i> Estado:</label>
              <select name="estado" onchange="mostrar_input(this)">
                <?php 
                    // El array esta en el inc-header.php
                    foreach ($lista_estados as $lista_estado)
                    {
                        echo '<option value="'.$lista_estado[0].'"';
						if($lista_estado[0]==$row['estado']) echo 'selected="selected"';
                        echo '>'.$lista_estado[1].'</option>'; 
                    }
                    ?>
              </select>
            </fieldset>
			  <fieldset>
            <label><i class="fas fa-snowflake"></i>Aire acondicionado:</label>
            <div class="checkbox">
              <input type="checkbox" name="aire_acondicionado" <?php if ($row['aire_acondicionado']==1) { echo 'checked="checked"'; }?> value="1">
              <span class="checkmark"> <span class="circle"></span> </span> </div>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-paw"></i>Acepta mascotas:</label>
              <div class="checkbox">
                <input type="checkbox" name="mascotas" <?php if ($row['mascotas']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-stroopwafel"></i>Parrillero:</label>
              <div class="checkbox">
                <input type="checkbox" name="parrillero" <?php if ($row['parrillero']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-building"></i>Azotea:</label>
              <div class="checkbox">
                <input type="checkbox" name="azotea" <?php if ($row['azotea']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </fieldset>
            <fieldset>
              <label><i class="fab fa-pagelines"></i>Jardín:</label>
              <div class="checkbox">
                <input type="checkbox" name="jardin" <?php if ($row['jardin']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-building"></i>Vivienda social:</label>
              <div class="checkbox">
                <input type="checkbox" name="vivienda_social" <?php if ($row['vivienda_social']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-home"></i>Barrio privado:</label>
              <div class="checkbox">
                <input type="checkbox" name="barrio_privado" <?php if ($row['barrio_privado']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </fieldset>
            
            <fieldset>
              <label><i class="fas fa-user-tie"></i>Garantía:</label>
				<div class="garantias">
                    <?php 
					$garantias = explode(',', $row['garantia']);
					
                    foreach ($lista_garantias as $lista_garantia)
                    {
                        echo '<div><input name="garantia[]" type="checkbox" value="'.$lista_garantia[1].'"';
						
						foreach($garantias as $garantia) if($lista_garantia[1]==$garantia) echo 'checked="checked"';
						
						echo ' />'.$lista_garantia[1].'</div>';
                    }
                    ?>
                </div>
            </fieldset>
            
            <fieldset>
              <i class="fas fa-pen"></i> Descripción:<br>
              <br>
              <?php //echo "Desripcion: ".$row['descripcion']; ?>
              <textarea name="descripcion" cols="" rows="5"><?php echo $row['descripcion'] ?></textarea>
            </fieldset>
            <fieldset class="set_upload">
              <label>Fotos sin 360:</label>
              <div class="image_upload">
                <div class="input_file">
                  <div class="btn_input_file" style="background-color: Red"><i class="fas fa-images"></i> <strong>Subir Fotos</strong> </div>
                  <input name="foto[]" type="file" id="upload_file" onChange="preview_image();" class="input_upload" multiple />
                </div>
                <div id="image_preview"></div>
              </div>
            </fieldset>
            <fieldset class="set_upload" style="min-height: 300px">
              <label>Fotos 360:</label>
              <div class="image_upload">
                <div class="input_file">
                  <div class="btn_input_file"><img src="images/Upload360.png" srcset="images/Upload360.svg" alt="Upload360" /> <strong>Subir Fotos</strong> 360</div>
                  <input name="imagen[]" type="file" id="upload_file2" onChange="preview_image2();" class="input_upload" multiple />
                </div>
                <output id="image_preview2" />
              </div>
            </fieldset>
            <fieldset class="fotos_subidas" id="fotos_subidas">
              <label>Foto subidas (Arrastra las fotos para establecer el orden. La primera será la foto de portada)</label>
              <ul id="sortable">
                <?php 
				$orden_inicial = 1;
				$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$id." ORDER BY orden ASC");
				$stmt->execute();
				while( $foto = $stmt->fetch() ) 
				{
					$id_foto_ref = $foto['id']."_".$row['id'];
					if($orden_inicial == 1){
						?>
                <?php
					}
					?>
                <li class="foto_subida" id="foto_<?php echo $foto['id']; ?>" style="background-image: url(<?php echo $foto['foto_thumb'] ?>)">
                  <select name="nombre_<?php echo $foto['id']; ?>">
                    <?php foreach ($lista_habitaciones as $lista_habitacion)
                    {
                        echo '<option value="'.$lista_habitacion[0].'"';
						if($lista_habitacion[0]==$foto['nombre']) echo 'selected="selected"';
						if($lista_habitacion[1]==1) echo '>Habitación o lugar</option>'; 
						else echo '>'.$lista_habitacion[0].'</option>'; 
                    }
					
                    ?>
                  </select>
                  <a class="btn_delete_image" id="<?php echo $foto['id']; ?>"><i class="fas fa-trash"></i></a> </li>
                <?php 
					$orden_inicial++;
				}
				?>
              </ul>
              <input name="orden_inicial" type="hidden" value="<?php echo $orden_inicial; ?>" />
            </fieldset>
            <input name="publicar" type="hidden" value="1" />
            <input name="img_tipo" type="hidden" value="360" />
            <fieldset><input id="submit_button" onclick="uploading()" name="" value="Guardar" type="submit" /></fieldset>
          </form>
          <?php }?>
        </div>
    </div>
  </div>
</div>
<style>

</style>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script> 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> 
<script src="js/multiple-select.js"></script> 
<script type="text/javascript">

$(document).ready(function(){
	$("#sortable").sortable({
		update: function(){
		var ordenElementos = $(this).sortable("toArray");
		$.ajax({ 
			data: { nuevo_orden : ordenElementos },
			type: 'POST',
			url: 'cambiar-orden.php',
			success:function(result) {
				console.log(ordenElementos);
				/*document.getElementById("GuardarMsj").innerHTML = "Listo.";
				setTimeout(function(){ document.getElementById("GuardarMsj").innerHTML = ""; }, 4000);*/
		}
		});
		}
	});
	$("#sortable").disableSelection();
})	


$(function(){
	$(".btn_delete_image").click(function(){
		var commentContainer = $(this).parent();
		var id = $(this).attr("id");
		var string = 'borrar_image_id='+ id ;
		$.ajax({
			type: "GET",
			url: "<?php echo $tabla ?>-edit.php",
			data: string,
			cache: false,
			success: function(){commentContainer.hide('fast', function() {$(this).remove();});}
		});
		return false;
	});
});
var tutoMapa_on = false;
function mostrarTuto(index){
	tutoMapa_on = !tutoMapa_on;
	if(tutoMapa_on) $("#div_info_mapa").fadeIn();
	else $("#div_info_mapa").fadeOut();
}
function uploading(){
	$("#uploading").fadeIn();
}

$(function() {
	$("#ubicacion").multipleSelect({
	filter: true,
	width: "100%",
	selectAll: false,
	single: true,
	placeholder: "Departamento, Barrio o Ciudad"
	});
});
</script>
<?php include 'inc-upload-preview.php'; ?>
<?php include 'inc-footer.php'; ?>
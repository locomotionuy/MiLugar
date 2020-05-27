<script src="js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
	selector: 'textarea',
	height: 200,
	menubar: false,
	//extended_valid_elements : "a[class|name|href|target|title|onclick|rel],script[type|src],iframe[src|style|width|height|scrolling|marginwidth|marginheight|frameborder],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]",
	//convert_fonts_to_spans : false,
	invalid_elements: "font",
    paste_auto_cleanup_on_paste : true,
	paste_remove_styles: true,
	paste_remove_styles_if_webkit: true,
	paste_strip_class_attributes: "all",
	paste_as_text: true,
	plugins: ['autolink lists link textcolor paste visualblocks code'],
  	toolbar: ' undo redo | paste link code bold italic | alignleft aligncenter alignright alignjustify | forecolor fontsizeselect | removeformat',
	fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt'
});
</script>
<?php
include '../inc-conn.php';

// Tabal y sección
$mod = 'Propiedades';
$tabla = 'propiedades';
// Grande para fotos 2d
$image_w_2d = '1280';
$image_h_2d = '720';
// Grande
$image_w = '4096';
$image_h = '2048';
// Thumbnail
$config_thumbs = true;
$th_image_w = '520';
$th_image_h = '260';
// Carpeta
$gallery_dir = "fotos";

include 'inc-header.php';

if(isset($_POST['publicar']))
{
	$titulo = $_POST['titulo'];
	$titulo= str_replace("'", "\'", $_POST['titulo']); 
	
	$IdTipoInmueble = $_POST['IdTipoInmueble'];
  $IdTipoOperacion = $_POST['IdTipoOperacion'];
  
  if(isset($_POST['IdLocalidad'])) { $IdLocalidad = $_POST['IdLocalidad']; } else { $IdLocalidad = " "; }
  
	$Calle = $_POST['Calle'];
	$Esquina = $_POST['Esquina'];
	
	$latitud = $_POST['latitud'];
	$longitud = $_POST['longitud'];
	
	if(isset($_POST['video'])){
		$videoSimple = explode('watch?v=', $_POST['video']);
		$video = $videoSimple[1];
	}
	
	$IdUnidadPrecio = $_POST['IdUnidadPrecio'];
	$Precio = limpiar_numeros($_POST['Precio']);
	$SuperficieConstruida = $_POST['SuperficieConstruida'];
	$SuperficieTotal = $_POST['SuperficieTotal'];
	$IdDormitorios = $_POST['IdDormitorios'];
	$IdBanios = $_POST['IdBanios'];
	$garage = $_POST['garage'];
	$IdUnidadGastosComunes = $_POST['IdUnidadGastosComunes'];	
	$GastosComunesMonto = $_POST['GastosComunesMonto'];
	
	if(isset($_POST['garantia'])) $garantia = implode(",",$_POST['garantia']);
	$descripcion= str_replace("'", "\'", $_POST['descripcion']); 
	$descripcion = str_replace('"', '\"',$descripcion);
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
	error_log('$usuario_permisos '.$usuario_permisos);
  if($usuario_permisos == '3') $publicado = "0";
  
	else if(isset($_POST['publicado'])) { $publicado = $_POST['publicado']; } else { $publicado = "0"; }	
	
	$fecha = date("d/m/Y");
	
  $subio360 = true;
  
	if($_FILES['imagen']['name'][0]=='' and $dimension=='1' and $milugar=='1'){
		$dimension='0';
		$subio360 = false;
	}

	try 
	{
		$sql = "INSERT INTO $tabla
		( 
		titulo,
		IdTipoInmueble,
		IdTipoOperacion,
		IdLocalidad,
		Calle,
		Esquina,
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
		aire_acondicionado,
		orientacion,
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
		milugar,
		dimension
		)
		values 
		(
		'$titulo',
		'$IdTipoInmueble',
		'$IdTipoOperacion',
		'$IdLocalidad',
		'$Calle',
		'$Esquina',
    '$latitud',
		'$longitud',
		'$video',
		'$Precio',
		'$SuperficieConstruida',
		'$SuperficieTotal',
		'$IdDormitorios',
		'$IdBanios',
		'$garage',
		'$GastosComunesMonto',
		'$descripcion',
		'$IdUnidadPrecio',
		'$IdUnidadGastosComunes',		
		'$usuario_id',
		'$amueblado',
		'$aire_acondicionado',
		'$orientacion',
		'$estado',
		'$mascotas',
		'$parrillero',
		'$azotea',
		'$jardin',
		'$vivienda_social',
		'$barrio_privado',
		'$garantia',
		'$fecha',
		'$publicado',
		'$milugar',
		'$dimension'
		)";
		
		$conn->exec($sql);
		$entrada_id = $conn->lastInsertId();

		if(isset($_FILES['foto']['name']))
		{
			include 'inc-upload-2d.php';		
		}

		if(isset($_FILES['imagen']['name']))
		{
			include 'inc-upload.php';		
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
          <li><a href="<?php echo $tabla ?>-upload.php">Nuevo</a></li>
          <li class="back"><a href="javascript:goBack()"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
        </ul>
        <?php if(isset($enviado)):?>
        <ul class="respuesta enviado">
          <li>Datos subidos con éxito.</li>
          <li><a href="<?php echo $tabla ?>.php">Volver a <?php echo $mod ?>.</a></li>
          <?php if(!$subio360):?>
          <li><a href="https://milugar.com.uy/file.php?id=<?php echo $entrada_id ?>" target="_blank">Vista previa <img style="0 5px -3px 5px" src="https://milugar.com.uy/favicon.ico" alt="Mi Lugar"/></a></li>
          <?php else:?>
          <li><a href="../file.php?id=<?php echo $entrada_id ?>" target="_blank">Vista previa</a></li>
          <?php endif;?>
        </ul>
        <?php if(!$subio360):?>
		<ul class="respuesta error">
		  <li>Esta publicación estará únicamente en el portal Mi Lugar.<br>No se mostrará la publicación en Dimensión 360 hasta que no se suba una foto 360 de la propiedad.</li>
		</ul>
		<?php endif;?>
        <?php elseif(isset($error)):?>
        <ul class="respuesta error">
          <li>Hubo un error, intentalo de nuevo.</li>
          <li><?php echo $error; ?></li>
        </ul>
        <?php endif;?>
        <div id="upload" class="upload">
        <?php if(!isset($enviado)):?>
        
<div id="uploading">
	<div id="subiendo">
		SUBIENDO PUBLICACIÓN<br>
		<i class="fas fa-spinner fa-pulse"></i>
	</div>
</div>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
          <fieldset id="publicado">
            <label><i class="fas fa-check-square"></i> Publicado:</label>
            <div class="checkbox">
              <input type="checkbox" name="publicado" value="1" checked="checked">
              <span class="checkmark"> <span class="circle"></span> </span> </div>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-newspaper"></i> Titulo (máx 50)</label>
            <input maxlength="50" name="titulo" type="text"/>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-home"></i> Tipo de inmueble:</label>
            <select name="IdTipoInmueble">
			<?php 
            foreach ($lista_inmuebles as $lista_inmueble)
            {
                echo '<option value="'.$lista_inmueble[0].'"';
                echo '>'.$lista_inmueble[1].'</option>'; 
            }
            ?>
            </select>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-exchange-alt"></i> Tipo de operación:</label>
            <select name="IdTipoOperacion" onchange="mostrar_input(this)">
			<?php 
            foreach ($lista_operaciones as $lista_operacion)
            {
                echo '<option value="'.$lista_operacion[0].'"';
				if(!isset($_GET['operacion']) and $lista_operacion[3]==1) echo 'selected="selected"';
                echo '>'.$lista_operacion[1].'</option>'; 
            }
            ?>
            </select>
          </fieldset>
          <fieldset class="none" id="amueblado">
            <label><i class="fas fa-couch"></i> Amueblado:</label>
            <div class="checkbox">
              <input type="checkbox" name="amueblado" value="1">
              <span class="checkmark"> <span class="circle"></span> </span> </div>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-map-marked-alt"></i> Ubicación:</label>
            <div class="wrap_ubicacion">
              <select name="IdLocalidad" class="ubicacion" id="ubicacion" multiple="multiple">
                <?php 
            foreach ($lista_ubicaciones as $lista_ubicacion)
            {
                echo '<option>'.$lista_ubicacion[0].", ".$lista_ubicacion[1].'</option>'; 
            }
            ?>
              </select>
            </div>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-road"></i> Calle:</label>
            <input name="Calle" type="text"/>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-sign"></i> Esquina:</label>
            <input name="Esquina" type="text"/>
          </fieldset>
          <fieldset class="info">
            <label><i class="fas fa-map-marked-alt"></i> Latitud:</label>
            <input name="latitud" type="text" placeholder="ejemplo: -34.905727" />
            <i id="info_mapa" onClick="mostrarTuto(1)" class="fas fa-question-circle"></i>
            <div id="div_info_mapa" >
                <h3 style="margin-bottom:5px;">¿Dónde buscar latitud y longitud en Google Maps?</h3>
                <img src="../images/mapaTuto.gif" width="100%">
            </div>
          </fieldset>
          <fieldset class="info">
            <label><i class="fas fa-map-marked-alt"></i> Longitud:</label>
            <input name="longitud" type="text" placeholder="ejemplo: -56.139168" />
          </fieldset>
           <fieldset>
            <label><i class="fab fa-youtube"></i> Video youtube:</label>
            <input name="video" type="text" placeholder="ejemplo: https://www.youtube.com/watch?v=0pPXOq87atY" />
          </fieldset>
          <fieldset>
            <label><i class="fas fa-dollar-sign"></i> Precio:</label>
            <select name="IdUnidadPrecio" class="input15 blue_text">
              <option value='USD'>U$S</option>
              <option value='UYU'>$</option>
            </select>
            <input name="Precio" type="text" class="input50"/>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-square"></i> Superfice const. m²:</label>
            <input name="SuperficieConstruida" type="text"/>
          </fieldset>
          <fieldset>
            <label><i class="far fa-square"></i> Superfice total m²:</label>
            <input name="SuperficieTotal" type="text"/>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-bed"></i> Dormitorios:</label>
            <div class="campo_numeros"> <a href="javascript:cambiar_num('restar','dormitorio')" class="btn_restar"><i class="fas fa-minus-circle"></i></a>
              <div class="input_numero">
                <input type="text" value="0" name="IdDormitorios" readonly id="dormitorio"/>
              </div>
              <a href="javascript:cambiar_num('sumar','dormitorio')" class="btn_sumar"><i class="fas fa-plus-circle"></i></a> </div>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-bath"></i> Baños:</label>
            <div class="campo_numeros"> <a href="javascript:cambiar_num('restar','bano')" class="btn_restar"><i class="fas fa-minus-circle"></i></a>
              <div class="input_numero">
                <input type="text" value="0" name="IdBanios" readonly id="bano"/>
              </div>
              <a href="javascript:cambiar_num('sumar','bano')" class="btn_sumar"><i class="fas fa-plus-circle"></i></a> </div>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-warehouse"></i> Garages:</label>
            <div class="campo_numeros"> <a href="javascript:cambiar_num('restar','garages')" class="btn_restar"><i class="fas fa-minus-circle"></i></a>
              <div class="input_numero">
                <input type="text" value="0" name="garage" readonly id="garages"/>
              </div>
              <a href="javascript:cambiar_num('sumar','garages')" class="btn_sumar"><i class="fas fa-plus-circle"></i></a> </div>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-dollar-sign"></i> Gastos Comunes Monto:</label>
            <select name="IdUnidadGastosComunes" class="input15 blue_text">
              <option value='$'>$</option>
              <option value='U$S'>U$S</option>
            </select>
            <input name="GastosComunesMonto" type="text" class="input50"/>
          </fieldset>
          <fieldset>
            <label><i class="fas fa-compass"></i>Orientación:</label>
            <select name="orientacion" onchange="mostrar_input(this)">
              <?php 
                    // El array esta en el inc-header.php
                    foreach ($lista_orientaciones as $lista_orientacion)
                    {
                        echo '<option value="'.$lista_orientacion[0].'"';
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
                        echo '>'.$lista_estado[1].'</option>'; 
                    }
                    ?>
            </select>
          </fieldset>
			
			<fieldset>
            <label><i class="fas fa-snowflake"></i>Aire acondicionado:</label>
            <div class="checkbox">
              <input type="checkbox" name="aire_acondicionado" value="1">
              <span class="checkmark"> <span class="circle"></span> </span> </div>
          </fieldset>
          
          <fieldset>
            <label><i class="fas fa-paw"></i>Acepta mascotas:</label>
            <div class="checkbox">
              <input type="checkbox" name="mascotas" value="1">
              <span class="checkmark"> <span class="circle"></span> </span> </div>
          </fieldset>
          
          <fieldset>
            <label><i class="fas fa-stroopwafel"></i>Parrillero:</label>
            <div class="checkbox">
              <input type="checkbox" name="parrillero" value="1">
              <span class="checkmark"> <span class="circle"></span> </span> </div>
          </fieldset>
          
          <fieldset>
            <label><i class="fas fa-building"></i>Azotea:</label>
            <div class="checkbox">
              <input type="checkbox" name="azotea" value="1">
              <span class="checkmark"> <span class="circle"></span> </span> </div>
          </fieldset>
          
          <fieldset>
            <label><i class="fab fa-pagelines"></i>Jardín:</label>
            <div class="checkbox">
              <input type="checkbox" name="jardin" value="1">
              <span class="checkmark"> <span class="circle"></span> </span> </div>
          </fieldset>
          
          <fieldset>
            <label><i class="fas fa-building"></i>Vivienda social:</label>
            <div class="checkbox">
              <input type="checkbox" name="vivienda_social" value="1">
              <span class="checkmark"> <span class="circle"></span> </span> </div>
          </fieldset>
          
          <fieldset>
            <label><i class="fas fa-home"></i>Barrio privado:</label>
            <div class="checkbox">
              <input type="checkbox" name="barrio_privado" value="1">
              <span class="checkmark"> <span class="circle"></span> </span> </div>
          </fieldset>
          
          <fieldset>
                <label><i class="fas fa-user-tie"></i>Garantía:</label>
                <div class="garantias">
                    <?php 
                    foreach ($lista_garantias as $lista_garantia)
                    {
                        echo '<div><input name="garantia[]" type="checkbox" value="'.$lista_garantia[1].'" />'.$lista_garantia[1].'</div>';
                    }
                    ?>
                </div>
            </fieldset>

          <fieldset>
           <i class="fas fa-pen"></i> Descripción:<br><br>
            <textarea name="descripcion" cols="" rows="5"></textarea>
          </fieldset>

          <fieldset class="set_upload">
            <label>Fotos sin 360:</label>
            <div class="image_upload">
              <div class="input_file">
                <div class="btn_input_file" style="background-color: Red"><i class="fas fa-images"></i> <strong>Subir Fotos 2D</strong> </div>
                <input name="foto[]" type="file" id="upload_file" onChange="preview_image();" class="input_upload" multiple />
              </div>
              <div id="image_preview"></div>
            </div>
          </fieldset>
          
          <fieldset class="set_upload">
            <label>Fotos 360:</label>
            <div class="image_upload">
              <div class="input_file">
                <div class="btn_input_file"><img src="images/Upload360.png" srcset="images/Upload360.svg" alt="Upload360" /> <strong>Subir Fotos</strong> 360</div>
                <input name="imagen[]" type="file" id="upload_file2" onChange="preview_image2();" class="input_upload" multiple />
              </div>
              <output id="image_preview2" />
            </div>
          </fieldset>
          
          <fieldset><input name="" value="Enviar" onClick="uploading()" type="submit" /></fieldset>
          </div>
          <input name="publicar" type="hidden" value="1" />
          <input name="img_tipo" type="hidden" value="360" />
        </form>
        <?php endif;?>
        <?php if(isset($enviado)):
		?>
        <fieldset class="fotos_subidas" id="fotos_subidas">
          <label>Foto subidas (Arrastra las fotos para establecer el orden. La primera será la foto de portada):</label>
				<ul id="sortable">
				<?php 
				$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$entrada_id." ORDER BY orden ASC");
				$stmt->execute();
				while( $foto = $stmt->fetch() ) 
				{
					$id_foto_ref = $foto['id']."_".$row['id'];
					?>
					<li class="foto_subida" id="foto_<?php echo $foto['id']; ?>" style="background-image: url(<?php echo $foto['foto_thumb'] ?>)">
						<a class="btn_delete_image" id="<?php echo $foto['id']; ?>"><i class="fas fa-trash"></i></a>
					</li>
				<?php 
				}
				?>
				</ul>
        </fieldset>
        <div class="btn_next" onclick="location.href='<?php echo $tabla ?>.php'">Terminar</div>
        <?php endif;?>
      </div>
    </div>
</div>
</div>
</div>
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
function uploading(){
	$("#uploading").fadeIn();
}
var tutoMapa_on = false;
function mostrarTuto(index){
	tutoMapa_on = !tutoMapa_on;
	if(tutoMapa_on) $("#div_info_mapa").fadeIn();
	else $("#div_info_mapa").fadeOut();
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
<?php include 'inc-footer.php'; ?>
<?php include 'inc-upload-preview.php'; ?>
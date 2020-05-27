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
	plugins: ['autolink lists link textcolor visualblocks code'],
  	toolbar: ' undo redo | link code bold italic | alignleft aligncenter alignright alignjustify | forecolor fontsizeselect | removeformat',
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
// Grande para fotos 360
$image_w = '4096';
$image_h = '2048';
// Thumbnail
$config_thumbs = true;
$th_image_w = '590';
$th_image_h = '345';
// Carpeta
$gallery_dir = "fotos";
$add_imagenes = 12;

include 'inc-header.php';

if(isset($_POST['publicar']))
{
	$IdTipoInmueble = $_POST['IdTipoInmueble'];
	$IdTipoOperacion = $_POST['IdTipoOperacion'];
	if(isset($_POST['IdLocalidad'])) { $IdLocalidad = $_POST['IdLocalidad']; } else { $IdLocalidad = " "; }
	$Calle = $_POST['Calle'];
	$Esquina = $_POST['Esquina'];
	$Precio = limpiar_numeros($_POST['Precio']);
	$IdDormitorios = $_POST['IdDormitorios'];
	$IdBanios = $_POST['IdBanios'];
	$garage = $_POST['garage'];
	$GastosComunesMonto = $_POST['GastosComunesMonto'];
	$descripcion= str_replace("'", "\'", $_POST['descripcion']); 
	$descripcion = str_replace('"', '\"',$descripcion);
	$IdUnidadPrecio = $_POST['IdUnidadPrecio'];
	$IdUnidadGastosComunes = $_POST['IdUnidadGastosComunes'];	
	$amueblado = " ";
	
	$fecha = date("d/m/Y");
	if($usuario_permisos == '3') $publicado = "0";
	else $publicado = "1"; 
	
	$subio360 = true;
	if($_FILES['imagen']['name'][0]=='' and $dimension=='1' and $milugar=='1'){
		$dimension='0';
		$subio360 = false;
	}
		
	try 
	{
		$sql = "INSERT INTO $tabla
		( 
		IdTipoInmueble,
		IdTipoOperacion,
		IdLocalidad,
		Calle,
		Esquina,
		Precio,
		IdDormitorios,
		IdBanios,
		garage,
		IdUnidadPrecio,
		GastosComunesMonto,
		IdUnidadGastosComunes,
		descripcion,
		inmobiliaria,
		amueblado,
		fecha,
		publicado,
		milugar,
		dimension
		)
		values 
		(
		'$IdTipoInmueble',
		'$IdTipoOperacion',
		'$IdLocalidad',
		'$Calle',
		'$Esquina',
		'$Precio',
		'$IdDormitorios',
		'$IdBanios',
		'$garage',
		'$IdUnidadPrecio',
		'$GastosComunesMonto',
		'$IdUnidadGastosComunes',
		'$descripcion',
		'$usuario_id',
		'$fecha',
		'$amueblado',
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

<div id="uploading">
	<div id="subiendo">
		SUBIENDO PUBLICACIÓN<br>
		<i class="fas fa-spinner fa-pulse"></i>
	</div>
</div>


<div class="body">
  <div class="center">
      <div class="content">
        <ul class="titulo-secciones">
          <li><a href="index.php">Principal</a></li>
          <li><a href="<?php echo $tabla ?>.php"><?php echo $mod ?></a></li>
          <li><a href="<?php echo $tabla ?>-fast-upload.php">Subida rápida</a></li>
          <li class="back"><a href="javascript:goBack()"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
        </ul>
        <?php if(isset($enviado)):?>
        <ul class="respuesta enviado">
          <li>Datos subidos con éxito.</li>
          <li><a href="<?php echo $tabla ?>-edit.php?id=<?php echo $entrada_id ?>"><i class="fas fa-file-upload"></i> Editar más datos de la propiedad</a></li>
          <li><a href="<?php echo $tabla ?>.php">Volver a <?php echo $mod ?></a></li>
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
          <ul class="tabs">
            <li class="btn_tab01 selected">Paso 1: <span>Ubicación y Tipo</span></li>
            <li class="btn_tab02">Paso 2: <span>Características</span></li>
            <li class="btn_tab03">Paso 3: <span>Fotos 360 y Vr</span></li>
          </ul>
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            
            <!-- Paso 1 -->
            <div class="paso tab1"> 
              <!-- Anulado -->
              <fieldset class="none">
                <label><i class="fas fa-newspaper"></i> Titulo (máx 50)</label>
                <input maxlength="50" name="titulo" type="text"/>
              </fieldset>
              <fieldset class="none" id="publicado">
                <label><i class="fas fa-check-square"></i> Publicado:</label>
                <div class="checkbox">
                  <input type="checkbox" name="publicado" value="1" checked="checked">
                  <span class="checkmark"> <span class="circle"></span> </span> </div>
              </fieldset>
              <fieldset>
                <label><i class="fas fa-home"></i> Tipo de inmueble:</label>
                <select name="IdTipoInmueble">
                  <?php 
                    // El array esta en el inc-header.php
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
                    // El array esta en el inc-header.php
                    foreach ($lista_operaciones as $lista_operacion)
                    {
                        echo '<option value="'.$lista_operacion[0].'"';
						if(!isset($_GET['operacion']) and $lista_operacion[3]==1) echo 'selected="selected"';
                        echo '>'.$lista_operacion[1].'</option>'; 
                    }
                    ?>
                </select>
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
              <div class="btn_next 1">Siguiente Paso <i class="fas fa-chevron-circle-right"></i></div>
            </div>
            
            <!-- Paso 2 -->
            <div class="paso tab2">
              <fieldset>
                <label><i class="fas fa-dollar-sign"></i> Precio:</label>
                <select name="IdUnidadPrecio" class="input15 blue_text">
                 <option value='USD'>U$S</option>
              <option value='UYU'>$</option>
                </select>
                <input name="Precio" type="text" class="input50"/>
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
                <label><i class="fas fa-car"></i> Garages:</label>
                <div class="campo_numeros"> <a href="javascript:cambiar_num('restar','garages')" class="btn_restar"><i class="fas fa-minus-circle"></i></a>
                  <div class="input_numero">
                    <input type="text" value="0" name="garage" readonly id="garages"/>
                  </div>
                  <a href="javascript:cambiar_num('sumar','garages')" class="btn_sumar"><i class="fas fa-plus-circle"></i></a> </div>
              </fieldset>
              <fieldset>
               <i class="fas fa-pen"></i>  Descripción:<br><br>
                <!--<label><i class="fas fa-pen"></i> Descripción:</label>-->
                <textarea name="descripcion" cols="" rows="5"></textarea>
              </fieldset>
              <div class="btn_next 2">Siguiente Paso <i class="fas fa-chevron-circle-right"></i></div>
            </div>
            
            <!-- Paso 3 -->
            <div class="paso tab3">
            
          <fieldset class="set_upload">
            <label>Fotos sin 360:</label>
            <div class="image_upload">
              <div class="input_file">
                <div class="btn_input_file"><i class="fas fa-images"></i> <strong>Subir Fotos</strong> </div>
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
              
              <input id="submit_button" onclick="uploading()" name="" value="Enviar" type="submit" />
            </div>
            <input name="publicar" type="hidden" value="1" />
            <input name="img_tipo" type="hidden" value="360" />
          </form>
          <?php endif;?>
          <?php if(isset($enviado)):
		?>
          <fieldset class="fotos_subidas" id="fotos_subidas">
            <label><strong>Elegir foto de portada:</strong></label>
            <label>Foto subidas:<br>(Arrastra las fotos para establecer el orden. La primera será la foto de portada)</label>
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

	
	function uploading(){
		console.log("uploading");
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
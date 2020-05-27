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
	plugins: ['autolink lists textcolor paste visualblocks code'],
  	toolbar: ' undo redo paste bold italic alignleft aligncenter alignright alignjustify forecolor removeformat',
	fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt'
});
</script>
<?php
include '../inc-conn.php';

// Tabal y sección
$mod = 'Soporte';
$tabla = 'soporte';
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
	$asunto = $_POST['asunto'];
	$mensaje = $_POST['mensaje'];
	$fecha = date("d/m/y H:i:s");

	try 
	{
		$sql = "INSERT INTO $tabla
		( 
		asunto,
		mensaje,
		fecha,
		inmobiliaria,
		estado
		)
		values 
		(
		'$asunto',
		'$mensaje',
		'$fecha',
		'$usuario_id',
		'Abierto'
		)";
		
		$conn->exec($sql);
		$entrada_id = $conn->lastInsertId();

		if(isset($_FILES['foto']['name']))
		{
			include 'inc-upload-captura.php';		
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
          <li><a href="<?php echo $tabla ?>-upload.php"><strong>Nuevo</strong></a></li>
          <li class="back"><a href="javascript:goBack()"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
        </ul>
        <?php if(isset($enviado)):?>
        <ul class="respuesta enviado">
          <li>Datos subidos con éxito.</li>
          <li><a href="<?php echo $tabla ?>.php">Volver a <?php echo $mod ?>.</a></li>
        </ul>
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


          <fieldset>
            <label><i class="fas fa-newspaper"></i> Asunto</label>
            <input name="asunto" type="text"/>
          </fieldset>
          
          <fieldset>
           <label><i class="fas fa-pen"></i> Mensaje:<br><br></label>
            <div class="wrap_ubicacion">
            <textarea name="mensaje" cols="" rows="5"></textarea></div>
          </fieldset>

          <fieldset class="set_upload">
            <label>Captura de pantalla:</label>
            <div class="image_upload">
              <div class="input_file">
                <div class="btn_input_file"><i class="fas fa-file-upload"></i> <strong>Subir Captura</strong> </div>
                <input name="foto[]" type="file" id="upload_file" onChange="preview_image3();" class="input_upload" multiple />
              </div>
              <div id="image_preview"></div>
            </div>
          </fieldset>
          <fieldset>         
          	<input name="" value="Enviar" onClick="uploading()" type="submit" />
          </fieldset>
          </div>
          <input name="publicar" type="hidden" value="1" />
          <input name="img_tipo" type="hidden" value="soporte" />
        </form>
        <?php endif;?>
        <?php if(isset($enviado)):
		?>
        <fieldset class="fotos_subidas" id="fotos_subidas">
          <label>Captura de pantalla subida:</label>
				<ul id="sortable">
				<?php 
				$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$entrada_id." and tipo='soporte' ORDER BY orden ASC");
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
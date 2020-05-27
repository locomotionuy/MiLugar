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
  
// Tabla y sección
$mod = 'Soporte';
$tabla = 'soporte';

// Thumbnail
$config_thumbs = true;

// Carpeta
$gallery_dir = "fotos";

$gallery_dir = "/uploads/fotos/";
$dir_fotos_thumbs = "/uploads/fotos/thumbs/";
$dir_logos = "/uploads/logos/";

include 'inc-header.php';

if(isset($_REQUEST['id'])) 
{
	// 1 = leido en usuario y no en super admin
	// 2 = leido en super admin y no en mi usuario
	
	$id = $_REQUEST['id'];
	try 
	{
		$sql = "UPDATE soporte SET leido=1 WHERE id='$id'";
		$conn->exec($sql);
	}		
	catch(PDOException $e)
    {
    }
}

if(isset($_GET['Cerrar'])) 
{
	$id = $_REQUEST['id'];
	try 
	{
		$sql = "UPDATE soporte SET estado='Cerrado' WHERE id='$id'";
		$conn->exec($sql);
		$borrado_ok = 1;
	}		
	catch(PDOException $e)
    {
    }
}

if(isset($_REQUEST['publicar']))
{
	$mensaje = $_POST['mensaje'];
	$fecha = date("d/m/y H:i:s");

	try 
	{
		$sql = "INSERT INTO soporte_mensajes
		( 
		mensaje,
		id_soporte,
		inmobiliaria,
		fecha
		)
		values 
		(
		'$mensaje',
		'$id',
		'$usuario_id',
		'$fecha'
		)";
		
		$conn->exec($sql);
		$entrada_id = $conn->lastInsertId();
		
		$sql = "UPDATE soporte SET estado='Mi respuesta', fecha='$fecha', leido=0 WHERE id='$id'";
		$conn->exec($sql);

		if(isset($_FILES['foto']['name']))
		{
			$soporte_mensajes = 1;
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
<?php

$stmt = $conn->prepare("SELECT * FROM $tabla WHERE id=".$id);
$stmt->execute();
while( $row = $stmt->fetch() ) 
{
?>

<div class="body">
  <div class="center">
    <div class="content">
      <ul class="titulo-secciones">
        <li><a href="index.php">Principal</a></li>
        <li><a href="<?php echo $tabla ?>.php"><?php echo $mod ?></a> / <strong style="color:#53585b">Ticket</strong></li>
        <li class="back"><a href="javascript:goBack()"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
      </ul>
      <div id="results">
        <div class="new"><span>Asunto: <?php echo $row['asunto'] ?></span></div>
        <div class="registros"> </div>
        <div class="buscar">
          <form action="soporte-edit.php" method="post" enctype="multipart/form-data">
            <input name="buscar" type="text" placeholder="Asunto, mensaje, # o fecha" />
            <input name="Filtrar" value="Filtrar" type="submit" />
          </form>
        </div>
        <?php if(isset($borrado_ok)):?>
        <ul class="respuesta enviado">
          <li>Propiedad borrada con éxito.</li>
        </ul>
        <?php elseif(isset($borrado_error)):?>
        <ul class="respuesta enviado">
          <li><?php echo $borrado_error ?></li>
          <li><a href="soporte.php">Volver a soporte</a></li>
        </ul>
        <?php endif;?>
        <div id="respuesta">
          <div class="btn_responder"><i class="fas fa-edit"></i> Responder</div>
          <div class="responder" id="respuesta">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form_respuesta" method="post" enctype="multipart/form-data">
              <fieldset>
                <textarea name="mensaje" cols="" rows="5"></textarea>
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
              <input name="publicar" type="hidden" value="1" />
              <input name="id" type="hidden" value="<?php echo $id ?>" />
              <input name="img_tipo" type="hidden" value="soporte" />
            </form>
          </div>
        </div>
        <script type="text/javascript">
        $(document).ready(function()
        {
            $(".btn_responder").click(function(){
				$('.form_respuesta').slideToggle('fast');
				$('.btn_responder').toggleClass('open');
            });

        });
        </script>
        <?php 
        $stmt2 = $conn->prepare("SELECT * FROM soporte_mensajes WHERE id_soporte=".$row['id']." ORDER BY id DESC");
        $stmt2->execute();
		$i=0;
        while( $row2 = $stmt2->fetch() )
        {
		$i++;
        ?>
        <div class="mensaje <?php if ($i == 1) { echo "last"; } ?>">
        
 			<?php 
            $stmtuser = $conn->prepare("SELECT * FROM usuarios WHERE id=".$row2['inmobiliaria']);
            $stmtuser->execute();
            while( $row_usuario = $stmtuser->fetch() ) 
            {
				$usuario_nombre2 = $row_usuario['nombre'];
            }
			if( $row2['inmobiliaria'] == $usuario_id )
			{
				$nombre = $usuario_nombre;
				$classusuario = "soporte";
			}
			else
			{
				$nombre = $usuario_nombre2;
				$classusuario = "usuario";
			}		
            ?>       
        
          <div class="mensaje_cabezal_<?php echo $classusuario ?>">
            <div class="mensaje_icono"><i class="fas fa-user-circle"></i></div>
            <div class="mensaje_nombre">
			<?php echo $nombre; ?>
            </div>
            <div class="mensaje_fecha"><?php echo $row2['fecha'] ?></div>
          </div>
          <div class="mensaje_texto"><?php echo $row2['mensaje'] ?></div>
          <div class="mensaje_pie">
			<?php 
            $stmt3 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$id." and tipo='soporte_mensajes' ORDER BY orden ASC");
            $stmt3->execute();
            while( $foto = $stmt3->fetch() ) 
            {
            ?>
            <i class="fas fa-file-image fa-fw"></i><a href="<?php echo $foto['foto'] ?>" target="_blank">Captura de imágen</a>
            <?php
            }
            ?>
          </div>
        </div>
        <?php 
        }
        ?>
        <div class="mensaje">
          <div class="mensaje_cabezal_soporte">
            <div class="mensaje_icono"><i class="fas fa-user-circle"></i></div>
            <div class="mensaje_nombre"><?php echo $usuario_nombre ?> (<?php echo $usuario_usuario ?>)</div>
            <div class="mensaje_fecha"><?php echo $row['fecha'] ?></div>
          </div>
          <div class="mensaje_texto"><?php echo $row['mensaje'] ?></div>
          <div class="mensaje_pie">
			<?php 
            $stmtfoto = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$id." and tipo='soporte' ORDER BY orden ASC");
            $stmtfoto->execute();
            while( $foto2 = $stmtfoto->fetch() ) 
            {
            ?>
            <i class="fas fa-file-image fa-fw"></i><a href="<?php echo $foto2['foto'] ?>" target="_blank">Captura de imágen</a>
            <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
}
?>
<?php include 'inc-footer.php'; ?>
<?php include 'inc-upload-preview.php'; ?>
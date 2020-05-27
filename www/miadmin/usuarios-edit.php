<?php 
include '../inc-conn.php';

// Tabal y sección
$mod = 'Usuarios';
$tabla = 'usuarios';
// Tamanio
$image_w = '320';
$image_h = '180';
// Thumbnail
$config_thumbs = false;

// Carpeta
$gallery_dir = "logos";
$add_imagenes = 12;

include 'inc-header.php';

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
		$url_explode_logo = explode("/",$row["foto"]);
		unlink("../uploads/logos/".$url_explode_logo[5]);
	}
	$sql = "DELETE FROM fotos WHERE id=$id";
	$conn->exec($sql);
}

if(isset($_POST['publicar']))
{
	$usuario = $_POST['usuario'];
	$nombre = $_POST['nombre'];
	$telefono = $_POST['telefono'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$web = $_POST['web'];
	if(substr($web,0,3) != "http" && $web!='' ) $web = "http://".$web;
	$direccion = $_POST['direccion'];	
	$facebook = $_POST['facebook'];
	$mapaSimple = explode('"', $_POST['mapa']);
	if($mapaSimple[0] == "<iframe src=" ) $mapa = $mapaSimple[1];
	else $mapa = $_POST['mapa'];

	//if(sha1($_POST['password'][0])!==$password){
		if($_POST['password'][0]!=="" && $_POST['password'][1]!=="")
		{
			if($_POST['password'][0]==$_POST['password'][1] and $_POST['password'][0]!=="")
			{
				$password = sha1($_POST['password'][0]);
			}
			else
			{
				$msj_pass_igual = "Contraseña y Repetir Contraseña no son iguales";
				$error = 1;
			}
			if(strlen($_POST['password'][0]) < 7)
			{
				$msj_pass_cant = "La Contraseña debe tener más de 6 caracteres";
				$error = 1;
			}
		}
	//}
	if(!isset($error))
	{
		try 
		{
			if(isset($password))
			{ 
				$sql = "UPDATE $tabla SET usuario='$usuario', nombre='$nombre',email='$email', telefono='$telefono',celular='$celular', web='$web', direccion='$direccion', facebook='$facebook', mapa ='$mapa', pass='$password' WHERE id='$id'";
			}
			else
			{
				$sql = "UPDATE $tabla SET usuario='$usuario', nombre='$nombre',email='$email', telefono='$telefono',celular='$celular', web='$web', direccion='$direccion', facebook='$facebook', mapa ='$mapa' WHERE id='$id'";
			}
			$conn->exec($sql);
			$entrada_id = $id;
			
			if(isset($_FILES['foto']['name']))
			{
				include 'inc-upload_logo.php';		
			}
			
			$enviado = 1;
		}
		catch(PDOException $e)
		{
			$error = $sql . "<br>" . $e->getMessage();
		}
	}
}
?>
<script type="text/javascript">
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
</script>

<div class="body">
  <div class="center">
    <div class="content">
        <ul class="titulo-secciones">
          <li><a href="index.php">Principal</a></li>
          <li><a href="<?php echo $tabla ?>-editar.php?id=<?php echo $row['id'] ?>">Editar</a></li>
          <li class="back"><a href="javascript:goBack()"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
        </ul>
        <?php if(isset($enviado)):?>
        <ul class="respuesta enviado">
          <li>Datos actualizados con éxito.</li>
        </ul>
        <?php elseif(isset($error)):?>
        <ul class="respuesta error">
          <li>Hubo un error, intentalo de nuevo.</li>
          <?php if(isset($msj_pass_igual)) echo "<li><strong>".$msj_pass_igual."</strong></li>"; ?>
          <?php if(isset($msj_pass_cant)) echo "<li><strong>".$msj_pass_cant."</strong></li>"; ?>
          <?php if(isset($msj_email)) echo "<li><strong>".$msj_email."</strong></li>"; ?>
        </ul>
        <?php endif;?>
        <div id="upload">
        <?php 
		// Permisos de usuario para crear o editar usuarios solo edita usuario propio
		$stmt = $conn->prepare("SELECT * FROM $tabla WHERE id='$usuario_id'"); 
		$stmt->execute();
		while( $row = $stmt->fetch() ) 
        {
        ?>
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>?id=<?php echo $row['id'] ?>" method="post" enctype="multipart/form-data">
            <fieldset>
              <label><i class="fas fa-user-tag"></i> Usuario</label>
              <input name="usuario" type="text" value="<?php echo $row['usuario']; ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-user-tie"></i> Nombre</label>
              <input name="nombre" type="text" value="<?php echo $row['nombre']; ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-envelope"></i> EMail</label>
              <input name="email" type="text" value="<?php echo $row['email']; ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-phone"></i> Telefono</label>
              <input name="telefono" type="text" value="<?php echo $row['telefono']; ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-mobile-alt"></i> Celular</label>
              <input name="celular" type="text" value="<?php echo $row['celular']; ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-globe"></i> Web</label>
              <input name="web" type="text" value="<?php echo $row['web']; ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-map-marker-alt"></i> Dirección</label>
              <input name="direccion" type="text" value="<?php echo $row['direccion']; ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-user-circle"></i> Facebook</label>
              <input name="facebook" type="text" value="<?php echo $row['facebook']; ?>"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-map-marked-alt"></i> Google maps:</label>
              <input name="mapa" type="text" value="<?php echo $row['mapa'];?>" placeholder="<iframe src='ejemplo: https://www.google.com/maps/embed?pb=example'></iframe>" />
            </fieldset>
            <fieldset>
              <label><i class="fas fa-key"></i> Contraseña</label>
              <input name="password[]" type="password" placeholder="**********" value="" autocomplete="false" autocomplete="off"/>
            </fieldset>
            <fieldset>
              <label><i class="fas fa-key"></i> Repetir Contraseña</label>
              <input name="password[]" type="password" placeholder="**********" value="" autocomplete="off"/>
            </fieldset>
            <fieldset class="set_upload">
                <label>Subir Logo:</label>
            <div class="image_upload">
              <div class="input_file">
                <div class="btn_input_file"><strong>Subir Logo</strong></div>
                <input name="imagen[]" type="file" id="upload_file2" onChange="preview_image2();" class="input_upload" multiple />
              </div>
              <output id="image_preview2" />
            </div>
            </fieldset>
                    <fieldset class="fotos_subidas" id="fotos_subidas">
          <label>Logos subidos:</label>
				<ul id="sortable">
				<?php 
				$stmt2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." and tipo = 'logo' ORDER BY orden ASC");
				$stmt2->execute();
				while( $foto = $stmt2->fetch() ) 
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
            <input name="publicar" type="hidden" value="1" />
            <input name="img_tipo" type="hidden" value="logo" />
            <input name="" value="Guardar" type="submit" />
          </form>
          <?php }?>
        </div>
    </div>
  </div>
</div>
<script type="text/javascript">

function handleFileSelect() {
    if (window.File && window.FileList && window.FileReader) {
        var files = event.target.files; //FileList object
        var output = document.getElementById("result");

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            if (!file.type.match('image')) continue;

            var picReader = new FileReader();
            picReader.addEventListener("load", function (event) {
                var picFile = event.target;
                var div = document.createElement("div");
                div.innerHTML = "<div class='preview' style='background-image: url(" + picFile.result + "'" + "title='" + picFile.name + ")'></div>";
                output.insertBefore(div, null);
            });
            picReader.readAsDataURL(file);
        }
    } else {
        console.log("Your browser does not support File API");
    }
}
document.getElementById('files').addEventListener('change', handleFileSelect, false);
</script>
<?php include 'inc-footer.php'; ?>
<?php include 'inc-upload-preview.php'; ?>
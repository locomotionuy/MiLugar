<?php 
include 'inc-conn.php';

$mod = 'upload';
include 'inc-header.php';

// Permisos de usuario para crear o editar usuarios
if ($usuario_permisos==1) {

$id = 1;

if(isset($_GET['publicar']))
{
	$titulo = $_GET['titulo'];
	$direccion = $_GET['direccion'];
	$telefono = $_GET['telefono'];
	$email = $_GET['email'];
	$mapa = $_GET['mapa'];
	
	try 
	{
		$sql = "UPDATE configuracion SET titulo='$titulo', direccion='$direccion', telefono='$telefono', email='$email', mapa='$mapa' WHERE id='$id'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$enviado = 1;
	}
	catch(PDOException $e)
    {
		$error = "Se detectó un error: ".$e->getMessage();
	}
}
?>

<div class="body">
  <div class="center">
    <div class="content">
        <div class="titulo-secciones"><a href="index.php">Principal</a> / <a href="configuration.php">Configuración</a><a href="javascript:goBack()" class="back"><i class="fas fa-arrow-alt-circle-left"></i></a></div>
        <?php if(isset($enviado)):?>
        <ul class="respuesta enviado">
          <li>Datos actualizados con éxito.</li>
          <li><a href="index.php"><i class="fas fa-home"></i> Volver a la página principal.</a></li>
        </ul>
        <?php elseif(isset($error)):?>
        <ul class="respuesta error">
          <li>Hubo un error, intentalo de nuevo.</li>
          <li><?php echo $error; ?></li>
        </ul>
        <?php endif;?>
        <div id="upload">
        <?php
		$stmt = $conn->prepare('SELECT * FROM configuracion WHERE id='.$id);
		$stmt->execute();
		while( $datos = $stmt->fetch() ) 
		{
        ?>
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get" enctype="multipart/form-data">
            <fieldset>
              <label><i class="fas fa-address-card fa-fw"></i> Título:</label>
              <input name="titulo" type="text" value="<?php echo $datos["titulo"] ?>" />
            </fieldset>
            <fieldset>
              <label><i class="fas fa-map-marker-alt fa-fw"></i> Dirección</label>
              <input name="direccion" type="text" value="<?php echo $datos['direccion'] ?>" />
            </fieldset>
            <fieldset>
              <label><i class="fas fa-phone fa-fw"></i> Teléfono</label>
              <input name="telefono" type="text" value="<?php echo $datos['telefono'] ?>" />
            </fieldset>
            <fieldset>
              <label><i class="fas fa-envelope fa-fw"></i> Email</label>
              <input name="email" type="text" value="<?php echo $datos['email'] ?>" />
            </fieldset>
            <fieldset style="margin-bottom: 20px;">
              <label><i class="fas fa-map fa-fw"></i> Mapa</label>
              <textarea name="mapa" cols="" rows="10"><?php echo $datos['mapa'] ?></textarea>
            </fieldset>
            <input name="publicar" type="hidden" value="1" />
            <input name="" value="Guardar" type="submit" />
          </form>
        </div>
        <?php 
		} 
		?>
      </div>
  </div>
</div>
<?php } ?>
<?php include 'inc-footer.php'; ?>
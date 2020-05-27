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

if(isset($_GET['delete']))
{
	$id = $_GET['delete'];
	try 
	{
		$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=$id && tipo!='logo'");
		$stmt->execute();
		while( $datos = $stmt->fetch() ) 
		{
			if( stripos($datos["foto"], 'milugar') !== false || stripos($datos["foto"], 'dimension360') !== false){
				unlink($datos["foto"]);
				unlink($datos["foto_thumb"]);
			}
		}

		$sql = "DELETE FROM fotos WHERE id_referencia=$id";
		$conn->exec($sql);
		
		$sql = "DELETE FROM $tabla WHERE id=$id";
		$conn->exec($sql);
		
		$borrado_ok = 1;
	}
	catch(PDOException $e)
	{
		$borrado_error = "Hubo un error: ".$e->getMessage();
	}
}

require 'inc-paginator.php';
$pagination = new PDO_Pagination($conn);

$pagination->rowCount("SELECT * FROM $tabla WHERE inmobiliaria='$usuario_id'");
$pagination->config(6, 60);


if(isset($_GET['buscar']))
{ 
	$sql = "SELECT * FROM $tabla WHERE inmobiliaria=$usuario_id and (asunto LIKE '%".$_GET['buscar']."%' or mensaje LIKE '%".$_GET['buscar']."%' or fecha LIKE '%".$_GET['buscar']."%' or id LIKE '%".$_GET['buscar']."%') ORDER BY id DESC LIMIT $pagination->start_row, $pagination->max_rows";
}
else
{
	$sql = "SELECT * FROM $tabla WHERE inmobiliaria=$usuario_id ORDER BY id DESC LIMIT $pagination->start_row, $pagination->max_rows";
}


$query = $conn->prepare($sql);
$query->execute();
$model = array();
while($rows = $query->fetch())
{
  $model[] = $rows;
}
?>

<div class="body">
  <div class="center">
    <div class="content">
      <ul class="titulo-secciones">
        <li><a href="index.php">Principal</a></li>
        <li><a href="<?php echo $tabla ?>.php"><strong><?php echo $mod ?></strong></a></li>
        <li class="back"><a href="javascript:goBack()"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
      </ul>
      <div id="results">
        <div class="new"><a href="<?php echo $tabla ?>-upload.php">Nuevo</a></div>
        <div class="registros">
        </div>
        <div class="buscar">
        <form action="soporte.php" method="get">
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
        </ul>
        <?php endif;?>
        <div class="lista">
          <div class="lista-fila">
              <div class="columna-numero indicador">#</div>
              <div class="columna-asunto indicador">Asunto</div>
              <div class="columna-estado indicador">Estado</div>
              <div class="columna-fecha indicador">Ultima actualización</div>
          </div>
          <?php 
          foreach($model as $row)
          {
          ?>
          <a href="soporte-edit.php?id=<?php echo $row['id'] ?>" class="lista-fila">
  			<div class="columna-numero"><?php echo $row['id'] ?></div>
            <div class="columna-asunto"><?php
			if($row['estado']=="Cerrado") 
			{ 
				echo '<span style="color:#999">'.$row['asunto'].'</span>';
			}
			else if($row['leido']==2) 
			{ 
				echo $row['asunto'];
			}
			else
			{
				echo "<strong>".$row['asunto']."</strong>"; 
			}
			?></div>
            <div class="columna-estado">
				<span class="abierto" style="background-color:<?php 
				if($row['estado']=="Abierto") echo "#0099cc";
				if($row['estado']=="Mi respuesta") echo "#26c1f4";
				if($row['estado']=="Respondido") echo "#22cc76";
				if($row['estado']=="Cerrado") echo "#b4b4b4";
				?>;"><?php echo $row['estado'] ?></span> 
            </div>
            <div class="columna-fecha"><?php echo $row['fecha'] ?></div>
          </a>
          <?php 
          }
          ?>
        </div>
        <div class="pagination">
          <?php
          $pagination->pages("btn");
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>

<?php 
include '../inc-conn.php';
  
// Tabla y sección
$mod = 'Propiedades';
$tabla = 'propiedades';

// Thumbnail
$config_thumbs = true;

// Carpeta
$gallery_dir = "fotos";

$gallery_dir = "/uploads/fotos/";
$dir_fotos_thumbs = "/uploads/fotos/thumbs/";
$dir_logos = "/uploads/logos/";

include 'inc-header.php';
if(isset($_GET['sold_id']))
{
	$id = $_GET['sold_id'];
	
	try 
	{
		$stmt = $conn->prepare("SELECT * FROM $tabla WHERE id=$id");
		$stmt->execute();
		while( $datos = $stmt->fetch() ) 
		{
			$vendida = !$datos['vendida'];
			$sql = "UPDATE $tabla SET vendida='$vendida' WHERE id=$id";
			$conn->exec($sql);
		}
		//$borrado_ok = 1;
	}
	catch(PDOException $e)
	{
		$borrado_error = "Hubo un error: ".$e->getMessage();
	}

}
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
			
			/*$url_explode = explode("/",$datos["foto"]);
			foreach ($url_explode as $part)
			{
				if($part == 'milugar.com.uy' || $part == 'dimension360.com.uy') {
					unlink("../uploads/fotos/".$url_explode[5]);
					unlink("../uploads/fotos/thumbs/".$url_explode[5]);
					break;
				}
			}*/
		}

		$sql = "DELETE FROM fotos WHERE id_referencia=$id && tipo!='logo'";
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
		
	$sql = "SELECT * FROM $tabla WHERE inmobiliaria=$usuario_id and ( IdLocalidad LIKE '%".$_GET['buscar']."%' OR titulo LIKE '%".$_GET['buscar']."%' OR Precio LIKE '%".$_GET['buscar']."%' OR id LIKE '%".$_GET['buscar']."%' ) ORDER BY id DESC";
	
	$sqlcount = "SELECT count(*) FROM $tabla WHERE inmobiliaria=$usuario_id and (id LIKE '%".$_GET['buscar']."%' or IdLocalidad LIKE '%".$_GET['buscar']."%' or titulo LIKE '%".$_GET['buscar']."%' or Precio LIKE '%".$_GET['buscar']."%')"; 
}
else
{
	$sql = "SELECT * FROM $tabla WHERE inmobiliaria=$usuario_id ORDER BY id DESC LIMIT $pagination->start_row, $pagination->max_rows";
	$sqlcount = "SELECT count(*) FROM $tabla WHERE inmobiliaria='$usuario_id'"; 
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
          <li><a href="<?php echo $tabla ?>.php"><?php echo $mod ?></a></li>
          <li class="back"><a href="javascript:goBack()"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
        </ul>
        <div id="results">
          <div class="new"><a href="<?php echo $tabla ?>-upload.php">Nuevo</a></div>
          <div class="registros">
          <?php
		 // $sqlcount = "SELECT count(*) FROM $tabla WHERE inmobiliaria='$usuario_id'"; 
		  $count = $conn->prepare($sqlcount); 
		  $count->execute(); 
		  $resultados = $count->fetchColumn(); 
		  if(isset($_GET['buscar']) and $resultados == 0){
			  echo '<ul class="respuesta enviado">
						<li>No se encontraron resultados.</li>
						<li>Busca usando <strong>uno</strong> de los siguientes parámetros: Barrio, ID, título o precio</li>
					</ul>';
		  }else{
			  echo 'Resultados: '.$resultados;
		  }
		  ?>
          </div>
          <div class="buscar">
          <form action="propiedades.php" method="get">
            <input name="buscar" type="text" placeholder="Barrio, ID, título o precio" />
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
          <?php 
          foreach($model as $row)
          {
          ?>
          <div class="list" <?php if ($row['publicado']==0) { echo 'style="background-color:#EAEAEA";opacity: 0.7'; }?>>
            <?php 
			$stmt2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." && tipo!='logo' ORDER BY orden ASC LIMIT 1");
			$stmt2->execute();
			while( $dato2 = $stmt2->fetch() ) 
			{
			?>
            <div class="thumbnail" style="background-image: url(<?php echo $dato2['foto_thumb'] ?>)"></div>
            <?php 
			}
			?>
            <div class="list-titulo">
			<?php 
            foreach ($lista_inmuebles as $lista_inmueble)
            {
				if($lista_inmueble[0]==$row['IdTipoInmueble']) echo $lista_inmueble[2]." ";
            }
			?>
			<?php 
            foreach ($lista_operaciones as $lista_operacion)
            {
				if($lista_operacion[0]==$row['IdTipoOperacion']) echo "en ".$lista_operacion[2]." ";
            }
            ?>
			<?php if(strlen($row['IdLocalidad'])>3) { $IdLocalidad = explode(", ",$row['IdLocalidad']); if($IdLocalidad[1]=="") { echo "en ".$IdLocalidad[0];} else { echo "en ".$IdLocalidad[1]; } }?>
            <?php 
			if($row['Calle']!=="") echo "<br /> En ".$row['Calle'];
			if($row['Esquina']!=="") echo " esq. ".$row['Esquina'];
			?> 
            (Id:<?php echo $row['id'] ?>, Precio:<?php echo $row['IdUnidadPrecio'].' '.$row['Precio'] ?>)
            
            <?php if($row['dimension']):?>
			  <a href="https://dimension360.com.uy/file.php?id=<?php echo $row['id'] ?>" class="list-preview-desktop" target="_blank" <?php if ($row['publicado']==0) { echo 'style="background-color:#C0C0C0"'; }?>><i class="fas fa-external-link-alt"></i> Vista Previa</a>
            </div>
            <a href="https://dimension360.com.uy/file.php?id=<?php echo $row['id'] ?>" class="list-preview" target="_blank" <?php if ($row['publicado']==0) { echo 'style="background-color:#C0C0C0"'; }?>>Vista previa</a>
			  <?php else:?>
			 <a href="https://milugar.com.uy/file.php?id=<?php echo $row['id'] ?>" class="list-preview-desktop" target="_blank" <?php if ($row['publicado']==0) { echo 'style="background-color:#C0C0C0"'; }?>><i class="fas fa-external-link-alt"></i> Vista Previa</a>
            </div>
            <a href="https://milugar.com.uy/file.php?id=<?php echo $row['id'] ?>" class="list-preview" target="_blank" <?php if ($row['publicado']==0) { echo 'style="background-color:#C0C0C0"'; }?>>Vista previa</a>
			<?php endif;?>
            
<div class="list-borrar desktop" onclick="location.href='#'" id="<?php echo $row['id'] ?>"><i class="fas fa-trash-alt"></i></div>
<div class="list-editar" onclick="location.href='<?php echo $tabla ?>-edit.php?id=<?php echo $row['id'] ?>'"><i class="fas fa-pencil-alt"></i></div>
<div class="list-sold <?php if($row['vendida']==1) echo 'vendida'; ?>" id="<?php echo $row['id'] ?>">
<span class="tooltiptext"><?php if($row['vendida']==1) echo 'Marcar como NO vendida'; else echo 'Marcar como vendida';?></span><i class="fas fa-handshake"></i></div>
<div class="list-borrar mobile" onclick="location.href='#'" id="<?php echo $row['id'] ?>"><i class="fas fa-trash-alt"></i></div>
          </div>
          <?php 
          }
          ?>
          <div class="pagination">
          <?php
          $pagination->pages("btn");
          ?>
          </div>
        </div>
      </div>
  </div>
</div>
<script>
	var vendidatext = [];
	vendidatext[true] = "Marcar como vendida";
	vendidatext[false] = "Marcar como NO vendida";
	console.log("vendidatext "+vendidatext[true]);
$(function(){
	$(".list-sold").click(function(){
		var estediv = $(this);
		var commentContainer = $(this).parent();
		
		var id = $(this).attr("id");
		var string = 'sold_id='+ id ;
		$.ajax({
			type: "GET",
			url: "<?php echo $tabla ?>.php",
			data: string,
			cache: false,
			success: function(){
				estediv.toggleClass("vendida");
				console.log("vendidatext "+estediv.hasClass("vendida"));
				estediv.find( "span" ).html(vendidatext[!estediv.hasClass("vendida")]);
				}
		});
		return false;
	});
});
</script>
<?php include 'inc-footer.php'; ?>

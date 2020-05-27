<?php 
include '../inc-conn.php';
  
$mod = 'Mensajes';
$tabla = 'mensajes';
include 'inc-header.php';

if(isset($_GET['delete']))
{
	$id = $_GET['delete'];
	try 
	{
		$sql = "DELETE FROM $tabla WHERE id=$id";
		$conn->exec($sql);
		$borrado_ok = 1;
	}
	catch(PDOException $e)
	{
		$borrado_error = "Hubo un error: ".$e->getMessage();
	}
}
if(isset($_GET['leido_id']))
{
	$id = $_GET['leido_id'];
	try 
	{
		$sql = "UPDATE mensajes SET leido=1 WHERE id=".$id;
		$conn->exec($sql);
	}
	catch(PDOException $e)
	{
		$borrado_error = "Hubo un error: ".$e->getMessage();
	}
}
?>
<script type="text/javascript">
$(function(){
$(".reply").click(function(){
var commentContainer = $(this).parent();
var id = $(this).attr("id");
var string = 'leido_id='+ id ;
$.ajax({
	type: "GET",
	url: "<?php echo $tabla ?>.php",
	data: string,
	cache: false,
	success: function(){
		$( "#mailto" ).submit();
	}
});
return false;
});
});
</script>

<div class="body">
  <div class="center">
      <div class="content">
        <ul class="titulo-secciones">
          <li><a href="<?php echo $tabla ?>.php"><?php echo $mod ?></a></li>
          <li class="back"><a href="javascript:goBack()"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
        </ul>  
        
        <ul class="respuesta enviado">
          <li><i class="fas fa-exclamation-circle"></i> El seguimiento de mensajes de usuarios no registrados se hace por email.</li>
        </ul>    
      
        <div id="messages">
         <div class="new"></div>
          <div class="registros">
          </div>
          <div class="buscar">
          </div>
          <?php if(isset($borrado_ok)):?>
          <ul class="respuesta enviado">
            <li>Entrada borrada con éxito.</li>
          </ul>
          <?php elseif(isset($borrado_error)):?>
          <ul class="respuesta enviado">
            <li><?php echo $borrado_error ?></li>
          </ul>
          <?php endif;?>

          <!-- Mensajes nuevos: -->
			<?php 
            $stmt = $conn->prepare("SELECT * FROM mensajes WHERE inmobiliaria=$usuario_id AND leido=0 ORDER BY id DESC");
            $stmt->execute();
            while( $dato = $stmt->fetch() ) 
            {
            ?>
          <div class="wrap"> 
            <div class="emisor"><i class="fas fa-user-circle"></i> <strong><?php echo $dato["nombre"]?></strong> (<?php echo $dato["email"]?>)
              <div class="date"><i class="far fa-calendar-alt"></i><?php echo $dato["fecha"]; ?></div>
            </div>
            <div class="message">
            <strong>Consulta por: </strong>
				<?php 
                $stmt2 = $conn->prepare("SELECT * FROM propiedades WHERE id=".$dato['id_referencia']);
                $stmt2->execute();
                while( $row = $stmt2->fetch() ) 
                {
                ?>
                <?php 
                foreach ($lista_inmuebles as $lista_inmueble)
                {
                if($lista_inmueble[0]==$row['IdTipoInmueble']) echo $lista_inmueble[1]." ";
                }
                ?>
                <?php 
                foreach ($lista_operaciones as $lista_operacion)
                {
                if($lista_operacion[0]==$row['IdTipoOperacion']) echo "en ".$lista_operacion[1]." ";
                }
                ?>
                <?php if($row['IdLocalidad']!=="") { $IdLocalidad = explode(", ",$row['IdLocalidad']); if($IdLocalidad[1]=="") { echo "en ".$IdLocalidad[0];} else { echo "en ".$IdLocalidad[1]; } }?>
                <?php 
                if($row['Calle']!=="") echo "<br /> <strong>En</strong> ".$row['Calle'];
                if($row['Esquina']!=="") echo " esq. ".$row['Esquina'];
                ?> 
                <br />
                <a href="../file.php?id=<?php echo $row['id'] ?>" class="list-preview" target="_blank">Ver propiedad consultada</a>
                <?php 
                }
                ?><br />

                <strong>Mensaje:</strong><br />

			<?php echo $dato['consulta'] ?>
              <div class="buttons"><div class="borrar list-borrar" id="<?php echo $dato['id'] ?>"><i class="far fa-trash-alt"></i></div>
              <form action="mailto:<?php echo $dato["email"]?>" method="GET" class="mailto" id="mailto">
                <input name="subject" type="hidden" value="Respuesta por propiedad en Mi Lugar, <?php echo $usuario_nombre ?>" />
                    <input name="body" type="hidden" value="<?php echo $usuario_nombre.":\n\n\n--------------------------\n".$dato['nombre'].":\n".$dato['consulta']."\n--------------------------\n" ?>" />
                    <input name="leido_id" type="hidden" value="<?php echo $dato['id'] ?>" />
                    <button type="submit" class="reply" id="<?php echo $dato['id'] ?>">
                    <i class="fas fa-envelope"></i>
                    </button>
                </form>
              </div>
              <div class="arrow<?php echo $i?>"></div>
            </div>
          </div>
          <?php } ?>
          <!-- Mensajes nuevos fin -->
          
          <div class="titulo-secciones">Mensajes contestados:</div>
			<?php 
            $stmt = $conn->prepare("SELECT * FROM mensajes WHERE inmobiliaria=$usuario_id AND leido=1 ORDER BY id DESC");
            $stmt->execute();
            while( $dato = $stmt->fetch() ) 
            {
            ?>
          <!-- Mensajes respondidos: -->
          <div class="wrap leido respondido"> 
            <div class="emisor"><i class="fas fa-user-circle"></i> <strong><?php echo $dato["nombre"]?></strong> (<?php echo $dato["email"]?>)
              <div class="date"><i class="far fa-calendar-alt"></i> <?php echo $dato["fecha"]?></div>
            </div>
            <div class="message"><?php echo $dato['consulta'] ?>
              <div class="arrow"></div>
              <div class="buttons">
                <div class="borrar list-borrar" id="<?php echo $dato['id'] ?>"><i class="fas fa-times"></i></div>
                <a href="mailto:<?php echo $dato["email"]?>?Subject=" class="reply"><i class="fas fa-envelope"></i></a>
              </div>
              <div class="buttons" style="display:block"><div class="borrar list-borrar" id="<?php echo $dato['id'] ?>"><i class="far fa-trash-alt"></i></div>
              <form action="mailto:<?php echo $dato["email"]?>" method="GET" class="mailto" id="mailto">
                <input name="subject" type="hidden" value="Respuesta por propiedad en Mi Lugar, <?php echo $usuario_nombre ?>" />
                    <input name="body" type="hidden" value="<?php echo $usuario_nombre.":\n\n\n--------------------------\n".$dato['nombre'].":\n".$dato['consulta']."\n--------------------------\n" ?>" />
                    <input name="leido_id" type="hidden" value="<?php echo $dato['id'] ?>" />
                    <button type="submit" class="reply" id="<?php echo $dato['id'] ?>">
                    <i class="fas fa-envelope"></i>
                    </button>
                </form>
              </div>
            </div>
          </div>
          <!-- Mensajes respondidos fin -->
           <?php } ?>
        </div>
      </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>
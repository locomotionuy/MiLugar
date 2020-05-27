<?php 
include 'inc-conn.php';

$mod = 'home';
include 'inc-header.php';
?>

<div class="body">
  <div id="home-search" style="background-image:url(images/home.jpg?id=1)">
    <div class="center">
      <div class="content">
        <div class="home-search">
          <form action="results.php" method="get">
            <fieldset>
              <div class="operativa">
                <select name="operacion" id="operativa" multiple="multiple" tabindex="1">
                  <?php 
                foreach ($lista_operaciones as $lista_operacion)
                {
                    echo '<option value="'.$lista_operacion[0].'"';
                    if(isset($_GET['operacion']) and $lista_operacion[0]==$_GET['operacion']) echo 'selected="selected"';
                    if(!isset($_GET['operacion']) and $lista_operacion[3]==1) echo 'selected="selected"';
                    echo '>'.$lista_operacion[1].'</option>'; 
                }
                ?>
                </select>
              </div>
              <div class="tipo">
                <select name="tipo[]" id="tipo" multiple="multiple" tabindex="2">
                  <?php 
                foreach ($lista_inmuebles as $lista_inmueble)
                {
                    echo '<option value="'.$lista_inmueble[0].'"';
                    if(isset($_GET['tipo']) and $lista_inmueble[0]==$_GET['tipo']) echo 'selected="selected"';
                    if(!isset($_GET['tipo']) and $lista_inmueble[3]==1) echo 'selected="selected"';
                    echo '>'.$lista_inmueble[1].'</option>'; 
                }
                ?>
                </select>
              </div>
              <div class="ubicacion">
                <select name="ubicacion[]" id="ubicacion" multiple="multiple" tabindex="3">
                  <?php 
                foreach ($lista_ubicaciones as $lista_ubicacion)
                {
                    echo '<option ';
                    if(isset($_GET['ubicacion']) and $lista_ubicacion[0].", ".$lista_ubicacion[1]==$_GET['ubicacion']) echo 'selected="selected"';
                    echo '>'.$lista_ubicacion[0].", ".$lista_ubicacion[1].'</option>'; 
                }
                ?>
                </select>
              </div>
              <input name="buscar" type="hidden" value="1" />
              <button class="submit"><?php echo $texto_btn_buscar ?></button>
            </fieldset>
            <div class="adv"><a href="results.php"><i class="fas fa-search"></i><?php echo $texto_adv_buscar ?></a></div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id="banner_principal">
    <div class="center">
      <div class="content"> 
   	  <img class="mobile" src="images/banner_mobile.jpg" alt="Banner" />
      <img class="desktop" src="images/banner.jpg" alt="Banner" />
      </div>
  	</div> 
  </div>
<div id="results">
    <div class="center">
      <div class="content">
      	<!--<div class="titulo_separador">Ultimas propiedades a la venta <span>|</span> <a href="#">ver más <span>+</span></a></div>-->
<?php 
require 'inc/inc-paginator.php';

$tabla = 'propiedades';

$pagination = new PDO_Pagination($conn);

$sqlCount = "SELECT * FROM $tabla WHERE publicado=1 && milugar='1' ORDER BY fecha DESC";

$pagination->rowCount($sqlCount);
$pagination->config(20, 24);

$sql = "SELECT * FROM $tabla WHERE publicado=1 && milugar='1' ORDER BY fecha DESC LIMIT $pagination->start_row, $pagination->max_rows";	

$query = $conn->prepare($sql);
$query->execute();

$model = array();
while($rows = $query->fetch())
{
  $model[] = $rows;
}
?>
        <?php 
foreach($model as $row)
{
	$inmueble = $lista_inmuebles[$row['IdTipoInmueble']-1][1];
	$operacion = $lista_operaciones[$row['IdTipoOperacion']-1][1];
	$tipovendida = $lista_operaciones[$row['IdTipoOperacion']-1][4];
	?>
        <div class="result"> <a class="wrap" href="file.php?id=<?php echo $row['id'] ?>">
        
          <div class="foto" style=" background-image:url(<?php 
			$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." and tipo!='logo' ORDER BY orden ASC LIMIT 1");
			$stmt->execute();
			while( $imagen = $stmt->fetch() ) 
			{
				echo $imagen["foto_thumb"];
				$tipo_foto = $imagen["tipo"];
			}
			?>)">
            <?php if($row['vendida']==1) { echo '<div class="vendida"><i class="fas fa-handshake"></i>'.$tipovendida.'</div>';  } ?>
            
			<?php if ($tipo_foto=='360') { ?>
            <div class="ready"><img src="images/360ready.png" alt="360Ready" /></div>
            <?php }?>
            
          </div>
          <div class="result_dato">
            <div class="precio">
              <?php if($row['IdUnidadPrecio']=="UYU" or $row['IdUnidadPrecio']=="$") echo "$"; else echo "U\$S"; ?>
              <?php  echo number_format($row['Precio'], 0, '', '.'); ?>
            </div>
            <div class="info"><?php echo $inmueble.' en '.$operacion; ?><p />
              <?php echo $row['IdLocalidad'] ?><p />
              <?php echo $row['SuperficieConstruida'] ?>m² Cons. -
				<?php echo $texto_label_dorms ?>:
				<?php if($row['IdDormitorios']==99) echo '5 o más'; else echo $row['IdDormitorios'] ?> - <?php echo $texto_label_banio ?>:
				<?php if($row['IdBanios']==99) echo '5 o más'; else echo $row['IdBanios'] ?> </div>
            <div class="favorite <?php
			if(isset($_COOKIE['favoritos']))
			{
				$favoritos_array = unserialize($_COOKIE['favoritos']);

				foreach($favoritos_array as $key => $valor)
				{
					if($valor==$row['id'])
					{
						echo "saved";
					}
				}
			}
			?>" id="<?php echo $row['id'] ?>"><i class="fas fa-heart"></i></div>
            <div class="result_dato_logo"> <img src="<?php 
                $stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['inmobiliaria']." and tipo='logo' LIMIT 1");
                $stmt->execute();
                while( $imagen = $stmt->fetch() ) 
                {
                    echo $imagen["foto"];
                }
                ?>" alt="Inmobiliaria" /> </div>
          </div>
          </a> </div>
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
  <div id="logos">
    <div class="center">
      <div class="content">
        <div class="titulo">Algunos de nuestros socios:</div>
        <div class="socios">
        <?php 
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id!='14' and id!='5' && milugar='1' && permisos=2 ORDER BY RAND() LIMIT 1,10"); 
        $stmt->execute();
        while( $row = $stmt->fetch() ) 
        {
           /* if(strlen($row['web'])>3) 
            { 
                $stmt2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." and tipo='logo'"); 
                $stmt2->execute();
                while( $row_logo = $stmt2->fetch() ) 
                {
                    echo '<a href="'.$row['web'].'"><img src="'.$row_logo["foto"].'" /></a>';
                }
            }
            else
            {*/
                $stmt2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." and tipo='logo'"); 
                $stmt2->execute();
                while( $row_logo = $stmt2->fetch() ) 
                {
                    echo '<a href="results.php?inmobiliaria='.$row['id'].'"><img src="'.$row_logo["foto"].'" /></a>';
                }
           // }			
        }
		?>
        </div>
        <div class="ver_mas"><a href="inmobiliarias.php">Ver todas</a></div>
      </div>
    </div>
  </div>
</div>
<script src="js/multiple-select.js"></script> 
<script>
$(function() {
	$("#operativa").multipleSelect({
	filter: false,
	width: "100%",
	selectAll: false,
	single: true
	});
});
$(function() {
	$("#tipo").multipleSelect({
	filter: false,
	width: "100%",
	selectAll: false,
	placeholder: "<?php echo $placeholder_tipo_propiedad ?>"
	});
});
$(function() {
	$("#ubicacion").multipleSelect({
	filter: true,
	width: "100%",
	selectAll: false,
	placeholder: "<?php echo $placeholder_ubicacion ?>"
	});
});
</script>
<?php include 'inc-footer.php'; ?>

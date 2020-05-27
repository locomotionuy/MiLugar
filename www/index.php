<?php 
include 'inc-conn.php';

$mod = 'home';
include 'inc-header.php';
?>
<script>
$(function(){$("#operativa").multipleSelect({filter:!1,width:"100%",selectAll:!1,single:!0})}),$(function(){$("#tipo").multipleSelect({filter:!1,width:"100%",selectAll:!1,placeholder:"<?php echo $placeholder_tipo_propiedad ?>"})}),$(function(){$("#ubicacion").multipleSelect({filter:!0,width:"100%",selectAll:!1,placeholder:"<?php echo $placeholder_ubicacion ?>"})});
</script>

<div class="body">
  <div id="home-search" style="background-image:url(images/home<?php echo rand(1, 5);?>.jpg?id=1)">
    <div class="center">
      <div class="content">
        <div class="home-search">
          <div class="loader"></div>
          <div class="formulario">
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
  </div>
  <div id="banner_principal">
    <div class="center">
      <div class="content"> <a href="https://www.ciu.org.uy/" target="_blank"><img class="mobile" src="images/banner_mobile.jpg" alt="Banner" /></a> <a href="https://www.ciu.org.uy/" target="_blank"><img class="desktop" src="images/banner.jpg" alt="Banner" /></a> </div>
    </div>
  </div>
  <div id="results">
    <div class="center">
      <div class="content">
        <div class="titulo_separador">Últimas propiedades a la venta <span>|</span> <a href="https://milugar.com.uy/results.php?operacion=2&tipo%5B%5D=1&tipo%5B%5D=2&moneda=USD&precio_min=&precio_max=&buscar=1">ver más <span>+</span></a></div>
        <?php 

$tabla = 'propiedades';

$sql = "SELECT * FROM $tabla WHERE publicado=1 && milugar='1' and IdTipoOperacion=2 ORDER BY fecha ASC LIMIT 6";	
$query = $conn->prepare($sql);
$query->execute();

while($rows = $query->fetch())
{
	$inmueble = $lista_inmuebles[$rows['IdTipoInmueble']-1][1];
	$operacion = $lista_operaciones[$rows['IdTipoOperacion']-1][1];
	$tipovendida = $lista_operaciones[$rows['IdTipoOperacion']-1][4];
	?>
        <div class="result"> <a class="wrap" href="file.php?id=<?php echo $rows['id'] ?>">
          <div class="foto" style=" background-image:url(<?php 
			$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$rows['id']." and tipo!='logo' ORDER BY orden ASC LIMIT 1");
			$stmt->execute();
			while( $imagen = $stmt->fetch() ) 
			{
				// Check if file exists
				$handle = @fopen($imagen["foto_thumb"], 'r');
				if($handle)
				{
					echo $imagen["foto_thumb"];
				}
				else
				{
					echo "images/sinfoto.jpg";
				}
				$tipo_foto = $imagen["tipo"];
			}
			?>)">
            <?php 
				if($rows['vendida']==1)  echo '<div class="vendida"><i class="fas fa-handshake"></i>'.$tipovendida.'</div>';
				if ($tipo_foto=='360') echo '<div class="ready"><img src="images/360ready.png" alt="360Ready" /></div>'; ?>
          </div>
          <div class="result_dato">
            <div class="precio">
              <?php if($rows['IdUnidadPrecio']=="UYU" or $rows['IdUnidadPrecio']=="$") echo "$"; else echo "U\$S"; 
					echo number_format($rows['Precio'], 0, '', '.'); ?>
            </div>
            <div class="info"><?php echo $inmueble.' en '.$operacion; ?>
              <p />
              <?php echo $rows['IdLocalidad'] ?>
              <p />
              <?php echo $rows['SuperficieConstruida'] ?>m² Cons. - <?php echo $texto_label_dorms ?>:
              <?php if($rows['IdDormitorios']==99) echo '5 o más'; else echo $rows['IdDormitorios'] ?>
              - <?php echo $texto_label_banio ?>:
              <?php if($rows['IdBanios']==99) echo '5 o más'; else echo $rows['IdBanios'] ?>
            </div>
            <div class="favorite <?php
			if(isset($_COOKIE['favoritos']))
			{
				$favoritos_array = unserialize($_COOKIE['favoritos']);
				foreach($favoritos_array as $key => $valor)
				{
					if($valor==$rows['id']) echo "saved";
				}
			}
			?>" id="<?php echo $rows['id'] ?>"><i class="fas fa-heart"></i></div>
            <div class="result_dato_logo"> <img src="<?php 
                $stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$rows['inmobiliaria']." and tipo='logo' LIMIT 1");
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
        <div class="titulo_separador">Últimas propiedades en alquiler <span>|</span> <a href="https://milugar.com.uy/results.php?operacion=1&tipo%5B%5D=1&tipo%5B%5D=2&moneda=USD&precio_min=&precio_max=&buscar=1">ver más <span>+</span></a></div>
        <?php 

$sql = "SELECT * FROM $tabla WHERE publicado=1 && milugar='1' and IdTipoOperacion=1 ORDER BY fecha ASC LIMIT 6";	
$query = $conn->prepare($sql);
$query->execute();

while($rows = $query->fetch())
{
	$inmueble = $lista_inmuebles[$rows['IdTipoInmueble']-1][1];
	$operacion = $lista_operaciones[$rows['IdTipoOperacion']-1][1];
	$tipovendida = $lista_operaciones[$rows['IdTipoOperacion']-1][4];
	?>
        <div class="result"> <a class="wrap" href="file.php?id=<?php echo $rows['id'] ?>">
          <div class="foto" style=" background-image:url(<?php 
			$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$rows['id']." and tipo!='logo' ORDER BY orden ASC LIMIT 1");
			$stmt->execute();
			while( $imagen = $stmt->fetch() ) 
			{
				// Check if file exists
/*				$handle = @fopen($imagen["foto_thumb"], 'r');
				if($handle)
				{
					echo $imagen["foto_thumb"];
				}
				else
				{
					echo "images/sinfoto.jpg";
				}*/
				
				echo $imagen["foto_thumb"];
				$tipo_foto = $imagen["tipo"];
			}
			?>)">
            <?php 
				if($rows['vendida']==1)  echo '<div class="vendida"><i class="fas fa-handshake"></i>'.$tipovendida.'</div>';
				if ($tipo_foto=='360') echo '<div class="ready"><img src="images/360ready.png" alt="360Ready" /></div>'; ?>
          </div>
          <div class="result_dato">
            <div class="precio">
              <?php if($rows['IdUnidadPrecio']=="UYU" or $rows['IdUnidadPrecio']=="$") echo "$"; else echo "U\$S"; 
					echo number_format($rows['Precio'], 0, '', '.'); ?>
            </div>
            <div class="info"><?php echo $inmueble.' en '.$operacion; ?>
              <p />
              <?php echo $rows['IdLocalidad'] ?>
              <p />
              <?php echo $rows['SuperficieConstruida'] ?>m² Cons. - <?php echo $texto_label_dorms ?>:
              <?php if($rows['IdDormitorios']==99) echo '5 o más'; else echo $rows['IdDormitorios'] ?>
              - <?php echo $texto_label_banio ?>:
              <?php if($rows['IdBanios']==99) echo '5 o más'; else echo $rows['IdBanios'] ?>
            </div>
            <div class="favorite <?php
			if(isset($_COOKIE['favoritos']))
			{
				$favoritos_array = unserialize($_COOKIE['favoritos']);
				foreach($favoritos_array as $key => $valor)
				{
					if($valor==$rows['id']) echo "saved";
				}
			}
			?>" id="<?php echo $rows['id'] ?>"><i class="fas fa-heart"></i></div>
            <div class="result_dato_logo"> <img src="<?php 
                $stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$rows['inmobiliaria']." and tipo='logo' LIMIT 1");
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
			$stmt2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." and tipo='logo'"); 
			$stmt2->execute();
			while( $row_logo = $stmt2->fetch() ) 
			{
				echo '<a href="results.php?inmobiliaria='.$row['id'].'"><img src="'.$row_logo["foto"].'" /></a>';
			}		
        }
		?>
        </div>
        <div class="ver_mas"><a href="inmobiliarias.php">Ver todas</a></div>
      </div>
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>

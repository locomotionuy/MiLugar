<?php 
include 'inc-conn.php';

if(isset($_GET['favorito_id'])) 
{
	if(isset($_COOKIE['favoritos']))
	{
		$repetido = 0;
		$favoritos_array = unserialize($_COOKIE['favoritos']);
		
		foreach($favoritos_array as $key => $valor)
		{
			if($valor==$_GET['favorito_id'])
			{
				unset($favoritos_array[$key]);
				$repetido = 1;
			}
		}
		
		if($repetido == 0) { array_push($favoritos_array,$_GET['favorito_id']); }
		setcookie("favoritos", serialize($favoritos_array), time() + (86400 * 30));
	}
	else
	{
		$favoritos_array = array($_GET['favorito_id']);
		setcookie("favoritos", serialize($favoritos_array), time() + (86400 * 30));	
	}
}

$mod = 'favoritos';
include 'inc-header.php';

?>

<div class="body">
  <div class="title">
    <div class="center">
      <div class="content"><?php echo $texto_titulo_favoritos ?></div>
    </div>
  </div>
  <div id="results">
    <div class="center">
      <div class="content">
        <?php 
require 'inc/inc-paginator.php';

$tabla = 'propiedades';
$thumbnails = true;

$pagination = new PDO_Pagination($conn);
$pagination->rowCount("SELECT * FROM $tabla");
$pagination->config(3, 10);

$sql = "SELECT * FROM $tabla WHERE publicado=1 and (";

$favoritos_array = unserialize($_COOKIE['favoritos']);
$i=0;

if(isset($_COOKIE['favoritos']))
{
	foreach($favoritos_array as $key => $valor)
	{
		if($i==0)
		{ 
			$sql .= " id=$valor"; 
		}
		else 
		{
			$sql .= " or id=$valor";
		}
		$i++;
	}
}
$sql .= ' ) ';
if(!isset($_COOKIE['favoritos']) or count(unserialize($_COOKIE['favoritos']))<1) 
{
	$sql .= " WHERE id='0'";
}

$sql .= " ORDER BY id DESC LIMIT $pagination->start_row, $pagination->max_rows";	
$query = $conn->prepare($sql);
$query->execute();
$model = array();
while($rows = $query->fetch())
{
  $model[] = $rows;
}
?>
        <div class="results-info">
          <div class="count">
            <?php if($mod=="home") echo "Ultimos ingresos"; else { echo count($model)." Resultados"; } ?>
          </div>
          <div class="order">
            <form action="" method="get">
              <div class="custom-select">
                <select name="ordenar" class="custom-select">
                  <option>Más Reciente</option>
                  <option>Mayor Precio</option>
                  <option>Menor Precio</option>
                </select>
              </div>
            </form>
          </div>
        </div>
        <?php 
foreach($model as $row)
{
?>
        <div class="result <?php echo $row['id'] ?>"> <a class="wrap" href="file.php?id=<?php echo $row['id'] ?>">
          <div class="foto" style=" background-image:url(<?php 
				$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." ORDER BY orden ASC LIMIT 1");
				$stmt->execute();
				while( $imagen = $stmt->fetch() ) 
				{
					echo $imagen["foto_thumb"];
				}
				?>)">
            <?php if($row['vendida']==1) echo '<div class="vendida"><i class="fas fa-handshake"></i>'.$tipovendida.'</div>'; ?>
            <div class="ready"><img src="images/360ready.png" srcset="images/360readyB.svg" alt="360Ready" /></div>
          </div>
          <div class="result_dato">
            <div class="precio">
              <?php if($row['IdUnidadPrecio']=="UYU" or $row['IdUnidadPrecio']=="$") echo "$"; else echo "U\$S"; ?>
              <?php  echo number_format($row['Precio'], 0, '', '.'); ?>
            </div>
            <div class="info"><?php echo $inmueble.' en '.$operacion; ?><br />
              <?php echo $row['IdLocalidad'] ?><br />
              <?php echo $row['SuperficieConstruida'] ?>m² Cons. - <?php echo $texto_label_dorms ?>: <?php echo $row['IdDormitorios'] ?> - <?php echo $texto_label_banio ?>: <?php echo $row['IdBanios'] ?> </div>
            <div class="favorite saved" id="<?php echo $row['id'] ?>"><i class="fas fa-heart"></i></div>
            <div class="result_dato_logo"> <img src="<?php 
                $stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia='".$row['inmobiliaria']."' and tipo='logo' ORDER BY principal DESC LIMIT 1");
                $stmt->execute();
                while( $imagen = $stmt->fetch() ) 
                {
                    echo $imagen["foto_thumb"];
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
</div>
<?php include 'inc-footer.php'; ?>

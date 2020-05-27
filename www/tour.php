<?php 
include 'inc-conn.php';

$mod = 'file';
$tabla = 'propiedades';

include 'inc-header.php';
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM $tabla WHERE id= $id " );
$stmt->execute();
while( $row = $stmt->fetch() ) 
	
{
?>

<div class="body">
  <div id="file">
    <div class="file-title">
      <div class="center">
        <div class="content">
          <?php 
	if(strlen($row['titulo'])>3) echo $row['titulo']; 
	else echo $lista_inmuebles[$row['IdTipoInmueble']-1][1]." en ".$lista_operaciones[$row['IdTipoOperacion']-1][1]." en ".$row['IdLocalidad'];
			?>
          <div class="favorite <?php

			$favoritos_array = unserialize($_COOKIE['favoritos']);

 			if(count($favoritos_array) > 0){
				foreach($favoritos_array as $key => $valor)
				{
					if($valor==$row['id'])
					{
						echo "saved";
					}
				}
			}?>" id="<?php echo $row['id'] ?>"><i class="fas fa-heart"></i> </div>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="js/dimensionTour360.min.js" id="<?php echo $row['id'] ?>" height="500"></script>
    <div id="datos">
      <div class="center">
        <div class="content">
          <div class="datos1">
            <div class="precio">
              <?php if($row['IdUnidadPrecio']=="UYU" or $row['IdUnidadPrecio']=="$") echo "$"; else echo "U\$S" ?>
              <?php 
				$precio = doubleval($row['Precio']);
				echo number_format($precio, 0, '', '.');  
			  ?>
              </div>
            <div class="ubicacion"><i class="fa fa-map-marker-alt fa-fw"></i> <?php echo $row['IdLocalidad'] ?></div>
            <div class="lugar"><?php echo $texto_label_dormitorio ?> <div class="cantidad"><?php echo $row['IdDormitorios'] ?></div></div>
            <div class="lugar"><?php echo $texto_label_banio ?> <div class="cantidad"><?php echo $row['IdBanios'] ?></div></div>
            <div class="lugar"><?php echo $texto_label_garage ?> <div class="cantidad"><?php echo $row['garage'] ?></div></div>
            
          </div>
          <div class="datos2">
            <div class="text_more_properties"><?php echo $texto_label_mas_propiedades ?></div>
            <div class="brand_logo" onclick="location.href='results.php?inmobiliaria=<?php echo $row['inmobiliaria'] ?>'" style="background-image: url(<?php 
			$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['inmobiliaria']." and tipo='logo' ORDER BY principal DESC LIMIT 1");
			$stmt->execute();
			while( $imagen = $stmt->fetch() ) 
			{
				echo $dir_logos.$imagen["foto"];
			}
			?>)"></div>
          </div>
          <div class="datos3">
            <div class="preguntar">
            <a href="consulta.php?id=<?php echo $row['id']."-".$row['inmobiliaria']; ?>"><i class="fas fa-question"></i> <?php echo $texto_label_preguntar_vendedor ?></a>
            </div>
            <div class="social">
            <a href="javascript:CopiarUrl();"><i class="fas fa-copy fa-fw"></i></a>
            
<a href="https://wa.me/?text=http://<?php echo  $_SERVER['SERVER_NAME']; ?>/file.php?id=<?php echo $row['id']; ?>%20-%20<?php 
				echo $lista_inmuebles[$row['IdTipoInmueble']-1][1]."%20%20en%20%20".$lista_operaciones[$row['IdTipoOperacion']-1][1]."%20%20en%20%20".$row['IdLocalidad'];?>"><i class="fab fa-whatsapp fa-fw"></i></a>
               
               
            <?php echo '<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: es_ES</script>'; ?>

			<!-- LinkedIn -->
			<a href="https://www.linkedin.com/sharing/share-offsite/?url=https%3A%2F%2F<?php echo  $_SERVER['SERVER_NAME']; ?>%2Ffile.php%3Fid%3D<?php echo $id; ?>" onClick="window.open(this.href, this.target, 'width=370,height=460'); return false;" target="_blank">
				<i class="fab fa-linkedin-in fa-fw"></i>
			</a>
			
			<!-- Mail -->
			<a href="mailto:?Subject=Dimensión360&amp;Body=<?php echo $lista_inmuebles[$row['IdTipoInmueble']-1][1]."%20%20en%20%20".$lista_operaciones[$row['IdTipoOperacion']-1][1]."%20%20en%20%20".$row['IdLocalidad']; ?>%20https://<?php echo  $_SERVER['SERVER_NAME']; ?>/file.php?id=<?php echo $row['id'] ?>" target="_blank"><i class="fa fa-envelope fa-fw"></i></a>
			
			<!-- Google+ -->
			<a href="https://plus.google.com/share?url=https://<?php echo  $_SERVER['SERVER_NAME']; ?>/file.php?id=<?php echo $id; ?>" onClick="window.open(this.href, this.target, 'width=410,height=500'); return false;" target="_blank">
				<i class="fab fa-google-plus-g fa-fw"></i>
			</a>
			<!-- Twitter -->
			<a href="https://www.twitter.com/share?url=https%3A%2F%2F<?php echo  $_SERVER['SERVER_NAME']; ?>%2Ffile.php%3Fid%3D<?php echo $row['id'] ?>"  onClick="window.open(this.href, this.target, 'width=350,height=250'); return false;" target="_blank">
				<i class="fab fa-twitter fa-fw"></i>
			</a>
			
			<!-- Facebook -->
			<a href="https://www.facebook.com/sharer.php?s=100&p[url]=https://<?php echo  $_SERVER['SERVER_NAME']; ?>/file.php?id=<?php echo $row['id'] ?>&p[images][0]=https://<?php echo  $_SERVER['SERVER_NAME']; ?>/<?php 
				
				$stmt2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." and tipo='360' ORDER BY orden ASC LIMIT 1");
				$stmt2->execute();
				while( $imagen2 = $stmt2->fetch() ) 
				{
					echo $dir_fotos_thumbs.$imagen2["foto"];
				}
				
			 ?>" onClick="window.open(this.href, this.target, 'width=560,height=600'); return false;" target="_blank">
				<i class="fab fa-facebook-f fa-fw"></i>
			</a>
               
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="center">
      <div class="content">
        <div id="detalle">
          <div class="titulo"><?php echo $texto_label_caracteristicas ?></div>
          <?php if($row['IdDormitorios']!=="") { ?>
          <div class="detalle_titulo"><i class="fa fa-bed fa-fw"></i><?php echo $texto_label_dormitorio ?>: </div>
          <div class="detalle_dato"><?php echo $row['IdDormitorios']?></div>
          <?php } ?>
          <?php if($row['IdBanios']!=="") { ?>
          <div class="detalle_titulo"><i class="fa fa-bath fa-fw"></i><?php echo $texto_label_banio ?>: </div>
          <div class="detalle_dato"><?php echo $row['IdBanios']?></div>
          <?php } ?>
          <?php if($row['SuperficieConstruida']!=="") { ?>
          <div class="detalle_titulo"><i class="far fa-square"></i><?php echo $texto_label_sup_cons ?>: </div>
          <div class="detalle_dato"><?php echo $row['SuperficieConstruida']?><?php echo $texto_label_medidas ?></div>
          <?php } ?>
          <?php if($row['SuperficieTotal']!=="") { ?>
          <div class="detalle_titulo"><i class="fas fa-square fa-fw"></i><?php echo $texto_label_sup_total ?>: </div>
          <div class="detalle_dato"><?php echo $row['SuperficieTotal']?><?php echo $texto_label_medidas ?></div>
          <?php } ?>
          <?php if($row['GastosComunesMonto']!=="") { ?>
          <div class="detalle_titulo"><i class="fa fa-shield-alt fa-fw"></i><?php echo $texto_label_gastos_comunes ?>:</div>
          <div class="detalle_dato"><?php echo $row['IdUnidadGastosComunes']?> <?php echo $row['GastosComunesMonto']?></div>
          <?php } ?>
          <?php if($row['orientacion']!=="") { ?>
          <div class="detalle_titulo"><i class="fa fa-compass fa-fw"></i><?php echo $texto_label_orientacion ?>:</div>
          <div class="detalle_dato"><?php echo $row['orientacion']?></div>
          <?php } ?>
          <?php if($row['garantia']!=="") { ?>
          <div class="detalle_titulo"><i class="fas fa-dollar-sign fa-fw"></i></i><?php echo $texto_label_garantia ?>:</div>
          <div class="detalle_dato"><?php echo $row['garantia']?></div>
          <?php } ?>
          <?php if($row['garage']!=="") { ?>
          <div class="detalle_titulo"><i class="fa fa-car fa-fw"></i><?php echo $texto_label_garage ?>: </div>
          <div class="detalle_dato">
            <?php if($row['garage']=="0") echo "No tiene"; else echo $row['garage']?>
          </div>
          <?php } ?>
          <?php if($row['barrio_privado']=="1") { ?>
          <div class="detalle_titulo"><i class="fa fa-home fa-fw"></i><?php echo $texto_label_barrio_privado ?>:</div>
          <div class="detalle_dato"><?php echo $texto_label_si ?></div>
          <?php } ?>
          <?php if($row['vivienda_social']=="1") { ?>
          <div class="detalle_titulo"><i class="fas fa-building fa-fw"></i><?php echo $texto_label_vivienda_social ?>:</div>
          <div class="detalle_dato"><?php echo $texto_label_si ?></div>
          <?php } ?>
          <?php if($row['amueblado']=="1") { ?>
          <div class="detalle_titulo"><i class="fa fa-couch fa-fw"></i><?php echo $texto_label_amueblado ?>:</div>
          <div class="detalle_dato"><?php echo $texto_label_si ?></div>
          <?php } ?>
          <?php if($row['mascotas']=="1") { ?>
          <div class="detalle_titulo"><i class="fas fa-paw"></i><?php echo $texto_label_mascotas ?>:</div>
          <div class="detalle_dato"><?php echo $texto_label_si ?></div>
          <?php } ?>
          <?php if($row['jardin']=="1") { ?>
          <div class="detalle_titulo"><i class="fab fa-pagelines fa-fw"></i><?php echo $texto_label_jardin ?>: </div>
          <div class="detalle_dato"><?php echo $texto_label_si ?></div>
          <?php } ?>
          <?php if($row['azotea']=="1") { ?>
          <div class="detalle_titulo"><i class="fas fa-building fa-fw"></i><?php echo $texto_label_azotea ?>:</div>
          <div class="detalle_dato"><?php echo $texto_label_si ?></div>
          <?php } ?>
          <?php if($row['parrillero']=="1") { ?>
          <div class="detalle_titulo"><i class="fas fa-stroopwafel"></i><?php echo $texto_label_parrillero ?>:</div>
          <div class="detalle_dato"><?php echo $texto_label_si ?></div>
          <?php } ?>
        </div>
        <?php if($row['descripcion']!=="") { ?>
        <div id="descripcion">
          <div class="titulo"><?php echo $texto_label_descripcion ?></div>
          <div class="texto">
            <?php  echo $row['descripcion']?>
          </div>
        </div>
        <?php } ?>
        <?php if($row['video']!=="") { ?>
        <div id="descripcion">
          <div class="titulo"><?php echo $texto_label_ubicacion ?></div>
          <div class="direccion"></div>
          <div class="map">
			<iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $row['video']?>?rel=0" frameborder="0" allow="accelerometer;  encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
        <?php } ?>
        <?php if($row['mapa']!=="") { ?>
        <div id="descripcion">
          <div class="titulo"><?php echo $texto_label_ubicacion ?></div>
          <div class="direccion"></div>
          <div class="map">
            <iframe src="<?php  echo $row['mapa']?>" width="100%" height="400px" frameborder="0" style="border:0;" allowfullscreen></iframe>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php include 'inc-footer.php'; ?>

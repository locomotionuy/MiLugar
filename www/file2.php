<?php 
include 'inc-conn.php';

$mod = 'file';
$tabla = 'propiedades';

include 'inc-header.php';
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM $tabla WHERE id= $id LIMIT 1" );
$stmt->execute();
while( $row = $stmt->fetch() ) 
	
{
	$inmobiliaria = $row['inmobiliaria'];
	$stmt_tabs2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=$inmobiliaria and tipo = 'logo'");
	$stmt_tabs2->execute();
	while( $row2 = $stmt_tabs2->fetch() ) 
	{
		$logo = $row2['foto'];
	}
	$stmt_tel = $conn->prepare("SELECT * FROM usuarios WHERE id=$inmobiliaria");
	$stmt_tel->execute();
	while( $row_tel = $stmt_tel->fetch() ) 
	{
		if($row_tel['telefono']=="") { $telefono = $row_tel['celular']; } else { $telefono = $row_tel['telefono']; }
	}
?>
<div class="body">
  <div id="file">
    <div class="center">
      <div class="content">
        <div id="copetes">
          <?php
			$stmt_tabs2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=$id and tipo = 'foto'");
            $stmt_tabs2->execute();
            while( $row2 = $stmt_tabs2->fetch() ) 
            {
                $cantidad_fotos[] = $row2;
				$cantidad_fotos2[] = $row2;
            }
			if(count($cantidad_fotos)>0){
				
				$visor = 2;
				$visor_tab2 = 2;
			}
		  
            $stmt_tabs1 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=$id and tipo = '360'");
            $stmt_tabs1->execute();
            while( $row1 = $stmt_tabs1->fetch() )
            {
                $cantidad[] = $row1;
            }
			
			if(isset($cantidad) and count($cantidad)>0)
			{
				
				$visor = 1;
				$visor_tab1 = 1;
			}
			
			if(isset($_GET['visor'])) 
			{ 
				$visor = $_GET['visor']; 
			}
			
            if(isset($visor_tab1) and $visor_tab1==1)
			{
            ?>
          <a href="file.php?id=<?php echo $_GET['id'] ?>&visor=1" class="btn_fotos360 <?php if($visor==1) echo 'brd_selected'; ?> btn"> <span <?php if($visor==1) echo 'class="selected"' ?>>Fotos 360</span> (<?php echo count($cantidad);?>)</a>
          <?php 
            }
            if($visor_tab2==2){
            ?>
          <a href="file.php?id=<?php echo $_GET['id'] ?>&visor=2" class="btn_fotos <?php if($visor==2) echo 'brd_selected'; ?> btn"> <span  <?php  if($visor==2) echo 'class="selected"' ?>>Fotos (<?php echo count($cantidad_fotos2);?>)</span> </a>
          <?php
            }
            ?>
          <div class="favorite <?php

			if(isset($_COOKIE['favoritos'])){
				
				$favoritos_array = unserialize($_COOKIE['favoritos']);

				if(count($favoritos_array) > 0){
					foreach($favoritos_array as $key => $valor)
					{
						if($valor==$row['id'])
						{
							echo "saved";
						}
					}
				}
				
			} ?>" id="<?php echo $row['id'] ?>"><i class="fas fa-heart"></i></div>
        </div>
        <?php 
		if($visor==1)
		{
		?>
        <div class="file-gallery" id="gallery360"> 
          <script type="text/javascript" src="js/dimension360.min.js" id="<?php echo $row['id'] ?>" height="550"></script> 
        </div>
        <?php
		}
		else if($visor==2)
		{
		?>
        <div class="file-gallery" id="gallery">
          <?php 
            $slide_tabla = "fotos"; 
            $slide_url = "#";
            $sldnum = 1;
            $id_referencia = $id;
            $duracion_slide = 3000;
            include 'inc-gallery.php';
            ?>
        </div>
        <?php 
		}
		?>
        <div class="file-info">
          <div class="col">
            <div class="file-info-title">
              <?php if(strlen($row['titulo'])>3) echo $row['titulo']; else echo $lista_inmuebles[$row['IdTipoInmueble']-1][1]." en ".$lista_operaciones[$row['IdTipoOperacion']-1][1]." en ".$row['IdLocalidad']; ?>
            </div>
            <div class="file-info-precio">
              <?php if($row['IdUnidadPrecio']=="UYU" or $row['IdUnidadPrecio']=="$") echo "$"; else echo "U\$S" ?>
              <?php 
				$precio = doubleval($row['Precio']);
				echo number_format($precio, 0, '', '.');  
			  ?>
            </div>
            <div class="file-cracteristicas">
              <?php if($row['IdDormitorios']==99) echo '+ de 4'; else echo $row['IdDormitorios']; ?>
              <?php echo $texto_label_dormitorio ?><br />
              <?php if($row['IdBanios']==99) echo '+ de 4'; else echo $row['IdBanios'] ?>
              <?php echo $texto_label_banio ?><br />
              <?php echo $row['garage']." ".$texto_label_garage; ?> </div>
          </div>
          <div class="col">
            <div id="file-contacto">
              <div class="contacto-titulo">Consultar por esta propiedad:</div>
              <iframe src="consulta.php?idprop=<?php echo $row['id'] ?>" frameborder="0" scrolling="no"></iframe>
            </div>
            <div class="social"> <a class="color_facebook" href="javascript:CopiarUrl();" ><i class="fas fa-copy fa-fw"></i></a> <a class="color_whatsapp" href="https://wa.me/?text=http://<?php echo  $_SERVER['SERVER_NAME']; ?>/file.php?id=<?php echo $row['id']; ?>%20-%20<?php 
				echo $lista_inmuebles[$row['IdTipoInmueble']-1][1]."%20%20en%20%20".$lista_operaciones[$row['IdTipoOperacion']-1][1]."%20%20en%20%20".$row['IdLocalidad'];?>"><i class="fab fa-whatsapp fa-fw"></i></a> <?php echo '<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: es_ES</script>'; ?> 
              
              <!-- LinkedIn --> 
              <a class="color_in" href="https://www.linkedin.com/sharing/share-offsite/?url=https%3A%2F%2F<?php echo  $_SERVER['SERVER_NAME']; ?>%2Ffile.php%3Fid%3D<?php echo $id; ?>" onClick="window.open(this.href, this.target, 'width=370,height=460'); return false;" target="_blank"> <i class="fab fa-linkedin-in fa-fw"></i> </a> 
              
              <!-- Mail --> 
              <a class="color_email" href="mailto:?Subject=MiLugar&amp;Body=<?php echo $lista_inmuebles[$row['IdTipoInmueble']-1][1]."%20%20en%20%20".$lista_operaciones[$row['IdTipoOperacion']-1][1]."%20%20en%20%20".$row['IdLocalidad']; ?>%20https://<?php echo  $_SERVER['SERVER_NAME']; ?>/file.php?id=<?php echo $row['id'] ?>" target="_blank"><i class="fa fa-envelope fa-fw"></i></a> 
              
              <!-- Twitter --> 
              <a class="color_twitter" href="https://www.twitter.com/share?url=https%3A%2F%2F<?php echo  $_SERVER['SERVER_NAME']; ?>%2Ffile.php%3Fid%3D<?php echo $row['id'] ?>" onClick="window.open(this.href, this.target, 'width=350,height=250'); return false;" target="_blank"> <i class="fab fa-twitter fa-fw"></i> </a> 
              
              <!-- Facebook --> 
              <a class="color_facebook" style="margin-right: 0px;" href="https://www.facebook.com/sharer.php?u=https://<?php echo  $_SERVER['SERVER_NAME']; ?>/file.php?id=<?php echo $row['id'] ?>&p[images][0]=<?php 
				
				$stmt2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." and tipo!='logo' ORDER BY orden ASC LIMIT 1");
				$stmt2->execute();
				while( $imagen2 = $stmt2->fetch() ) 
				{
					echo $imagen2["foto_thumb"];
				}
				
				 ?>" onClick="window.open(this.href, this.target, 'width=560,height=600'); return false;" target="_blank"> <i class="fab fa-facebook-f fa-fw"></i> </a> </div>
          </div>
        </div>
        <div id="resumen">
          <div class="datos-ubicacion"> <i class="fas fa-map-marker-alt"></i> <?php echo $row['IdLocalidad'] ?><br />
            <span><?php echo $row['Calle'] ?>
            <?php if(strlen($row['Esquina'])>3) echo "Esq: ".$row['Esquina'] ?>
            </span> </div>
          <div class="datos-inmobiliaria">
            <div class="datos-inmobiliaria-text"><?php echo $texto_label_mas_propiedades ?></div>
            <div class="datos-inmobiliaria-logo" onclick="location.href='results.php?inmobiliaria=<?php echo $row['inmobiliaria'] ?>'"><img src="<?php echo $logo; ?>" alt="Inmobiliaria" /></div>
          </div>
          <div class="datos-telefono"> TELÉFONO DE CONTACTO:<br />
            <span> <?php echo $telefono ?> </span> </div>
        </div>
        <div id="informacion">
          <div class="separador"></div>
          <div class="titulos">CARACTERÍSTICAS</div>
          <div class="wrap">
            <?php if($row['IdDormitorios']!=="") { ?>
            <div class="detalle_titulo"><i class="fa fa-bed fa-fw"></i><?php echo $texto_label_dormitorio ?>: </div>
            <div class="detalle_dato">
              <?php 
			  if($row['IdTipoInmueble'] == 'Terreno') 
			  {
			  	echo $row['IdDormitorios'];
			  }
			  else
			  {
			  	if($row['IdDormitorios'] == '0') echo 'Monoambiente'; else echo $row['IdDormitorios']; 
			  }
			  ?>
            </div>
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
            <?php if($row['aire_acondicionado']=="1") { ?>
            <div class="detalle_titulo"><i class="fas fa-stroopwafel"></i><?php echo $texto_label_aire_acondicionado ?>:</div>
            <div class="detalle_dato"><?php echo $texto_label_si ?></div>
            <?php } ?>
            <?php if($row['garantia']!=="") { ?>
            <div class="detalle_titulo fix_titulo_garantia"><i class="fas fa-dollar-sign fa-fw"></i></i><?php echo $texto_label_garantia ?>S:</div>
            <div class="detalle_dato fix_dato_garantia">
              <?php 
			echo $row['garantia'];
			?>
            </div>
            <?php } ?>
          </div>
          <?php if($row['descripcion']!=="") { ?>
          <div class="titulos"><?php echo $texto_label_descripcion ?></div>
          <div class="wrap">
            <?php  echo $row['descripcion']?>
          </div>
          <?php } ?>
          <?php if($row['video']!=="") { ?>
          <div class="titulos">Video</div>
          <div class="wrap" style="text-align:center">
            <iframe class="youtube" src="https://www.youtube.com/embed/<?php echo $row['video']?>?rel=0" frameborder="0" allow="accelerometer;  encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
          <?php } ?>
          <?php if($row['mapa']!=="") { ?>
          <div class="titulos"><?php echo $texto_label_ubicacion ?></div>
          <div class="map"><?php echo $row['latitud']; ?>
         <iframe src = "https://maps.google.com/maps?q=<?php echo $row['latitud']; ?>,<?php echo $row['longitud']; ?>&hl=es;z=14&amp;output=embed" width="100%" height="400px" frameborder="0" style="border:0;" allowfullscreen></iframe>
          <<!--iframe src = "https://maps.google.com/maps?q=-34.898609,-56.179622&hl=es;z=14&amp;output=embed" width="100%" height="400px" frameborder="0" style="border:0;" allowfullscreen></iframe>-->

            <!--<iframe  src="<?php  echo $row['mapa']?>" width="100%" height="400px" frameborder="0" style="border:0;" allowfullscreen></iframe>-->
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
  <?php

$inmobiliaria = $row['inmobiliaria'];

} 
 
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id= $inmobiliaria " );
$stmt->execute();
while( $row = $stmt->fetch() ) 
{
	$nombre_inmobiliaria = $row['nombre'];
}
?>
  <div id="titulo_file">
    <div class="center">
      <div class="content"><?php echo $texto_mas_inmuebles."<strong>".$nombre_inmobiliaria."</strong>" ?>:</div>
    </div>
  </div>
  <div id="results" class="fix_results">
    <div class="center">
      <div class="content">
        <?php 
    $stmt2 = $conn->prepare("SELECT * FROM propiedades WHERE publicado=1 and inmobiliaria ='$inmobiliaria' ORDER BY id DESC LIMIT 0, 6");
    $stmt2->execute();
    while($row = $stmt2->fetch()) 
    {
    
    $inmueble = $lista_inmuebles[$row['IdTipoInmueble']-1][1];
    $operacion = $lista_operaciones[$row['IdTipoOperacion']-1][1];
    $tipovendida = $lista_operaciones[$row['IdTipoOperacion']-1][4];
    ?>
        <div class="result"> <a class="wrap" href="file.php?id=<?php echo $row['id'] ?>">
          <div class="foto" style=" background-image:url(<?php 
			$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." ORDER BY orden ASC LIMIT 1");
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
            <div class="info"><?php echo $inmueble.' en '.$operacion; ?>
              <p />
              <?php echo $row['IdLocalidad'] ?>
              <p />
              <?php echo $row['SuperficieConstruida'] ?>m² Cons. - <?php echo $texto_label_dorms ?>: <?php echo $row['IdDormitorios'] ?> - <?php echo $texto_label_banio ?>: <?php echo $row['IdBanios'] ?> </div>
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
            <div class="result_dato_logo"> <img src="<?php echo $logo; ?>" alt="Inmobiliaria" /> </div>
          </div>
          </a> </div>
        <?php 
}
?>
        <div class="mas_resultados"> <a href="results.php?inmobiliaria=<?php echo $inmobiliaria ?>">Ver más inmuebles de <strong><?php echo $nombre_inmobiliaria ?></strong></a> </div>
      </div>
    </div>
  </div>
</div>
<script>
function showCopete(vardiv) {
  document.getElementById("gallery360").style.display = "none";
  document.getElementById("gallery").style.display = "none";
  document.getElementById(vardiv).style.display = "block";  
}
</script>
<?php include 'inc-footer.php'; ?>
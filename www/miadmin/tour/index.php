<!DOCTYPE html>
<html lang="es">
<script>
var panos = [];
var posiciones = [];
var visibilidades = [];
var folder = '../../uploads/fotos/';
var folderThumbs = '../../uploads/fotos/thumbs/';
var marcadores = [];
	
</script>
<?php 
	include '../../inc-conn.php';
	$folder = '../../uploads/fotos/';
	$folder_thumb = $folder.'thumbs/';

	$id = $_GET['id'];
	
	$stmt = $conn->prepare("SELECT * FROM propiedades WHERE id=".$id." LIMIT 1 ");
	$stmt->execute();
	while( $row = $stmt->fetch() ) 
	{
		$descripcion = $row['descripcion'];
		$titulo = $row['titulo'];
	}
	$existeperovacio = false;
	$nuevo = true;
	$stmt = $conn->prepare("SELECT * FROM tour WHERE idreferencia=".$id." LIMIT 1 ");
	$stmt->execute();
	while( $row = $stmt->fetch() ) 
	{
		$nuevo = false;
		$visibilidades = $row['visibilidades'];
		$panos = $row['panos'];
		//$panos = json_decode($row['panos'], true);
		$posiciones = $row['posiciones'];
		?> 
		<script>
		panos = <?php echo $panos; ?>;
		visibilidades = <?php echo $visibilidades; ?>;
		posiciones = <?php echo $posiciones; ?>;
		</script>
		<?php
		$panos = json_decode($row['panos'], true);
	}
	
	if($nuevo){
		$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$id." ORDER BY orden ASC");
		$stmt->execute();
		
		$i = 0;
		while( $foto = $stmt->fetch() ) 
		{
			$panos[] = $foto;
			/*$fotosDB[$i]['desc'] = $foto['nombre'];
			if($fotosDB[$i]['desc']=='') $fotosDB[$i]['desc']='Foto '.$i;
			$fotosDB[$i]['url'] = $foto['foto'];*/
			
			$i++;
		}
		?>
		<script>
			var fotos = <?php echo json_encode($panos); ?>;
			var p=0;
			var f;
			var cant = fotos.length;
			fotos.forEach(function(element) {
				if(fotos[p].nombre=='') fotos[p].nombre='Foto '+p.toString();
				panos.push({
					foto: fotos[p].foto,
					nombre: fotos[p].nombre
				});
				posiciones.push(new Array());
				visibilidades.push(new Array());
				f = 0;
				while(f<cant){
					posiciones[p].push({
						latitude: p,
						longitude:f
					});
					visibilidades[p].push(false) ;
					f++;
				}
				p++;
			});
			
			
		</script>
		<?php 
	}

?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dimension 360 - Tour Virtual</title>
	<link rel="stylesheet" href="../../tour/dist/photo-sphere-viewer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
    html, body {
		width: 100%;
		height: 100%;
		overflow: hidden;
		margin: 0;
		padding: 0;
		font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, "sans-serif";
		color: #fff;
    }

    #visor {
		width: calc(100% - 280px);
		height: 100%;
		float: right;
		cursor: url('../../tour/assets/addpin.png') 22 22, cell;
    }
	#menu{
		float: left;
		height: 100vh;
		width: 280px;
	}
	.tabs {
		margin: 0;
		padding: 0;
		list-style: none;
		overflow: hidden;
		height: 76px;
	}

	.tabs li {
		height: 76px;
		float: left;
		border-bottom: 6px solid #9c9c9c;
		text-align: center;
		width: 33.3%;
		line-height: 14px;
		padding-top: 4%;
		box-sizing: border-box;
		font-size: 11px;
		color: #9c9c9c;
		text-decoration: none;
		transition: all 0.5s ease;
	}
	  .tabs li img{
		 -webkit-filter: grayscale(100%);
   		 filter: grayscale(100%);
	  }
	  .tabs li i{
		  line-height: 30px;
		  margin-bottom: 3px;
		  font-size: 17px;
	  }
	  
	  .tabs li:nth-child(2n) {
		  border-right: 1px solid #9c9c9c; border-left: 1px solid #9c9c9c;
	  }

	.tabs li:hover {
		background: #2babe254;
		border-bottom: 6px #00ade5 solid;
		cursor: pointer;
	}

	.tabs li.active,
	.tabs li.active:hover {
		background: #2babe254;
		border-bottom: 6px #00ade5 solid;
	}
	  
	.tab_container {
		position: relative;
		background-color: #181818;
		width: 100%;
   		height: calc(100% - 76px);
		overflow-x: hidden;
  		overflow-y: auto;
	}
	  
	#btn_guardar{
		position: absolute;
		z-index: 30;
		z-index: 30;
		right: 30px;
		top: 90px;
		width: 250px;
		background-color: #0096d6;
		line-height: 50px;
		border-radius: 6px;
		text-align: center;
		transition: all 0.5s ease;
		letter-spacing: 1px;
	}
	  #btn_guardar i{
		  opacity: 0;
		  margin-left: -15px;
		  margin-right: 5px;
	  }
	  
	  #btn_guardar:hover{
		  cursor: pointer;
		  background-color: #9c9c9c;
	  }
	  
	#btn_ver{
		color: #fff;
		position: absolute;
		z-index: 30;
		right: 30px;
		top: 30px;
		width: 250px;
		background-color: #00d60e;
		line-height: 50px;
		border-radius: 6px;
		text-align: center;
		transition: all 0.5s ease;
		letter-spacing: 1px;
		text-decoration: none;
	}
	  
	  #btn_ver:hover{
		  cursor: pointer;
		  background-color: #9c9c9c;
	  }

	.tab_content {
		padding: 20px;
		font-size: 16px;
		position: absolute;
	}
	  .tab_content ul{
		  list-style: none;
		  padding: 0;
	  }
	  
	  .tab_content h3{
		  margin: 0px;
	  }
	  
	.tab_content li{
		transition: all 0.5s ease;
		margin-bottom: 20px;
		margin-top: 10px;
	}
	.tab_content li img{
		-webkit-filter: grayscale(80%);
		filter: grayscale(80%);
		box-sizing: border-box;
		border: #181818 3px solid;
	}
	  
	#tab1 li.active img{
		border: #fff 3px solid;
		-webkit-filter: grayscale(0%); /* Safari 6.0 - 9.0 */
		filter: grayscale(0%);
	}
	#tab2 li{
		padding-top: 5px;
		padding-bottom: 5px;
		border-radius: 5px;
	}
	  #tab2 li i{
		  margin-right: 8px;
	  }
	#tab2 li:hover{
		padding-left: 10px;
		background-color: #2babe270;
	}
	#tab2 li.active{
		padding-left: 20px;
		background-color: #2babe2;
	}
	  
	  .psv-marker{
		  text-align: center;
	  }
	 
	.tab_content li:hover{
		cursor: pointer;
		-webkit-filter: grayscale(0%); /* Safari 6.0 - 9.0 */
		filter: grayscale(0%);
	}
	.tab_content li:hover img{
		border: #fff 3px solid;
		-webkit-filter: grayscale(0%); /* Safari 6.0 - 9.0 */
		filter: grayscale(0%);
	}
	
	.psv-button{
		font-size: 22px;
		line-height: 20px;
	}

  </style>
</head>
<body>
<div id="btn_ver" onClick="vertour()">VER TOUR</div>
<div id="btn_guardar" onClick="guardartour()"><i id="guardando" class="fas fa-sync fa-spin"></i>GUARDAR TOUR</div>
<div id="menu">
	<ul class="tabs">
		<li mostrar="#tab1"><img src="../../images/btn-360.png" width="30" alt=""/><br>FOTO 360</li>
		<li mostrar="#tab2"><!--<i class="fas fa-angle-double-up"></i><img src="../../tour/assets/pin2.png" width="26" alt="" style="margin-bottom: 4px;"/>--><i class="fas fa-map-marker-alt"></i><br>UBICACIÓN</li>
		<li mostrar="#tab3"><i class="fas fa-info-circle"></i><br>INFORMACIÓN</li>
	</ul>
	<div class="tab_container">
		<div id="tab1" class="tab_content">
		<h3>Elegir la foto que quieres editar</h3>
		<ul>
			<?php 
				$numero=0;
			//$panos = json_encode($panos);
				foreach ($panos as $foto) {
					if($foto['nombre'] == "") $foto['nombre'] = "Foto ".$numero;
					echo '<li onclick=cambiarPano('.$numero.') id="foto'.$numero.'"><img width="230" src="'.$folder_thumb.$foto['foto'].'" alt="Editar esta foto"/><br>'.$foto['nombre'].'</li>';
					$numero++;
				}
			?>
		</ul>
      </div>
		<div id="tab2" class="tab_content">
			<h3>Elegir el punto que quieres poner</h3>
			<ul>
			<?php 
				$numero=0;
				foreach ($panos as $foto) {
					echo '<li onclick=cambiarMarcador('.$numero.') id="marcador'.$numero.'"><i class="fas fa-map-marker-alt"></i> '.$foto['nombre'].'</li>';
					$numero++;
				}
			?>
			</ul>
		</div>
		<div id="tab3" class="tab_content">
		  <div id="addTag"><i class="fas fa-info-circle"></i> Agregar tag</div>
        </div>
  </div>
</div>
<div id="visor"></div>

<script src="../../tour/node_modules/three/build/three.js"></script>
<script src="../../tour/node_modules/d.js/lib/D.js"></script>
<script src="../../tour/node_modules/uevent/uevent.js"></script>
<script src="../../tour/node_modules/dot/doT.js"></script>
<script src="../../tour/node_modules/nosleep.js/dist/NoSleep.js"></script>
<script src="../../tour/node_modules/three/examples/js/renderers/CanvasRenderer.js"></script>
<script src="../../tour/node_modules/three/examples/js/renderers/Projector.js"></script>
<script src="../../tour/node_modules/three/examples/js/controls/DeviceOrientationControls.js"></script>
<script src="../../tour/node_modules/three/examples/js/effects/StereoEffect.js"></script>
<script src="../../tour/dist/photo-sphere-viewer.js"></script>

<script type="text/template" id="pin-content">
  <h1><?php echo $titulo; ?></h1>
  <p><?php echo $descripcion; ?></p>
</script>

<script>
	
$(document).ready(function($) {
	$('.tab_content').hide();
	$('.tab_content:first').show();
	$('.tabs li:first').addClass('active');
	$('.tabs li').click(function(event) {
		$('.tabs li').removeClass('active');
		$(this).addClass('active');
		$('.tab_content').hide();
		//var selectTab = $(this).find('a').attr("href");
		var selectTab = $(this).attr("mostrar");
		$(selectTab).fadeIn();
	});
	
	$('#tab1 li:first').addClass('active');
	$('#tab1 li').click(function(event) {
		$('#tab1 li').removeClass('active');
		$(this).addClass('active');
	});
	$('#tab2 li:nth-child(1)').hide();
	$('#tab2 li:nth-child(2)').addClass('active');
	$('#tab2 li').click(function(event) {
		$('#tab2 li').removeClass('active');
		$(this).addClass('active');
	});
});

var PSV = new PhotoSphereViewer({
    container: 'visor',
	//touchmove_two_fingers: true,
    panorama: folder+panos[0].foto,
    caption: panos[0].nombre,
    loading_img: '../../tour/assets/preload.gif',
    anim_speed: '-3rpm',
    default_fov: 50,
    fisheye: true,
    move_speed: 1.1,
    time_anim: false,
    navbar: [
		'autorotate', 'zoom', 'caption', 'gyroscope', 'stereo', 'fullscreen'
    ]
	,markers: Marcadores()
});

function Marcadores(){
	var i=0;
	panos.forEach(function(element) {
		marcadores.push({
			id: '#'+i,
			tooltip: panos[i].nombre,
			longitude: posiciones[0][i].longitude,
			latitude: posiciones[0][i].latitude,
			visible: visibilidades[0][i],
			image: '../../tour/assets/pin2.png',
			width: 60,
			height: 60,
			anchor: 'center center'
		});
		i++;
	});
	/*
	marcadores.push({
		id: '#floor',
		tooltip: 'inmobiliaria',
		longitude:3 ,
		latitude: -1.56,
		visible: 0.8,
		image: '../../tour/assets/floor.png',
		width: 450,
		height: 450,
		anchor: 'center center'
	});*/
	return marcadores;
}

var idfoto = 0;
var idmarcador = 1;//es el index en el array
var limarcador = 2;//el li es 1 mas q el index del id de la foto
var loading = false;
var liesconder = 1;
function cambiarPano(fotoActual) {
	idfoto=fotoActual;
	$('#tab2 li:nth-child('+liesconder+')').show();//muestro el q estaba escondido
	liesconder = idfoto+1;
	$('#tab2 li:nth-child('+liesconder+')').hide();//escondo la foto actual
	if(idfoto == idmarcador){
		limarcador = idmarcador+1;
		$('#tab2 li:nth-child('+limarcador+')').removeClass('active');
		//console.log("coiniden. tenes q cambiar el marcaador");
		if(idmarcador==0) idmarcador=1;
		else idmarcador=0;
		limarcador = idmarcador+1;
		$('#tab2 li:nth-child('+limarcador+')').addClass('active');
	}
	loading = true;

	PSV.setPanorama(folder+panos[idfoto].foto, panos[idfoto].target, true).then(function() {
		PSV.setCaption(panos[idfoto].nombre);
		loading = false;
	});
	var i=0;
	marcadores.forEach(function(element) {
		if(element.id!='floor'){
			PSV.updateMarker({
				id: element.id,
				longitude: posiciones[idfoto][i].longitude,
				latitude: posiciones[idfoto][i].latitude,
				visible: visibilidades[idfoto][i]
			});
		};
		i++;
	});	

}
	
function cambiarMarcador(marcadorActual){
	idmarcador=marcadorActual;
	console.log("idmarcador "+idmarcador);
}
	
PSV.on('click', function(e) {
	posiciones[idfoto][idmarcador].latitude = e.latitude;
	posiciones[idfoto][idmarcador].longitude = e.longitude;
	visibilidades[idfoto][idmarcador] = true;
	PSV.updateMarker({
		id: "#"+idmarcador,
		longitude: e.longitude,
		latitude: e.latitude,
		tooltip: "<i class='fas fa-trash-alt'></i> Quitar punto que va al:<br>"+panos[idmarcador].nombre,
		visible: visibilidades[idfoto][idmarcador]
	});
});
	
PSV.on('select-marker', function(marker, click) {
	var numeroId = marker.id.substring(1, marker.id.length);
	if(marker.id != 'floor'){
		visibilidades[idfoto][numeroId] = false;
		PSV.updateMarker({
			id: marker.id,
			visible: visibilidades[idfoto][numeroId]
        });
	}
});
	
function guardartour(){
	$('i#guardando').css('opacity', '1');
	posicionesString = JSON.stringify(posiciones);
	visibilidadesString = JSON.stringify(visibilidades);
	panosString = JSON.stringify(panos);
	$.ajax({
		type: "GET",
		url: "guardar.php",
		data: {posiciones:posicionesString,visibilidades:visibilidadesString,panos:panosString,idreferencia:<?php echo $id; ?>},
		//data: posiciones,visibilidades,panos,
		cache: false,
		success: function(){
			console.log('se guardo?');
			$('i#guardando').css('opacity', '0');
		}
	});
}
function vertour(){
		console.table(posiciones);
		posicionesString = JSON.stringify(posiciones);
		visibilidadesString = JSON.stringify(visibilidades);
		panosString = JSON.stringify(panos);
		$.ajax({
			type: "GET",
			url: "guardar.php",
			data: {posiciones:posicionesString,visibilidades:visibilidadesString,panos:panosString,idreferencia:<?php echo $id; ?>},
			//data: posiciones,visibilidades,panos,
			cache: false,
			success: function(){
				console.log('se guardo?')
				window.open("../../tour.php?id=<?php echo $id; ?>");
  				//new_page.document.write("output");
			}
		});
	}
			   
			    
	/*		   
window.onbeforeunload = function () {
  return 'SSSSeguro?';
 }
	*/

</script>

</body}>
</html>

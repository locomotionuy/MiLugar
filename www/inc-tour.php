<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Visor Dimensión 360</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php 
include 'inc-conn.php';
$tabla = 'fotos';
$dir_fotos = "uploads/fotos/";
$dir_fotos_thumbs = "uploads/fotos/thumbs/";
?>
<link rel="stylesheet" href="js/visor/photo-sphere-viewer.min.css">
<link href="css/desktop-visor360.css?id=1" rel="stylesheet" type="text/css" />
<link href="css/responsive-visor360.css?id=1" rel="stylesheet" type="text/css" />
<script src="js/visor/three.min.js"></script>
<script src="js/visor/D.min.js"></script>
<script src="js/visor/doT.min.js"></script>
<script src="js/visor/uevent.min.js"></script>
<script src="js/visor/CanvasRenderer.js"></script>
<script src="js/visor/Projector.js"></script>
<script src="js/visor/photo-sphere-viewer.js"></script>
<script src="js/visor/StereoEffect.js"></script>
</head>

<body onload="fullscreenCheck()">
<?php
$limit = 1;
$query = "SELECT * FROM fotos WHERE seccion='propiedades' and id_referencia=".$_GET['id']." ORDER BY orden ASC " ;

$s = $conn->prepare($query);
$s->execute();
$total_results = $s->rowCount();
$total_pages = ceil($total_results/$limit);

if (!isset($_GET['page'])) {
    $page = 1;
} else{
    $page = $_GET['page'];
}
$starting_limit = ($page-1)*$limit;
$show  = "SELECT * FROM fotos WHERE id_referencia=".$_GET['id']." and seccion='propiedades' ORDER BY orden ASC LIMIT $starting_limit, $limit";

$r = $conn->prepare($show);
$r->execute();

while($res = $r->fetch(PDO::FETCH_ASSOC))
{

$id_foto = $res["id"];

}
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM tour WHERE idreferencia=".$id." LIMIT 1 ");
	$stmt->execute();
	while( $row = $stmt->fetch() ) 
	{
		$visibilidades = $row['visibilidades'];
		$panos = $row['panos'];
		$posiciones = $row['posiciones'];
	}
	
?>

<div class="wrap-center nav">
  <div class="btn-mask">
    <div onclick="restar()" class="btn-prev"><img src="images/btn-arrow.png" srcset="images/btn-arrow.svg" alt="Prev" /></div>
  </div>
  <div class="btn-mask right">
    <div onclick=sumar() class="btn-next"><img src="images/btn-arrow.png" srcset="images/btn-arrow.svg" alt="Next" /></div>
  </div>
</div>

	
<div class="visor" id="viewer"></div>

	
<div class="wrap-center thumbnails">
 
 <?php 
	$numero=0;
	$panos_array = json_decode($panos, true);
	foreach ($panos_array as $foto) {
		if($foto['nombre'] == "") $foto['nombre'] = "Foto ".$numero;
		?>
		<div onclick=cambiarPano(<?php echo $numero; ?>) class="thumb" style="background-image:url(<?php echo $dir_fotos_thumbs.$foto['foto']; ?>)">
		<?php if(strlen($foto['nombre'])>3){?>
    	<div class="nombre_foto"><span><?php echo $foto['nombre']; ?><i></i></span></div>
		<?php } ?>
 		</div>
  <?php 
		$numero++;
	}
?>
</div>
</body>
</html>


<script>
	
var folder = '<?php echo $dir_fotos; ?>';
var folderThumbs = '<?php echo $dir_fotos_thumbs; ?>';
	
var p=0;
var panos = [];
var posiciones = [];
var visibilidades = [];
var marcadores = [];
	
panos = <?php echo $panos; ?>;
visibilidades = <?php echo $visibilidades; ?>;
posiciones = <?php echo $posiciones; ?>;

$('.thumb:first').addClass('selected');
$(document).ready(function($) {	
	$('.thumb').click(function(event) {
		$('.thumb').removeClass('selected');
		$(this).addClass('selected');
		});
});

var PSV = new PhotoSphereViewer({
	panorama: folder+panos[0].foto,
	caption: panos[0].nombre,
	container: 'viewer',
	anim_speed: '45dpm',
	default_fov: 70,
	time_anim: 100,
	navbar: [
	'autorotate',
	'stereo',
	'zoom'
	],
	transition: {
		duration: 1500, // duration of transition in milliseconds
		loader: false // should display the loader ?
	},
	loading_img: 'tour/assets/preload.gif',
	markers: Marcadores()
});

var marcadores;
function Marcadores(){
	marcadores = [];
	var i=0;
	panos.forEach(function(element) {
		marcadores.push({
			id: '#'+i,
			tooltip: panos[i].nombre,
			longitude: posiciones[0][i].longitude,
			latitude: posiciones[0][i].latitude,
			visible: visibilidades[0][i],
			image: 'tour/assets/pin2.png',
			width: 40,
			height: 40,
			anchor: 'center center'
		});
		i++;
	})
	return marcadores;
}
	
var i = 0;	
var thumb_seleccionado = 1;
function restar(){
	if(i>0 && loading==false) {
		i--;
		cambiarPano(i);
	}
}
function sumar(){
	if(i<panos.length-1 && loading==false) {
		i++;
		cambiarPano(i);
	}
}


var loading = false;
function cambiarPano(fotoActual) {
	i=fotoActual;
	console.log("thumb_seleccionado "+thumb_seleccionado);
	$('.thumb:nth-child('+thumb_seleccionado+')').removeClass('selected');
	thumb_seleccionado = i+1;
	$('.thumb:nth-child('+thumb_seleccionado+')').addClass('selected');
	loading = true;
	PSV.setPanorama(folder+panos[i].foto, true).then(function() {
		loading = false;
	});
	CambiarMarcadores();
}
	
function CambiarMarcadores(){
	marcadores.forEach( function(valor, indice, array) {
		if(valor.id!='floor'){
			PSV.updateMarker({
				id: valor.id,
				longitude: posiciones[i][indice].longitude,
				latitude: posiciones[i][indice].latitude,
				visible: visibilidades[i][indice]
			});
		}
	});
}
	

	
PSV.on('select-marker', function(marker, click) {
    console.log('marcador', marker.id);
	var foto = marker.id.substring(1, marker.id.length);
	if(marker.id != 'floor')
		cambiarPano(foto);
  });
</script>
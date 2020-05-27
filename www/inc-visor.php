<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Visor Dimensión 360</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php 
include 'inc-conn.php';
$tabla = 'fotos';
$dir_fotos = "/uploads/fotos/";
$dir_fotos_thumbs = "/uploads/fotos/thumbs/";
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
	
$query = "SELECT * FROM fotos WHERE seccion='propiedades' and tipo='360' and id_referencia=".$_GET['id']." ORDER BY orden ASC " ;

$s = $conn->prepare($query);
$s->execute();

while( $row = $s->fetch() ) 
{
	$panos[] = $row['foto'];
	$panos_thumb[] = $row['foto_thumb'];
	$nombres[] = $row['nombre'];
	//$inmobiliaria = $row['nombre'];
}
$stmt2 = $conn->prepare("SELECT * FROM propiedades WHERE id=".$_GET['id']." LIMIT 1");
$stmt2->execute();
while( $prop = $stmt2->fetch() ) 
{
	$stmt3 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$prop['inmobiliaria']." and tipo='logo' LIMIT 1");
	$stmt3->execute();
	while( $imagen = $stmt3->fetch() ) 
	{
		$logo = $imagen["foto"];
	}
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
	foreach ($panos_thumb as $foto) {

	?>
		<div onclick=cambiarPano(<?php echo $numero?>) class="thumb " style="background-image:url(<?php echo $foto; ?>)">
		<?php if(strlen($nombres[$numero])>3){?>
    	<div class="nombre_foto"><span><?php echo $nombres[$numero]; ?><i></i></span></div>
		<?php } ?>
 		</div>
  <?php 
		$numero++;
	}
?>
</div>

<script type="text/javascript">
	$('.thumb:first').addClass('selected');
$(document).ready(function($) {	
	$('.thumb').click(function(event) {
		$('.thumb').removeClass('selected');
		$(this).addClass('selected');
		});
});
	
var folder = '';
var folderThumbs = '';
var panos = <?php echo json_encode($panos); ?>;
var logo = <?php echo json_encode($logo); ?>;
var i = 0;
var viewer = new PhotoSphereViewer({
	panorama: folder+panos[i],
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
		duration: 800, // duration of transition in milliseconds
		loader: false // should display the loader ?
	},
	loading_img: 'https://milugar.com.uy/images/preload.png',
	markers:Marcadores()
});
var marcadores;
var	logo = 'https://milugar.com.uy/images/preload.png';
function Marcadores(){
	marcadores = [];
	var i=0;
	//panos.forEach(function(element) {
		marcadores.push({
			id: '#piso',
			//tooltip: 'inmobiliaria',
			width: 360,
			height: 360,
			visible: true,
			image: 'https://milugar.com.uy/images/piso.png',
			latitude: 4,
			longitude: 0,
			anchor: 'center center',
			scale:[1,4]
		});
		marcadores.push({
			id: '#logo',
			//tooltip: 'inmobiliaria2',
			latitude: 4,
			longitude: 0,
			visible: true,
			image: logo,
			width: 160,
			height: 160,
			anchor: 'center center'
		});
	//})
	return marcadores;
}
var thumb_seleccionado = 1;
function restar(){
	if(i>0 && loading==false) {
		i--;
		$('.thumb:nth-child('+thumb_seleccionado+')').removeClass('selected');
		thumb_seleccionado--;
		$('.thumb:nth-child('+thumb_seleccionado+')').addClass('selected');
		loading = true;
		viewer.setPanorama(folder+panos[i], true).then(function() {
			loading = false;
		});
		
	}
}
function sumar(){
	if(i<panos.length-1 && loading==false) {
		i++;
		$('.thumb:nth-child('+thumb_seleccionado+')').removeClass('selected');
		thumb_seleccionado++;
		$('.thumb:nth-child('+thumb_seleccionado+')').addClass('selected');
		loading = true;
		viewer.setPanorama(folder+panos[i], true).then(function() {
			loading = false;
		});
		
	}
}
var loading = false;
function cambiarPano(fotoActual) {
	i = fotoActual;
	thumb_seleccionado = i+1;
	loading = true;
	viewer.setPanorama(folder+panos[i], true).then(function() {
		loading = false;
	});
}
	
</script>

</body>
</html>
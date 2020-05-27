<!DOCTYPE html>
<html lang="es">
<?php 
	//include '../inc-conn.php';
	$foto = $_GET['foto'];
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Dimension 360 - Tour Virtual</title>
	<script src="../tour/node_modules/three/build/three.js"></script>
	<!--<link rel="stylesheet" href="../tour/dist/photo-sphere-viewer.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->
  <style>
    html, body {
		width: 100%;
		height: 100%;
		overflow: hidden;
		margin: 0;
		padding: 0;
		color: #2babe2;
    }

    #visor {
		width: 100%;
		height: 100%;
		float: left;
		cursor: move;
    }
	
	.psv-button{
		font-size: 22px;
		line-height: 20px;
	}

  </style>
</head>
<body>
<div id="visor"></div>

<!--
<script src="../tour/node_modules/three/build/three.js"></script>
<script src="../tour/node_modules/three/examples/js/renderers/CanvasRenderer.js"></script>
<script src="../tour/node_modules/three/examples/js/renderers/Projector.js"></script>
<script src="../tour/node_modules/three/examples/js/controls/DeviceOrientationControls.js"></script>
<script src="../tour/node_modules/three/examples/js/effects/StereoEffect.js"></script>
<script src="../tour/node_modules/d.js/lib/D.js"></script>
<script src="../tour/node_modules/uevent/uevent.js"></script>
<script src="../tour/node_modules/dot/doT.js"></script>
<script src="../tour/node_modules/nosleep.js/dist/NoSleep.js"></script>
<script src="../tour/dist/photo-sphere-viewer.js"></script>
-->

<script>
	var camera, scene, renderer;
	var isUserInteracting = false,
		onMouseDownMouseX = 0, onMouseDownMouseY = 0,
		lon = 0, onMouseDownLon = 0,
		lat = 0, onMouseDownLat = 0,
		phi = 0, theta = 0;
	init();
	animate();
	function init() {
		var container, mesh;
		container = document.getElementById( 'visor' );
		camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 1, 1100 );
		camera.target = new THREE.Vector3( 0, 0, 0 );
		scene = new THREE.Scene();
		var geometry = new THREE.SphereBufferGeometry( 500, 60, 40 );
		// invert the geometry on the x-axis so that all of the faces point inward
		geometry.scale( - 1, 1, 1 );
		var material = new THREE.MeshBasicMaterial( {
			map: new THREE.TextureLoader().load( '../uploads/fotos/<?php echo $foto; ?>' )
		} );
		mesh = new THREE.Mesh( geometry, material );
		scene.add( mesh );
		renderer = new THREE.WebGLRenderer();
		renderer.setPixelRatio( window.devicePixelRatio );
		renderer.setSize( window.innerWidth, window.innerHeight );
		container.appendChild( renderer.domElement );

		/*
		document.addEventListener( 'mousedown', onPointerStart, false );
		document.addEventListener( 'mousemove', onPointerMove, false );
		document.addEventListener( 'mouseup', onPointerUp, false );
		document.addEventListener( 'wheel', onDocumentMouseWheel, false );
		document.addEventListener( 'touchstart', onPointerStart, false );
		document.addEventListener( 'touchmove', onPointerMove, false );
		document.addEventListener( 'touchend', onPointerUp, false );
		//
		document.addEventListener( 'dragover', function ( event ) {
			event.preventDefault();
			event.dataTransfer.dropEffect = 'copy';
		}, false );
		document.addEventListener( 'dragenter', function () {
			document.body.style.opacity = 0.5;
		}, false );
		document.addEventListener( 'dragleave', function () {
			document.body.style.opacity = 1;
		}, false );
		document.addEventListener( 'drop', function ( event ) {
			event.preventDefault();
			var reader = new FileReader();
			reader.addEventListener( 'load', function ( event ) {
				material.map.image.src = event.target.result;
				material.map.needsUpdate = true;
			}, false );
			reader.readAsDataURL( event.dataTransfer.files[ 0 ] );
			document.body.style.opacity = 1;
		}, false );
		//
		window.addEventListener( 'resize', onWindowResize, false );*/
	}
	/*
	function onWindowResize() {
		camera.aspect = window.innerWidth / window.innerHeight;
		camera.updateProjectionMatrix();
		renderer.setSize( window.innerWidth, window.innerHeight );
	}
	function onPointerStart( event ) {
		isUserInteracting = true;
		var clientX = event.clientX || event.touches[ 0 ].clientX;
		var clientY = event.clientY || event.touches[ 0 ].clientY;
		onMouseDownMouseX = clientX;
		onMouseDownMouseY = clientY;
		onMouseDownLon = lon;
		onMouseDownLat = lat;
	}
	function onPointerMove( event ) {
		if ( isUserInteracting === true ) {
			var clientX = event.clientX || event.touches[ 0 ].clientX;
			var clientY = event.clientY || event.touches[ 0 ].clientY;
			lon = ( onMouseDownMouseX - clientX ) * 0.1 + onMouseDownLon;
			lat = ( clientY - onMouseDownMouseY ) * 0.1 + onMouseDownLat;
		}
	}
	function onPointerUp() {
		isUserInteracting = false;
	}
	function onDocumentMouseWheel( event ) {
		var fov = camera.fov + event.deltaY * 0.05;
		camera.fov = THREE.Math.clamp( fov, 10, 75 );
		camera.updateProjectionMatrix();
	}*/
	function animate() {
		requestAnimationFrame( animate );
		update();
	}
	function update() {
		if ( isUserInteracting === false ) {
			lon += 0.1;
		}
		
		/*console.log("lat > "+lat);
		console.log("phi > "+lat);
		
		lat = Math.max( - 85, Math.min( 85, lat ) );*/
		phi = THREE.Math.degToRad( 90 - lat );
		theta = THREE.Math.degToRad( lon );
		camera.target.x = 500 * Math.sin( phi ) * Math.cos( theta );
		camera.target.y = 500 * Math.cos( phi );
		camera.target.z = 500 * Math.sin( phi ) * Math.sin( theta );
		camera.lookAt( camera.target );
		/*
		// distortion
		camera.position.copy( camera.target ).negate();
		*/
		renderer.render( scene, camera );
	}
	/*
var PSV = new PhotoSphereViewer({
    container: 'visor',
	//touchmove_two_fingers: true,
    panorama: '../uploads/fotos/<?php echo $foto; ?>',
    caption: 'Elije foto portada',
    loading_img: '../../tour/assets/preload.gif',
    anim_speed: '0rpm',
    default_fov: 50,
    fisheye: true,
    move_speed: 1.1,
    time_anim: false,
    navbar: [ 'zoom', 'caption' ]
});
*/
</script>

</body>
</html>

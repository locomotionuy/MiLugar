<script type="text/javascript">
var cX = cX || {}; cX.callQueue = cX.callQueue || [];
cX.callQueue.push(['setSiteId', '1136292848854841359']);
cX.callQueue.push(['sendPageViewEvent']);
</script>
<script type="text/javascript">
(function(d,s,e,t){e=d.createElement(s);e.type='text/java'+s;e.async='async';
e.src='http'+('https:'===location.protocol?'s://s':'://')+'cdn.cxense.com/cx.js';
t=d.getElementsByTagName(s)[0];t.parentNode.insertBefore(e,t);})(document,'script');
</script>
<?php
include "inc/inc-listas.php"; 
include 'inc/inc-ubicaciones.php';
include 'inc/inc-textos.php';
include 'inc/inc-functions.php';
$dir_fotos = "/uploads/fotos/";
$dir_fotos_thumbs = "/uploads/fotos/thumbs/";
$dir_logos = "/uploads/logos/";
$stmt = $conn->prepare("SELECT * FROM configuracion WHERE id=1");
$stmt->execute();
while( $row = $stmt->fetch() ) 
{
	$config_cotizacion = $row['cotizacion'];
	//error_log("config_cotizacion: ".$config_cotizacion);
	// Actualizar fecha y cotización si es un nuevo dia!
	$hoy = date("ymd");
	if($hoy!==$row['fecha'])
	{
		$nueva_cotizacion = convertCurrency("USD", "UYU", 1);
		//error_log("nueva_cotizacion: ".$nueva_cotizacion);
		$sql = "UPDATE configuracion SET fecha='$hoy', cotizacion=$nueva_cotizacion WHERE id=1";
		$conn->exec($sql);
		
		// Consultar nueva cotización
		$stmt2 = $conn->prepare("SELECT * FROM configuracion WHERE id=1");
		$stmt2->execute();
		while( $row2 = $stmt2->fetch() ) 
		{
			$config_cotizacion = $row2['cotizacion'];
			//error_log("config_cotizacion: ".$config_cotizacion);
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $config_titulo ?></title>
<?php $css_update = "?i=005"; ?>
<link href="css/desktop-all.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<style>
</style>
<link href="css/desktop-multiple.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/responsive-all.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/responsive-multiple.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/desktop-results.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/desktop-file.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/desktop-contact.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/desktop-custom-select.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/responsive-results.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/responsive-file.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/responsive-contact.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/responsive-custom-select.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/multiple-select.js<?php echo $css_update ?>"></script>
<?php 
echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">';
echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>' ?>
<?php
$meta_foto = "/images/facebook.jpg?v=".time();
if($mod == 'file')
{
	//echo '<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZhB57BmPmsyKgavcfxBoc6mjw-6q7-To&callback=initMap"></script>';
	include 'inc/inc-social.php'; 	
}
else
{
?>
<meta property="og:url"                content="https://<?php echo $_SERVER['SERVER_NAME']; ?>" />
<meta property="og:type"               content="website" />
<meta property="og:site_name"		   content="<?php echo $meta_site_name ?>"/>
<meta property="og:title"              content="<?php echo $meta_title ?>" />
<meta property="og:description"        content="<?php echo $config_titulo ?> <?php echo  $_SERVER['SERVER_NAME']; ?>" />
<meta property="og:image"              content="<?php echo $meta_foto; ?>" />
<?php 
}
?>
<script type="text/javascript">
$(document).ready(function(){$(".menu-button").click(function(){$("#header .menu").slideToggle("fast")}),$(".btn-adv-active").click(function(){$(".advanced").slideToggle("fast"),$(".arrow").toggleClass("rotate")})});
<?php 
if($mod=="favoritos")
{
?>
$(function(){$(".favorite").click(function(){$(this).parent();var t=$(this).attr("id"),i="favorito_id="+t;return $.ajax({type:"GET",url:"favorites.php",data:i,cache:!1,success:function(){$(".result."+t).hide("fast",function(){$(this).remove()})}}),!1})});
<?php 
} 
else
{
?>
$(function(){$(".favorite").click(function(){$(this).parent();var t=$(this).attr("id"),a="favorito_id="+t;return $.ajax({type:"GET",url:"favorites.php",data:a,cache:!1,success:function(){$("#"+t).toggleClass("saved")}}),!1})});
<?php 
}
?>
function CopiarUrl(){var e=document.createElement("input");e.setAttribute("value",window.location.href),document.body.appendChild(e),e.select(),document.execCommand("copy"),document.body.removeChild(e),alert("Link copiado: "+window.location.href)}
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-154810914-1"></script>
<script>
function gtag(){dataLayer.push(arguments)}window.dataLayer=window.dataLayer||[],gtag("js",new Date),gtag("config","UA-154810914-1");
</script>
<script src="js/platform.js" async defer></script>
</head>
<body>
<div id="header">
  <div class="center">
    <div class="content">
      <div class="header">
        <div class="logo"> <a href="index.php"><img src="images/logo.png<?php echo $css_update ?>" alt="<?php echo $_SERVER['SERVER_NAME'] ?>" /></a>
          <div class="menu-button"> <i class="fas fa-bars"></i> </div>
        </div>
        <ul class="menu">
          <?php 
	  foreach ($menu_header as $links_header)
	  {
		  if($links_header[0]==1) echo '<li class="text">'; else echo '<li>';
		  echo '<a href="'.$links_header[1].'" ';
		  if($links_header[2]==0) echo '>'; else echo 'target="_blank">';
//		  if($links_header[3]!==0) echo '<i class="'.$links_header[3].' fa-fw"></i>';
		  echo $links_header[4].'</a></li>';
	  }
	  ?>
        </ul>
      </div>
    </div>
  </div>
</div>

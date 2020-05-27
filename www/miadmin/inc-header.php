<?php
//echo 'user: '.$_SESSION['usuario'];
if(!isset($_SESSION['usuario']))
{
	header("location:login.php");
}
else
{
	$usuario_usuario = $_SESSION['usuario'];
	$usuario_id = $_SESSION['usuario_id'];
	$usuario_permisos = $_SESSION['usuario_permisos'];
	$usuario_nombre = $_SESSION['usuario_nombre'];
	if(isset($_SESSION['dimension'])) $dimension = $_SESSION['dimension'];
	//$milugar = $_SESSION['milugar'];
	$milugar = '1';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MiAdmin</title>

<?php $css_update = "?i=0127"; ?>
<link href="css/desktop-all.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/desktop-upload.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/desktop-results.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/desktop-messages.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/desktop-schedule.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/desktop-select.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/desktop-multiple.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />

<link href="css/mobile-all.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/mobile-upload.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/mobile-results.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/mobile-messages.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/mobile-schedule.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />
<link href="css/mobile-multiple.css<?php echo $css_update ?>" rel="stylesheet" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">'
 ?>
<script type="text/javascript">
// Menu mobile
$(document).ready(function() {
    $('.menu-button').click(function(){
        $('#menu').slideToggle('fast');
    });;
});
function goBack() {
    window.history.back();
}
$(document).ready(function()
{
	$(".list-borrar").click(function(){
		$(".confirmation-window").show();
		var id = $(this).attr("id");
		$(".si").attr("href", "<?php echo $_SERVER['PHP_SELF'] ?>?delete="+id)
	});
	$(".no").click(function(){
		$(".confirmation-window").hide();
	});
	$(".cancelar").click(function(){
		var id = $(this).attr("id");
		$("#wrap"+id).css("margin-bottom", "30px");
		$(".arrow"+id).fadeOut();
		$("#form"+id).slideUp(500, function() {
			$("#message-buttons"+id).fadeIn();
  		});
	});
});
</script>
<?php 
include "../inc/inc-listas.php";
include "../inc/inc-functions.php";
include "../inc/inc-ubicaciones.php";
?>
</head>

<body>
<div class="confirmation-window">
  <div class="titulo">Ventana de confirmación</div>
  <div class="evento"><i class="fas fa-exclamation-triangle"></i>¿Está seguro que desea eliminar?</div>
  <a href="javascript:void(0)" class="no">No</a><a href="" class="si">Si</a>
</div>
<div id="header">
  <div class="center">
    <div class="content">
      <div class="logo"><a href="index.php"><img src="images/admin360.png<?php echo $css_update ?>" alt="<?php echo $_SERVER['SERVER_NAME'] ?>" /></a></div>
      <div class="menu-button"> <i class="fas fa-bars"></i> </div>
      <ul class="user">
        <li><a href="usuarios-edit.php"><i class="fas fa-user-cog"></i> </a>
            <?php 
			$stmt = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=$usuario_id and tipo='logo' LIMIT 1 "); 
			$stmt->execute();
			while( $row = $stmt->fetch() ) 
			{
				echo '<div class="realstatelogo" style="background-image: url(https://dimension360.com.uy/uploads/logos/'.$row["foto"].')"></div>';
			}			
			?>
        <a href="usuarios-edit.php"><?php echo $usuario_nombre; ?></a></li>
        <li><a href="login.php?logout=1"><i class="fas fa-sign-out-alt"></i> Salir</a></li>
      </ul>
    </div>
  </div>
</div>
<div id="menu">
  <div class="center">
    <div class="content">
      <ul >
        <li><a href="index.php" <?php if($mod=='home') echo 'class="selected"'; ?>><i class="fas fa-home fa-fw"></i> Inicio</a></li>
        <li><a href="propiedades.php" <?php if($mod=='Propiedades') echo 'class="selected"'; ?>><i class="fas fa-building fa-fw"></i> Propiedades</a>
          <ul >
          <span></span>
            <li><a href="propiedades-upload.php"><i class="fas fa-file-upload fa-fw"></i> Nueva</a></li>
            <li><a href="propiedades.php"><i class="fas fa-list-ul fa-fw"></i> Mis propiedades</a></li>
          </ul>
        </li>
        <li><a href="mensajes.php" <?php if($mod=='Mensajes') echo 'class="selected"'; ?>><i class="fas fa-comments fa-fw"></i> Mensajes</a>
        
          <ul>
          <span></span>
            <li><a href="mensajes.php"><i class="fas fa-envelope"></i> Usuarios no registrados</a></li>
            <li><a href="consultas.php"><i class="fas fa-user-circle"></i> Usuarios registrados</a></li>
          </ul>
        
        
        </li>
        <?php /*?><li><a href="consultas.php" <?php if($mod=='Consultas') echo 'class="selected"'; ?>><i class="fas fa-comments fa-fw"></i> Consultas)</a></li><?php */?>
        <li><a href="soporte.php" <?php if($mod=='Soporte') echo 'class="selected"'; ?>><i class="fas fa-tools fa-fw"></i>Soporte (<?php
		
		$sql = "SELECT count(*) FROM soporte WHERE inmobiliaria='$usuario_id' and estado='Respondido'"; 
		$result = $conn->prepare($sql);
		$result->execute();
		$number_of_rows = $result->fetchColumn();
		echo $number_of_rows;
		
	   ?>)</a>
          <ul>
          <span></span>
            <li><a href="soporte-upload.php"><i class="fas fa-file-upload fa-fw"></i> Nuevo</a></li>
            <li><a href="soporte.php"><i class="fas fa-list-ul fa-fw"></i> Tickets</a></li>
          </ul>
        </li>
<?php /*?>        <li><a href="agenda.php" <?php if($mod=='Agenda') echo 'class="selected"'; ?>><i class="far fa-calendar-alt fa-fw"></i>Agenda</a></li>
<?php */?>        <li><a href="usuarios-edit.php" <?php if($mod=='Usuarios') echo 'class="selected"'; ?>><i class="fas fa-user-cog fa-cog"></i> Mi Cuenta</a></li>
        <li><a href="login.php"><i class="fas fa-sign-out-alt fa-fw"></i> Salir</a></li>
      </ul>
    </div>
  </div>
</div>
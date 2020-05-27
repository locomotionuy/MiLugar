<?php
session_start();
include '../inc-conn.php';
  
$mod = 'home';
include 'inc-header.php';
?>
<div class="body">
  <div class="center">
    <div class="content">
        <ul class="titulo-secciones">
          <li><a href="index.php">Principal</a></li>
          <li class="back"><a href="javascript:goBack()"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
        </ul>
        <div id="home">
<?php /*?>        <div class="banner"> <a href="propiedades.php">
        <img src="images/banner01.gif" width="100%" height="auto" alt="Banner" class="desktop" />
        <img src="images/banner_mobile_01.gif" width="100%" height="auto" class="mobile" />
        </a>
          </div><?php */?>
<div class="tile-large" onclick="location.href='propiedades-fast-upload.php'">
            <div class="titulo"><strong>Publicación Rápida </strong></div>
            <i class="fas fa-file-upload fa-fw"></i>
            <div class="info">Formulario con los datos básicos paso a paso</div>
          </div>
          <div class="tile blue tile_margin_right" onclick="location.href='propiedades-upload.php'">
            <div class="titulo">Publicación completa</div>
            <i class="fas fa-file-upload fa-fw"></i>
            <div class="info">Formulario completo para subir propiedades</div>
          </div>
          <div class="tile grey" onclick="location.href='usuarios-edit.php">
            <div class="titulo">Mi Cuenta</div>
            <i class="fas fa-user-cog"></i>
            <div class="info">Configuración</div>
          </div>
          <div class="tile cian" onclick="location.href='mensajes.php'">
            <div class="titulo">Mensajes</div>
            <i class="fas fa-comments fa-fw"></i>
            <div class="info">Mensajes de interesados</div>
          <?php
		  $sql = "SELECT count(*) FROM mensajes WHERE leido=0 and inmobiliaria=$usuario_id"; 
		  $result = $conn->prepare($sql); 
		  $result->execute(); 
		  $number_of_rows = $result->fetchColumn(); 
		  
		  if($number_of_rows>0)
		  {
		  	echo '<div class="cantidad">'.$number_of_rows.'</div>';
		  }
		  else
		  {
		  	echo '<div class="cantidad off">0</div>';  
		  }
		  ?>
          
          </div>
          <div class="tile green" onclick="location.href='tickets.php'">
            <div class="titulo">Tickets</div>
            <i class="fas fa-tools fa-fw"></i>
            <div class="info">Soporte técnico</div>
          </div>
        </div>
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>
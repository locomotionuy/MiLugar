<?php 
include 'inc-conn.php';

$mod = 'contacto';
include 'inc-header.php';
?>

<div class="body">
  <div id="secciones">
    <div class="nombre_seccion">
      <div class="center">
        <div class="content">Contacto</div>
      </div>
    </div>
    <div class="center">
      <div class="content">
        <?php include 'inc-contacto.php'; ?>
      </div>
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>

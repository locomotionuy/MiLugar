<?php 
include 'inc-conn.php';
  
$mod = 'login';
include 'inc-header.php';
?>
<div id="login">
  <div class="bg"></div>
  <div class="center">
    <div class="titulo">
      <i class="far fa-user-circle"></i>
      <div class="text">Login</div>
    </div>
    <div class="form">
      <form action="" method="get">
        <fieldset>
          <label>Email:</label>
          <input name="" type="text" />
        </fieldset>
        <fieldset>
          <input name="" type="submit" value="Recuperar contraseña" />
        </fieldset>
        <div class="recuperar"><a href="login.php">Volver</a></div>
      </form>
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>

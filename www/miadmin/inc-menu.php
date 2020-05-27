<ul id="menu">
  <li>
	<?php 
    $stmt2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=$usuario_id and tipo='logo'"); 
    $stmt2->execute();
    while( $row = $stmt2->fetch() ) 
    {
        echo '<div class="realstatelogo mobile" style="background-image: url(../uploads/logos/'.$row["foto"].')"></div>';
    }			
    ?>
    <div class="titulo"><i class="fas fa-bars fa-fw "></i> Panel de administración:</div>
    <div class="cliente">¡Bienvenida/o <?php echo $usuario_nombre; ?>!</div>
  </li>
  <li><a href="index.php"><i class="fas fa-home fa-fw"></i> Inicio</a></li>
  <li><a href="propiedades.php"><i class="fas fa-list-ul fa-fw"></i> Propiedades</a></li>
  <li><a href="mensajes.php"><i class="fas fa-comments fa-fw"></i> Mensajes</a></li>
  <li><a href="agenda.php"><i class="far fa-calendar-alt fa-fw"></i>Agenda</a></li>
  <li><a href="usuarios-edit.php"><i class="fas fa-user-cog fa-cog"></i> Mi Cuenta</a></li>
  <li><a href="tickets.php"><i class="far fa-envelope fa-fw"></i>Tickets de Soporte</a></li>
  <li class="mobile"><a href="login.php"><i class="fas fa-sign-out-alt fa-fw"></i> Salir</a></li>
</ul>

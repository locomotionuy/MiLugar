
 <div id="head" <?php if ($mod=='home') echo 'class="home"';?>>
  <div class="center">
    <div class="content">
      <div class="logo" onclick="location.href='index.php'">
        <div class="text"><strong>Dimensión</strong>360</div>
        <div class="icono"><img src="imagenes/icono.png" srcset="imagenes/icono.svg" /></div>
      </div>
      <div class="btn_menu mobile"><i class="fa fa-bars fa-fw"></i><i class="fa fa-times-circle fa-fw"></i><span class="arrow"></span></div>
      <form action="results.php" method="get">
        <select name="direccion[]" id="ubicacionMenu" tabindex="3" multiple="multiple" class="ubicacion" >
         <?php 
		$consultaDeptos = mysql_query("SELECT * FROM departamentos ORDER BY id DESC");
		while($row=mysql_fetch_array ($consultaDeptos)){
			$idDepartamento = $row['id'];
			$nombreDepartamento = $row['nombre'];
			$consultaBarrios = mysql_query("SELECT * FROM barrios WHERE idDepartamento='$idDepartamento' ORDER BY id DESC");
			while($row=mysql_fetch_array ($consultaBarrios)){
				$idBarrio = $row['id'];
				$nombreBarrio = $row['nombre'];
				echo '<option>'.$nombreDepartamento.', '.$nombreBarrio.'</option>';
			}
		}

		?>
        </select>
        <button class="submit"><i class="fas fa-search"></i></button>
      </form>
      <div class="menu">
        <ul>
         <li><a href="admin360/"><i class="fas fa-user-circle fa-fw"></i>Ingresar</a></li>
          <li class="text"><a href="https://www.gallito.com.uy/inmuebles" target="_blank"><i class="fa fa-sign-out-alt fa-fw"></i>Volver a Gallito</a></li>
          <li><a href="contact.php"><i class="fa fa-paper-plane fa-fw"></i>Contacto</a></li>
          <li><a href="favorites.php"><i class="fa fa-heart fa-fw"></i>Favoritos</a></li>
          <li><a href="index.php"><i class="fa fa-home fa-fw"></i>Inicio</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<script>
$(function(){
	$("#ubicacionMenu").multipleSelect({
	filter: true,
	width: "90%",
	selectAll: false,
	placeholder: "Departamento, Barrio o Ciudad "
	});
});
</script>
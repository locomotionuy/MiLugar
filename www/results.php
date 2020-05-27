<?php 
include 'inc-conn.php';

$mod = 'results';
include 'inc-header.php';
?>
<script>
$(function(){$("#operativa").multipleSelect({filter:!1,width:"100%",selectAll:!1,single:!0})}),$(function(){$("#tipo").multipleSelect({filter:!1,width:"100%",selectAll:!1,placeholder:"Tipo de propiedad"})}),$(function(){$("#ubicacion").multipleSelect({filter:!0,width:"100%",selectAll:!1,placeholder:"Departamento, Barrio o Ciudad"})}),$(function(){$("#estado").multipleSelect({filter:!1,width:"100%",selectAll:!1,placeholder:"Estado"})}),$(function(){$("#dormitorios").multipleSelect({placeholder:"Dormitorios",filter:!1,width:"100%",selectAll:!1,single:!0})}),$(function(){$("#banios").multipleSelect({filter:!1,width:"100%",selectAll:!1,single:!0,placeholder:"Baños"})}),$(function(){$("#moneda").multipleSelect({filter:!1,width:"100%",selectAll:!1,single:!0})}),$(function(){$("#sup_construida").multipleSelect({filter:!1,width:"100%",selectAll:!1,single:!0,placeholder:"Sup construida"})}),$(function(){$("#sup_total").multipleSelect({filter:!1,width:"100%",selectAll:!1,single:!0,placeholder:"Sup total"})}),$(function(){$("#orientacion").multipleSelect({filter:!1,width:"100%",selectAll:!1,placeholder:"Orientacion"})}),$(function(){$("#garantia").multipleSelect({filter:!1,width:"100%",selectAll:!1,single:!0,placeholder:"Garantía"})});
</script>

<div id="search">
  <div class="loader"></div>
  <div class="formulario">
  <form action="results.php" class="buscador-avanzado" method="get" enctype="multipart/form-data" id="adv_form">
    <fieldset class="blur">
      <div class="center">
        <div class="content">
          <div class="operativa">
            <select name="operacion" id="operativa" multiple="multiple">
              <?php 
            foreach ($lista_operaciones as $lista_operacion)
            {
                echo '<option value="'.$lista_operacion[0].'"';
                if(isset($_GET['operacion']) and $lista_operacion[0]==$_GET['operacion']) echo 'selected="selected"';
				if(!isset($_GET['operacion']) and $lista_operacion[3]==1) echo 'selected="selected"';
                echo '>'.$lista_operacion[1].'</option>'; 
            }
            ?>
            </select>
          </div>
          <div class="tipo">
            <select name="tipo[]" id="tipo" multiple="multiple">
              <?php 
				foreach ($lista_inmuebles as $lista_inmueble)
				{
					echo '<option value="'.$lista_inmueble[0].'"';
					
					if(isset($_GET['tipo']))
					{
						foreach ($_GET["tipo"] as $var_tipo)
						{
							if($lista_inmueble[0]==$var_tipo) echo 'selected="selected"';
						}
					}
					
					if(!isset($_GET['tipo']) and $lista_inmueble[3]==1) echo 'selected="selected"';
					echo '>'.$lista_inmueble[1].'</option>'; 
				}
			    ?>
            </select>
          </div>
          <div class="fix_mobile">
            <div class="ubicacion shadow">
              <select name="ubicacion[]" id="ubicacion" multiple="multiple">
                <?php 
				foreach ($lista_ubicaciones as $lista_ubicacion)
				{
					echo '<option ';
					if(isset($_GET["ubicacion"])) 
					{
						foreach ($_GET["ubicacion"] as $var_ubicacion)
						{
							if(isset($_GET['ubicacion']) and $lista_ubicacion[0].", ".$lista_ubicacion[1]==$var_ubicacion) echo 'selected="selected"';
						}
					}
					else
					{
						if(isset($_GET['ubicacion']) and $lista_ubicacion[0].", ".$lista_ubicacion[1]."_".$i==$_GET['ubicacion'][$i]) echo 'selected="selected"';
						
					}
					echo '>'.$lista_ubicacion[0].", ".$lista_ubicacion[1].'</option>'; 
				}
				?>
              </select>
            </div>
          </div>
        </div>
      </div>
    </fieldset>
    <fieldset class="advanced">
      <div class="center">
        <div class="content">
          <div class="set w25">
            <div class="wrap">
              <select name="dormitorios" id="dormitorios"  multiple="multiple">
                <option <?php if(isset($_GET['dormitorios']) and $_GET['dormitorios']==0) echo 'selected="selected"'; ?> value="0">Monoambiente</option>
                <option <?php if(isset($_GET['dormitorios']) and $_GET['dormitorios']==1) echo 'selected="selected"'; ?>>1</option>
                <option <?php if(isset($_GET['dormitorios']) and $_GET['dormitorios']==2) echo 'selected="selected"'; ?>>2</option>
                <option <?php if(isset($_GET['dormitorios']) and $_GET['dormitorios']==3) echo 'selected="selected"'; ?>>3</option>
                <option <?php if(isset($_GET['dormitorios']) and $_GET['dormitorios']==4) echo 'selected="selected"'; ?>>4</option>
                <option <?php if(isset($_GET['dormitorios']) and $_GET['dormitorios']==5) echo 'selected="selected"'; ?>>5 o más</option>
              </select>
            </div>
          </div>
          <div class="set w25">
            <div class="wrap">
              <select name="banios" id="banios" multiple="multiple">
                <option <?php if(isset($_GET['banios']) and $_GET['banios']==1) echo 'selected="selected"'; ?>>1</option>
                <option <?php if(isset($_GET['banios']) and $_GET['banios']==2) echo 'selected="selected"'; ?>>2</option>
                <option <?php if(isset($_GET['banios']) and $_GET['banios']==3) echo 'selected="selected"'; ?>>3 o más</option>
              </select>
            </div>
          </div>
          <div class="fix_precios">
            <div class="set w20">
              <div class="wrap">
                <select name="moneda" id="moneda" multiple="multiple">
                  <option <?php if(isset($_GET['moneda']) and $_GET['moneda']=="UYU") echo 'selected="selected"';?> value="UYU">$</option>
                  <option <?php if(isset($_GET['moneda']) and $_GET['moneda']=="USD") echo 'selected="selected"'; if(!isset($_GET['moneda'])) echo 'selected="selected"';?> value="USD">U$S</option>
                </select>
              </div>
            </div>
            <div class="set w40">
              <div class="wrap">
                <input name="precio_min" type="number" placeholder="Precio Mín" value="<?php if(isset($_GET['precio_min']) && $_GET['precio_min']!='') echo $_GET['precio_min'];?>" />
              </div>
            </div>
            <div class="set w40 fix_corner">
              <div class="wrap">
                <input name="precio_max" type="number" placeholder="Precio Máx" value="<?php if(isset($_GET['precio_max']) && $_GET['precio_max']!='') echo $_GET['precio_max'];?>" />
              </div>
            </div>
          </div>
          <div class="set w25">
            <div class="wrap">
              <select name="estado[]" id="estado" multiple="multiple">
                <?php 
				foreach ($lista_estados as $lista_estado)
				{
					echo '<option ';
					if(isset($_GET["estado"])) 
					{
						foreach ($_GET["estado"] as $var_estado)
						{
							if(isset($_GET['estado']) and $lista_estado[0]==$var_estado) echo 'selected="selected"';
						}
					}
					else
					{
						if(isset($_GET['estado']) and $lista_estado[0]."_".$i==$_GET['estado'][$i]) echo 'selected="selected"';
					}
					echo '>'.$lista_estado[1].'</option>'; 
				}
				?>
              </select>
            </div>
          </div>
          <div class="set w25">
            <div class="wrap">
              <select name="sup_construida" id="sup_construida" multiple="multiple">
                <?php 
				foreach ($lista_sup_construida as $lista_sup_cons)
				{
					echo '<option value="'.$lista_sup_cons[0].'"';
					if(isset($_GET['sup_construida']) and $lista_sup_cons[0]==$_GET['sup_construida']) echo 'selected="selected"';
					echo '>'.$lista_sup_cons[1].'</option>'; 
				}
			    ?>
              </select>
            </div>
          </div>
          <div class="set w25">
            <div class="wrap">
              <select name="sup_total" id="sup_total" multiple="multiple">
                <?php 
				foreach ($lista_sup_total as $lista_sup_tot)
				{
					echo '<option value="'.$lista_sup_tot[0].'"';
					if(isset($_GET['sup_total']) and $lista_sup_tot[0]==$_GET['sup_total']) echo 'selected="selected"';
					echo '>'.$lista_sup_tot[1].'</option>'; 
				}
			    ?>
              </select>
            </div>
          </div>
          <div class="set w25 fix">
            <div class="wrap check">
              <h2>Garage:</h2>
              <div class="checkbox">
                <input type="checkbox" name="garage" <?php if(isset($_GET['garage']) and $_GET['garage']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </div>
          </div>
          <div class="set w25 fix">
            <div class="wrap check">
              <h2>Amueblado:</h2>
              <div class="checkbox">
                <input type="checkbox" name="amueblado" <?php if(isset($_GET['amueblado']) and $_GET['amueblado']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </div>
          </div>
          <div class="set w25 fix">
            <div class="wrap check">
              <h2>Jardín:</h2>
              <div class="checkbox">
                <input type="checkbox" name="jardin" <?php if(isset($_GET['jardin']) and $_GET['jardin']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </div>
          </div>
          <div class="set w25 fix">
            <div class="wrap check">
              <h2>Parrillero:</h2>
              <div class="checkbox">
                <input type="checkbox" name="parrillero" <?php if(isset($_GET['parrillero']) and $_GET['parrillero']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </div>
          </div>
          <div class="set w25 fix">
            <div class="wrap check">
              <h2>Barrio Privado:</h2>
              <div class="checkbox">
                <input type="checkbox" name="barrio_privado" <?php if(isset($_GET['barrio_privado']) and $_GET['barrio_privado']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </div>
          </div>
        </div>
      </div>
    </fieldset>
    <div class="center">
      <div class="btn-adv">
        <?php /*?><span class="btn-adv-active">Desplegar más filtros<i class="fas fa-angle-down arrow"></i></span><?php */?>
        <button class="submit">Buscar</button>
      </div>
    </div>
    </div>
    <input name="buscar" type="hidden" value="1" />
  </form>
</div>
</div>
</div>
<div class="body">
  <div class="center" id="inmobiliaria">
    <?php
if(isset($_GET['inmobiliaria'])) {
?>
    <div class="content">
      <div class="results-info">
        <div class="inmobiliaria">
          <?php 
		$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id=".$_GET['inmobiliaria']." LIMIT 1");
		$stmt->execute();
		while( $row = $stmt->fetch())
		{
			$email = $row["email"];
			$mapa = $row["mapa"];
			$nombre_inmo = $row["nombre"];
			$info_direccion = $row["direccion"];
			$info_telefono = $row["telefono"];
			if($row["telefono"] && $row["celular"]) $info_telefono .= ' / ';
			$info_telefono .= $row["celular"];
			?>
          <div class="info-title"><?php echo $nombre_inmo; ?></div>
          <i class="fas fa-phone"></i>
          <div class="info-phone"><?php echo $info_telefono ?></div>
          <?php 
		}
?>
        </div>
      </div>
    </div>
    <?php 
}
?>
  </div>
  <div id="results">
    <div class="center">
      <div class="content">
        <?php include "inc-results.php"; ?>
      </div>
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>

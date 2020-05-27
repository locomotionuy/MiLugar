<?php 
include 'inc-conn.php';

$mod = 'contact';
include 'inc-header.php';

if(isset($_GET["enviado"]))
{	
	$email = stripslashes($_GET["email"]);
	$nombre = stripslashes($_GET["nombre"]);
	$apellido = stripslashes($_GET["apellido"]);
	$nacimiento = stripslashes($_GET["nacimiento"]);
	$departamento = stripslashes($_GET["departamento"]);
	$telefono = stripslashes($_GET["telefono"]);
	$contrasena = $_GET["contrasena"];
	$repetir_contrasena = $_GET["repetir_contrasena"];
	$nuevos_ingresos = stripslashes($_GET["nuevos_ingresos"]);
	$nuevos_ingresos_busquedas = stripslashes($_GET["nuevos_ingresos_busquedas"]);
	$novedades = stripslashes($_GET["novedades"]);
	$estado_favoritos = stripslashes($_GET["estado_favoritos"]);

	$recaptcha = $_GET["g-recaptcha-response"];
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$data = array(
		'secret' => '6LfcH7AUAAAAAHQHLQkLkgLu2gNVnep0hSADPomm',
		'response' => $recaptcha
	);
	$options = array(
		'http' => array (
			'method' => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success = json_decode($verify);
 
	if ($captcha_success->success)
	{
		// Verificar usuario:
		if (!preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $email)) 
		{ 
			$mensaje_email = $texto_falan_datos_email;
		}
		else
		{
			$yaexiste = false;
			$stmt = $conn->prepare("SELECT * FROM clientes WHERE email='$email' ");
			$stmt->execute();
			while( $datos = $stmt->fetch() ) 
			{
				$yaexiste = true;
			}
			if( $yaexiste == true )	
			{
				$mensaje_email = "El email ya esta registrado.";
			}
		}
		
		// Verificar Password
		if($_GET['password'][0]==$_GET['password'][1] and $_GET['password'][0]!=="")
		{
			$password = sha1($_GET['password'][0]);
			$msj_pass = $password;
		}
		else
		{
			$mensaje_contrasena = "Contraseña y Repetir Contraseña no son iguales";
			$error = 1;
		}
		if(strlen($_GET['password'][0]) < 11)
		{
			$mensaje_contrasena = "La Contraseña debe tener más de 10 caracteres";
			$error = 1;
		}
		
		// Verificar:
		if (!$nombre) { $mensaje_nombre = $texto_falan_datos; }
		if (!$apellido) { $mensaje_apellido = $texto_falan_datos; }
		if (!$nacimiento) { $mensaje_nacimiento = $texto_falan_datos; }
		if (!$departamento) { $mensaje_departamento = $texto_falan_datos; }
		if (!$telefono) { $mensaje_telefono = $texto_falan_datos; }
		if (!$nuevos_ingresos) { $mensaje_nuevos_ingresos = $texto_falan_datos; }
		if (!$nuevos_ingresos_busquedas) { $mensaje_nuevos_ingresos_busquedas = $texto_falan_datos; }
		if (!$novedades) { $mensaje_novedades = $texto_falan_datos; }
		if (!$estado_favoritos) { $mensaje_estado_favoritos = $texto_falan_datos; }

		if(empty($mensaje_email) and empty($mensaje_nombre) and empty($mensaje_apellido) and empty($mensaje_nacimiento) and empty($mensaje_departamento) and empty($mensaje_telefono) and empty($mensaje_contrasena))
		{
			try 
			{
				$sql = "INSERT INTO clientes 
				(
				email,
				nombre,
				apellido,
				nacimiento,
				departamento,
				telefono,
				nuevos_ingresos,
				nuevos_ingresos_busquedas,
				novedades,
				estado_favoritos,
				tipo,
				pass
				) 
				values 
				(
				'$email',
				'$nombre',
				'$apellido',
				'$nacimiento',
				'$departamento',
				'$telefono',
				'$nuevos_ingresos',
				'$nuevos_ingresos_busquedas',
				'$novedades',
				'$estado_favoritos',
				'usuario',
				'".$_GET['password']."'
				)";
				
				$conn->exec($sql);
				$subido_db = 1;
				
				if(isset($enviado)) 
				{
					$mymail = $email;
					$Subject = "Confirmación de registro de cuenta MiLugar" ;
					$subject = "=?ISO-8859-1?B?".base64_encode($Subject)."=?=";
					$contenido = '
<img src="inc/https|//milugar.com.uy/images/logo.png?i=11" alt="MiLugar" /><br />
<br />
<strong>Confirmación de registro de cuenta</strong><br />
Gracias por crear una nueva cuenta para acceder a MiLugar.<br />
Para entrar a tu cuenta en mi lugar deberás verificar la dirección de correo electrónico haciendo clic en le link de abajo.
';
					$header = "From:".$email."\nReply-To:".$email."\n";
					$header .= "X-Mailer:PHP/".phpversion()."\n";
					$header .= "Mime-Version: 1.0\n";
					$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						
					if (mail($config_email, $subject, utf8_decode($contenido) ,$header))
					{
						$nombre = "";
						$email = "";
						$asunto = "";
						$mensaje = "";
						$enviado = 1;
					}
					else
					{
						$error = 1;
					}
				}
			}
			catch(PDOException $e)
			{
				$error [0]= $sql . "<br>" . $e->getMessage();
			}
		}	
	} 
	else 
	{
		$error = 1;
		$texto_mensaje_error = "Captcha incorrecto";
	}
}
?>
<div class="body">
  <div class="title"><div class="center"><div class="content">Registro de usuario</div></div></div>
  <div id="contacto">
    <div class="center">
      <div class="registro">
        <div class="content">
          <?php if(isset($enviado)) { ?>
          <div class="enviado">
            <i class="far fa-envelope"></i><br /><br />
            Gracias por registrarte.<br />
            <br />
            <strong>Te hemos enviado un correo electrónico <br />
            para verificar tu cuenta, haciendo clic en el link <br />
            podrás habilitarla para poder acceder.</strong>
          </div>
          <?php } else if (isset($error)) { ?>
          <div class="error">
         	<?php echo $texto_mensaje_error ?>
          </div>
          <?php } else { ?>
          <div class="descripcion">
          <div class="des_registro">
          <img src="images/registro.jpg" alt="Milugar" />
          Recibí novedades de <strong>Mi Lugar</strong>, guarda y recibí notificaciones de tus preferencias de búsqueda o cambios de estado en tus propiedades favoritas.
          </div>
           </div>
          <form action="registro.php" method="get">
            <input name="enviado" type="hidden" value="1" />
            <div class="notificaciones">
              <div class="label">El Email es obligatorio, va a ser tu usuario para entrar)</div>
              <label> Email:</span> </label>
              <input name="email" type="text" value="<?php if(isset($email)) echo $email ?>" />
              <?php if(isset($mensaje_email) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_email.'</div>'; } ?>
            </div>
            <div class="notificaciones">
              <div class="label">Datos personales</div>
              <label> Nombre:</span></label>
              <?php if(isset($mensaje_nombre) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_nombre.'</div>'; } ?>
              <input name="nombre" type="text" value="<?php if(isset($nombre)) echo $nombre ?>" />
              <label> Apellido:</label>
              <?php if(isset($mensaje_apellido) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_apellido.'</div>'; } ?>
              <input name="apellido" type="text" value="<?php if(isset($apellido)) echo $apellido ?>" />
              <label> Fecha de nacimiento:</label>
              <?php if(isset($mensaje_nacimiento) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_nacimiento.'</div>'; } ?>
              <input name="nacimiento" type="text" value="<?php if(isset($nacimiento)) echo $nacimiento ?>" />
              <label> Departamento de residencia:</label>
              <?php if(isset($mensaje_departamento) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_departamento.'</div>'; } ?>
              <input name="departamento" type="text" value="<?php if(isset($departamento)) echo $departamento ?>" />
              <label> Teléfono:</label>
              <?php if(isset($mensaje_telefono) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_telefono.'</div>'; } ?>
              <input name="telefono" type="text" value="<?php if(isset($telefono)) echo $telefono ?>" />
            </div>
            <div class="notificaciones">
              <div class="label">Ingresa tu contraseña 2 veces:</div>
              <label> Contraseña </label>
              <?php if(isset($mensaje_contrasena) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_contrasena.'</div>'; } ?>
              <input name="password[]" type="password" value="<?php if(isset($contrasena)) echo $contrasena ?>" />
              <label> Repetir Contraseña </label>
              <?php if(isset($mensaje_repetir_contrasena) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_repetir_contrasena.'</div>'; } ?>
              <input name="password[]" type="password" value="<?php if(isset($repetir_contrasena)) echo $repetir_contrasena ?>" />
            </div>
            <div class="notificaciones">
              <div class="label">Notificaciones:</div>
              <div class="notificacion">Nuevos ingresos <?php if(isset($mensaje_nuevos_ingresos) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_nuevos_ingresos.'</div>'; } ?></div>
              <div class="checkbox fix">
                <input type="checkbox" name="nuevos_ingresos" <?php if(isset($_GET['nuevos_ingresos']) and $_GET['nuevos_ingresos']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
              <div class="notificacion">Nuevos ingresos busquedas <?php if(isset($mensaje_nuevos_ingresos_busquedas) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_nuevos_ingresos_busquedas.'</div>'; } ?></div>
              <div class="checkbox">
                <input type="checkbox" name="nuevos_ingresos_busquedas" <?php if(isset($_GET['nuevos_ingresos_busquedas']) and $_GET['nuevos_ingresos_busquedas']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
              <div class="separado"></div>
              <div class="notificacion">Novedades <?php if(isset($mensaje_novedades) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_novedades.'</div>'; } ?></div>
              <div class="checkbox fix">
                <input type="checkbox" name="novedades" <?php if(isset($_GET['novedades']) and $_GET['novedades']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
              <div class="notificacion">Estado favoritos <?php if(isset($mensaje_estado_favoritos) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_estado_favoritos.'</div>'; } ?></div>
              <div class="checkbox">
                <input type="checkbox" name="estado_favoritos" <?php if(isset($_GET['estado_favoritos']) and $_GET['estado_favoritos']==1) { echo 'checked="checked"'; }?> value="1">
                <span class="checkmark"> <span class="circle"></span> </span> </div>
            </div>
            <div class="g-recaptcha" data-sitekey="6LfcH7AUAAAAAGE_r6EMvOSei9FDXf3w5E-Mq2pZ" style="width:100%; height: 100px; overflow:hidden; float:left;"></div>
            <input name="Enviar" type="submit" value="Crear cuenta" />
          </form>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>

<?php 
include 'inc-conn.php';

$mod = 'contact';
include 'inc-header.php';

if(isset($_GET["enviado"]))
{	
	$nombre = stripslashes($_GET["nombre"]);
	$nombre=  utf8_encode($nombre);
	$email = stripslashes($_GET["email"]);
	$asunto = stripslashes($_GET["asunto"]);
	$mensaje = stripslashes($_GET["mensaje"]);

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
		if (!$nombre) { $mensaje_nombre = $texto_falan_datos; }
		if (!preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $email)) { $mensaje_email = $texto_falan_datos_email;  }
		if (!$asunto) { $mensaje_asunto = $texto_falan_datos; }
		if (!$mensaje) { $mensaje_mensaje = $texto_falan_datos; }
		
		if(empty($mensaje_nombre) and empty($mensaje_email) and empty($mensaje_asunto) and empty($mensaje_mensaje))
		{
		$mymail = $config_email;
		$Subject = $texto_mensaje_asunto ;
		$subject = "=?ISO-8859-1?B?".base64_encode($Subject)."=?=";
		$contenido = $texto_cuerpo_nombre.$nombre.$texto_cuerpo_email.$email.$texto_cuerpo_asunto .$asunto.$texto_cuerpo_mensaje.$mensaje;
		$header = "From:".$email."\nReply-To:".$email."\n";
		$header .= "X-Mailer:PHP/".phpversion()."\n";
		$header .= "Mime-Version: 1.0\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			if (mail($config_email, $subject, utf8_decode($contenido) ,$header))
			{
				$procesado = 1;
				$nombre = "";
				$email = "";
				$asunto = "";
				$mensaje = "";
			}
			else
			{
				$error = 1;
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
  <div class="title">
    <div class="center">
      <div class="content"><?php echo $texto_titulo_contacto ?></div>
    </div>
  </div>
  <div id="contacto">
    <div class="center">
      <div class="content">
        <div class="columna">
          <?php if(isset($procesado)) { ?>
          <div class="enviado"><?php echo $texto_mensaje_enviado ?></div>
          <?php } else if (isset($error)) { ?>
          <div class="error"><?php echo $texto_mensaje_error ?></div>
          <?php } else { ?>
          <form action="contact.php" method="get">
            <input name="enviado" type="hidden" value="1" />
            <label> <?php echo $texto_label_nombre ?> </label>
            <?php if(isset($mensaje_nombre) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_nombre.'</div>'; } ?>
            <input name="nombre" type="text" value="<?php if(isset($nombre)) echo $nombre ?>" />
            <label> <?php echo $texto_label_email ?> </label>
            <?php if(isset($mensaje_email) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_email.'</div>'; } ?>
            <input name="email" type="text" value="<?php if(isset($email)) echo $email ?>" />
            <label> <?php echo $texto_label_asunto ?> </label>
            <?php if(isset($mensaje_asunto) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_asunto.'</div>'; } ?>
            <input name="asunto" type="text" value="<?php if(isset($asunto)) echo $asunto ?>" />
            <label> <?php echo $texto_label_mensaje ?> </label>
            <?php if(isset($mensaje_mensaje) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_mensaje.'</div>'; } ?>
            <textarea name="mensaje" rows="7"><?php if(isset($mensaje)) echo $mensaje ?>
</textarea>
            <div class="g-recaptcha" data-sitekey="6LfcH7AUAAAAAGE_r6EMvOSei9FDXf3w5E-Mq2pZ" style="width:100%; height: 100px; overflow:hidden; float:left;"></div>
            <input name="Enviar" type="submit" />
          </form>
          <?php } ?>
        </div>
        <div class="columna">
          <div class="informacion">
            <div class="tipo"><?php echo $texto_label_direccion ?></div>
            <div class="dato"><?php echo $config_direccion ?></div>
            <div class="tipo"><?php echo $texto_label_tel ?></div>
            <div class="dato"><?php echo $config_telefono ?></div>
            <div class="tipo"><?php echo $texto_label_email ?></div>
            <div class="dato"><?php echo $config_email ?></div>
          </div>
          <img src="images/milugar.jpg<?php echo $css_update ?>" class="foto" /> </div>
      </div>
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>

<?php 
$email_receptor = "danielz@locomotionco.com";
$info_direccion = "Calle 0000 esq. Calle. Montevideo, Uruguay";
$info_telefono = "000 000 000";
$color_boton_enviar = "#333";

if(isset($_GET["enviado"]))
{
	$nombre = $_GET["nombre"];
	$email = $_GET["email"];
	$asunto = $_GET["asunto"];
	$mensaje = $_GET["mensaje"];
	
	if (!$nombre) { $mensaje_nombre = "Faltan datos"; }
	if (!preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $email)) { $mensaje_email = "El dato debe ser un email.";  }
	if (!$asunto) { $mensaje_asunto = "Faltan datos"; }
	if (!$mensaje) { $mensaje_mensaje = "Faltan datos"; }
	
	if(empty($mensaje_nombre) and empty($mensaje_email) and empty($mensaje_asunto) and empty($mensaje_mensaje))
	{
		$Subject = "Contacto para ".$_SERVER['SERVER_NAME'];
		$contenido = '
		<br /><br />
		NOMBRE:
		<br />
		'.$nombre.'
		<br /><br />
		EMAIL:
		<br />
		'.$email.'
		<br /><br />
		ASUNTO:
		<br />
		'.$asunto.'
		<br /><br />		
		MENSAJE:
		<br />
		'.$mensaje.'
		<br />		
		';
		$subject = "=?ISO-8859-1?B?".base64_encode($Subject)."=?=";
		$header = "From:".$email."\nReply-To:\n";
		$header .= "X-Mailer:PHP/".phpversion()."\n";
		$header .= "Mime-Version: 1.0\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		if (mail($email_receptor, $subject, utf8_decode($contenido) ,$header))
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
?>
<style>
#contacto {
	float: left;
	width: 100%;
	padding: 0 0 20px 0;
}
#contacto .columna {
	float: right;
	width: 50%;
	padding: 0 0 0 20px;
}
#contacto .columna:last-child {
	float: left;
	padding: 0;
}
#contacto iframe {
	width: 100%;
	height: 300px;
}
#contacto .informacion {
	width: 100%;
	padding: 20px 0 20px 0;
}
#contacto .tipo, #contacto .dato {
	width: 100%;
	font-weight: bold;
	padding: 0 0 5px 0;
}
#contacto .dato {
	font-weight: normal;
	padding: 0 0 20px 0;
}
#contacto .titulo {
	float: left;
	width: 100%;
	padding: 30px 0 30px 0;
	font-size: 24px;
	line-height: 20px;
}
#contacto form {
	float: left;
	width: 100%;
}
#contacto label {
	float: left;
	width: auto;
	font-size: 18px;
	padding: 0 0 10px 0;
}
#contacto input[type=text], #contacto textarea {
	float: left;
	width: 100%;
	padding: 10px;
	border: 1px solid #999;
	border-radius: 3px;
	margin: 0 0 20px 0;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
#contacto input[type=submit] {
	float: left;
	width: 100%;
	margin: 10px 0 0 0;
	padding: 15px;
	cursor: pointer;
 border: 1px solid <?php echo $color_boton_enviar ?>;
 background-color: <?php echo $color_boton_enviar ?>;
	color: #FFF;
	font-size: 18px;
	border-radius: 3px;
	text-transform: uppercase;
}
#contacto input[type=submit]:hover {
	-webkit-filter: brightness(120%);
	filter: brightness(120%);
}
#contacto .enviado, #contacto .error {
	float: left;
	width: 100%;
	border: 1px solid #AEDDC4;
	background-color: #E2FAE7;
	padding: 20px;
	text-align: center;
	border-radius: 3px;
}
#contacto strong {
	float: left;
	width: 100%;
}
#contacto .error, #contacto .alerta {
	border: 1px solid #EDD1D1;
	background-color: #FCEDED;
}
#contacto .alerta {
	width: auto;
	float: left;
	color: #C00;
	font-size: 14px;
	margin-left: 10px;
	padding-top: 3px;
	padding-right: 5px;
	padding-bottom: 3px;
	padding-left: 5px;
	border-radius: 3px;
}
@media only screen and (max-width : 768px) {
#contacto .columna {
	width: 100%;
	padding: 0;
}
#contacto input[type=submit] {
	margin: 10px 0 30px 0;
}
}
</style>
<div id="contacto">
  <div class="columna">
    <div class="titulo">Formulario de Contacto:</div>
    <?php if(isset($procesado)) { ?>
    <div class="enviado">Su mensaje fué enviando y será procesado a la brevedad. <strong>Muchas gracias.</strong></div>
    <?php } else if (isset($error)) { ?>
    <div class="error">Hubo uno error, inténtalo de nuevo. <a href="javascript:history.back(1)">Volver</a></div>
    <?php } else { ?>
    <form action="contacto.php" method="get">
      <input name="enviado" type="hidden" value="1" />
      <label> Nombre: </label>
      <?php if(isset($mensaje_nombre) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_nombre.'</div>'; } ?>
      <input name="nombre" type="text" value="<?php if(isset($nombre)) echo $nombre ?>" />
      <label> Email: </label>
      <?php if(isset($mensaje_email) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_email.'</div>'; } ?>
      <input name="email" type="text" value="<?php if(isset($email)) echo $email ?>" />
      <label> Asunto: </label>
      <?php if(isset($mensaje_asunto) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_asunto.'</div>'; } ?>
      <input name="asunto" type="text" value="<?php if(isset($asunto)) echo $asunto ?>" />
      <label> Mensaje: </label>
      <?php if(isset($mensaje_mensaje) and isset($_GET["enviado"])) { echo '<div class="alerta">'.$mensaje_mensaje.'</div>'; } ?>
      <textarea name="mensaje" rows="7"><?php if(isset($mensaje)) echo $mensaje ?>
</textarea>
      <input name="Enviar" type="submit" />
    </form>
    <?php } ?>
  </div>
  <div class="columna">
    <div class="titulo">Datos de Contacto:</div>
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d13087.545361870685!2d-56.15752593906767!3d-34.90930173038883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2suy!4v1537038385845" frameborder="0" style="border:0" allowfullscreen></iframe>
    <div class="informacion">
      <div class="tipo">Dirección:</div>
      <div class="dato"><?php echo $info_direccion ?></div>
      <div class="tipo">Teléfono:</div>
      <div class="dato"><?php echo $info_telefono ?></div>
      <div class="tipo">Email:</div>
      <div class="dato"><?php echo $email_receptor ?></div>
    </div>
  </div>
</div>

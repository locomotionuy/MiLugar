<?php 
include 'inc-conn.php';

$idprop = $_GET["idprop"];
$stmt = $conn->prepare("SELECT * FROM propiedades WHERE id=$idprop LIMIT 1 "); 
$stmt->execute();
while( $row2 = $stmt->fetch() ) 
{
	$idinmo = $row2["inmobiliaria"];
	$stmt2 = $conn->prepare("SELECT * FROM usuarios WHERE id=$idinmo LIMIT 1 "); 
	$stmt2->execute();
	while( $row = $stmt2->fetch() ) 
	{
		$email_receptor = $row["email"];
		$mapa = $row["mapa"];
		$nombre_inmo = $row["nombre"];
		$info_direccion = $row["direccion"];
		$info_telefono = $row["telefono"];
		if($row["telefono"] && $row["celular"]) $info_telefono .= ' / ';
		$info_telefono .= $row["celular"];
	}
}

if(isset($_REQUEST["submit"])) {

$nombre = $_POST["nombre"];
$email = $_POST["email"];
$mensaje = $_POST["mensaje"];	
$telefono = $_POST["telefono"];

if (!$nombre) { $mensaje_nombre = "Faltan datos"; }
if (!preg_match("/^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/", $email)) { $mensaje_email = "El dato debe ser un email.";  }
if (!$mensaje) { $mensaje_mensaje = "Faltan datos"; }
if (!$telefono) { $mensaje_telefono = "Faltan datos"; }
	
if(empty($mensaje_nombre) and empty($mensaje_email) and empty($mensaje_mensaje) and empty($mensaje_telefono))
{
	try 
	{
		$fecha = date('d/m/Y');
		
		$sql = "INSERT INTO mensajes (nombre,consulta,email,telefono,id_referencia,inmobiliaria,fecha) values ('$nombre','$mensaje','$email','$telefono','$idprop','$idinmo','$fecha')";
		$conn->exec($sql);
				
		$mail_mensaje = '<html>
<body>
<div style="color: #666; font-size: 18px; width: 100%; padding: 10px; float: left; background-color: #D5D5D5;"><img src="https://milugar.com.uy/images/logo.png"  height="70" alt="" style="vertical-align: middle; margin-right: 15px; margin-left: 25px; "/>Consulta recibida por propiedad N° '.$idprop.'</div>
<div style="width: 100%; float: left; padding: 20px; padding-top: 30px;padding-bottom: 30px; background-color: #eaeaea;">Nombre: '.$nombre.'<br>
Telefono '.$telefono.'<br><br>
Consulta:<br><br>'.$mensaje.'<br><br><br>
  <a href="https://milugar.com.uy/file.php?id='.$idprop.'" style="border-radius: 3px; text-decoration:none; color: #fff; font-size: 18px; float: left; padding: 20px; background-color: #fc0606; margin: 10px;">Ver propiedad</a>
<br><br><br><br>
</div>
</body>
</html>';
		
		$headers = "From: " . strip_tags($email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($email) . "\r\n";
		//$headers .= "CC: ".$email_receptor."\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		mail($email_receptor, 'Mi Lugar - Recibiste una consulta', $mail_mensaje, $headers);
		
		$contacto="si";
		$nombre = "";
		$email = "";
		$telefono = "";
		$mensaje = "";
    }
	catch(PDOException $e)
    {
		$error = $sql . "<br>" . $e->getMessage();
		$contacto="no";
		//error_log(print_r($error));
    }
}

}


?>
<style>
@charset "utf-8";
@import url("fonts/fonts.css");
body {
	margin: 0;
	padding: 0;
	font-family: "Ubuntu Light";
}
#contacto {
	float: left;
	width: 100%;
}
#contacto .notificaciones {
	float: left;
	width: 100%;
	padding: 20px 20px 10px 20px;
	border: 1px solid #CCCCCC;
	border-radius: 5px;
	margin: 10px 0 20px 0;
	position: relative;
	font-size: 14px;
}
#contacto .notificacion {
	float: left;
	width: 30%;
	color: #666;
	padding: 3px 0 0 0;
}
#contacto .checkbox {
	float: left;
	width: 20%;
	height: 37px;
	text-align: left;
	padding: 5px 0;
}
#contacto .label {
	position: absolute;
	top: -10px;
	left: 15px;
	background-color: #FFF;
	color: #C00;
	font-size: 12px;
	padding: 0 5px;
	font-family: "Ubuntu Medium";
}
#contacto .separado {
	float: left;
	width: 100%;
	border-bottom: 1px solid #CCC;
	margin-bottom: 10px;
}
#contacto .columna {
	float: left;
	width: 50%;
	padding: 0 20px 0 0;
	border-radius: 5px;
	overflow: hidden;
}
#contacto .columna:last-child {
	float: right;
	padding: 0;
}
#contacto .columna img{
	float: left;
	width: 100%;
}
#contacto iframe {
	width: 100%;
	height: 300px;
}
#contacto .informacion {
	float: left;
	width: 100%;
	padding: 20px;
	color: #6d6e71;
	background-color:#fff;
}
#contacto .tipo, #contacto .dato {
	width: 100%;
	font-weight: bold;
	padding: 0 0 5px 0;
}
#contacto .dato {
	font-weight: normal;
	padding: 0 0 10px 0;
}
#contacto .tipo{
	color: #FF0000;
	font-size: 12px;
	text-transform: uppercase;
}
#contacto form {
	float: left;
	width: 100%;
}
#contacto placeholder {
	float: left;
	width: auto;
	font-size: 16px;
	padding: 0 0 5px 0;
	color: #333;
	font-family: "Ubuntu Light";
}
#contacto label span{
	font-size: 14px;
	color: #999;
	text-transform: uppercase;
}
#contacto input[type=text], #contacto input[type=password], #contacto textarea {
	float: left;
	width: 100%;
	padding: 5px;
	border: 1px solid #fff;
	margin: 0 0 3px 0;
	font-family: "Ubuntu Light";
}
#contacto textarea {
	height: 114px;
	margin: 0;
}
#contacto input[disabled="disabled"]{
	color: #7D7D7D;
	border: solid 1px #A6A6A6;
	background-color: #CCC;
}
#contacto input[type=submit] {
	float: left;
	width: 100%;
	margin: 0;
	cursor: pointer;
	border: 1px solid #eb0606;
	background-color: #eb0606;
	color: #FFF;
	font-size: 18px;
	text-transform: uppercase;
	font-family: "Ubuntu Light";
	height: 38px;
}
#contacto input[type=submit]:hover {
	-webkit-filter: brightness(120%);
	filter: brightness(120%);
}
#contacto .enviado, #contacto .error {
	float: left;
	width: auto;
	text-align: center;
	padding: 20px;
}
#contacto .enviado a, #contacto .error a{
	margin-top: 10px;
	padding: 5px 20px;
	display: inline-block;
	color: #FFF;
	background-color: #cf2f33;
	text-decoration: none;
}
#contacto .enviado a:hover, #contacto .error a:hover{
	background-color: #E74549;
}
#contacto .enviado i{
	color: #fff;
	border-radius: 50%;
	padding: 20px;
	font-size: 30px;
	background: rgba(255,0,0,1);
	background: -moz-linear-gradient(top, rgba(255,0,0,1) 0%, rgba(173,0,0,1) 100%);
	background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(255,0,0,1)), color-stop(100%, rgba(173,0,0,1)));
	background: -webkit-linear-gradient(top, rgba(255,0,0,1) 0%, rgba(173,0,0,1) 100%);
	background: -o-linear-gradient(top, rgba(255,0,0,1) 0%, rgba(173,0,0,1) 100%);
	background: -ms-linear-gradient(top, rgba(255,0,0,1) 0%, rgba(173,0,0,1) 100%);
	background: linear-gradient(to bottom, rgba(255,0,0,1) 0%, rgba(173,0,0,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ff0000', endColorstr='#ad0000', GradientType=0 );
}
#contacto strong {
}
#contacto .error, #contacto .alerta {
	color: #C00;
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
#contacto .descripcion {
	float: left;
	width: 100%;
	padding: 30px;
	background-color: #fff;
	border-radius: 5px;
	margin-bottom: 20px;
	color: #C00;
	text-align: center;
	box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2);
	font-family:"Ubuntu Light";
	font-size: 20px;
}
#contacto .descripcion .des_registro{
	float: left;
	width: 100%;
	height: 160px;
	position: relative;
	padding-left: 180px;
	padding-top: 37px;
}
#contacto .descripcion img{
	position: absolute;
	left: 0;
	top: 0;
	border-radius: 50%;
	overflow: hidden;
	width: 160px;
	height: 160px;
	display: inline-block;
}
#contacto .checkbox {
	float: left;
	width: 20%;
	height: 37px;
	padding: 0;
    display: block;
    position: relative;
    cursor: pointer;
    user-select: none;
}
#contacto .checkbox input[type="checkbox"] {
    position: absolute;
	right: 0;
    opacity: 0;
    cursor: pointer;
	width: 70px;
	height: 30px;
	z-index: 1000;
}
#contacto .checkmark {
	position: absolute;
	top: 0;
	right: 0;
	height: 24px;
	width: 50px;
	border: 1px solid #fff;
	background-color: #ccc;
	border-radius: 20px;
}
#contacto .checkbox.fix .checkmark, #contacto .checkbox.fix .checkmark input[type="checkbox"]{
	right: 20px;
}
#contacto .checkmark .circle{
	position: absolute;
	height: 24px;
	width: 24px;
	top: -1px;
	left: -1px;
	background-color: #fff;
	border: 3px solid #fc0606;
	border-radius: 20px;
}
#contacto .checkbox:hover input[type="checkbox"] ~ .checkmark {
	background-color: #FFC1C1;
}
#contacto .checkbox input[type="checkbox"]:checked ~ .checkmark {
	background-color: #EC8080;
}
#contacto .checkbox input[type="checkbox"]:checked ~ .checkmark .circle{
	position: absolute;
	height: 24px;
	width: 24px;
	top: -1px;
	right: -1px;
	left: auto;
	background-color: #fff;
	border: 3px solid #fc0606;
	border-radius: 20px;
}
#contacto .checkbox input[type="checkbox"]:checked ~ .checkmark:after {
    display: block;
}
</style>
<div id="contacto">
  <?php if(isset($contacto) and $contacto=="si") { ?>
  <div class="enviado">Su mensaje fué enviando y será procesado a la brevedad.<br>
    <strong>Muchas gracias.</strong></div>
  <?php } else if (isset($contacto) and $contacto=="no") { ?>
  <div class="error">Hubo uno error, inténtalo de nuevo. <br />
<a href="javascript:history.back(1)">volver</a></div>
  <?php } else { ?>
  <form action="consulta.php?idprop=<?php echo $idprop; ?>" method="post" enctype="multipart/form-data">
    
    <input name="nombre" type="text" placeholder="<?php if(isset($mensaje_nombre)) { echo "Falta un nombre:"; } else { echo "Nombre:";}?>" value="<?php if(isset($nombre)) echo $nombre ?>"/>
    
    <input name="email" type="text" placeholder="<?php if(isset($mensaje_email)) { echo "Falta un email:"; } else { echo "Email:";}?>" value="<?php if(isset($email)) echo $email ?>"/>
    
    <input name="telefono" type="text" placeholder="<?php if(isset($mensaje_telefono)) { echo "Falta un teléfono:"; } else { echo "Teléfono:";}?>" value="<?php if(isset($telefono)) echo $telefono ?>"/>
    
    <textarea name="mensaje" placeholder="<?php if(isset($mensaje_mensaje)) { echo "Falta un mensaje:"; } else { echo "Consulta:";}?>" cols="" ><?php if(isset($mensaje)) echo $mensaje ?>
</textarea>
	<input name="asunto" type="hidden" value="Consulta por propiedad N°: <?php echo $idprop; ?>" />
    <input type="submit" name="submit" id="enviar" value="Enviar">
  </form>
  <?php } ?>
</div>

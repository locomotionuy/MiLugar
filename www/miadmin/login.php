<?php
session_start();
include '../inc-conn.php';

if(isset($_POST['entrar']) and empty($_GET['logout']))
{
	if (empty($_POST['usuario']) or empty($_POST['password'])) 
	{
		$error = "Hubo un error: <br />Debe especificar usuario y contraseña";
	}
	else
	{
		$usuario = stripslashes($_POST['usuario']);
		$password = stripslashes($_POST['password']);	
	
		$passSha1 = sha1($password);
  
    $existe_usuario = false;
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario='".$usuario."' LIMIT 1");
		$stmt->execute();
		while( $row = $stmt->fetch() ) 
    {
      $existe_usuario = true;
			if($passSha1==$row['pass']) 
			{
        $_SESSION['usuario'] = $row['usuario'];
        //$_COOKIE['usuario'] = $row['usuario'];
				$_SESSION['password'] = $row['pass'];
				$_SESSION['usuario_id'] = $row['id'];
				$_SESSION['usuario_permisos'] = $row['permisos'];
				$_SESSION['usuario_nombre'] = $row['nombre'];
				$_SESSION['dimension'] = $row['dimension'];
        $_SESSION['milugar'] = $row['milugar'];
        //echo 'usuario: '.$_SESSION['usuario'];
        //usleep(3000000);
        header("location: index.php");
       // echo '<script>window.location = "index.php";</script>';
       // exit();
        break;
			} 
			else 
			{
        $error = "Hubo un error: <br />El nombre o contraseña son incorrectos";
        break;
      }
      break;
    }
    if($existe_usuario == false) $error = "Hubo un error: <br />El nombre o contraseña son incorrectos...";
	}
}
elseif(isset($_GET['logout']))
{
  session_unset(); 
  session_destroy();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link href="css/desktop-all.css" rel="stylesheet" type="text/css" />
<link href="css/mobile-all.css" rel="stylesheet" type="text/css" />
<link href="css/desktop-login.css" rel="stylesheet" type="text/css" />
<link href="css/mobile-login.css" rel="stylesheet" type="text/css" />
<?php 
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
echo '<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">';
?>
</head>

<div id="login">
  <div class="bg">
  <div class="logo"><a href="../index.php"><img src="images/admin360.png" alt="<?php echo $_SERVER['SERVER_NAME'] ?>" /></a></div>
  </div>
  <div class="center">
    <?php if (!isset($error)) {?>
    <div class="titulo"><i class="fas fa-user-circle"></i></i>
      <div class="text">Ingreso de usuario
        <?php if (isset($_GET['logout'])) echo '<div class="logout"><strong>(Sesión terminada)</strong></div>'; ?>
      </div>
    </div>
    <?php } elseif (isset($error)) {?>
    <div class="mensajes">
      <div class="text"><?php echo $error ?></div>
    </div>
    <?php } ?>
    <div class="form">
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <fieldset>
          <label>Usuario:</label>
          <input name="usuario" type="text" <?php if(isset($usuario)) echo 'value="'.$usuario.'"'; ?> />
        </fieldset>
        <fieldset>
          <label>Contraseña:</label>
          <input name="password" type="password" />
        </fieldset>
        <fieldset>
          <input value="Entrar" name="" type="submit" />
        </fieldset>
        <input name="entrar" type="hidden" value="1" />
        <div class="recuperar"><a href="login-recuperar.php">Recuperar contraseña</a></div>
      </form>
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>
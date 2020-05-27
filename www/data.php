<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>

<?php echo 'Versión actual de PHP: ' . phpversion();
	
	
	print_r(phpinfo());
	
		
	$user = getenv('APACHE_RUN_USER');
$group = getenv('APACHE_RUN_GROUP');
echo $user.":";
echo $group."<br />";

echo exec('whoami');
	?>
	
</body>
</html>
<?php 

$id = $_GET['id'];
$stmt1 = $conn->prepare("SELECT * FROM $tabla WHERE id= $id " );
$stmt1->execute();
while( $row = $stmt1->fetch() ) 
{
	
// Consulta Foto Principal
$stmt2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." and tipo!='logo' ORDER BY orden ASC LIMIT 1");
$stmt2->execute();
while( $row_img = $stmt2->fetch() ) 
{
	$meta_foto = $row_img["foto_thumb"];
}
// Consulta Inmobiliaria
$stmt3 = $conn->prepare("SELECT * FROM usuarios WHERE id=".$row['inmobiliaria']." LIMIT 1");
$stmt3->execute();
while( $row_inm = $stmt3->fetch() )
{
	$meta_inmobiliaria = $row_inm["nombre"];
	$telefono = $row_inm["telefono"];
	if($row_inm["telefono"] && $row_inm["celular"]) $telefono .= ' / ';
	$telefono .= $row_inm["celular"];
}
$descripcion = strip_tags($row['descripcion']);
	
echo '<meta property="og:url" content="https://'.$_SERVER['SERVER_NAME'].'/file.php?id='.$_GET['id'].'" />';
echo '<meta property="og:type" content="article" />';
echo '<meta property="og:site_name" content="'.$meta_title.'" />';
echo '<meta property="og:description" content="'.$descripcion.'" />';
echo '<meta property="og:image" content="'.$meta_foto.'" />';
//allow_spherical_photo

echo '<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@milugar360">
<meta name="twitter:creator" content="@'.$meta_inmobiliaria.'">';
if($row['titulo']!==Null) 
{ 
	$meta_title = $row['titulo']; 
}
else
{
	foreach ($lista_inmuebles as $lista_inmueble)
	{
		if($lista_inmueble[0]==$row['IdTipoInmueble']) $meta_title .= $lista_inmueble[1]." en ";
	}
	
	foreach ($lista_operaciones as $lista_operacion)
	{
		if($lista_operacion[0]==$row['IdTipoOperacion']) $meta_title .= $lista_operacion[1];
	}
	
	$meta_title .= " en ".$row['IdLocalidad'];
}
echo '<meta name="twitter:title" content="'.$meta_title.'" />';
echo '<meta property="og:title" content="'.$meta_title.'" />';
echo '<meta name="twitter:description" content="'.$descripcion.'" />';
echo '<meta name="twitter:image" content="'.$meta_foto.'">';	
}
?>

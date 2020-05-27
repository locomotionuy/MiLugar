<?php 

	include '../../inc-conn.php';
	$folder = '../../uploads/fotos/';
	$folder_thumb = $folder.'thumbs/';

$id = $_GET['idreferencia'];
$posiciones = $_GET['posiciones'];
$panos = $_GET['panos'];
$visibilidades = $_GET['visibilidades'];

$nuevo = true;

$stmt = $conn->prepare("SELECT * FROM tour WHERE idreferencia=".$id." LIMIT 1 ");
$stmt->execute();
while( $row = $stmt->fetch() ) 
{
	$nuevo = false;
	try 
	{
		$sql = "UPDATE tour SET 
		posiciones='$posiciones',panos='$panos',visibilidades='$visibilidades' WHERE idreferencia='$id'";
		
		$conn->exec($sql);
		
	}
	catch(PDOException $e)
    {
		$error = $sql . "<br>" . $e->getMessage();
    }

}

if($nuevo){
	try 
	{
		$sql = "INSERT INTO tour ( idreferencia,panos,visibilidades,posiciones ) values ('$id','$panos','$visibilidades','$posiciones')";
		$conn->exec($sql);
	}
	catch(PDOException $e)
	{
		$error = $sql . "<br>" . $e->getMessage();
	}
}


?>
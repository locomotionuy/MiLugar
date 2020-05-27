<?php 
include 'inc-conn.php';

$mod = 'logos';
include 'inc-header.php';
?>

<style>
body{
	background-color: #fff;
	}
</style>


<div class="body">
  <div class="title">Algunas de las inmobiliarias asociadas a MiLugar:</div>
</div>
<div id="logos">
  <div class="center">
    <div class="content">
      <div class="titulo"> 
      
<?php /*?>          <?php
		  $sql = "SELECT count(*) FROM usuarios WHERE milugar='1'"; 
		  $result = $conn->prepare($sql); 
		  $result->execute(); 
		  $number_of_rows = $result->fetchColumn(); 
		  echo $number_of_rows;
		  ?><?php */?>
      </div>
      
      
      <?php 
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE permisos='2' and milugar='1'"); 
    $stmt->execute();
    while( $row = $stmt->fetch() ) 
    {
		
		/*if(strlen($row['web'])>3) 
		{ 
			$stmt2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." and tipo='logo'"); 
			$stmt2->execute();
			while( $row_logo = $stmt2->fetch() ) 
			{
				echo '<a href="'.$row['web'].'" target="_blank"><img class="logo2" src="'.$row_logo["foto"].'" /></a>';
			}
		}
		else
		{*/
		$nombre = $row["nombre"];
		$stmt2 = $conn->prepare("SELECT * FROM fotos WHERE id_referencia=".$row['id']." and tipo='logo'"); 
		$stmt2->execute();
		while( $row_logo = $stmt2->fetch() ) 
		{
			if($row_logo["foto"]!='')
				echo '<a href="results.php?inmobiliaria='.$row['id'].'"><img alt="'.$nombre.'" class="logo2" src="'.$row_logo["foto"].'" /></a>';
		}
		//}		
    }
    ?>
      <br />
      <br />
      <br />
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>

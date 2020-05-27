<?php 
include 'inc-conn.php';
  
$mod = 'Agenda';
$tabla = 'agenda';
include 'inc-header.php';

if(isset($_GET['delete']))
{
	$id = $_GET['delete'];
	try 
	{
		$stmt = $conn->prepare("SELECT * FROM galerias WHERE id_entrada=$id");
		$stmt->execute();
		while( $datos = $stmt->fetch() ) 
		{
			unlink("../uploads/".$gallery_dir."/".$row["foto"]);
			unlink("../uploads/".$gallery_dir."/thumbs/".$row["foto"]);
		}

		$sql = "DELETE FROM galerias WHERE id_entrada=$id";
		$conn->exec($sql);
		
		$sql = "DELETE FROM $tabla WHERE id=$id";
		$conn->exec($sql);
		
		$borrado_ok = 1;
	}
	catch(PDOException $e)
	{
		$borrado_error = "Hubo un error: ".$e->getMessage();
	}
}

require 'inc-paginator.php';
$pagination = new PDO_Pagination($conn);

$pagination->rowCount("SELECT * FROM $tabla");
$pagination->config(3, 10);
$sql = "SELECT * FROM $tabla ORDER BY id ASC LIMIT $pagination->start_row, $pagination->max_rows";
$query = $conn->prepare($sql);
$query->execute();
$model = array();
while($rows = $query->fetch())
{
  $model[] = $rows;
}
?>

<div class="body">
  <div class="center">
    <div class="content">
        <ul class="titulo-secciones">
          <li><a href="index.php">Principal</a></li>
          <li><a href="<?php echo $tabla ?>.php"><?php echo $mod ?></a></li>
          <li class="back"><a href="javascript:goBack()"><i class="fas fa-arrow-alt-circle-left"></i></a></li>
        </ul>
        <div id="results">
        <ul class="respuesta enviado">
          <li>¡Muy pronto!</li>
        </ul>
          <?php /*?><div id="schedule">
            <div class="titulo-secciones">Agenda de visitas:</div>
            <div class="mes"><i class="far fa-calendar-alt"></i> Septiembre de 2018</div>
            <div class="dia programado hoy" id="18092018">Lunes 18 (Hoy)<i class="fas fa-chevron-down rotate" id="i-18092018"></i><span>¡Hay Visitas para hoy!</span></div>
            <ul class="visitas hoy" id="visita-18092018">
              <li><i class="fas fa-user"></i> Dueño</li>
              <li><i class="fas fa-map-marker-alt"></i> Dirección</li>
              <li><i class="fas fa-phone"></i> Telefono</li>
              <li class="sep"></li>
              <li><i class="fas fa-user"></i> Dueño</li>
              <li><i class="fas fa-map-marker-alt"></i> Dirección</li>
              <li><i class="fas fa-phone"></i> Telefono</li>
              <li class="sep"></li>
            </ul>
            <div class="dia">Martes 19</div>
            <div class="dia">Miércoles 20</div>
            <div class="dia programado" id="21092018">Jueves 21 <i class="fas fa-chevron-down" id="i-21092018"></i><span>Hay Visitas programadas</span></div>
            <ul class="visitas" id="visita-21092018">
              <li><i class="fas fa-user"></i> Dueño</li>
              <li><i class="fas fa-map-marker-alt"></i> Dirección</li>
              <li><i class="fas fa-phone"></i> Telefono</li>
              <li class="sep"></li>
            </ul>
            <div class="dia">Viernes 22</div>
            <div class="dia sabado">Sábado 23</div>
            <div class="dia domingo">Domingo 24</div>
            <div class="dia">Lunes 25</div>
            <div class="dia programado" id="26092018">Martes 26 <i class="fas fa-chevron-down" id="i-26092018"></i><span>Hay Visitas programadas</span></div>
            <ul class="visitas" id="visita-26092018">
              <li><i class="fas fa-user"></i> Dueño</li>
              <li><i class="fas fa-map-marker-alt"></i> Dirección</li>
              <li><i class="fas fa-phone"></i> Telefono</li>
              <li class="sep"></li>
            </ul>
            <div class="dia">Miércoles 27</div>
            <div class="dia programado" id="28092018">Jueves 28 <i class="fas fa-chevron-down" id="i-28092018"></i></i><span>Hay Visitas programadas</span></div>
            <ul class="visitas" id="visita-28092018">
              <li><i class="fas fa-user"></i> Dueño</li>
              <li><i class="fas fa-map-marker-alt"></i> Dirección</li>
              <li><i class="fas fa-phone"></i> Telefono</li>
              <li class="sep"></li>
            </ul>
            <div class="dia">Viernes 29</div>
            <div class="dia sabado">Sábado 30</div>
            <div class="mes"><i class="far fa-calendar-alt"></i> Octubre de 2018</div>
            <div class="dia domingo">Domingo 1</div>
          </div><?php */?>
        </div>
      </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>

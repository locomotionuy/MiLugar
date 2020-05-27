<?php 
include 'inc-conn.php';
  
$mod = 'Mensajes';
$tabla = 'mensajes';
include 'inc-header.php';
?>
<script type="text/javascript">
$(document).ready(function(){
	$(".reply").click(function(){
		var id = $(this).attr("id");
		$("#form"+id).slideDown();
		$("#message-buttons"+id).hide();
		$(".arrow"+id).show();
		$("#wrap"+id).css("margin-bottom", "70px");
	});
	$(".cancelar").click(function(){
		var id = $(this).attr("id");
		$("#wrap"+id).css("margin-bottom", "30px");
		$(".arrow"+id).fadeOut();
		$("#form"+id).slideUp(500, function() {
			$("#message-buttons"+id).fadeIn();
  		});
	});
	$(".emisor, .remitente").click(function(){
		$(this).next().toggle();
	});
});
</script>
<!--
Guía de CSS para mensajes anidados con 3 respuestas o mas:
<div class="wrap leido">si el mensaje fue respondido se agrega leido a la clase .wrap .leido

Guía de CSS si el mensaje es respondido por el administrador pasa a la categoria de mensajes respondidos:
<div class="wrap leido respondido"> sea grega .leido y .respondido al wrap

Guía PHP:
El contenido de la div class="buttons" solo aparece al final de cada mensaje nuevo de una usuario.
-->
<script type="text/javascript">
$(document).ready(function(){
	$(".borrar").click(function(){
		$(".confirmation-window").show();
	});
	$(".no").click(function(){
		$(".confirmation-window").hide();
	});
});
</script>

<div class="confirmation-window">
  <div class="titulo">Ventana de confirmación</div>
  <div class="evento"><i class="fas fa-exclamation-triangle"></i>¿Está seguro que desea eliminar la Marca?</div>
  <a href="messages-open.php" class="no">No</a><a href="#">Si</a> </div>
<div class="body">
  <div class="center">
    <div class="content">
      
        <ul class="respuesta enviado">
          <li>¡En breve nueva sección de consultas para usuarios registrados a milugar !</li>
        </ul>
        
    </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>
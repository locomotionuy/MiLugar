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
  <a href="messages-open.php" class="no">No</a><a href="#">Si</a>
</div>

<div class="body">
  <div class="center">
      <div class="content">
        <div id="messages">
          <div class="titulo-secciones alert">Mensajes nuevos:<span>Los mensajes con un mes de antigüedad serán borrados</span></div>
          <?php for ($i = 1; $i <= 1; $i++): ?>
          <!-- Mensajes nuevos: -->
          <div class="wrap leido" id="wrap<?php echo $i?>"> 
            
            <!-- Emisor -->
            <div class="emisor"><i class="fas fa-user-circle"></i> <strong>Usuario</strong> (nombre@email.com)
              <div class="date"><i class="far fa-calendar-alt"></i> 06/09/2018</div>
            </div>
            <div class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tempor egestas odio, sed porttitor augue interdum in. Donec gravida eros lacinia urna condimentum sagittis. Mauris imperdiet aliquet sodales. Nam et turpis eu urna hendrerit maximus.
              <div class="arrow<?php echo $i?>"></div>
            </div>
            
            <!-- Remitente -->
            <div class="remitente"><i class="far fa-user-circle"></i> <strong>Inmobiliaria Verdún</strong>
              <div class="date"><i class="far fa-calendar-alt"></i> 06/09/2018</div>
            </div>
            <div class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tempor egestas odio, sed porttitor augue interdum in. Donec gravida eros lacinia urna condimentum sagittis. Mauris imperdiet aliquet sodales. Nam et turpis eu urna hendrerit maximus.
            </div>
            
            <!-- Emisor -->
            <div class="emisor"><i class="fas fa-user-circle"></i> <strong>Usuario</strong> (nombre@email.com)
              <div class="date"><i class="far fa-calendar-alt"></i> 06/09/2018</div>
            </div>
            <div class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tempor egestas odio, sed porttitor augue interdum in. Donec gravida eros lacinia urna condimentum sagittis. Mauris imperdiet aliquet sodales. Nam et turpis eu urna hendrerit maximus.
              <div class="buttons" id="message-buttons<?php echo $i?>">
                <div class="borrar"><i class="fas fa-times"></i></div>
                <div class="reply" id="<?php echo $i?>"><i class="fas fa-reply-all"></i></div>
              </div>
              <div class="arrow<?php echo $i?>"></div>
            </div>
            
            <!-- Formulario -->
            <form action="" method="get" id="form<?php echo $i?>">
              <div class="remitente"><i class="far fa-user-circle"></i> <strong>Inmobiliaria Verdún</strong></div>
              <textarea name="mensaje" cols="" rows=""></textarea>
              <input name="Responder" type="submit" value="Responder" />
              <input name="Cancelar" type="button" value="Cancelar" class="cancelar" id="<?php echo $i?>"/>
            </form>
          </div>
          <!-- Mensajes nuevos fin -->
          
          <?php endfor; ?>
          <div class="titulo-secciones">Mensajes contestados:</div>
          <?php for ($i = 1; $i <= 2; $i++): ?>
          
          <!-- Mensajes respondidos: -->
          <div class="wrap leido respondido">
            <div class="emisor"><i class="fas fa-user-circle"></i> <strong>Usuario</strong> (nombre@email.com)
              <div class="date"><i class="far fa-calendar-alt"></i> 06/09/2018</div>
            </div>
            <div class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tempor egestas odio, sed porttitor augue interdum in. Donec gravida eros lacinia urna condimentum sagittis. Mauris imperdiet aliquet sodales. Nam et turpis eu urna hendrerit maximus.
              <div class="buttons" id="message-buttons<?php echo $i?>">
                <div class="borrar"><i class="fas fa-times"></i></div>
                <div class="reply" id="<?php echo $i?>"><i class="fas fa-reply-all"></i></div>
              </div>
            </div>
            <div class="remitente"><i class="far fa-user-circle"></i> <strong>Inmobiliaria Verdún</strong>
              <div class="date"><i class="far fa-calendar-alt"></i> 06/09/2018</div>
            </div>
            <div class="message">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tempor egestas odio, sed porttitor augue interdum in. Donec gravida eros lacinia urna condimentum sagittis. Mauris imperdiet aliquet sodales. Nam et turpis eu urna hendrerit maximus. </div>
          </div>
          <!-- Mensajes respondidos fin -->
          
          <?php endfor; ?>
        </div>
      </div>
  </div>
</div>
<?php include 'inc-footer.php'; ?>
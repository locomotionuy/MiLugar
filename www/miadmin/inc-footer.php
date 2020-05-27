<script>
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
$(function(){
	$("#search_list").multipleSelect({
	filter: true,
	width: "100%",
	selectAll: false,
	placeholder: "Departamento"
	});
});
}
else
{
$(function(){
	$("#search_list").multipleSelect({
	filter: true,
	width: "65%",
	selectAll: false,
	placeholder: "Departamento"
	});
});	
}
</script>
<script type="text/javascript" src="js/scripts.js"></script>
<script type="text/javascript" src="js/multiple-select.js"></script>
<div id="footer">
  <div class="center">
    <div class="content">
      <div class="logo">© <?php echo date("Y"); ?> <strong>Milugar</strong> - Todos los derechos reservados</div>
      <div class="version">Cámara Inmobiliaria Uruguaya</strong></div>
    </div>
  </div>
</div>
</body></html>
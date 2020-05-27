<script>
function preview_image() 
{
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append('<li class="preview" style="background-image: url(' +URL.createObjectURL(event.target.files[i])+ ')"><select name="nombre_foto_2d[]"><?php foreach ($lista_habitaciones as $lista_habitacion)
                    {
                        echo '<option value="'.$lista_habitacion[0].'"';
						if($lista_habitacion[1]==1){
							echo 'selected="selected">Habitación o lugar</option>';
						}else{
							echo '>'.$lista_habitacion[0].'</option>'; 
						}
						
                    }
                    ?></select></li>');
 }
}

function preview_image2() 
{
 var total_file=document.getElementById("upload_file2").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview2').append('<li class="preview" style="background-image: url(' +URL.createObjectURL(event.target.files[i])+ ')"><select name="nombre_foto[]"><?php foreach ($lista_habitaciones as $lista_habitacion)
                    {
                        echo '<option value="'.$lista_habitacion[0].'"';
						if($lista_habitacion[1]==1){
							echo 'selected="selected">Habitación o lugar</option>';
						}else{
							echo '>'.$lista_habitacion[0].'</option>'; 
						}
						
                    }
                    ?></select></li>');
 }
}

function preview_image3() 
{
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append('<li class="preview" style="background-image: url(' +URL.createObjectURL(event.target.files[i])+ ')"></li>');
 }
}

</script>  
// Sumar Restar
function cambiar_num(var1,var2) 
{
	varactual = $('#'+var2).val();
	if(varactual >= 0)
	{
		if(var1=='sumar') { $('#'+var2).val(Number( $('#'+var2).val() ) + 1).change() }
		if(var1=='restar' && varactual >= 1) { $('#'+var2).val(Number( $('#'+var2).val() ) - 1).change() }
	} 
}
// Fotos Preview
$(function() 
{
    var imagesPreview = function(input, placeToInsertImagePreview) 
	{
        if (input.files) 
		{
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) 
			{
                var reader = new FileReader();

                reader.onload = function(event) 
				{
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };
    $('.input_upload').on('change', function() 
	{
		var id = $(this).attr("id");
        imagesPreview(this, '#preview_'+id);
    });
	
	// Agregar image file inputs
	$(".add_button").click(function()
	{
		var id = $(this).attr("id");
		$('.add_button#'+id).hide();
		$('#thumbnail_'+id).show();
		id++;
		$('.add_button#'+id).show();

    });
});
// Formulario 3 pasos
$(document).ready(function(){
	$(".btn_tab01").click(function(){
		$(".tab1").show();
		$(".tab2").hide();
		$(".tab3").hide();
		$('.btn_tab01').addClass('selected');
		$('.btn_tab02').removeClass('selected');
		$('.btn_tab03').removeClass('selected');
	});
	$(".btn_next.1, .btn_tab02").click(function(){
		$(".tab1").hide();
		$(".tab2").show();
		$(".tab3").hide();
		$('.btn_tab01').removeClass('selected');
		$('.btn_tab02').addClass('selected');
		$('.btn_tab03').removeClass('selected');
	});
	$(".btn_next.2, .btn_tab03").click(function(){
		$(".tab1").hide();
		$(".tab2").hide();
		$(".tab3").show();
		$('.btn_tab01').removeClass('selected');
		$('.btn_tab02').removeClass('selected');
		$('.btn_tab03').addClass('selected');
	});
});
// Agenda
$(document).ready(function(){
	$(".dia").click(function(){
		var id = $(this).attr("id");
		$("#visita-"+id).slideToggle(100, function() {
			$("#i-"+id).toggleClass('rotate');
  		});
	});
});
// Mostrar Input
function mostrar_input(selectObject) {
    var value = selectObject.value; 
	var x = document.getElementById("amueblado");
    if (value==1 || value==3) {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
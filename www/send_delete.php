<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<?php
$arr = array(
    "CodigoWeb"=>17140469,"CodCliente"=>2359571, "Info"=>"Aviso Cancelado desde MAS", "Estado"=> 2
);

?>

<script>
$.ajax({
    url: "https://dimension360.com.uy/admin360_apiV2/callbacks/delete.php",
    type: "POST",
    dataType: "json",
    data: {
        "CodigoWeb":17140469,"CodCliente":00000, "Info":"Aviso Cancelado desde MAS", "Estado": 2
    },
    success: function(result) {
        console.log(result);
        // continue program
    },
    error: function(log) {
        console.log(log);
        // handle error
    }
});

</script>
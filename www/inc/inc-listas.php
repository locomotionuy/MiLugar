<?php 
// Lista tipos de permiso:
$lista_permisos = array(
	array("2","Administrador","Admin."),
	array("1","Super Administrador","Super Admin.")
);
/***********************
LAS LIASTAS INCLUYEN LOS CODIGOS DE LAS API GALLITO Y CASASWEB
PENULTIMO 	- GALLITO
ULTIMO 		- CASASWEB
***********************/

// Lista tipos inmuebles:
$lista_inmuebles = array(
	array("1","Casa",				"Casa",				"1",1,"c"),
	array("2","Apartamento",		"Apto",				"1",2,"a"),
	array("3","Campo",				"Campo",			"0",3,"e"),
	array("4","Comercio",			"Comercio",			"0",7,""),
	array("5","Local",				"Local",			"0",5,"l"),
	array("6","Oficina",			"Oficina",			"0",6,"o"),
	array("7","Terreno",			"Terreno",			"0",4,"t"),
	array("8","Alquiler Temporada",	"Alq. Temp.",		"0",99,""),
	array("9","Pieza",				"Pieza",			"0",8,""),
	array("10","Garage",			"Garage",			"0",9,"g"),
	array("11","Edificio",			"Edificio",			"0",10,"b"),
	array("12","Galpón",			"Galpón",			"0",99,""),
	array("13","Depósito",			"Depósito",			"0",99,"d"),
	array("14","Empresa",			"Empresa",			"0",99,"m"),
	array("15","Local Industrial",	"Local Industrial",	"0",99,"i"),
	array("16","Local Comercial",	"Local Comercial",	"0",99,"l"),
	array("17","Chacra",			"Chacra",			"0",99,"")
);

$lista_locaciones = array(
	array("1","Chacra","Chacra","1"),
	array("2","Estancia","Estancia","1"),
	array("3","Campo","Campo","0"),
	array("4","Salón de fiestas","Salón","0"),
	array("5","Viñedo","Viñedo","0")
);
// Lista tipo de operacion:
/*$lista_operaciones = array(
	array("1","Alquiler",		"Alq.",			"0",	"Alquilado",	2,"A"),
	array("2","Venta",			"Venta",		"1", 	"Vendido",		1,"V"),
	array("3","Alquiler Temp.",	"Alq. Temp.",	"0",	"Alquilado",	3,"T"),
	array("4","Comprado","Comprado","0", "Comprado",4,""),
	array("5","Permutado","Permutado","0", "Permutado",5,""),
	array("6","Otra","Otra","0", "Otra",6,""),
	array("7","Remate","Remate","0", "Rematado",7,"")
);*/
$lista_operaciones = array(
	array("1","Alquiler",		"Alq.",			"0",	"Alquilado",	2,"A"),
	array("2","Venta",			"Venta",		"1", 	"Vendido",		1,"V"),
	array("3","Alquiler Temp.",	"Alq. Temp.",	"0",	"Alquilado",	3,"T"),
	array("4","Compra",			"Comprado",		"0", 	"Comprado",		4,""),
	array("5","Permuta",		"Permutado",	"0",	"Permutado",	5,""),
	array("6","Otra",			"Otra",			"0",	"Finalizado",	6,""),
	array("7","Remate",			"Remate",		"0", 	"Rematado",		7,"")
);
//1 = venta 2 = alquiler 3 =  alquiler temporario 4 = compra 5 =  permuta 6 = otra 7 =  remate 
// el dato despues del estado de la publicaion ("alquilado") es el numero q recibe la api de gallito.
// después del gallito viene la api de casasweb (A , V , T)

// Lista orientación:
$lista_orientaciones = array(
	array("Frente","Frente","Frente"),
	array("Contrafrente","Contrafrente","Contrafrente"),
	array("Lateral","Lateral","Lateral"),
	array("Interior","Interior","Interior"),
	array("Penthouse","Penthouse","Penthouse"),
);
//1 = Frente 2 = Contrafrente 3 = Lateral  4 = Interior 5 = Penthouse 
// Lista estados:

$lista_estados = array(
	array("1","Impecable",			"Impecable",		"I",5),
	array("2","Buen Estado",		"Buen Estado",		"B",3),
	array("3","Estrenar",			"Estrenar",			"E",6),
	array("4","En Construccion",	"En Construccion",	"C",7),
	array("5","Para Reciclar",		"Para Reciclar",	"Z",8),
	array("6","Reciclado",			"Reciclado",		"R",0),
	array("7","En Pozo",			"En Pozo",			"W",0),
	//array("8","Invisible",			"Invisible",		"-",0),
	array("8","Malo",				"Malo",				"-",1),
	array("9","Regular",			"Regular",			"-",2),
	array("10","Muy Bueno",			"Muy Bueno",		"-",4),
);
//CASASWEB: 0 Invisible, 1 Malo, 2 Regular, 3 Bueno 4 Muy Bueno, 5 Excelente, 6 A Estrenar, 7 En Construccion, 8 A Reciclar
/*“I” = Impecable. “E”= A Estrenar. “R” =Reciclado. “B” = Buen Estado.
“Z” = Para Reciclar. “W” = En Pozo. “C” = En Construcción*/
// Lista garantias:
$lista_garantias = array(
	array("","Otras",""),
	array("FIDECIU","FIDECIU","FIDECIU"),
	array("ANDA","ANDA","ANDA"),
	array("Depósito bancario","Depósito bancario","Depósito bancario"),
	array("Contaduría (CGN)","Contaduría (CGN)","Contaduría (CGN)"),
	array("Propiedad","Propiedad","Propiedad"),
	array("Ministerio de Vivienda (MVOTMA)","Ministerio de Vivienda (MVOTMA)","MVOTMA"),
	array("Porto Seguro","Porto Seguro","Porto Seguro"),
	array("Confianza","Confianza","Confianza")
);
	
// Lista superfice construida:
$lista_sup_construida = array(
	array("0-50","Hasta 50 m²"),
	array("50-100","50 a 100 m²"),
	array("100-10000","Más de 100 m²")
);
// Lista superfice total:
$lista_sup_total = array(
	array("0-100","Hasta 100 m²"),
	array("100-150","100 a 150 m²"),
	array("150-10000","Más de 150 m²")
);
// Lista habitaciones:
$lista_habitaciones = array(
	array("","1"),
	array("Living","0"),
	array("Living comedor","0"),
	array("Comedor","0"),
	array("Cocina","0"),
	array("Baño","0"),
	array("Baño de servicio","0"),
	array("Dormitorio","0"),
	array("Dormitorio principal","0"),
	array("Escritorio","0"),
	array("Garage","0"),
	array("Balcón","0"),
	array("Frente","0"),
	array("Fondo","0"),
	array("Pasillo","0"),
	array("Sótano","0"),
	array("Depósito","0"),
	array("Lavadero","0"),
	array("Barbacoa","0"),
	array("Patio","0"),
	array("Azotea","0"),
	array("Jardín","0")
);
?>

<?php 
// Titulo Web y configuracion de contacto:
$config_titulo = "Mi lugar inmobiliario, Alquiler y Venta de propiedades con Fotos 360";
$config_direccion = "Av. Uruguay 820, Montevideo, Uruguay";
$config_telefono = "(+598) 2901 0485 - 2902 8266";
$config_email = "ciu@ciu.org.uy";

// Metas header:
$meta_site_name = "Mi lugar inmobiliario";
$meta_title = "Mi lugar inmobiliario";

// Textos web:
$texto_principal = "Buscador de propiedades especializado en Realidad Virtual y Fotos 360.";
$texto_vr = "¿Cómo ver en Realidad Virtual?";
$texto_search_titulo_home = "Buscar propiedades en Venta o Alquiler:";
$texto_btn_buscar = "Buscar";
$texto_adv_buscar = "Buscador avanzado";
$texto_titulo_favoritos = "Tus Favoritos:";
$texto_titulo_contacto = "Contacto";
$texto_titulo_formulario = "Formulario de Contacto:";
$texto_label_nombre = "Nombre:";
$texto_label_email = "Email:";
$texto_label_asunto = "Asunto:";
$texto_label_mensaje = "Mensaje:";
$texto_titulo_datos = "Datos de Contacto:";
$texto_label_direccion = "Dirección:";
$texto_label_tel = "Teléfono:";
$texto_label_email = "Email:";
$texto_mensaje_asunto = "Contacto para Mi Lugar";
$texto_cuerpo_nombre = "NOMBRE: ";
$texto_cuerpo_email = "<br>EMAIL: ";
$texto_cuerpo_asunto = "<br>ASUNTO: ";
$texto_cuerpo_mensaje = "<br>MENSAJE:<br>";
$texto_falan_datos = "Faltan datos";
$texto_falan_datos_email = "El dato debe ser un email.";
$texto_mensaje_enviado = "Su mensaje fué enviando y será procesado a la brevedad. <strong>Muchas gracias.</strong>";
$texto_mensaje_error = 'Hubo uno error, inténtalo de nuevo. <a href="javascript:history.back(1)">Volver</a>';
$texto_ultimos_resultados = "Ultimos ingresos";
$texto_resultados = " Resultados";
$texto_orden_ingresos = "Más Reciente";
$texto_orden_may_precio = "Mayor Precio";
$texto_orden_men_precio = "Menor Precio";
$texto_label_dorms = "Dorms";
$texto_label_dormitorio = "Dormitorios";
$texto_label_banio = "Baños";
$texto_label_garage = "Garage";
$texto_label_sup_cons = "Superficie const.";
$texto_label_sup_total = "Superficie total";
$texto_label_medidas = "m°";
$texto_label_gastos_comunes = "Gastos Comunes";
$texto_label_orientacion = "Orientación";
$texto_label_garantia = "Garantía";
$texto_label_jardin = "Jardín";
$texto_label_mascotas = "Acepta mascotas";
$texto_label_amueblado = "Amueblado";
$texto_label_barrio_privado = "Barrio privado";
$texto_label_vivienda_social = "Vivienda social";
$texto_label_azotea = "Azotea";
$texto_label_parrillero = "Parrillero";
$texto_label_aire_acondicionado = "Aire acondicionado";
$texto_label_si = "Si";
$texto_label_no = "No";
$texto_label_caracteristicas = "Características";
$texto_label_descripcion = "Descripción";
$texto_label_ubicacion = "Ubicación";
$texto_label_mas_propiedades = "Ver más propiedades de";
$texto_label_preguntar_vendedor = "Preguntar al vendedor";
$texto_label_apartamento = "Apartamento";
$texto_label_casa = "Casa";
$texto_label_alquiler = "Alquiler";
$texto_label_venta = "Venta";
$texto_mas_inmuebles = "Más publicaciones de ";

// Placeholders:
$placeholder_tipo_propiedad = "Tipo de propiedad";
$placeholder_ubicacion = "Departamento, Barrio o Ciudad";

// Contar Favoritos:
$count_favorites = 0;
if(isset($_COOKIE['favoritos'])){
	$favoritos_array = unserialize($_COOKIE['favoritos']);
	foreach($favoritos_array as $value)
	{
		  $count_favorites++;
	}
}

// Menu Header (Siempre se ve texto,Target,Url,Icono,Texto):
$menu_header = array(
	array("0","results.php","0","fas fa-search",'Buscar&nbsp;&nbsp;&nbsp;<i class="fas fa-search"></i>'),
	array("0","contact.php","0","fas fa-paper-plane","Contacto"),
	array("0","miadmin","0","fas fa-user","Ingreso"),
	array("0","favorites.php","0","fa fa-heart","Favoritos <span>$count_favorites</span>"),
);

// Menu Footer(Siempre se ve texto,Target,Url,Icono,Texto):
$menu_footer = array(
	array("0","results.php","0","fas fa-search","Buscar Mi Lugar"),
	array("0","contact.php","0","fas fa-paper-plane","Contacto"),
	array("0","miadmin","0","fas fa-user","Ingreso"),
	array("0","favorites.php","0","fa fa-heart","Favoritos <span>$count_favorites</span>"),
);

// Developer info(si $developer_link==0 no pone nada)
$developer_link = "0";
$developer_text = "0";
$developer_target = 'target="_blank"';

?>
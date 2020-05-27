<?php 
include '../inc-conn.php';
include '../inc/inc-listas.php';
//primer "api" agregada es CASASWEBS - https://grupoavanza.uy/feed
$lista_deptos = array(
	array(2, "Artigas"),
	array(3, "Canelones"),
	array(4, "Cerro Largo"),
	array(5, "Colonia"),
	array(6, "Durazno"),
	array(7, "Flores"),
	array(8, "Florida"),
	array(9, "Lavalleja"),
	array(10, "Maldonado"),
	array(1, "Montevideo"),
	array(11, "Pysandú"),
	array(12, "Rio Negro"),
	array(13, "Rivera"),
	array(14, "Rocha"),
	array(15, "Salto"),
	array(16, "San José"),
	array(17, "Soriano"),
	array(18, "Tacuarembó"),
	array(19, "Treinta y Tres")
);

$lista_zonas =  array(
	array(79,1,"Abayubá"),
	array(20,1,"Aguada"),
	array(40,1,"Aires Puros"),
	array(344,1,"Arroyo Seco"),
	array(49,1,"Atahualpa"),
	array(23,1,"Barrio Sur"),
	array(41,1,"Bella vista"),
	array(26,1,"Belvedere"),
	array(56,1,"Bolívar"),
	array(51,1,"Brazo Oriental"),
array(21,1,"Buceo"),
array(43,1,"Capurro"),
array(1,1,"Carrasco"),
array(48,1,"Carrasco Norte"),
array(60,1,"Casabó"),
array(14,1,"Centro"),
array(44,1,"Cerrito"),
array(61,1,"Cerro"),
array(18,1,"Ciudad Vieja"),
array(128,1,"Colinas de Carrasco"),
array(45,1,"Colón"),
array(129,1,"Conciliación"),
array(15,1,"Cordón"),
array(54,1,"Flor de Maroñas"),
array(237,1,"Goes"),
array(169,1,"Golf"),
array(77,1,"Jacinto Vera"),
array(183,1,"Jardines de Carrasco"),
array(305,1,"Jardines del Hipodromo"),
array(13,1,"La Blanqueada"),
array(27,1,"La Comercial"),
array(65,1,"La Figurita"),
array(46,1,"La Teja"),
array(315,1,"Las Acacias"),
array(66,1,"Lezica"),
array(5,1,"Malvín"),
array(28,1,"Malvín Norte"),
array(182,1,"Manantiales de Carrasco"),
array(67,1,"Manga"),
array(47,1,"Maroñas"),
array(133,1,"Melilla"),
array(248,1,"Nuevo Centro"),
array(68,1,"Nuevo París"),
array(132,1,"Pajas Blancas"),
array(29,1,"Palermo"),
array(16,1,"Parque Batlle"),
array(17,1,"Parque Rodó"),
array(69,1,"Paso de la Arena"),
array(24,1,"Paso Molino"),
array(70,1,"Peñarol"),
array(71,1,"Piedras Blancas"),
array(238,1,"Playa la Colorada"),
array(6,1,"Pocitos"),
array(30,1,"Pocitos Nuevo"),
array(8,1,"Prado"),
array(23,1,"Puerto del Buceo"),
array(7,1,"Punta Carretas"),
array(2,1,"Punta Gorda"),
array(72,1,"Punta Rieles"),
array(50,1,"Reducto"),
array(122,1,"San Nicolás y Aledaños"),
array(78,1,"Santiago Vázquez"),
array(73,1,"Sayago"),
array(31,1,"Tres Cruces"),
array(32,1,"Unión"),
array(241,1,"Villa Biarritz"),
array(347,1,"Villa Dolores"),
array(75,1,"Villa Española"),
array(76,1,"Villa Muñoz"),
array(227,1,"Zona América"),
array(201,2,"Artigas - 7 de Septiembre"),
array(205,2,"Artigas - Aldea"),
array(203,2,"Artigas - Ayuí"),
array(202,2,"Artigas - Centro"),
array(206,2,"Artigas - Ferrocarril"),
array(95,2,"Artigas - Industrial"),
array(204,2,"Artigas - Zorrilla"),
array(209,2,"Baltasar Brum"),
array(210,2,"Bella Unión - El Puerto"),
array(211,2,"Bella Unión - Hospital"),
array(207,2,"Bella Unión - Tres Fronteras"),
array(208,2,"Tomás Gomensoro"),
array(229,3,"Aeropuerto de Carrasco"),
array(225,3,"Aguas Corrientes"),
array(358,3,"Araminda"),
array(114,3,"Atlántida"),
array(167,3,"Av. de las Américas"),
array(4,3,"Barra de Carrasco"),
array(170,3,"Barrios Privados Canelones"),
array(186,3,"Barros Blancos"),
array(346,3,"Bello Horizonte"),
array(224,3,"Canelón Chico"),
array(80,3,"Canelones"),
array(185,3,"Colonia Nicolich"),
array(173,3,"Costa Azul"),
array(236,3,"Cuatro Piedras"),
array(176,3,"Cuchilla Alta"),
array(223,3,"El Colorado"),
array(11,3,"El Pinar"),
array(319,3,"Empalme Olmos"),
array(314,3,"Fortín de Santa Rosa"),
array(345,3,"Guazuvira"),
array(356,3,"Jaureguiberry"),
array(216,3,"Joaquín Suarez"),
array(222,3,"Juanicó"),
array(135,3,"La Floresta"),
array(130,3,"La Paz"),
array(116,3,"Lagomar"),
array(228,3,"Lagos de Carrasco"),
array(234,3,"Las Brujas"),
array(131,3,"Las Piedras"),
array(242,3,"Las Toscas"),
array(360,3,"Las Vegas"),
array(118,3,"Lomas de Solymar"),
array(226,3,"Los Cerrillos"),
array(175,3,"Los Titanes - La Tuna"),
array(320,3,"Marindia"),
array(38,3,"Médanos de Solymar"),
array(318,3,"Montes de Solymar"),
array(244,3,"Neptunia"),
array(81,3,"Pando"),
array(307,3,"Parque de Solymar"),
array(177,3,"Parque del Plata"),
array(3,3,"Parque Miramar"),
array(171,3,"Paso Carrasco"),
array(243,3,"Pinamar"),
array(212,3,"Progreso"),
array(172,3,"Salinas"),
array(220,3,"San Antonio"),
array(313,3,"San Jacinto "),
array(33,3,"San José de Carrasco"),
array(174,3,"San Luis"),
array(213,3,"San Ramón"),
array(310,3,"Santa Ana"),
array(214,3,"Santa Lucía"),
array(239,3,"Santa Lucía del Este"),
array(221,3,"Santa Rosa"),
array(215,3,"Sauce"),
array(115,3,"Shangrilá"),
array(361,3,"Soca"),
array(117,3,"Solymar"),
array(217,3,"Tala"),
array(218,3,"Toledo"),
array(184,3,"Villa Aeroparque"),
array(235,3,"Villa Nueva"),
array(105,4,"Cerro Largo"),
array(289,5,"Agraciada"),
array(279,5,"Artilleros "),
array(293,5,"Arvillaga"),
array(290,5,"Barker"),
array(284,5,"Blancarena"),
array(287,5,"Boca del Rosario"),
array(286,5,"Brisas del Plata"),
array(283,5,"Britópolis"),
array(275,5,"Campana"),
array(86,5,"Carmelo"),
array(188,5,"Colonia"),
array(92,5,"Colonia"),
array(251,5,"Colonia"),
array(253,5,"Colonia"),
array(249,5,"Colonia"),
array(189,5,"Colonia"),
array(250,5,"Colonia"),
array(255,5,"Colonia"),
array(257,5,"Colonia"),
array(259,5,"Colonia"),
array(263,5,"Colonia"),
array(190,5,"Colonia"),
array(187,5,"Colonia"),
array(291,5,"Colonia"),
array(265,5,"Colonia"),
array(261,5,"Colonia"),
array(281,5,"Colonia"),
array(269,5,"Colonia"),
array(196,5,"Colonia"),
array(272,5,"Conchillas"),
array(278,5,"El Ensueño"),
array(276,5,"Estanzuela"),
array(273,5,"Gil"),
array(295,5,"Juan Carlos Casero"),
array(299,5,"Juan J. Jackson"),
array(82,5,"Juan Lacaze"),
array(270,5,"La Paz"),
array(292,5,"Laguna de los Patos"),
array(300,5,"Los Cerros de San Juan"),
array(282,5,"Los Pinos"),
array(280,5,"Minuano"),
array(199,5,"Nueva Helvecia"),
array(193,5,"Nueva Palmira"),
array(200,5,"Ombúes de Lavalle"),
array(297,5,"Paso Antolín"),
array(294,5,"Paso de la Horqueta"),
array(303,5,"Playa Azul"),
array(192,5,"Playa Fomento"),
array(302,5,"Playa Parant"),
array(288,5,"Puerto Ingles"),
array(301,5,"Quintón"),
array(274,5,"Radial Conchillas"),
array(304,5,"Rosario"),
array(298,5,"San Pedro"),
array(194,5,"Santa Ana"),
array(285,5,"Santa Regina"),
array(271,5,"Semillero"),
array(197,5,"Tarariras"),
array(296,5,"Zagarzazú"),
array(246,6,"Blanquillo"),
array(339,6,"Carlos Reyles"),
array(337,6,"Cerro Chato"),
array(99,6,"Durazno"),
array(335,6,"Durazno"),
array(328,6,"Durazno"),
array(333,6,"Durazno"),
array(334,6,"Durazno"),
array(323,6,"Durazno"),
array(331,6,"Durazno"),
array(330,6,"Durazno"),
array(326,6,"Durazno"),
array(327,6,"Durazno"),
array(329,6,"Durazno"),
array(325,6,"Durazno"),
array(332,6,"Durazno"),
array(338,6,"La Paloma"),
array(336,6,"Sarandí del Yi"),
array(340,6,"Villa del Carmen"),
array(100,7,"Flores"),
array(101,8,"Florida"),
array(247,9,"José Batlle y Ordoñez"),
array(102,9,"Lavalleja"),
array(103,9,"Minas"),
array(355,9,"Villa Serrana"),
array(155,10,"Aiguá"),
array(231,10,"Balneario Bella Vista"),
array(359,10,"Buenos Aires"),
array(108,10,"José Ignacio"),
array(230,10,"Las Flores"),
array(141,10,"Maldonado"),
array(353,10,"Pan de Azúcar"),
array(39,10,"Piriápolis"),
array(321,10,"Playa Hermosa"),
array(157,10,"Portezuelo"),
array(348,10,"Punta del Este"),
array(178,10,"Punta del Este"),
array(162,10,"Punta del Este"),
array(165,10,"Punta del Este"),
array(140,10,"Punta del Este - La Barra"),
array(160,10,"Punta del Este"),
array(161,10,"Punta del Este"),
array(163,10,"Manantiales"),
array(164,10,"Punta del Este"),
array(25,10,"Punta del Este"),
array(159,10,"Punta del Este"),
array(137,10,"Punta Ballena"),
array(158,10,"Punta del Este"),
array(179,10,"Punta del Este"),
array(166,10,"Punta del Este"),
array(154,10,"San Carlos"),
array(232,10,"Solís"),
array(93,11,"Paysandú"),
array(91,12,"Fray Bentos"),
array(245,12,"Pueblo Grecco"),
array(354,12,"Young"),
array(96,13,"Rivera"),
array(349,14,"Aguas Dulces"),
array(113,14,"Chuy"),
array(240,14,"El Caracol"),
array(363,14,"La Coronilla"),
array(317,14,"La Esmeralda"),
array(110,14,"La Paloma"),
array(111,14,"La Pedrera"),
array(351,14,"Oceania Del Polonio"),
array(362,14,"Palmares de La Coronilla"),
array(350,14,"Pueblo Nuevo"),
array(352,14,"Puimayen"),
array(112,14,"Punta del Diablo"),
array(107,14,"Rocha"),
array(94,15,"Salto"),
array(342,16,"Ciudad del Plata"),
array(357,16,"Ecilda Paullier"),
array(341,16,"Playa Pascual"),
array(85,16,"San José"),
array(89,17,"Dolores"),
array(88,17,"Mercedes"),
array(87,17,"Soriano"),
array(98,18,"Paso de los Toros"),
array(97,18,"Tacuarembó"),
array(104,19,"Treinta y Tres")
);

?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Lector de feeds - Casasweb</title>
        <link href="style.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <div class="content">

    <?php
			$usuario_id= $_GET['id'];// esto lo tengo q cambiar cada vez! es el id de mi lugar. es el único dato obligatorio q tenés q poner.
			$idCasasWeb= $_GET['idCasasWeb'];// esto se lo tenés que pedir a Álvaro de casasweb.
											//Sino lo ponés en la url lo busca en la base de datos.
			
			$actualizar_fotos = false;
			
			if($idCasasWeb==null){
				$sql = "SELECT * FROM usuarios WHERE id='$usuario_id' && milugar='1' ORDER BY id DESC LIMIT 1";
				$stmt2 = $conn->prepare($sql); 
				$stmt2->execute();
				while( $row_prop = $stmt2->fetch() ) 
				{
					$idCasasWeb= $row_prop['idCasasWeb'];
					echo "<br>Id CasasWeb del usuario: $idCasasWeb";
				}
			}else{
				$sql2 = "UPDATE usuarios SET idCasasWeb=$idCasasWeb , milugar=1 WHERE id='$usuario_id' LIMIT 1";
				$conn->exec($sql2);
				echo "<br>Se actualizó el Id de CasasWeb: $idCasasWeb";
			}
			
			$url = 'https://casasweb.com/export/avanza.aspx?inm='.$idCasasWeb;
			$feeds = simplexml_load_file($url);
			
		echo "<br>-----------------<br>";
/*
<ad>
        <ID>id Origen</ID> (texto hasta 50)
        <URL>http://link a la ficha</URL> (texto hasta 150)
        <TITULO>titulo de la publicacion</TITULO> (texto hasta 200)
        <DORM>3</DORM> (entero)
        <BATH>3</BATH> (entero)
        <AREA>280 m²</AREA> (texto hasta 10)
        <FOTO>http://link a thumbnail</FOTO> (texto hasta 150) 
        <YEAR>2001</YEAR> (texto hasta 10)
        <DEPTO>1</DEPTO> (entero ver tabla)
        <ZONA>7</ZONA> (entero ver tabla)
        <TIPO>a</TIPO>(caracter ver tabla)
        <PRECIO>750000</PRECIO>(entero)
        <SALDO>true</SALDO>(True o False) saldo hipotecario
        <GARAGE>True</GARAGE>(True o False)
        <PRESTAMOS>True</PRESTAMOS>(True o False)
        <NEGOCIO>V</NEGOCIO>(caracter ver tabla)
        <LAT>-34.912875</LAT> (latitud)
        <LNG>-56.151574</LNG> (longitud)
        <MONEDA>0</MONEDA> (0 para dolares y 1 para pesos)
        <EXPENSAS>$ 10000</EXPENSAS>(texto hasta 10)
        <ESTADO>6</ESTADO>(entero ver tabla)
        <AREAEDIFICADA>160</AREAEDIFICADA>(entero m2)
        <BANOSERV>True</BANOSERV>(True o False)
        <DORMSERV>True</DORMSERV>(True o False)
        <TEXTOAVISO>(texto plano hasta 2000) 
        Estrene casa en barrio privado, con todos los servicios (club house, vigilancia permanente, cancha de golf, etc.) 
        </TEXTOAVISO>
        <EXTRAS>(texto hasta 1000) contenido separado por comas 
        Vehiculos:3,Plantas:2,Calefaccion,Parrillero,Comedor,Estar,Toilette,etc
            para muebles usar amoblado o muebles
        </EXTRAS>
        <FOTOS>(hasta 25)
            <IMG>http://link a la foto</IMG>(texto hasta 150)
        </FOTOS>
    </ad> */
													   

        $i=0;
        if(!empty($feeds)){
			
            foreach ($feeds->ad as $item) {  
				
				//print_r($item);
				
				$descripcion = $item->TEXTOAVISO;
				if( strpos( $descripcion, '_NC' ) === false ){

					$titulo = $item->TITULO;	
					$idCW = $item->ID;

					foreach ($lista_estados as $li)
					{
						if($li[4] == $item->ESTADO) {
							$estado = $li[0];
							break;
						}
					}

					foreach ($lista_operaciones as $li)
					{
						if($li[6] == $item->NEGOCIO) {
							$IdTipoOperacion = $li[0];
							break;
						}
					}

					foreach ($lista_inmuebles as $li)
					{
						if($li[5] == $item->TIPO) {
							$IdTipoInmueble = $li[0];
							break;
						}
					}

					foreach ($lista_deptos as $li)
					{
						if($li[0] == $item->DEPTO) {
							$depto = $li[1];
							break;
						}
					}

					foreach ($lista_zonas as $li)
					{
						if($li[0] == $item->ZONA && $li[1] == $item->DEPTO) {
							$zona = $li[2];
							break;
						}
					}
					
					$mascotas = '0';
					$parrillero = '0';
					//$azotea = '0';
					$jardin = '0';
					//$vivienda_social = '0';
					$barrio_privado = '0';
					$aire_acondicionado = '0';
					$amueblado = '0';
					
					$latitud = $item->LAT;
					$longitud = $item->LNG;
					
					if($item->GARAGE == "True") $garage = '1'; else $garage = '0';
					$arrayExtras = explode(",",$item->EXTRAS);
					foreach ($arrayExtras as $extra){
						if (strpos($extra, ":") !== false) {
							$extra2 = explode(":",$extra);
							if($extra2[0]=='Vehiculos') $garage = $extra2[1];
							//echo $extra2[0].':'.$extra2[1];
						}
						else {
							if($extra == 'Mascota') $mascotas = '1';
							else if($extra == 'Barrio Privado') $barrio_privado = '1';
							else if($extra == 'Parrillero') $parrillero = '1';
							else if($extra == 'Calefaccion') $aire_acondicionado = '1';
							else if($extra == 'Patio') $jardin = '1';
							else if($extra == 'Muebles' or $extra == 'Amoblado') $amueblado = '1';
							//echo $extra;
						}
						//echo ' -- ';
					}

					$IdLocalidad = $depto.", ".$zona;
					$Precio = $item->PRECIO;
					if($item->MONEDA =="0") $IdUnidadPrecio = "USD";
					else  $IdUnidadPrecio = "UYU";
					$expensas = $item->EXPENSAS;
					$IdUnidadGastosComunes = '$';	
					$GastosComunesMonto = (int)preg_replace('/\D/ui','',$expensas);
					$SuperficieConstruida = $item->AREAEDIFICADA;
					$SuperficieTotal = intval($item->AREA);
					if(strpos($item->AREA, "Hect")) $SuperficieTotal = $SuperficieTotal * 10000;
					
					$IdDormitorios = $item->DORM;
					$IdBanios = $item->BATH;

					$publicado = "1"; 

					$fechaIng = $item->ING;
					$fecha = date("d/m/Y", strtotime($fechaIng));
					//echo '$fecha '.$fecha;
					
					$editar = false;
					//if($actualizar_propiedades){
						$sqlSelect = $conn->prepare("SELECT * FROM propiedades WHERE idCasasWeb='$idCW' LIMIT 1 ");
						$sqlSelect->execute();
						while( $row = $sqlSelect->fetch() ) 
						{
	/*//////////////////////
	ACÁ ENTRA SI LA PROPIEDAD YA EXISTE, PARA ACTUALIZAR CUALQUIER CAMBIO QUE HAYA PODIDO HACER EL USUARIO EN CASASWEB DE ESTA PROPIEDAD.
	//////////////////////*/
							$editar = true;
							$idEditar = $row['id'];
							$sql = "UPDATE propiedades SET titulo='$titulo', 
							IdTipoInmueble='$IdTipoInmueble',IdTipoOperacion='$IdTipoOperacion',IdLocalidad='$IdLocalidad',
							Precio='$Precio',SuperficieConstruida='$SuperficieConstruida',SuperficieTotal='$SuperficieTotal',
							IdDormitorios='$IdDormitorios',IdBanios='$IdBanios', garage='$garage' , mascotas='$mascotas', barrio_privado='$barrio_privado', parrillero='$parrillero', aire_acondicionado='$aire_acondicionado', jardin='$jardin', amueblado='$amueblado', GastosComunesMonto='$GastosComunesMonto' ,descripcion='$descripcion',IdUnidadPrecio='$IdUnidadPrecio',IdUnidadGastosComunes='$IdUnidadGastosComunes', fecha='$fecha',estado='$estado' WHERE id='$idEditar' && idCasasWeb='$idCW'";
							$conn->exec($sql);
							echo 'YA EXISTE ESA PROPIEDAD id:'.$idEditar.' idCasasWeb:'.$idCW;
	/*//////////////////////
	EN CASO DE QUERER ACTUALIZAR LAS FOTOS $actualizar_fotos = true;
	Esto lo hice así porque a veces demora bastante, y no siempre hacen actualizaciones de fotos.
	Por defecto está en false.
	//////////////////////*/
							if($actualizar_fotos){
								
								$sql = "DELETE FROM fotos WHERE id_referencia=$idEditar && tipo='foto' ";
								$conn->exec($sql);
								usleep(100000);
								$orden = 1;
								$foto = '';

								foreach ($item->FOTOS->IMG as $foto) {
									//echo ' --- foto: '.$foto;
									$fotoThumb = $foto;
									if( strpos( $foto, 'edificios' ) !== false ){
										$fotoFinal = $fotoThumb;
									}else{
										$porciones = explode("/", $foto);
										$ultimo = count($porciones) - 1;
										$fotoSola = $porciones[$ultimo];
										$fotoFinal = 'https://casasweb.com/fotos/'.str_replace('u', '', $fotoSola);
									}

									try { 
										$sqlImg = "INSERT INTO fotos (foto,id_referencia,tipo,seccion,orden,nombre,url,foto_thumb) VALUES ('$fotoFinal','$idEditar','foto','propiedades',$orden,'','https://casasweb.com/','$fotoThumb')";

										$conn->exec($sqlImg);
										$orden++;
										}
									catch(PDOException $e)
									{
										$error = $sql . "<br>" . $e->getMessage();
										break;
									}
								}
							}
						}
					//}
							
			
					if(!$editar){
						try {
							$sql = "INSERT INTO propiedades
							( 
							titulo,IdTipoInmueble,IdTipoOperacion,IdLocalidad,Precio,SuperficieConstruida,SuperficieTotal,IdDormitorios,IdBanios,garage,mascotas,barrio_privado,parrillero,aire_acondicionado,jardin,amueblado,latitud,longitud,
							GastosComunesMonto,descripcion,IdUnidadPrecio,IdUnidadGastosComunes,inmobiliaria,estado, fecha,publicado,milugar,idCasasWeb)values 
							('$titulo','$IdTipoInmueble','$IdTipoOperacion','$IdLocalidad','$Precio','$SuperficieConstruida','$SuperficieTotal','$IdDormitorios','$IdBanios','$garage'
							,'$mascotas','$barrio_privado','$parrillero','$aire_acondicionado','$jardin','$amueblado','$latitud','$longitud',
							'$GastosComunesMonto','$descripcion','$IdUnidadPrecio','$IdUnidadGastosComunes','$usuario_id','$estado','$fecha','$publicado','1','$idCW')";

							$conn->exec($sql);
							$entrada_id = $conn->lastInsertId();
							echo '<br>Propiedad NUEVA idCasasWeb: '.$idCW.' - id '.$entrada_id;  

							$orden = 1;
							$foto = '';

							foreach ($item->FOTOS->IMG as $foto) {
								//echo ' --- foto: '.$foto;
								$fotoThumb = $foto;
								
								if( strpos( $foto, 'edificios' ) !== false ){
									$fotoFinal = $fotoThumb;
								}else{
									$porciones = explode("/", $foto);
									$ultimo = count($porciones) - 1;
									$fotoSola = $porciones[$ultimo];
									$fotoFinal = 'https://casasweb.com/fotos/'.str_replace('u', '', $fotoSola);
								}

								try { 
										$sqlImg = "INSERT INTO fotos (foto,id_referencia,tipo,seccion,orden,nombre,url,foto_thumb) VALUES ('$fotoFinal','$entrada_id','foto','propiedades',$orden,'','https://casasweb.com/','$fotoThumb')";

									$conn->exec($sqlImg);
									//echo '<br>sqlImagen: '.$sqlImg;
									$orden++;
									}
								catch(PDOException $e)
								{
									$error = $sql . "<br>" . $e->getMessage();
									break;
								}
							}
						}
						catch(PDOException $e)
						{
							$error = $sql . "<br>" . $e->getMessage();
							break;
						}
					}

					$i++;
					echo "<br>";
				}else{
					echo 'La quiere excluir de la importacion';
				}
			}
        }else{
             echo "<h2>No item found</h2>";
        }
			echo "<br>Cant de propiedades: ".$i;
    ?>
        </div>
    </body>
</html>


<?php	
	
	## A comntimnuacion hacemos varias consultas a la BBDD 
	## para saber las caracteristicas del personaje
	
	$idjugador = $_SESSION['idjugador'];
	$idpersonaje = $idjugador; // Alias
	
	# Atributos del personaje
	
	$info_personaje = $db -> query("select * from personajes where id=$idjugador");
	$atributo = mysqli_fetch_array($info_personaje);
		
	$nombre = $atributo['nombre']; 
	$dinero = $atributo['dinero']; 
	$fecha = $atributo['fecha']; 
	
	
	## Recuperamos los valores de la BBDD con unas simples consultas que almacenan los arrays con un sencillo nombre
	$faccion = $db -> query("select * from facciones where id=(select idfaccion from personaje_facciones where idpersonaje='$idjugador')");
	$faccion = mysqli_fetch_array($faccion);
	
	$ciudad = $db -> query("select * from ciudades where id=(select idciudad from personaje_ciudades where idpersonaje='$idjugador');");
	$ciudad = mysqli_fetch_array($ciudad);
	
	$tienda = $db -> query("select * from tiendas where id={$ciudad['idtienda']}");
	$tienda = mysqli_fetch_array($tienda);
	
	$barcos_personaje = $db -> query ("select idbarco from personaje_barcos where idpersonaje='$idjugador'");
	
	while ($barco = mysqli_fetch_array($barcos_personaje)) {
		$barcos[] = $barco[0];
	}
	
	$habilidades = $db -> query("select * from personaje_habilidades_general where id='$idjugador'");
	$habilidades = mysqli_fetch_array($habilidades);

	echo " <h4>IDJugador: $idjugador IDfaccion: $faccion[0] IDciudad: {$ciudad['id']} IDbarco: {$barco['id']} Nombre: {$atributo['nombre']} Dinero: $dinero Fecha: $fecha</h4>";
	
	?>
	<section>
			<table class='datos_jugador'>
			  <tr class='info-tr'>
				<td class='info_td'> Nombre:<?=' '.$atributo['nombre']?></td>
				<td class='info_td'>Ciudad:<?=' '.$ciudad['nombre']?></td>
				<td class='info_td'>Barcos:<?=' ' . count($barcos)?></td>
			  </tr>
			  <tr class='info-tr'>
				<td class='info_td' >Facción:<?=' '.$faccion['nombre']?></td>
				<td class='info_td'> P. Experienci:<?=' '.$habilidades['experiencia'] ?></td>
				<td class='info_td'> Dinero:<?=' '.$atributo['dinero'] ?></td>
			  </tr>
			  <tr class='info-tr'>
				<td class='info_td'></td>
				<td class='info_td'><input type='submit' name='atras' value='Atras'></td>
				<td class='info_td'><input type='submit' name='salir' value='Cerrar Sesión'></td>
			  </tr>
			</table>
		</section>

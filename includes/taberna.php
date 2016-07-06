<?php
### Recuperamos la informacion de la taberna en base 
### a la variable obtenida de la consulta global $ciudad[2]

$tabernas = mysqli_query($db,"SELECT * FROM tabernas WHERE id=$ciudad[2]");
$taberna = mysqli_fetch_array($tabernas);
  
if (!empty($_POST['n_piratas']) && isset($_POST['contratar']) && !empty($_POST['id_barco'])) {
	## Recoenos el id del barco seleccionado
	$idbarco = $_POST['id_barco'];
	
	## Recogemos el numero de piratas a contratar y los existentes en la taberna
	$n_piratas_cotratar = $_POST['n_piratas'];
	$n_piratas_taberna = $taberna['n_piratas'];
	
	## Recogemos los piratas asignados en el momento en el barco
	$existentes = $db -> query("SELECT * from barcos where id=$idbarco");
	$barco = mysqli_fetch_array($existentes);
	
	$max_piratas_barco = $barco['max_piratas'];
	$n_piratas_barco = $barco['n_piratas'];
	
	## Comprobamos el valor monetario de los piratas
	$valor_pirata = $taberna['valor_pirata'];

	
			## Si no hay piratas en la taberna
			if ($n_piratas_taberna==0) {
				volver_taberna("No hay disponibles piratas en este momento");
				}
					
			## Si el numero de piratas a contratar es negativo
			elseif ($n_piratas_cotratar<0) {
				volver_taberna("Has seleccionado un numero negativo");
				}
				
			## Si el numero de piratas por el valor de cada uno excede el dinero actual no permite la compra
			elseif (($dinero < $valor_pirata*$n_piratas_cotratar)) {
				volver_taberna("No tienes suficiente dinero marinero");
				}
				
			## Si el numero de piratas a contratar mas el numero de piratas en el barco excede 
			## el maximo de piratas en el barco, impide la transaccion
			elseif (($n_piratas_cotratar+$n_piratas_barco) > $max_piratas_barco) {
				volver_taberna("No puedes contratar mas piratas de los que tienes");
				} 
			else {
				
				## Si todo va bien debemos restar el coste de los
				## piratas del bolsillo del personaje
				$nuevo_dinero = $dinero-($valor_pirata*$n_piratas_cotratar);
			    $db -> query("UPDATE personajes SET dinero='$nuevo_dinero' where id=$idjugador");
				
				## Sumar los piratas a los existentes en el barco
			    $nuevo_num_piratas_barco = $n_piratas_cotratar+$n_piratas_barco;
				$db -> query("UPDATE barcos SET n_piratas='$nuevo_num_piratas_barco' where id=$idbarco");
				
				## Aumentamos diferentes parametros del personaje como los puntos de experiencia,labia e inteligencia
				$db -> query("UPDATE personaje_habilidades_general SET experiencia=experiencia+1,labia=labia+1,inteligencia=inteligencia+1 where id=$idjugador");
				
				?>
				<script type='text/javascript'>document.location.href='/menu.php?action=menu.php&mensaje=<?=$nombre?>';</script>
				<?php
				}
	
	
				echo "<h1>Contratar: $n_piratas_cotratar Taberna: $n_piratas_taberna Max_piratas_barco: $max_piratas_barco Numero_piratas_Barco: $n_piratas_barco Valor_pirata: $valor_pirata</h1>";
	
	}
elseif (isset($_POST['atras'])) {
	header ("Location: menu.php?action=menu.php"); 
	}
//~ elseif (empty($_POST['id_barco'])) {
	//~ volver_taberna("Seleccione un barco capitan");
	//~ }
elseif (empty($_POST['n_piratas']) && isset($_POST['contratar'])) {
	volver_taberna("¿Cuantos quiere contratar capitan? ¿0?");
	}
else {
	## El maximo numero de piratas a contratar es la resta entre el nª de piratas del barco y 
	## el máximo perimito
	
	$max_barco = $barco['max_piratas']-$barco['n_piratas'];
	
	if ($max_barco>$taberna['n_piratas']) {
		$maximo=$max_barco;
		}
	else {
		$maximo=$taberna['n_piratas'];
		}
	?>
		<tr>
			<td><h1><?=$taberna[1]?></h1></td>
		</tr>
		<tr>
			<td>Marineros en la Taberna: <?=$taberna[2]?></td>
			<td>Precio: <?=$taberna[3]?></td>
		</tr>
		<?php
		mensaje();
		?>
		<tr>
			<td><br></td>
		</tr>
		<tr>
			<td>
			<select name='id_barco'>
				<option value=''>Barco...</option>
				<?php
				foreach ($barcos as $ship) {
					$barco = $db -> query("select * from barcos where id=$ship");
					$barco = mysqli_fetch_array($barco)
					?>
					<option value='<?=$barco['id']?>'><?=$barco['nombre']?></option>
					<?php
					}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td><input type='number' max="<?=$maximo?>" name='n_piratas'></td>
			<td><input type='submit' name='contratar' value='Contratar'></td>
		</tr>
	<?php
}

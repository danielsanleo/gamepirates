<?php
### Recuperamos la informacion de l barco que tiene el personaje en caso de que disponga de uno

if (!empty($_POST['id_barco'])) {
	
	$idbarco = $_POST['id_barco'];	
	$barco = $db -> query ("SELECT * FROM barcos where id='$idbarco'");
	$barco = mysqli_fetch_array($barco);
	
	?>
	<table>
	<tr>
		<td class='titulo'><h3>Características del barco: </h3></td>
	</tr>
	<tr>
		<td>Nombre:<?=' ' .$barco['nombre']?></td>
		<td>Valor:<?=' ' .$barco['valor']?></td>
		<td>Casco:<?=' ' .$barco['casco']?></td>
	</tr>
	<tr>
		<td class='titulo'><h3>Equipamiento: </h3></td>
	</tr>
	<tr>
		<td>Nº piratas:<?=' ' .$barco['n_piratas']?></td>
		<td>Nº velas:<?=' ' .$barco['n_velas']?></td>
		<td>Nº Max.canones:<?=' ' .$barco['max_canones']?></td>
	</tr>
	<tr>
		<td>Nº Max. piratas:<?=' '  .$barco['max_piratas']?></td>
		<td>Max. velas:<?=' ' .$barco['max_velas']?></td>
		<td>Max. casco:<?=' ' .$barco['max_casco']?></td>
		<td>Nº canones:<?=' ' .$barco['n_canones']?></td>
	</tr>
	<tr>
		<td>Comentario:<?=' ' .$barco['comentario']?></td>
	</tr>
	</table>
	<?php
	}
else {
	?>
	<tr>
		<td>Selecciona un barco:</td>
	</tr>
	<tr>
		<td>
		<select form='form_menu' name='id_barco' onchange='this.form.submit()'>
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
	<?php
}

<?php

if (isset($_POST['comprar'])) {
	
	$atributos = $db -> query("show columns from productos");
	$total_columnas =  mysqli_num_rows($atributos);
	
	## Recogemos el array con el id de los productos a comprar de la tienda
	foreach($_POST['productos_tienda'] as $idproducto => $cantidad) {
		
		if (!empty($cantidad)) {
			## Realizamos las validaciones
				
				$productos = $db -> query("SELECT * from tienda_productos where id_tienda={$ciudad['idtienda']} AND id_producto=$idproducto");
				$producto = mysqli_fetch_array($productos);
				
				# Si el numero de productos a comprar es mayor que el stock --> error 
				if ($cantidad > $producto['stock']) {
					volver_tienda("La cantidad es mayor que el stock de la tienda: {$producto['stock']}");
					}
				# Si el numero es negativo
				elseif ($cantidad < 1) {
					volver_tienda("¿Cuanto?");
					}
				
				# Si el valor de los productos a comprar es mayor que el dinero del jugador --> error
				elseif ($cantidad*$producto['valor'] > $dinero) {
					volver_tienda("No tienes suficiente dinero para realizar a compra: {$producto['stock']}");
					}
				
				# Si todo va bien añadimos el producto al personaje
				# Los restamos del stock de la tienda
				# Sumamos experiencia y labia al personaje
				else {
					
					//~ echo "Añadir el producto con id: $idproducto al personaje: $idpersonaje";
					
					$nuevo_productos_tienda = $producto['stock'] - $cantidad;
					$nuevo_productos_personaje = $cantidad;
					
					$nuevo_dinero_tienda =  $tienda['dinero'] + $cantidad*$producto['valor'];
					$nuevo_dinero_personaje = $dinero - ($cantidad*$producto['valor']);
					
					$db -> query("UPDATE tienda_productos SET stock='$nuevo_productos_tienda' where id_producto='$idproducto' and id_tienda='{$ciudad['idtienda']}'");
					
					$db -> query("UPDATE tiendas SET dinero='$nuevo_dinero_tienda' where id='{$ciudad['idtienda']}'");
					
					$db -> query("UPDATE personajes SET dinero='$nuevo_dinero_personaje' where id='$idpersonaje'");
					
					# Añadimos un nuevo item al personaje
					$existe = $db -> query("SELECT * from personaje_items where iditem=$idproducto and idpersonaje=$idpersonaje");
					
					// Si el tipo de objeto ya lo tiene el personaje se suma al total
					if (mysqli_num_rows($existe)==1) {
						
						$YaLoTiene = mysqli_fetch_array($existe);
						
						// Hacemos la suma
						$cantidad = $cantidad + $YaLoTiene['cantidad'];
								
						$db -> query("UPDATE personaje_items SET 
										cantidad=$cantidad 
										WHERE iditem={$YaLoTiene['iditem']} 
										AND idpersonaje=$idpersonaje");
						}
					else {
						
						$db -> query("INSERT INTO personaje_items SET 
										idpersonaje=$idpersonaje,
										iditem=$idproducto,
										cantidad=$nuevo_productos_personaje,
										valor={$producto['valor']},
										valor_anterior={$producto['valor']},
										descripcion='{$producto['descripcion']}'") OR DIE("MAL insert personaje_items");
					}
					
					if ($nuevo_productos_tienda==0) {
							$db -> query("DELETE FROM tienda_productos WHERE id_producto=$idproducto AND id_tienda={$ciudad['idtienda']}")or die("Morir");
							}
				}
			}
		}
		
	## Recogemos el array con el id de los productos a vender a la tienda
	if (!empty($_POST['productos_personaje'])) {
		
		foreach($_POST['productos_personaje'] as $iditem => $cantidad) {
			
				## Realizamos las validaciones
				if (!empty($cantidad)) {
					
					$personaje_items = $db -> query("select * from personaje_items where idpersonaje=$idpersonaje AND iditem=$iditem");
					$personaje_item = mysqli_fetch_array($personaje_items);
					
					# Si el numero de productos a venver es mayor que la cantidad que tiene el personaje --> error 
					if ($cantidad > $personaje_item['cantidad']) {
						volver_tienda("La cantidad a vender es mayor que la que posees {$personaje_item['cantidad']}");
						}
					# Si el numero es negativo
					elseif ($cantidad < 1) {
						volver_tienda("¿Cuanto?");
						}
					
					# Si el valor de los productos a comprar es mayor que el dinero de la tienda --> error
					elseif ($cantidad*$personaje_item['valor'] > $tienda['dinero']) {
						volver_tienda("La tienda no tiene suficiente dinero para pagarte: {$tienda['dinero']} $");
						}
					
					# Si todo va bien añadimos el producto la tienda
					# Los restamos de la cantidad del personaje
					# Sumamos experiencia y labia al personaje
					else {
						
						//~ echo "Añadir el producto con id: $iditem la tienda: {$tienda['id']}";
						
						$existe = $db -> query("SELECT * FROM tienda_productos WHERE id_tienda={$tienda['id']} AND id_producto=$iditem;");
						
						if (mysqli_num_rows($existe)==1) {
							
							$datos_tienda = mysqli_fetch_array($existe);
							
							$nuevo_productos_tienda = $datos_tienda['stock'] + $cantidad;
							
							$db -> query("UPDATE tienda_productos SET 
											stock='$nuevo_productos_tienda' 
											where id_producto='$iditem' and id_tienda={$tienda['id']}");
							
							}
						else {
							
							$db -> query("INSERT INTO tienda_productos SET 
											id_tienda={$tienda['id']},
											id_producto=$iditem,
											stock=$cantidad,
											valor={$personaje_item['valor']},
											descripcion='{$personaje_item['descripcion']}'") OR DIE("MAL insert tienda Items");
							}
							
						$nuevo_productos_personaje = $personaje_item['cantidad'] - $cantidad;
						
						$db -> query("UPDATE personaje_items SET cantidad=$nuevo_productos_personaje where iditem=$iditem");
						
						if ($nuevo_productos_personaje==0) {
							$db -> query("DELETE FROM personaje_items WHERE iditem=$iditem AND idpersonaje=$idpersonaje");
							}
						
						$nuevo_dinero_tienda =  $tienda['dinero'] - $cantidad*$personaje_item['valor'];
						$nuevo_dinero_personaje = $dinero + ($cantidad*$personaje_item['valor']);
						
						$db -> query("UPDATE tiendas SET dinero='$nuevo_dinero_tienda' where id='{$tienda['id']}'");
						
						$db -> query("UPDATE personajes SET dinero='$nuevo_dinero_personaje' where id='$idpersonaje'");
						
						}
					}
				}
			 }
	 volver_tienda("Transacción realizada correctamente");
	}
else {
	if (!empty($ciudad['idtienda']) || $ciudad['idtienda']==0) {
		
		## Recuperamos la informacion relacionada con los items del personaje
		$tienda = $db -> query("SELECT * from tiendas where id={$ciudad['idtienda']}");
		
		if ($tienda = mysqli_fetch_array($tienda)) {
			$tienda_productos = $db -> query("SELECT * from tienda_productos where id_tienda={$tienda['id']} ORDER BY id_producto asc") or die ("asd");
			}
		
		mensaje();
		
		?>
		<table class='personaje_tienda'>
			<tr>
				<td><h3>Tienda:</h3> <?=$tienda['nombre'].' <br> <strong>Dinero:</strong> '.$tienda['dinero'].' $'?></td>
				<td> Valor </td>
				<td> Stock </td>
				<td> Comprar </td>
			</tr>
			<?php
			while ($tienda_producto = mysqli_fetch_array($tienda_productos)) {
				$producto = $db -> query("SELECT * FROM productos WHERE id={$tienda_producto['id_producto']}");
				$producto = mysqli_fetch_array($producto);
				
				?>
				<tr>
					<td> <?=$producto['nombre']?></td>
					<td> <?=$tienda_producto['valor']?> $</td>
					<td> <?php if ($tienda_producto['stock']==0) { echo "Agotado!!"; } else { echo $tienda_producto['stock'];} ?> </td>
					<td> <input type='number' max="<?=$tienda_producto['stock']?>" name='productos_tienda[<?=$producto['id']?>]'></td>
				</tr>
				<?php
				}
			?>
		</table>
		<?php
		
		## Recuperamos la informacion de la tienda a traves de 
		## la variable que contiene el id de la tienda
		
		$lista_items = $db -> query("select iditem,cantidad,valor from personaje_items where idpersonaje=$idpersonaje");
		

		?>
		<table class='personaje_tienda'>
			<tr>
				<td><h3>Personaje:</h3><?=$nombre.' <br> Dinero: '.$dinero.' $'?></td>
				<td> Valor </td>
				<td> Cantidad </td>
				<td> Vender </td>
			</tr>
			<?php
			while ($item = mysqli_fetch_array($lista_items)) {
				$objeto = $db -> query("SELECT * from productos where id={$item['iditem']}");
				$objeto = mysqli_fetch_array($objeto);
				?>
				<tr>
					<td> <?=$objeto['nombre']?></td>
					<td> <?=$item['valor']?> $</td>
					<td> <?=$item['cantidad']?> </td>

					<td><input type='number' max="<?=$item['cantidad']?>" name='productos_personaje[<?=$objeto['id']?>]'></td>
				</tr
				<?php
				}
			?>
			<tr>
				<td></td>
				<td><input type='submit' name='comprar' value='Comprar'></td>
			</tr>
		</table>
		
		
		<?php
		}
	else {
		header ("Location: menu.php?action=menu.php"); 
	}
}

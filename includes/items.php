<?php
// Comprobamos si se han elegido items a eliminar
if (!empty($_POST['operacion'])) {
	foreach ($_POST['operacion'] as $iditem => $valor) {
		if (!empty($iditem) && !empty($valor)) {
			$cantidad = $db -> query("SELECT cantidad FROM personaje_items WHERE idpersonaje=$idpersonaje AND iditem=$iditem") or die ("Mal cantidad");
			$cantidad = mysqli_fetch_array($cantidad);
			// Cantidad actual - valor = cantidad final 
			$cantidad_final = $cantidad[0] - $valor;
			
			# Si la cantidad a eliminar es mayor que lo que posee el personaje -> error
			if ($cantidad_final<1) {
				volver_items("La cantidad a eliminar es mayor de la que dispones");
				}
			# En caso contrario actualizamos la cantidad del personaje
			else {
				$db -> query("UPDATE personaje_items SET cantidad=$cantidad_final WHERE idpersonaje=$idpersonaje AND iditem=$iditem") or die ("Mal Actualizar");
				volver_items("Items eliminados");
				}
			}
		}
	}

require("clases/clase_base.php");
$base = new base;

$base -> consulta = "SELECT imagen,nombre,cantidad,valor,descripcion,iditem AS Eliminar 
						FROM personaje_items INNER JOIN productos 
						ON personaje_items.iditem=productos.id  
						WHERE idpersonaje=$idpersonaje";

$base -> tabla_primera_width = '75%';
$base -> tabla_titulo = "Items del personaje: ";

$base -> tabla_imagen = 'images/cofre.png';
$base -> tabla_ruta = 'menu.php?action=items.php';

$base -> columna = array('0' => 'imagen','5' => 'operacion');

$base -> animacion = array('1' => 'fadeIn','0' => 'fadeIn', '2' => 'fadeIn', '3' => 'fadeIn','4' => 'fadeIn','5' => 'fadeIn');
$base -> nuevo_registro=0;
$base -> tabla();

?>

<?php
function limpiarArray($array) {
		$array = array_map('trim', $array);
		$array = array_map('stripslashes', $array);
		return $array;
		
		}
?>

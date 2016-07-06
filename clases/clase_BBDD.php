<?php
class BBDD
{
	
	## Clase diseñada para manipular facilmente la BBDD del juego
	## Contiene consultas basicas para cada una de las tablas
	
	public $conexion = $db;
	
	public $incio_query;
	
	public $tabla_personajes = ' personajes ';
	public $tabla_barcos = ' barcos ';
	public $tabla_personajes = ' personajes ';
	
	
	public $campo;
	
	public $nuevo_valor;
	
	
	function barcos($this->campo,$this->nuevo_valor) {
		
		$sql="UPDATE personajes SET $campo='$nuevo_valor' where id=$idjugador";
		echo "$sql";
		exit;
		$conexion -> query("");
		}
	
}
?>

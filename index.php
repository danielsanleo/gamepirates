 <!DOCTYPE html>
<html>
	<head>
		<title>Pirates!</title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
		<script type="text/javascript" src="crafty.js"></script>
	</head>
		<body>
			<form method='POST' action='#' id="form1"> 
<?php

require("includes/conexion.php");


## Script JavaScript para volver al index
function volver($mensaje) {
		echo "<script type='text/javascript'>
					document.location.href='index.php?action=index.php#&mensaje=$mensaje';
			  </script>";
		}


## Comprobamos si el usuario ha iniciado sesiopn, en caso de que no se asi, 
## mostramos los camos para ingresar su usuario y contraseña

//~ if (!empty($_SESSION['idusuario'])) {
	//~ header ("Location: index.php");
	//~ }
//~ if {
if (isset($_POST['sesion'])) {
	
	$usuario = $_POST['usuario'];
	$clave = $_POST['clave'];
	
	$existe = $db -> query("select idpersonaje from usuarios where nombre='$usuario' and clave=MD5('$clave')");
	if ($existe->num_rows ==1) {
		 $tmp = mysqli_fetch_array($existe);
		 $_SESSION['idjugador'] = $tmp[0];
		 header ("Location: menu.php?action=menu.php"); 
		}
	else {
		header ("Location: index.php"); 
		}
}
else {
	?>
	Usuario:<input name='usuario' type='text'>
	Password:<input name='clave' type='password'>
	<input name='sesion' type='submit' value='Iniciar Sesion'>
	<?php
}
	
?>

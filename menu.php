<?php
require("includes/cabecera.html");
require("includes/conexion.php");
require("includes/info.php");
require("includes/funciones.php");

## A continuacion creamos un sistema de autentificacion 
## De forma que si no existe el id del jugador en la sesion del cliente --> lo redireccionamos al index.
## Puede darse el caso de un 'action' vacio po lo que si tiene el id en la sesión --> sera redireccionado al menu.
## En el caso de querer dar de baja la sesión primero se comprueba si existe la variable de sesion kill, en caso afirmativo se mata la session --> index.php.
 

if (!empty($_SESSION['idjugador'])) {
	
	if (isset($_POST['salir'])) {
		unset($_SESSION['idjugador']);
		header("Location: menu.php"); 
		}
	
	if (isset($_POST['atras'])) {
		header ("Location: menu.php?action=menu.php"); 
		}
	
	$action = $_GET['action'];

	if (!empty($action)) {
		
		include("includes/$action");
		}
	else {
		header ("Location: menu.php?action=menu.php"); 
		}
	}
else {
	header ("Location: index.php"); 
	}
	
include("includes/footer.php");
?>


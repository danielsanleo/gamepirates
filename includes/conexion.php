<?php
## Comienza la sesión
session_start();

## incluimos el archivo config.php
require("config.php");


$db = new mysqli($db_host, $db_usuario,$db_clave, $db_nombre);

?>

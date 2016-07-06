<?php

function mensaje() {
	if (!empty($_GET['mensaje']))
		{
		?>
		<tr>
		<td>
		  <div></div>
		  <table class='mensaje' width="560" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="grass" class="bordeExterior">
			<tr>
			  <td><div align="center"><img src="images/info.png" alt="Informacion" border="0" width="40" align="absmiddle">&nbsp;<?=$_GET['mensaje'];?></div></td>
			</tr>
		   </table>
		</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<?php
		}
	}

function volver($url,$mensaje) {
		echo "<script type='text/javascript'>
					document.location.href='menu.php?action=$ur&mensaje=$mensaje';
			  </script>";
		}

function volver_taberna($mensaje) {
		echo "<script type='text/javascript'>
					document.location.href='/menu.php?action=taberna.php&mensaje=$mensaje';
			  </script>";
		}
function volver_items($mensaje) {
		echo "<script type='text/javascript'>
					document.location.href='/menu.php?action=items.php&mensaje=$mensaje';
			  </script>";
		}
		
function volver_tienda($mensaje) {
		echo "<script type='text/javascript'>
					document.location.href='/menu.php?action=tienda.php&mensaje=$mensaje';
			  </script>";
		}
?>

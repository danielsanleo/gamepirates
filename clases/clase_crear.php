<?php
class clase_crear
{  
  #Form
  public $action='#';
  public $enctype='multipart/form-data';
  public $method='POST';
  public $style_form='margin:0px;';
  public $form_class='';
  public $table_class='';
  public $encabezado='';
  public $imagen_cabecera='';
  public $titulo='';
  public $onsubmit='';
  public $id='';
  public $name='';
  
  #Table
  public $table_color_bg='#FFFFFF';
  public $table_width='100%';
  public $table_2_color_bg='#DDDDDD';
  public $barra = '1';
  public $numero='';
	#IMG
	public $links='';
  
  # Footer
  public $imagen_footer='images/icono-volver.png';
  
  public function cabecera () {
	  ?>
	  
	 <form name="<?=$this->name;?>" id="<?=$this->id;?>" class='<?=$this->form_class;?>' action="<?=$this->action;?>" onsubmit='<?=$this->onsubmit;?>' method="<?=$this->method;?>" enctype="<?=$this->enctype;?>" style="<?=$this->style_form?>">
      <table width="100%" border="0" cellspacing="0" cellpadding="20">
		  <tr>
			<td>
			  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="bordeExterior">
			  <tr>
				<td bgcolor="#F2F2F2" class="bordeAbajo">
				  <table width="100%" border="0" cellpadding="6" cellspacing="0">
					<tr>
					  <td width="2"><a href="<?=$this->links;?>"><img src="<?=$this->imagen_cabecera;?>" alt="visitas" border="0" title="visitas" width="64" /></a></td>
					  <td class="departamento"><?=$this->titulo;?></td>
					</tr>
				  </table>
			    </td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>
				 <?php
				 if (!empty($this->numero)) {
					 ?>
					<div class="textoPeque" style="padding:4px;">Se han encontrado <?=$this->numero?> visitas</div>
					<?php
					}
				  ?>
					<table width="100%" border="0" cellspacing="0" cellpadding="5">
          <?php
          if ($this->barra == 1) {
			?>
			
			
                <tr>
                  <td colspan="4" bgcolor="<?=$this->table_2_color_bg?>" class="bordeaa texto"><div align="center"><strong><?=$this->encabezado;?></strong></div></td>
                </tr>
			
			  <?php
			  }
	  }
	  
  public function form_input_tr($type,$name,$value,$class_td,$class_input,$texto,$align,$size,$id_input) {
	  ?>
	  <tr>
		  <td class='<?=$class_td?>' align="<?=$align?>"><?=$texto?></td>
          <td>
			<input type="<?=$type?>" id='<?=$id_input?>' name="<?=$name?>" value="<?=$value?>" class="<?=$class_input?>" size="<?=$size?>">
		  </td>
	  </tr>
	  <?php
	  }
	  
  //Esta funcion devulve un <td> puede que haga falta especificar <tr> antes
  
  public function form_input_td($type,$name,$value,$class_td,$class_input,$texto,$align,$size) {
	  ?>
		  <td class='<?=$class_td?>' align="<?=$align?>"><?=$texto?></td>
          <td>
			<input type="<?=$type?>" name="<?=$name?>" value="<?=$value?>" class="<?=$class_input?>" size="<?=$size?>">
		  </td>
	  <?php
	  }
	  
  public function input_fecha_td ($name,$texto,$class_td,$min,$max,$align) {
	  // min="2010-05-02"
	  // max="2020-06-01"
	  ?>
	  <tr>
	    <td class='<?=$class_td?>' align="<?=$align?>"><?=$texto?></td>
		<td class='<?=$class_td?>'> 
			<input type="date" min="<?=$min?>" max="<?=$max?>" value="<?=date("Y-m-d");?>" name="<?=$name?>"> 
		</td>
	  </tr>
	  <?php
	  } 
  public function input_hora_td ($name,$texto,$class_td,$align) {
	  ?>
	   <tr>
		<td class='<?=$class_td?>' align="<?=$align?>"><?=$texto?></td>
		<td class='<?=$class_td?>'> <input type="time" name="<?=$name?>" placeholder="hrs:mins " pattern="^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$"> </td>
	   </tr>
	  <?php
	  }
  public function form_terminar () {
	  ?>
		</table>  
        </td>
        </tr>
    </table>
	</form>
	<tr>
			<td bgcolor="#FFFFFF">
			<table width="910" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#FFFFFF" class="bordeExterior">
			<tr>
				<td width="2"><div align="right"><a href="javascript:window.history.back();"><img src="<?=$this->imagen_footer?>" alt="Volver" title="Volver" width="16" height="16" border="0" /></a></div></td>
				<td width="40"><a href="javascript:window.history.back();" class="enlace">atr&aacute;s</a></td>
				<td width="2"><div align="right"><a href="menu.php?action=soporte"><img src="images/icono-soporte.png" alt="Soporte tÃ©cnico" title="Soporte" width="16" height="16" border="0" /></a></div></td>
				<td><a href="menu.php?action=soporte" class="enlace">soporte</a></td>
				<td><div align="right"><a href="salir.php"><img src="images/icono-salir.png" alt="Cerrar" title="Salir" width="16" height="16" border="0" /></a></div></td>
				<td width="80"><a href="salir.php" class="enlace">cerrar sesi&oacute;n</a></td>
			</tr>
		</table>
	  <?php
	  }
	  
  public function recuperar_datos ($id,$tabla) {
	  
	 $datos=mysql_query("select * from $tabla where id='$id'") or die ("Mal Datos cliente");
	 $dato=mysql_fetch_array($datos);
	 
	 
	   $numberfields = mysql_num_fields($datos);
	  
	  for ($i=0; $i<$numberfields ; $i++ ) {
		  
		   $columna = mysql_field_name($datos, $i);
	   ?>
	   
	   <tr>
		  <td align="right" class="texto"><?=$columna?></td>
		  <td class="texto"><strong><?=$dato[$i]?></strong></td>
	   </tr>
	   <?php
	   
	   }
	}

	  
  public function volver ($url,$mensaje) {
		echo "<script type='text/javascript'>
					document.location.href='menu.php?action=$url&mensaje=$mensaje';
			  </script>";
		}
		
  public function mostrar_mensaje ($men) {
	      ?>
		  <tr>
			<td>
			  <div class="limpiar10"></div>
			  <table width="560" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#BBBBBB" class="bordeExterior">
				<tr>
				  <td class="textoBlanco"><div align="center"><img src="images/icoInfo.png" alt="Informacion" border="0" align="absmiddle">&nbsp;<?=$men?></div></td>
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
?>

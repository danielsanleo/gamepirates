<?php
class clase_html
{  
  #Form
  public $consulta='select id,nombre from personajes;';
  
  public $title='Pirates';
  public $filas=array();
 
  public $db_host='localhost';
  public $db_usuario='root';
  public $db_clave='R46N4RL0D8R0K';
  public $db_nombre='pirates';
  
 
  public function cabecera () {
		include_once("includes/cabecera.html");
		
		$db = new mysqli("$this->db_host", "$this->db_usuario","$this->db_clave", "$this->db_nombre");
		$resultados = $db -> query($this->consulta);
		
		while ($fila = mysqli_fetch_array($resultados)) {
			?>
			<strong><?=$fila[1]?><input name='jugador' type='radio' value='<?=$fila[0]?>'></strong>
			<input name='submit' type='submit' value='Elegir jugador'>
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
	
  public function footer() {
	  mysqli_close($db);
	  ?>
			</form>
		</body>
      </html> 
	  <?php
	  
	}
}
?>

<?php include 'menu/menu.php'; ?>
<div class="conteudo">
<table class="full_table_cad" align="center">
<tr>
	<td colspan="4" bgcolor="#C0C0C0" align="center"><b>Gr&aacute;fico de Matr&iacute;culas</b></td>
</tr>
<form action="gerar_grafico.php" method="GET" onsubmit="validarAction(this);return false;">
<tr>
<?php
			include('includes/conectar.php');
		?>
<td><b>Unidade:</b></td>
<td>
		  <select name="unidade" id="unidade" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <?php
				if($user_unidade == "" || $user_iduser == 26){
					$sql = "SELECT distinct unidade
						FROM unidades WHERE categoria <> 0 OR unidade LIKE 'EAD'";
					echo '<option value="">Todas as Unidade</option>';
				} else {
				$sql = "SELECT distinct unidade
						FROM unidades WHERE unidade LIKE '%$user_unidade%'";
					}
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.$row['unidade'].'">'.($row['unidade']).'</option>';
				}
			?>
                            </select> 
</td>
</tr>
<tr>
<td><b>Grupo:</b></td>
<td>
		  <select name="grupo" id="grupo" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <?php
				$sql = "SELECT DISTINCT grupo
						FROM grupos ORDER BY grupo";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.$row['grupo'].'">'.($row['grupo']).'</option>';
				}
			?>
           </select>
</td>
</tr>

<tr>
<td><b>N&iacute;vel:</b></td>
<td>
		  <select name="nivel" id="nivel" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <option value="">- ESCOLHA O N&Iacute;VEL -</option>
		    <?php
				$sql = "SELECT DISTINCT tipo
						FROM cursosead ORDER BY tipo";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.$row['tipo'].'">'.($row['tipo']).'</option>';
				}
			?>
           </select>
</td>
</tr>

<tr>
<td><b>M&oacute;dulo:</b></td>
<td>
           <select name="modulo" id="modulo" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <option value="1" selected="selected">M&oacute;dulo I</option>
            
            <option value="2">M&oacute;dulo II</option>
            <option value="3">M&oacute;dulo III</option>
            
            
 </select>  
</td>
	</tr>   
<tr>
<td><b>Modelo:</b></td>
<td>
<select name="modelo" class="textBox" id="modelo" onKeyPress="return arrumaEnter(this, event)">
      <?php
$sql = "SELECT * FROM ced_filtro WHERE (categoria = 2 AND id_pessoa = 0) OR (categoria = 2 AND id_pessoa LIKE '%$user_iduser%') ORDER BY layout";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_filtro'] . "'>" . $row['layout'] . "</option>";
}
?>
      </select> 
</td> 
</tr>
<tr>
<td colspan="4">
                            <input name="GERAR" type="submit" value="Gerar Gráfico" />     
                            
</td></tr>
</form>
</table>


</div>
  <?php include 'menu/footer.php' ?>



 <script language='JavaScript'>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script> 
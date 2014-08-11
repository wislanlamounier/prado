<?php
include ('menu/menu.php');// inclui o menu
?>
<form action="gerar_rel_inadimplencia.php" method="GET">
<div class="conteudo">
<table class="full_table_cad" align="center" cellpadding="3">
<tr>
<td colspan="4" align="center"><B>FILTRO DE ALUNOS INADIMPLENTES</B></td>
</tr>
<tr>
<td align="right"><B>N&iacute;vel:</B></td>
<td>
<select name="nivel" class="textBox" id="nivel" onKeyPress="return arrumaEnter(this, event)">
<option value="" selected="selected">- Selecione o N&iacute;vel -</option>
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT DISTINCT tipo FROM cursosead WHERE tipo NOT LIKE '%-%' AND tipo NOT LIKE '%profis%' ORDER BY tipo";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['tipo'] . "'>" . $row['tipo'] . "</option>";
}
?>
      </select>
</td>
<td align="right"><b>De:</b></td>
<td>
<input type="date" name="data_inicio" id="data_inicio"/>
</td>
</tr>
<tr>
<td align="right"><B>Curso:</B></td>
<td><select name="curso" class="textBox" id="curso" onKeyPress="return arrumaEnter(this, event)">
        <option value="">- Selecione o Curso -</option>
        
      </select></td>
<td align="right"><b>At&eacute;:</b></td>
<td>
<input type="date" name="data_fim" id="data_fim"/>
</td>
</tr>
<tr>
<td align="right"><B>Ano/M&oacute;dulo:</B></td>
<td ><select name="modulo" class="textBox" id="modulo" onKeyPress="return arrumaEnter(this, event)">
        <option value="" selected="selected">- Selecione o M&oacute;dulo/Ano -</option>
        <option value="1">M&oacute;dulo I</option>
        <option value="2">M&oacute;dulo II</option>
        <option value="3">M&oacute;dulo III</option>
        
      </select></td>
<td colspan="2" align="center"></td>

</tr>
<tr>
<td align="right"><B>Turno:</B></td>
<td ><select name="turno" class="textBox" id="turno" onKeyPress="return arrumaEnter(this, event)">
        <option value="" selected="selected">- Selecione o Turno -</option>
        <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT DISTINCT turno FROM cursosead ORDER BY turno";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['turno'] . "'>" . strtoupper($row['turno']) . "</option>";
}
?>
        
      </select></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>



<tr>
<td align="right"><B>Unidade:</B></td>
<td><select name="unidade" class="textBox" id="unidade" onKeyPress="return arrumaEnter(this, event)">
        <option value="" selected="selected">- Selecione a Unidade -</option>
        <?php
include("menu/config_drop.php");?>
      <?php
	  if($user_unidade == "" || $user_iduser == 26){
		$sql = "SELECT DISTINCT unidade FROM unidades WHERE categoria > 0 OR unidade LIKE '%EAD%' ORDER BY unidade";
	  } else {
		$sql = "SELECT DISTINCT unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' ORDER BY unidade";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . strtoupper($row['unidade']) . "</option>";
}
?>
        
      </select></td>
<td colspan="2"></td>
</tr>
<tr>
<td align="right"><B>Polo:</B></td>
<td ><select name="polo" class="textBox" id="polo" onKeyPress="return arrumaEnter(this, event)">
  <option value="" selected="selected">- Selecione o Polo -</option>
  <?php
include("menu/config_drop.php");?>
  <?php
	  if($user_unidade == "" || $user_unidade == "EAD"){
		$sql = "SELECT DISTINCT unidade FROM unidades WHERE categoria > 0 ORDER BY unidade";
	  } else {
		$sql = "SELECT DISTINCT unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' ORDER BY unidade";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . strtoupper($row['unidade']) . "</option>";
}
?>
  
</select></td>
<td colspan="2" align="center"></td>
</tr>
<tr>
<td align="right"><B>Grupo:</B></td>
<td><select name="grupo" class="textBox" id="grupo" onKeyPress="return arrumaEnter(this, event)">
        <option value="" selected="selected">- Selecione o Grupo -</option>
        <?php
include("menu/config_drop.php");?>
      <?php

		$sql = "SELECT DISTINCT grupo FROM grupos  ORDER BY grupo";
	  
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . strtoupper($row['grupo']) . "</option>";
}
?>
        
      </select></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center" colspan="4"><input class="button" type="submit" value="Pesquisar" /></td>
</tr>
</table>
</div></form>

<?php
include ('menu/footer.php');?>

<script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
	    <script type="text/javascript">
		$(function(){
			$('#nivel').change(function(){
				if( $(this).val() ) {
					$('#curso').hide();
					$('.carregando').show();
					$.getJSON('a1.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="">- Selecione o Curso -</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].curso + '">' + j[i].curso + '</option>';
						}	
						$('#curso').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso').html('<option value="">– Selecione o Curso –</option>');
				}
			});
		});
		</script>
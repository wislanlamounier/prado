<?php
include ('menu/menu.php');// inclui o menu
?>
<form action="gerar_rel_interessados.php" method="GET">
<div class="conteudo">
<table class="full_table_cad" align="center" cellpadding="3">
<tr>
<td colspan="4" align="center"><B>FILTRO DE INTERESSADOS</B></td>
</tr>
<tr>
  <td align="right"><b>Unidade:</b></td>
  <td><select name="unidade" class="textBox" id="unidade" onkeypress="return arrumaEnter(this, event)">
    <option value="" selected="selected">- Selecione a Unidade -</option>
    <?php
include("menu/config_drop.php");?>
    <?php
$sql = "SELECT DISTINCT unidade FROM unidades WHERE categoria > 0 ORDER BY unidade";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
  </select></td>
<td align="right"><b>Modelo:</b></td>
<td><select name="modelo" class="textBox" id="modelo" onkeypress="return arrumaEnter(this, event)">
  <?php
include("menu/config_drop.php");?>
  <?php
$sql = "SELECT * FROM ced_filtro WHERE (categoria = 3 AND id_pessoa = 0) OR (categoria = 3 AND id_pessoa LIKE '%$user_iduser%') ORDER BY layout";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_filtro'] . "'>" . $row['layout'] . "</option>";
}
?>
</select></td>
</tr>
<tr>
  <td align="right"><b>N&iacute;vel:</b></td>
  <td><select name="nivel" class="textBox" id="nivel" onkeypress="return arrumaEnter(this, event)">
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
  </select></td>
<td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td align="right"><b>Curso:</b></td>
  <td><select name="curso" class="textBox" id="curso" onkeypress="return arrumaEnter(this, event)">
    <option value="">- Selecione o Curso -</option>
  </select></td>
<td colspan="2" align="center"></td>

</tr>
<tr>
  <td align="right"><b>Modalidade:</b></td>
  <td ><select name="modalidade" class="textBox" id="modalidade" onkeypress="return arrumaEnter(this, event)">
    <option value="" selected="selected">- Selecione a Modalidade -</option>
    <option value="1">Presencial</option>
    <option value="2">EAD</option>
  </select></td>
  <td colspan="2" align="center"><input name="confirmado" id="confirmado" type="hidden" value="N" /> 
   </td>
</tr>



<tr>
  <td align="right"><b>In&iacute;cio:</b></td>
  <td ><input type="date" name="data_inicio" /></td>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <td align="right"><b>Fim:</b></td>
  <td ><input type="date" name="data_fim" /></td>
<td colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
<td align="right">&nbsp;</td>
<td>&nbsp;</td>
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
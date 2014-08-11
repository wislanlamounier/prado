<?php
include ('menu/menu.php');// inclui o menu
?>
<form action="gerar_rel_prova_escrita.php" target="_blank" method="GET">
<div class="conteudo">
<table class="full_table_cad" align="center" cellpadding="3">
<tr>
<td colspan="4" align="center"><b>Prova Escrita</b></td>
</tr>
<tr>
  <td align="right"><b>Ano / Grade:</b></td>
  <td><select name="anograde" class="textBox" id="anograde" onkeypress="return arrumaEnter(this, event)">
    <option value="" selected="selected">- Selecione a Grade -</option>
    <?php
include("menu/config_drop.php");?>
    <?php
$sql = "SELECT DISTINCT anograde FROM disciplinas";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['anograde'] . "'>" . $row['anograde'] . "</option>";
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
</tr>
<tr>
  <td align="right"><b>Curso:</b></td>
  <td><select name="curso" class="textBox" id="curso" onkeypress="return arrumaEnter(this, event)">
    <option value="">- Selecione o Curso -</option>
  </select></td>

</tr>

<tr>
  <td align="right"><b>Nº Questões (Grau: Baixo):</b></td>
  <td ><input type="text" readonly="readonly" value="5" name="nquestoes_baixo2" />
  <input type="hidden" name="nquestoes_baixo" value="5" /></td>
</tr>
<tr>
  <td align="right"><b>Nº Questões (Grau: Médio):</b></td>
  <td ><input type="text" readonly="readonly" value="3" name="nquestoes_medio2" />
  <input type="hidden" name="nquestoes_medio" value="3"  /></td>
</tr>
<tr>
  <td align="right"><b>Nº Questões (Grau: Alto):</b></td>
  <td ><input type="text" readonly="readonly" value="2" name="nquestoes_alto2" />
  <input type="hidden" name="nquestoes_alto" value="2" /></td>
</tr>
<tr>
  <td align="right"><b>Data da Prova:</b></td>
  <td ><input type="date" name="data" /></td>
</tr>
<tr>
  <td align="right"><b>Valor da Prova:</b></td>
  <td ><input type="text" name="valor" /></td>
</tr>
<tr>
<td align="right">&nbsp;</td>
<td align="right">&nbsp;</td>
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
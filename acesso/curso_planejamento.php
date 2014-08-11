<?php
include ('menu/menu.php');// inclui o menu
include ('includes/conectar.php');// inclui o menu
$get_anograde = $_GET["anograde"];
$get_curso = $_GET["curso"];
$get_nivel = $_GET["nivel"];
$get_modulo = $_GET["modulo"];
?>
<div class="conteudo">
<font size="+2"><center>Planejamentos Previstos</center></font>
<hr />
<form action="filtrar_planejamento.php" method="get">
Selecione a Grade:  <select name="anograde" class="textBox" id="anograde" style="width:auto;">
    <?php
include ('menu/config_drop.php');?>
    <?php

$sql = "SELECT distinct anograde FROM disciplinas ORDER BY anograde DESC";


$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['anograde'] . "'>" . $row['anograde'] . "</option>";
}
?>
  </select>
<input type="submit" value="Pesquisar"/>
</form>
<table class="full_table_cad" border="1" align="center">
<tr>
	<td colspan="2" align="center" bgcolor="#575757"><font color="#FFFFFF"><b><?php echo $get_nivel.": ".$get_curso." - M&oacute;d. ".$get_modulo ;?></b></font></td>
</tr>
<tr>
	<td align="center"><b>Disciplinas</b></td>
    <td align="center"><b>Carga Hor&aacute;ria</b></td>
</tr>
<?php
$sql_disciplinas = mysql_query("SELECT DISTINCT * FROM disciplinas WHERE anograde LIKE '%$get_anograde%' AND curso LIKE '%$get_curso%' AND modulo LIKE '%$get_modulo%' AND nivel LIKE '%$get_nivel%'  ORDER BY disciplina");
while($dados_disc = mysql_fetch_array($sql_disciplinas)){
	$disc_nome = format_curso($dados_disc["disciplina"]);
	$disc_ch = format_curso($dados_disc["ch"]);
	$disc_cod = $dados_disc["cod_disciplina"];

	echo "
	<tr>
		<td align=\"center\"><a href=\"planejamento.php?anograde=$get_anograde&cod_disc=$disc_cod&nivel=$get_nivel&curso=$get_curso\">$disc_nome</a></td>
		<td align=\"center\"><a href=\"planejamento.php?anograde=$get_anograde&cod_disc=$disc_cod&nivel=$get_nivel&curso=$get_curso\">$disc_ch</a></td>
	</tr>
	";
	
}
?>
</table>
</div>
<?php
include ('menu/footer.php');?>
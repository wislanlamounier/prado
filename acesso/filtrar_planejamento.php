<?php
include ('menu/menu.php');// inclui o menu
include ('includes/conectar.php');// inclui o menu
$get_anograde = $_GET["anograde"];
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
<table class="full_table_list" border="1" width="100%">
<tr>
	<td align="center"><b>N&iacute;vel</b></td>
    <td align="center"><b>Curso</b></td>
    <td align="center"><b>M&oacute;dulo</b></td>
    <td align="center"><b>Ano / Grade</b></td>
</tr>
<?php
$sql_cursos = mysql_query("SELECT DISTINCT nivel, curso, modulo, anograde FROM disciplinas WHERE anograde LIKE '%$get_anograde%' ORDER BY nivel, curso, modulo");
while($dados_cursos = mysql_fetch_array($sql_cursos)){
	$curso_nivel = format_curso($dados_cursos["nivel"]);
	$curso_nome = format_curso($dados_cursos["curso"]);
	$curso_modulo = format_curso($dados_cursos["modulo"]);
	$curso_grade = format_curso($dados_cursos["anograde"]);
	echo "
	<tr>
		<td align=\"center\"><a href=\"curso_planejamento.php?nivel=$curso_nivel&curso=$curso_nome&modulo=$curso_modulo&anograde=$curso_grade\">$curso_nivel</a></td>
		<td align=\"center\"><a href=\"curso_planejamento.php?nivel=$curso_nivel&curso=$curso_nome&modulo=$curso_modulo&anograde=$curso_grade\">$curso_nome</a></td>
		<td align=\"center\"><a href=\"curso_planejamento.php?nivel=$curso_nivel&curso=$curso_nome&modulo=$curso_modulo&anograde=$curso_grade\">$curso_modulo</a></td>
		<td align=\"center\"><a href=\"curso_planejamento.php?nivel=$curso_nivel&curso=$curso_nome&modulo=$curso_modulo&anograde=$curso_grade\">$curso_grade</a></td>
	</tr>
	";
	
}
?>
</table>
</div>
<?php
include ('menu/footer.php');?>
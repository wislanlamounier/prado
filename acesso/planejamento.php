<?php
include ('menu/menu.php');// inclui o menu
include ('includes/conectar.php');// inclui o menu
$get_anograde = $_GET["anograde"];
$get_cod_disc = $_GET["cod_disc"];
$get_nivel = $_GET["nivel"];
$get_curso = $_GET["curso"];
$sql_disciplina = mysql_query("SELECT * FROM disciplinas WHERE curso LIKE '%$get_curso%' AND nivel LIKE '%$get_nivel%' AND anograde LIKE '%$get_anograde%' AND cod_disciplina LIKE '%$get_cod_disc%' ORDER BY disciplina");
$dados_disc = mysql_fetch_array($sql_disciplina);
$disc_ch = $dados_disc["ch"];
$disc_nome= format_curso($dados_disc["disciplina"]);
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
<table class="full_table_list" width="40%" border="1" align="center">
<tr>
	<td colspan="4" align="center" bgcolor="#575757"><font color="#FFFFFF"><b><?php echo $disc_nome ;?></b></font></td>
</tr>
<tr>
	<td align="center"><b>Disciplina</b></td>
	<td align="center"><b>N&ordm; Aula</b></td>
    <td align="center"><b>Planejamento</b></td>
    <td align="center"><b>Status</b></td>
    
</tr>
<?php
$aula = 1;
while($aula <= $disc_ch){
	$sql_planejamento = mysql_query("SELECT * FROM conteudo_previsto WHERE n_aula = '$aula' AND cod_disc LIKE '%$get_cod_disc%' AND ano_grade LIKE '%$get_anograde%'");
	if(mysql_num_rows($sql_planejamento)>=1){
		$dados_planejamento = mysql_fetch_array($sql_planejamento);
		$status = $dados_planejamento["arquivo"];
	} else {
		$status = "PENDENTE";	
	}
	echo "
	<tr>
		<td align=\"center\">$disc_nome</td>
		<td align=\"center\">$aula</td>
		<td align=\"center\"><a href=\"javascript:abrir('ver_planejamento.php?aula=$aula&cod_disc=$get_cod_disc')\">[VISUALIZAR]</a> | <a href=\"javascript:abrir('cad_planejamento.php?aula=$aula&cod_disc=$get_cod_disc&anograde=$get_anograde')\">[ALTERAR]</a></td>
		<td align=\"center\"><a href=\"$status\" rel=\"shadowbox\">$status</a></td>
	</tr>
	";
	$aula +=1;
	
}
?>
</table>
</div>
<?php
include ('menu/footer.php');?>
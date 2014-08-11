<?php
include ('menu/menu.php');// inclui o menu
?>
<div class="conteudo">
<?php 
//conecta banco de dados cedtec


$bol = mysql_query("SELECT * FROM  full_aluno_disc WHERE  matricula =  '$user_usuario' AND ano_grade LIKE '%$user_turma_anograde%' AND id_turma = '$user_turma_id_turma' ORDER BY nome_disciplina");
?>
<div class="nota">
<?php 
if($aluno_unidade == "EAD"){
	echo "<a href=\"javascript:abrir('listar_provas_tentativas.php?turma=$user_turma_id_turma');\">[Visualizar Provas Realizadas]</a>";
}

?>

<table width="500px" border="1" bordercolorlight="#CCCCCC" class="full_table_list">
	<th colspan="5"> ACOMPANHAMENTO PEDAG&Oacute;GICO
    </th>
    <th colspan="3"><form action="index.php" method="GET" >Turma: <select style="width:auto;"name="id_turma" id="id_turma" onKeyPress="return arrumaEnter(this, event)">
	<?php
			include('menu/config_drop.php');?>
        <?php
$sql = "SELECT DISTINCT ct.cod_turma, ct.grupo, ct.nivel, ct.curso, ct.modulo, ct.unidade, ct.polo, ct.turno, ct.id_turma 
FROM ced_turma_aluno cta
INNER JOIN ced_turma ct
ON ct.id_turma = cta.id_turma
WHERE cta.matricula = '$user_usuario' AND ct.id_turma NOT IN ('$user_turma_id_turma')";
$result = mysql_query($sql);
$sql_select = "SELECT DISTINCT ct.cod_turma, ct.grupo, ct.nivel, ct.curso, ct.modulo, ct.unidade, ct.polo, ct.turno, ct.id_turma 
FROM ced_turma_aluno cta
INNER JOIN ced_turma ct
ON ct.id_turma = cta.id_turma
WHERE cta.matricula = '$user_usuario' AND cta.id_turma = $user_turma_id_turma
";
$result_select = mysql_query($sql_select);
while ($row2 = mysql_fetch_array($result_select)) {
    echo "<option selected='selected' value='" . ($row2['id_turma']) . "'>" .format_curso($row2['nivel']).": ".format_curso($row2['curso'])." M&oacute;d. ".$row2['modulo']." (".$row2['grupo'].")"."</option>";
}

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . ($row['id_turma']) . "'>" .format_curso($row['nivel']).": ".format_curso($row['curso'])." M&oacute;d. ".$row['modulo']." (".$row['grupo'].")</option>";
}
?>
      </select>
      <input type="submit" value="Ver" />
      </form></th>
	<tr>
		<td><div align="center"><strong>A&Ccedil;&Otilde;ES</strong></div></td>
      <td><div align="center"><strong>DISCIPLINA</strong></div></td>
        <td bgcolor="#D5D5D5"><div align="center"><strong>FALTAS</strong></div></td>
        <td><div align="center"><strong>AVALIA&Ccedil;&Otilde;ES</strong></div></td>
        <td><div align="center"><strong>ATIVIDADES DIVERSIFICADAS</strong></div></td>
        <td><div align="center"><strong>RECUPERA&Ccedil;&Atilde;O</strong></div></td>
        <td><div align="center"><strong>NOTA TOTAL</strong></div></td>
        <td><div align="center"><strong>PROFESSOR / TUTOR</strong></div></td>
		
    </tr>
<?php
if(strtoupper($aluno_unidade) != ""){
while($l2 = mysql_fetch_array($bol)) {
	$cod_disc         = strtoupper($l2["disciplina"]);
	$disciplina         = format_curso($l2["nome_disciplina"]);
	$ano_grade_disc         = $l2["ano_grade"];
	$cod_professor         = $l2["cod_prof"];
	$cod_turmadisc         = $l2["turma_disc"];
	
	
	//pega dados do professor
	$sql_prof = mysql_query("SELECT * FROM ced_professor WHERE cod_user = $cod_professor");
	$dados_prof = mysql_fetch_array($sql_prof);
	$nome_professor = format_curso($dados_prof["Nome"]);
		
	//pega nota_A
	$pesq_nota_A = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $user_usuario AND turma_disc = $cod_turmadisc AND grupo LIKE 'A'  AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
	$dados_a = mysql_fetch_array($pesq_nota_A);
	$contar_nota_a = mysql_num_rows($pesq_nota_A);
	if($contar_nota_a == 0){
		$nota_a = "0,00";
	} else {
		$nota_a = number_format($dados_a["notafinal"], 2, ',', '');
		$nota_a2 = $dados_a["notafinal"];
	}
	
	//pega nota_B
	$pesq_nota_B = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $user_usuario AND turma_disc = $cod_turmadisc AND grupo = 'B' AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
	$dados_b = mysql_fetch_array($pesq_nota_B);
	$contar_nota_b = mysql_num_rows($pesq_nota_B);
	if($contar_nota_b == 0){
		$nota_b = "0,00";
	} else {
		$nota_b = number_format($dados_b["notafinal"], 2, ',', '');
		$nota_b2 = $dados_b["notafinal"];
	}
	
	//pega nota_C
	$pesq_nota_C = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $user_usuario AND turma_disc = $cod_turmadisc AND grupo = 'C'  AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
	$dados_c = mysql_fetch_array($pesq_nota_C);
	$contar_nota_c = mysql_num_rows($pesq_nota_C);
	if($contar_nota_c == 0){
		$nota_c = "0,00";
	} else {
		$nota_c = number_format($dados_c["notafinal"], 2, ',', '');
	}
	
	
	//PEGA AS FALTAS
	$sql_falta = mysql_query("SELECT COUNT(*) as falta_total FROM ced_falta_aluno WHERE matricula = $user_usuario AND turma_disc = '$cod_turmadisc' AND status LIKE 'F' AND DATA IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$cod_turmadisc') ");
	$dados_falta = mysql_fetch_array($sql_falta);
	$falta         = $dados_falta["falta_total"];
	
	
	//VERIFICA SE TEM RECUPERAÇÃO
	if($nota_c =="0,00" || $nota_c<=$nota_a+$nota_b){
		$nota_final = number_format($nota_a2+$nota_b2,2,",",".");
	} else {
		$nota_final = number_format($nota_c,2,",",".");
	}

echo "
	<tr>
		<td><b><a href=\"ea_exercicio.php?cod_disc=$cod_disc&turma_disc=$cod_turmadisc&tipo=1\">[AVALIAÇÃO]</a> | <a href=\"ea_simulado.php?cod_disc=$cod_disc&turma_disc=$cod_turmadisc&tipo=2\">[SIMULADO]</a></b></td>
		<td><b>$disciplina</b></td>
		<td bgcolor=\"#D5D5D5\"><a href=\"javascript:abrir('a_detalhes_falta.php?matricula=$user_usuario&td=$cod_turmadisc');\"><center>$falta</a></center></td>
		<td align=\"center\"><a href=\"javascript:abrir('a_detalhes_nota.php?matricula=$user_usuario&td=$cod_turmadisc&grupo=A');\">$nota_a</a></td>
		<td align=\"center\"><a href=\"javascript:abrir('a_detalhes_nota.php?matricula=$user_usuario&td=$cod_turmadisc&grupo=B');\">$nota_b</a></td>
		<td align=\"center\"><a href=\"javascript:abrir('a_detalhes_nota.php?matricula=$user_usuario&td=$cod_turmadisc&grupo=C');\">$nota_c</a></td>
		<td align=\"center\"><a href=\"javascript:abrir('a_detalhes_nota_geral.php?matricula=$user_usuario&td=$cod_turmadisc');\">$nota_final</a></td>
		<td>$nome_professor</td>
	</tr>";
}	
} else { //else aluno unidade
include('includes/conectar_md.php');
	$sql_moodle_notas = mysql_query("SELECT codaluno, concat(nome,' ',sobrenome) as nome, curso, idnota, idcurso,turma, ROUND(notafinal,2) as notafinal, itemmodulo, ROUND(recupera,2) as recupera, observa FROM nota2 WHERE codaluno = '$user_usuario' AND curso NOT LIKE '%AMB%'");
	while($dados_moodle = mysql_fetch_array($sql_moodle_notas)){
		include('includes/conectar_md.php');
		$nota_final = number_format($dados_moodle["notafinal"],2,",",".");
		$nota_rec = $dados_moodle["recupera"];
		$cod_disc_bruto = explode("- ",$dados_moodle["curso"]); //FAZ 1 EXPLODE DE -
		$cod_disc_2 = explode("_",trim($cod_disc_bruto[1])); // FAZ 2 EXPLODE DE _
		$cod_disc_final = trim($cod_disc_2[0]);
		$ano_grade_disc = trim($cod_disc_2[1]);
		$disc_modulo = substr($cod_disc_final,2,1);
		if($disc_modulo == $aluno_modulo){ // pega apenas disciplinas do módulo atual
		include('includes/conectar.php');
			$sql_disciplina = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '%$cod_disc_final%' AND anograde LIKE '%$ano_grade_disc%'");
			$dados_disciplina = mysql_fetch_array($sql_disciplina);
			$nome_disciplina = $dados_disciplina["disciplina"];
			echo "
			<tr>
				<td> -- </td>
				<td><b>$nome_disciplina</b></td>
				<td bgcolor=\"#D5D5D5\"><center>0</center></td>
				<td align=\"center\">$nota_final</a></td>
				<td align=\"center\">0</a></td>
				<td align=\"center\">$nota_rec</a></td>
				<td align=\"center\">$nota_final</td>
				<td><center>EAD</center></td>
			</tr>";
		}
	}



}
?>	

</table>
<div style="background-color:#E9E9E9" align="right"><?php 
if(strtoupper($aluno_unidade) != "EAD"){
	echo "OBS: Clique sobre a nota para exibir o detalhamento.";
};?></div>
<hr />

<table width="500px" border="1" bordercolorlight="#CCCCCC" class="full_table_list">
	<th colspan="7"> EXTRATO FINANCEIRO
    </th>
	<tr>
		<td><div align="center"><strong>T&Iacute;TULO</strong></div></td>
        <td><div align="center"><strong>PARCELA</strong></div></td>
        <td><div align="center"><strong>VENCIMENTO</strong></div></td>
        <td bgcolor="#D5D5D5"><div align="center"><strong>VALOR</strong></div></td>
        <td><div align="center"><strong>DATA DE PAGAMENTO</strong></div></td>
        <td><div align="center"><strong>VALOR DE PAGAMENTO</strong></div></td>
        <td><div align="center"><strong>2&ordf; VIA</strong></div></td>
		
    </tr>
<?php
include('includes/conectar.php');
$sql_fin = mysql_query("SELECT * FROM geral_titulos WHERE codigo LIKE $user_usuario AND tipo_titulo=2 AND status = 0 ORDER BY vencimento");
while($l_fin = mysql_fetch_array($sql_fin)) {
	$id2         = $l_fin["id_titulo"];
	$layout         = $l_fin["layout"];
	$parcela         = $l_fin["parcela"];
	$vencimento         = substr($l_fin["vencimento"],8,2)."/".substr($l_fin["vencimento"],5,2)."/".substr($l_fin["vencimento"],0,4);
	$data_pagto         = substr($l_fin["data_pagto"],8,2)."/".substr($l_fin["data_pagto"],5,2)."/".substr($l_fin["data_pagto"],0,4);
	$valor_tit         = number_format($l_fin["valor"],2,",",".");
	$valor_pagto         = number_format($l_fin["valor_pagto"],2,",",".");
	if($data_pagto == "//"){
		$data_pagto = "A Pagar";
	}
	//INICIA CALCULO DINÂMICO DE JUROS
		$data_atual = date("Y-m-d");
		$sql_calculo = mysql_query("SELECT t1.id_titulo, t1.vencimento, t1.valor, t1.dias_atraso , 
t1.multa, t1.juros_dia, t1.honorario,
t1.multa+t1.juros_dia+t1.honorario as acrescimos_totais,
t1.valor+t1.multa+t1.juros_dia+t1.honorario as valor_calculado

FROM (
SELECT id_titulo, vencimento,data_pagto, valor_pagto, valor, DATEDIFF(NOW(), vencimento) as dias_atraso,  status,

IF(DATEDIFF(NOW(), vencimento) >=1,0.02*valor,0) as multa,
IF(DATEDIFF(NOW(), vencimento) >=1,((DATEDIFF(NOW(), vencimento)-1)* 0.00233)*valor,0) as juros_dia,
IF(DATEDIFF(NOW(), vencimento) >=11,0.10*(valor+((DATEDIFF(NOW(), vencimento)* 0.00233)*valor)+(0.02*valor)),0) as honorario


FROM titulos 
) as t1
WHERE (t1.data_pagto = '' OR t1.data_pagto IS NULL) AND t1.vencimento < '$data_atual' AND t1.status = 0 AND t1.id_titulo = $id2");
		if(mysql_num_rows($sql_calculo)==1){
			$dados_calculo = mysql_fetch_array($sql_calculo);
			$valor_tit = format_valor($dados_calculo["valor_calculado"]);
		}
	
	echo "
	<tr align='center'>
		<td>&nbsp;$id2</td>
		<td>&nbsp;$parcela</td>	
		<td>&nbsp;$vencimento</td>
		<td>R$&nbsp;$valor_tit</td>	
		<td>&nbsp;$data_pagto</td>
		<td>R$&nbsp;$valor_pagto</td>
		<td>&nbsp;<a href=\"../boleto/$layout?id=$id2&p=$parcela&id2=$user_usuario&refreshed=no\" target='_blank'>[IMPRIMIR]</a></td>
	</tr>
	";
}
	@mysql_close();
	
?>
</table>
</div>
<?php
include ('menu/footer.php');?>
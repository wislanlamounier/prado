<?php
include ('menu/menu.php');// inclui o menu
?>
<div class="conteudo">
<?php 
//conecta banco de dados cedtec


$bol = mysql_query("SELECT * FROM  full_aluno_disc WHERE  matricula =  '$user_usuario' AND ano_grade LIKE '%$user_turma_anograde%' AND id_turma = '$user_turma_id_turma' ORDER BY nome_disciplina");
?>
<div class="nota">
<table width="500px" border="1" bordercolorlight="#CCCCCC" class="full_table_list">
	<th colspan="7"> ACOMPANHAMENTO PEDAG&Oacute;GICO
    </th>
	<tr>
		<td><div align="center"><strong>DISCIPLINA</strong></div></td>
        <td bgcolor="#D5D5D5"><div align="center"><strong>FALTAS</strong></div></td>
        <td><div align="center"><strong>AVALIA&Ccedil;&Otilde;ES</strong></div></td>
        <td><div align="center"><strong>ATIVIDADES DIVERSIFICADAS</strong></div></td>
        <td><div align="center"><strong>RECUPERA&Ccedil;&Atilde;O</strong></div></td>
        <td><div align="center"><strong>NOTA TOTAL</strong></div></td>
        <td><div align="center"><strong>PROFESSOR / TUTOR</strong></div></td>
		
    </tr>
<?php
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
	$pesq_nota_A = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $user_usuario AND turma_disc = $cod_turmadisc AND grupo LIKE 'A'");
	$dados_a = mysql_fetch_array($pesq_nota_A);
	$contar_nota_a = mysql_num_rows($pesq_nota_A);
	if($contar_nota_a == 0){
		$nota_a = "0,00";
	} else {
		$nota_a = number_format($dados_a["notafinal"], 2, ',', '');
		$nota_a2 = $dados_a["notafinal"];
	}
	
	//pega nota_B
	$pesq_nota_B = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $user_usuario AND turma_disc = $cod_turmadisc AND grupo = 'B'");
	$dados_b = mysql_fetch_array($pesq_nota_B);
	$contar_nota_b = mysql_num_rows($pesq_nota_B);
	if($contar_nota_b == 0){
		$nota_b = "0,00";
	} else {
		$nota_b = number_format($dados_b["notafinal"], 2, ',', '');
		$nota_b2 = $dados_b["notafinal"];
	}
	
	//pega nota_C
	$pesq_nota_C = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $user_usuario AND turma_disc = $cod_turmadisc AND grupo = 'C'");
	$dados_c = mysql_fetch_array($pesq_nota_C);
	$contar_nota_c = mysql_num_rows($pesq_nota_C);
	if($contar_nota_c == 0){
		$nota_c = "0,00";
	} else {
		$nota_c = number_format($dados_c["notafinal"], 2, ',', '');
	}
	
	
	//PEGA AS FALTAS
	$sql_falta = mysql_query("SELECT COUNT(*) as falta_total FROM ced_falta_aluno WHERE matricula = $user_usuario AND turma_disc = '$cod_turmadisc' AND status LIKE 'F'");
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
		<td><b>$disciplina</b></td>
		<td bgcolor=\"#D5D5D5\"><a href=\"javascript:abrir('a_detalhes_falta.php?matricula=$user_usuario&td=$cod_turmadisc');\"><center>$falta</a></center></td>
		<td align=\"center\"><a href=\"javascript:abrir('a_detalhes_nota.php?matricula=$user_usuario&td=$cod_turmadisc&grupo=A');\">$nota_a</a></td>
		<td align=\"center\"><a href=\"javascript:abrir('a_detalhes_nota.php?matricula=$user_usuario&td=$cod_turmadisc&grupo=B');\">$nota_b</a></td>
		<td align=\"center\"><a href=\"javascript:abrir('a_detalhes_nota.php?matricula=$user_usuario&td=$cod_turmadisc&grupo=C');\">$nota_c</a></td>
		<td align=\"center\"><a href=\"javascript:abrir('a_detalhes_nota_geral.php?matricula=$user_usuario&td=$cod_turmadisc');\">$nota_final</a></td>
		<td>$nome_professor</td>
	</tr>";
}	

?>	
</table>
<div style="background-color:#E9E9E9" align="right">OBS: Clique sobre a nota para exibir o detalhamento.</div>
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

<div align="center" class="filtro"><a href="javascript:window.print()">[IMPRIMIR]</a></div>
<?php include('menu/tabela.php');
include('includes/conectar.php');
$id_turma = $_GET["id_turma"];
$id_aluno = $_GET["id_aluno"];
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_nivel = $dados_turma["nivel"];
$turma_curso = $dados_turma["curso"];
$turma_cod = $dados_turma["cod_turma"];
$turma_modulo = $dados_turma["modulo"];
$turma_unidade = $dados_turma["unidade"];
$turma_polo = $dados_turma["polo"];
$turma_turno = $dados_turma["turno"];
$turma_grupo = $dados_turma["grupo"];
$ano_atual = date("Y");
if($id_aluno == 0){
$sql_alunos = mysql_query("SELECT distinct matricula, nome FROM v_aluno_disc WHERE id_turma = $id_turma ORDER BY nome");
} else {
$sql_alunos = mysql_query("SELECT distinct matricula, nome FROM v_aluno_disc WHERE id_turma = $id_turma AND matricula = $id_aluno ORDER BY nome");
}
	
while($dados_aluno = mysql_fetch_array($sql_alunos)){
	$mat_aluno = $dados_aluno["matricula"];
	$nome_aluno = $dados_aluno["nome"];
	$sql_senha = mysql_query("SELECT * FROM acesso WHERE codigo = $mat_aluno");
	$dados_senha = mysql_fetch_array($sql_senha);
	$senha_aluno = $dados_senha["senha"];


?>

<table border="1" class="full_table_list" style="font-size:10px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
  
  
  <tr>
    <th colspan="2"><img src="images/logo-cedtec.png" /></th>
    <th colspan="2">BOLETIM ESCOLAR
    <?php if(strtoupper(substr(trim($turma_nivel),0,3))=="ENS"){
		echo" - 1&ordm; Trimestre";
	}
	?>
    </th>
    </tr>
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo (strtoupper($turma_nivel)).": ".(strtoupper($turma_curso))." - Ano/M&oacute;dulo ".(strtoupper($turma_modulo));?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $turma_grupo;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $turma_unidade;?> / <?php echo $turma_polo;?> - <?php echo $turma_cod;?></b></td>
    </tr>
    <tr>
    <td colspan="4"><b>Aluno(a):<br /><?php echo $mat_aluno;?> | <?php echo (strtoupper($nome_aluno));?></b></td>
    </tr>
	</table>
    <?php 
	$sql_turma_disc = mysql_query("SELECT * FROM ced_turma_disc WHERE id_turma = $id_turma");
	echo "
	<table border=\"1\" class=\"full_table_list\" style=\"font-size:10px; font-family:Arial, Helvetica, sans-serif; line-height:10px\">
  	
    <tr>
		<td align=\"center\" bgcolor=\"#D5D5D5\"><b>Componente Curricular / Disciplina</b></td>";
	$sql_atividades = mysql_query("SELECT * FROM ced_desc_nota WHERE subgrupo LIKE 0 ORDER BY codigo");
	while($dados_atividades = mysql_fetch_array($sql_atividades)){
		$atividade = ($dados_atividades["atividade"]);	
		echo "<td align=\"center\" bgcolor=\"#D5D5D5\"><b>$atividade</b></td>";
	}
	echo"<td align=\"center\" bgcolor=\"#D5D5D5\"><b>Nota Final</b></td>
	<td align=\"center\" bgcolor=\"#D5D5D5\"><b>Faltas</b></td></tr>
	";
	while($dados_turma_disc = mysql_fetch_array($sql_turma_disc)){
		$turma_disc = $dados_turma_disc["codigo"];
		$cod_disc = $dados_turma_disc["disciplina"];
		$ano_grade = $dados_turma_disc["ano_grade"];
		$sql_disciplina = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina = '$cod_disc' AND anograde LIKE '$ano_grade'");
		$dados_disciplina = mysql_fetch_array($sql_disciplina);
		$disciplina = strtoupper(($dados_disciplina["disciplina"]));
		echo "
		<tr>
			<td>$disciplina</td>
	";
	//pega nota_A
	$pesq_nota_A = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $mat_aluno AND turma_disc = $turma_disc AND grupo LIKE 'A' AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
	$dados_a = mysql_fetch_array($pesq_nota_A);
	$contar_nota_a = mysql_num_rows($pesq_nota_A);
	if($contar_nota_a == 0){
		$nota_a = "0,00";
	} else {
		$nota_a = number_format($dados_a["notafinal"], 2, ',', '');
		$nota_a2 = $dados_a["notafinal"];
	}
	
	//pega nota_B
	$pesq_nota_B = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $mat_aluno AND turma_disc = $turma_disc AND grupo = 'B' AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
	$dados_b = mysql_fetch_array($pesq_nota_B);
	$contar_nota_b = mysql_num_rows($pesq_nota_B);
	if($contar_nota_b == 0){
		$nota_b = "0,00";
	} else {
		$nota_b = number_format($dados_b["notafinal"], 2, ',', '');
		$nota_b2 = $dados_b["notafinal"];
	}
	
	//pega nota_C
	$pesq_nota_C = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $mat_aluno AND turma_disc = $turma_disc AND grupo = 'C' AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
	$dados_c = mysql_fetch_array($pesq_nota_C);
	$contar_nota_c = mysql_num_rows($pesq_nota_C);
	if($contar_nota_c == 0){
		$nota_c = "0,00";
	} else {
		$nota_c = number_format($dados_c["notafinal"], 2, ',', '');
	}
	
	
	//PEGA AS FALTAS
	$sql_falta = mysql_query("SELECT COUNT(*) as falta_total FROM ced_falta_aluno WHERE matricula = '$mat_aluno' AND turma_disc = '$turma_disc' AND status LIKE 'F'");
	$dados_falta = mysql_fetch_array($sql_falta);
	$falta         = $dados_falta["falta_total"];
	
	
	//VERIFICA SE TEM RECUPERAÇÃO
	if($nota_c =="0,00" || $nota_c<=$nota_a+$nota_b){
		$nota_final = number_format($nota_a2+$nota_b2,2,",",".");
	} else {
		$nota_final = number_format($nota_c,2,",",".");
	}

	
		
	echo "
	<td align=\"center\">$nota_a</td>
	<td align=\"center\">$nota_b</td>
	<td align=\"center\">$nota_c</td>
	<td align=\"center\">$nota_final</td>
	<td align=\"center\">$falta</td>
	</tr>";
	}
	
	
	?>
<tr>
    <td colspan="6" valign="top"><b>Observa&ccedil;&otilde;es:</b> O detalhamento de notas, faltas e ocorr&ecirc;cncias est&atilde;o dispon&iacute;veis em seu portal acad&ecirc;mico, entre em www.cedtec.com.br e clique em portal acad&ecirc;mico, acesse com os dados abaixo para utiliza-lo:<br>
    <b>Usu&aacute;rio / Matr&iacute;cula:</b> <?php echo $mat_aluno;?><br>
    <?php 
	$sql_obs = mysql_query("SELECT * FROM obs_nivel WHERE nivel_obs LIKE '%$turma_nivel%'");
	$dados_obs = mysql_fetch_array($sql_obs);
	$observacao_geral = ($dados_obs["obs"]);
	echo $observacao_geral;?></td>
    </tr>
</table>
<table border="1" class="full_table_list" style="font-size:10px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
<tr>
<td colspan="5" align="center" bgcolor="#C0C0C0"><b>OCORR&Ecirc;NCIAS - <?php echo $ano_atual;?></b></td>
</tr>
<tr>
<td align="center" bgcolor="#EAEAEA"><b>Data</b></td>
<td align="center" bgcolor="#EAEAEA"><b>Tipo</b></td>
<td align="center" bgcolor="#EAEAEA"><b>Descri&ccedil;&atilde;o</b></td>
</tr>
<?php
$sql_ocorrencias = mysql_query("SELECT * FROM ocorrencias WHERE matricula = $mat_aluno AND data LIKE '%$ano_atual%' AND n_ocorrencia <> 4 AND n_ocorrencia <> 7 ORDER BY data DESC LIMIT 10");
$count_ocorrencias = mysql_num_rows($sql_ocorrencias);
if($count_ocorrencias >=1){
while($dados_oc = mysql_fetch_array($sql_ocorrencias)){
	$n_ocorrencia = $dados_oc["n_ocorrencia"];
	$data_ocorrencia = substr($dados_oc["data"],8,2)."/".substr($dados_oc["data"],5,2)."/".substr($dados_oc["data"],0,4);
	$ocorrencia = $dados_oc["ocorrencia"];
	$sql_tipo_oc = mysql_query("SELECT * FROM tipo_ocorrencia WHERE id = $n_ocorrencia");
	$dados_tipo_oc = mysql_fetch_array($sql_tipo_oc);
	$tipo_ocorrencia = ($dados_tipo_oc["ocorrencia"]);
	echo "
	<tr>
	<td align=\"center\">$data_ocorrencia</td>
	<td><b>$tipo_ocorrencia</b></td>
	<td>$ocorrencia</td>
	
	</tr>";
	
	
}
} else {
	echo "
	<tr>
	<td colspan=\"3\" align=\"center\">N&atilde;o h&aacute; ocorr&ecirc;ncias para o aluno no ano de $ano_atual</td>
	</tr>";
	
}

?>
</table>


<table border="1" class="full_table_list" style="font-size:10px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
<tr>
<td colspan="7" align="center" bgcolor="#C0C0C0"><b>Extrato Financeiro - <?php echo $ano_atual;?></b></td>
</tr>
<tr>
<td align="center" bgcolor="#EAEAEA">T&iacute;tulo</td>
<td align="center" bgcolor="#EAEAEA">Parcela</td>
<td align="center" bgcolor="#EAEAEA">Vencimento</td>
<td align="center" bgcolor="#EAEAEA">Valor Integral</td>
<td align="center" bgcolor="#EAEAEA">Valor C/ Desconto</td>
<td align="center" bgcolor="#EAEAEA">Pagamento</td>
<td align="center" bgcolor="#EAEAEA">Valor Pagto</td>
</tr>
<?php
$sql_fin = mysql_query("SELECT * FROM titulos WHERE cliente_fornecedor = $mat_aluno AND vencimento LIKE '%$ano_atual%' AND status = 0 AND conta NOT LIKE '%LT%' ORDER BY vencimento");
while($dados_fin = mysql_fetch_array($sql_fin)){
	$id_titulo = $dados_fin["id_titulo"];
	$parcela = $dados_fin["parcela"];
	$vencimento = substr($dados_fin["vencimento"],8,2)."/".substr($dados_fin["vencimento"],5,2)."/".substr($dados_fin["vencimento"],0,4);
	$data_pagto = substr($dados_fin["data_pagto"],8,2)."/".substr($dados_fin["data_pagto"],5,2)."/".substr($dados_fin["data_pagto"],0,4);
	$valor = number_format($dados_fin["valor"],2,",",".");
	$valor2 = $dados_fin["valor"] - (($dados_fin["valor"]*$dados_fin["desconto"])/100);
	$valor_calculado = number_format($valor2,2,",",".");
	$valor_pagto = number_format($dados_fin["valor_pagto"],2,",",".");
	if(trim($data_pagto) == "//"){
		$data_pagto = "a Pagar";
	}
	echo "
	<tr>
	<td align=\"center\">$id_titulo</td>
	<td align=\"center\">$parcela</td>
	<td align=\"center\">$vencimento</td>
	<td align=\"right\">R$ $valor</td>
	<td align=\"right\">R$ $valor_calculado</td>
	<td align=\"center\">$data_pagto</td>
	<td align=\"right\">R$ $valor_pagto</td>
	
	</tr>";
	
	
}

?>
</table>
<br>
<div style="border: 1px dashed #FF0000;"></div>    
<br>
<table border="1" class="full_table_list" style="font-size:10px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
  
    <tr>
    <td colspan="3"><b>Curso:<br /><?php echo (strtoupper($turma_nivel)).": ".(strtoupper($turma_curso))." - Ano/M&oacute;dulo ".(strtoupper($turma_modulo));?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $turma_grupo;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $turma_unidade;?> / <?php echo $turma_polo;?> - <?php echo $turma_cod;?></b></td>
    </tr>
    <tr>
    <td colspan="5"><b>Aluno(a): <?php echo $mat_aluno;?> | <?php echo (strtoupper($nome_aluno));?></b></td>
    </tr>
    <tr style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:30px; height:30px;">
    <td colspan="1"><b>Este Canhoto Deve ser Devolvido &agrave; Escola</b></td>
    <td colspan="1"><b>Data: _____/_____/_______</b></td>
    <td colspan="3"><b>Assinatura do Respons&aacute;vel:</b></td>
    </tr>
	</table>

<?php
include("menu/footer.php");
echo "<p style=\"page-break-before: always\"></p>";

 }
?>
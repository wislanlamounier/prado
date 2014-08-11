<?php
include ('menu/tabela.php');// inclui o menu
?>
<div class="conteudo">
<?php 
include('includes/conectar.php');


$sql_provas = mysql_query("
SELECT eqf.matricula, alu.nome, eqf.id_questionario,eaq.cod_disc,ct.anograde, ct.unidade, ct.curso,ct.nivel,ct.modulo, ct.polo, eqf.tentativa, eqf.datahora
FROM ea_q_feedback eqf
INNER JOIN alunos alu
ON alu.codigo = eqf.matricula
INNER JOIN ea_questionario eaq
ON eaq.id_questionario = eqf.id_questionario
INNER JOIN ced_turma_disc ctd
ON ctd.codigo = eaq.turma_disc
LEFT JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
WHERE eqf.matricula LIKE '$user_usuario' AND  eqf.datahora >= '2014-07-22' AND eqf.datahora <= ((addtime(eqf.datahora , '24:00:00')))
GROUP BY eqf.id_questionario, eqf.matricula ORDER BY alu.nome, eqf.datahora DESC");

$contar_provas = mysql_num_rows($sql_provas);

if($contar_provas == 0){
	echo "<center>Ainda não há registro de provas.</center>";	
} else {
	echo "<table class=\"full_table_list\" border=\"1\" cellspacing=\"3\">
	<tr style=\"font-size:10px\">
		<td><div align=\"center\"><strong>Matr&iacute;cula</strong></div></td>
        <td><div align=\"center\"><strong>Nome</strong></div></td>
        <td><div align=\"center\"><strong>Curso</strong></div></td>
		<td><div align=\"center\"><strong>M&oacute;dulo</strong></div></td>
        <td><div align=\"center\"><strong>Unidade</strong></div></td>
        <td><div align=\"center\"><strong>Polo</strong></div></td>
		<td><div align=\"center\"><strong>Disciplina</strong></div></td>
        <td><div align=\"center\"><strong>Tentativa</strong></div></td>
        <td><div align=\"center\"><strong>Data da Realiza&ccedil;&atilde;o</strong></div></td>
		<td><div align=\"center\"><strong>Revisão</strong></div></td>
	</tr>";
while($dados_prova = mysql_fetch_array($sql_provas)){
	$matricula          = $dados_prova["matricula"];
	$aluno          = $dados_prova["nome"];
	$id_questionario          = $dados_prova["id_questionario"];
	$unidade         = $dados_prova["unidade"];
	$polo         = $dados_prova["polo"];
	$modulo         = $dados_prova["modulo"];
	$curso         = format_curso($dados_prova["curso"]);
	$nivel         = format_curso($dados_prova["nivel"]);
	$cod_disc         = $dados_prova["cod_disc"];
	$tentativa         = $dados_prova["tentativa"];
	$anograde         = $dados_prova["anograde"];
	$datahora         = format_data_hora($dados_prova["datahora"]);
	
	//pega o nome da disciplina
	$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '%$cod_disc%' AND anograde LIKE '%$anograde%'");
	$dados_disc = mysql_fetch_array($sql_disc);
	$nome_disciplina = $dados_disc["disciplina"];
	
	echo "
	<tr style=\"font-size:10px\">
		<td><div align=\"center\">$matricula</div></td>
        <td><div align=\"center\">$aluno</div></td>
        <td><div align=\"center\">$curso</div></td>
		<td><div align=\"center\">$modulo</div></td>
        <td><div align=\"center\">$unidade</div></td>
        <td><div align=\"center\">$polo</div></td>
		<td><div align=\"center\">$nome_disciplina</div></td>
        <td><div align=\"center\">$tentativa</div></td>
        <td><div align=\"center\">$datahora</div></td>
		<td><div align=\"center\"><strong><a target=\"_self\" href=\"revisao_prova.php?matricula=$matricula&tentativa=$tentativa&questionario=$id_questionario\">[REVISÃO DE TENTATIVA]</a></strong></div></td>
	
	</tr>";
	
}
echo "</table>";
	
}
?>
</div>
<?php
include ('menu/footer.php');?>
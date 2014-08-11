<?php include ("menu/tabela.php");?>
<div class="filtro"><center><a href="javascript:window.print()">[IMPRIMIR TODOS OS BOLETOS]</a>
</center><BR /></div>
<?php
$get_turma = $_GET["id_turma"];
$sql_aluno_turma = mysql_query("SELECT distinct cta.matricula FROM ced_turma_aluno cta INNER JOIN alunos a
ON cta.matricula = a.codigo
 WHERE cta.id_turma = $get_turma ORDER BY a.nome");
while($dados_aluno_turma = mysql_fetch_array($sql_aluno_turma)){
	$matricula = $dados_aluno_turma["matricula"];
	
	
	//dados do boleto
	$sql_aluno_tit = mysql_query("SELECT * FROM titulos WHERE cliente_fornecedor = $matricula AND documento_fiscal LIKE '%REM%' AND data_pagto IS NULL LIMIT 1");
	$dados_tit = mysql_fetch_array($sql_aluno_tit);
	$id_titulo = $dados_tit["id_titulo"];
	
	echo "<iframe frameborder=\"0\" src=\"../boleto/boleto_santander.php?id=$id_titulo&p=1&id2=$matricula&refreshed=no\" width=\"100%\" height=\"1000px\"></iframe>
	<div style=\"page-break-after:always\"></div>";
}

?>

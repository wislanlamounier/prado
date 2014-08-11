

<?php
include('includes/conectar.php');	
include('menu/tabela.php');	
$id = $_POST["id"];
$ref = $_POST["ref_curso"];

$re    = mysql_query("select count(*) as total from geral WHERE codigo = $user_usuario AND ref_id = $ref " );	
$total = 1;

if($total == 1) {
	$re    = mysql_query("select * from geral WHERE codigo LIKE '$id' AND ref_id = '$ref' ORDER BY ref_id DESC LIMIT 1");
	$dados = mysql_fetch_array($re);
	//VERIFICA SITUACAO FINANCEIRA E AUTORIZA REMATRÍCULA
	$data = date("Y-m-d");	
	$pesq = mysql_query("SELECT DISTINCT A.codigo, A.aluno, C.telefone, C.celular, C.tel_fin FROM g_cliente_fornecedor A  
	INNER JOIN titulos B ON A.codigo = B.cliente_fornecedor 
	INNER JOIN alunos C ON A.codigo = C.codigo 
	WHERE (B.data_pagto = '' OR B.data_pagto is null) 
	AND B.vencimento < '$data' AND B.status = 0 AND B.cliente_fornecedor = $id");
	$count_fin = mysql_num_rows($pesq);
}

//pega a turma do aluno
$sql_turma = mysql_query("SELECT * FROM ced_turma_aluno WHERE matricula = $user_usuario ORDER BY id_turma ASC LIMIT 1");
$dados_aluno_turma = mysql_fetch_array($sql_turma);
$turma_id = $dados_aluno_turma["id_turma"];
$turma_unidade = $dados_aluno_turma["unidade"];
$turma_modulo = $dados_aluno_turma["modulo"];
$turma_curso = $dados_aluno_turma["curso"];
$turma_grupo = $dados_aluno_turma["grupo"];

$qtd = mysql_num_rows($re);
if($qtd == 0){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('A REMATRÍCULA PARA A SUA TURMA AINDA NÃO ESTÁ DISPONÍVEL')
    window.close();
    </SCRIPT>");}
	
if($count_fin > 0){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ POSSUI TÍTULOS EM ATRASO, VERIFIQUE SUA SITUAÇÃO COM O SETOR FINANCEIRO PARA PODER REALIZAR A REMATRÍCULA.')
    window.close();
    </SCRIPT>");
}


$ver_remat    = mysql_query("select * from rematricula WHERE codigo = $id AND grupo LIKE '%$turma_grupo%' AND modulo LIKE '%$turma_modulo%'");
$total_remat = mysql_num_rows($ver_remat);
if($total_remat >=1){
	//REDIRECIONA PARA O BOLETO
	$p_boleto = mysql_query("SELECT * FROM titulos WHERE status = 99 AND cliente_fornecedor = $id AND documento_fiscal LIKE '%REREM%'");
	$dados_boleto = mysql_fetch_array($p_boleto);
	$id_titulo = $dados_boleto["id_titulo"];
	header("Location: ../boleto/boleto_santander.php?id=$id_titulo&p=1&id2=$id");
} else {
	mysql_query("INSERT INTO rematricula (codigo, grupo, modulo) VALUES ('$id','$turma_grupo','$turma_modulo');");
	$p_curso = mysql_query("SELECT * FROM cursosead WHERE tipo LIKE '%$nivel%' AND curso LIKE '%$curso%' AND grupo LIKE '%AGOSTO/14%' LIMIT 1");
	$dados_curso = mysql_fetch_array($p_curso);
	if(trim(strtoupper($turma_unidade))=="RECIFE"){ 
		$valor = 249;
		$conta = "B00RE";
		$parcela = 1;
		while($parcela <= 6){
			mysql_query("INSERT INTO titulos (id_titulo, cliente_fornecedor, descricao,parcela, vencimento, valor,status,tipo,conta,c_custo,documento_fiscal) VALUES (NULL,'$id','BOLETO REMATRÍCULA',1,'2014-08-10','$valor',99,2,'$conta','10EA212101','REREM');");
			$parcela +=1;
		}
	}
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('PARA FINALIZAR SUA REMATRÍCULA REALIZE O PAGAMENTO DO BOLETO E ENTREGUE-O NA SECRETARIA DA ESCOLA.')
    </SCRIPT>");
	
	
	//REDIRECIONA PARA O BOLETO
	$p_boleto = mysql_query("SELECT * FROM titulos WHERE status = 99 AND cliente_fornecedor = $id AND documento_fiscal LIKE '%REREM%'s");
	$dados_boleto = mysql_fetch_array($p_boleto);
	$id_titulo = $dados_boleto["id_titulo"];
	header("Location: ../boleto/boleto_santander.php?id=$id_titulo&p=1&id2=$id");
	
}


?>

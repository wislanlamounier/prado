<?php
include('menu/tabela.php');
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$matricula           = $_POST["id"];
	$get_fin           = $_POST["fin"];
	$modulo = strtoupper(($_POST["mod"]));
	$curso = ($_POST["curso"]); 
	$nivel = ($_POST["tipo"]); 
	$turno = strtoupper(($_POST["turno"])); 
	$grupo = strtoupper(($_POST["grupo"])); 
	$unidade = strtoupper(($_POST["unidade"])); 


if($unidade == 'EAD') {
	$polo = strtoupper(($_POST["polo"])); 
} else {
	$polo = $unidade;
}

include('includes/conectar.php');



if(@mysql_query("INSERT INTO curso_aluno (matricula, nivel, curso, modulo, grupo, turno, unidade, polo)
VALUES ('$matricula','$nivel','$curso','$modulo','$grupo','$turno','$unidade','$polo')")) {
	
	if(mysql_affected_rows() == 1){

		if($unidade == "EAD"){
			$p_filtro = "AND modalidade LIKE '%EAD%'";
		}
		//PEGA VALOR DA PARCELA DO CURSO
		$cursopesq    = mysql_query("SELECT * FROM cursosead WHERE tipo LIKE '%$nivel%' AND modulo = '$modulo' 
		AND curso LIKE '%$curso%' $p_filtro ");
		$dadoscur = mysql_fetch_array($cursopesq);
		$desconto = $dadoscur["desconto"];
		$grupo_curso = $dadoscur["grupo"];
		$conta_curso = $dadoscur["conta"];
		$parcela			= $dadoscur["max_parcela"];
		$valor = $dadoscur["valor"]/$parcela;					
		$parcelas		= 1;
		
		//PEGA VENCIMENTO DO GRUPO 
		$grupopesq = mysql_query("SELECT * FROM grupos WHERE grupo LIKE '%$grupo%' AND status = 0 AND modulo = '$modulo'");
		$grdados = mysql_fetch_array($grupopesq);
		$venc_grupo = $grdados["vencimento"];
		
		
		
		// CENTRO DE CUSTO EMPRESA 1
		$cc1 = 10;
									
		// CENTRO DE CUSTO FILIAL 2
		$cc2 = mysql_query("SELECT * FROM cc2 WHERE nome_filial LIKE '%$unidade%'");
		$c2dados = mysql_fetch_array($cc2);
		$cc2final = $c2dados["id_filial"];
															
		// CENTRO DE CUSTO 3
		$cc3 = 21;
									
		// CENTRO DE CUSTO 4									
		$cc4 = mysql_query("SELECT * FROM cc4 WHERE nome_cc4 LIKE '%$nivel%'");
		$c4dados = mysql_fetch_array($cc4);
		$cc4final = $c4dados["cc4"];
									
		// CENTRO DE CUSTO DO CURSO 5
		$cc5    = mysql_query("SELECT * FROM cc5 WHERE nome_cc5 LIKE '%$curso%' AND id_cc5 LIKE '%$cc4final%'");
		$cdados = mysql_fetch_array($cc5);
		$cc5final = $cdados["cc5"];
									
		// CENTRO DE CUSTO FINAL
		$c_custo = $cc1.$cc2final.$cc3.$cc4final.$cc5final;
		
		
		//GERA TITULOS
		$vencimento = $venc_grupo;
		$datadoc = date('Y-m-d');
		if($get_fin == 1){
		while($parcelas <= $parcela){
			if(@mysql_query("INSERT INTO titulos(cliente_fornecedor,dt_doc, descricao, vencimento, valor,desconto, parcela, tipo, c_custo,valor_pagto,conta) VALUES( $matricula,'$datadoc','Boleto de Mensalidade Aluno','$vencimento','$valor','$desconto','$parcelas','2','$c_custo','','$conta_curso')")) {
										
				if(mysql_affected_rows() == 1){
					$parcelas += 1;
					for ($i = 1; $i <= $parcelas; $i++)
					$vencimento = date("Y-m-d", strtotime(" " . $i-1 . " Month", strtotime($venc_grupo)));
					}
				} else {
					if(mysql_errno() == 1062) {
						echo $erros[mysql_errno()];
							exit;
					} else {	
						echo "";
						exit;
					}
					@mysql_close();
					}
					}	
		}
		
		//MENSAGEM DE CONFIRMAÇÃO
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Dados atualizados com sucesso');
			window.close();
			window.opener.location.reload();
			</SCRIPT>");
			return;
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível atualizar os dados.";
			exit;
		}	
		@mysql_close();
	}



}
?>
<a href="javascript:window.close()">Fechar</a>
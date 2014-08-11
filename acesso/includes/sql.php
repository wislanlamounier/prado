<?php

function buscar_aluno($buscar, $unidade, $empresa)
{
if($unidade =="" || $empresa == 20){
	$sql = "SELECT DISTINCT matricula, nome, curso, unidade, polo, Dtpaga FROM geral WHERE (nome LIKE '%$buscar%' OR nome_fin LIKE '%$buscar%') ORDER BY nome";
} else {
	$sql = "SELECT DISTINCT matricula, nome, curso, unidade, polo, Dtpaga FROM geral WHERE (unidade LIKE '%$unidade%' OR polo LIKE '%$unidade%') AND (nome LIKE '%$buscar%' OR nome_fin LIKE '%$buscar%') ORDER BY nome";	
}

	return $sql;
}
?>
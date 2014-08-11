<?php
include("menu/tabela.php");
include("includes/conectar.php");
include_once ("includes/Redimensiona.php");
$get_anograde = $_GET["anograde"];
$get_cod_disc = $_GET["cod_disc"];
$get_aula = $_GET["aula"];




$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc LIKE '%$get_cod_disc%' AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'");
if(mysql_num_rows($sql_verificar_previsto)==1){
	$dados_previsto=mysql_fetch_array($sql_verificar_previsto);
} else {
	$sql_nome_disciplina = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '%$get_cod_disc%' AND anograde LIKE '%$get_anograde%' LIMIT 1");
	$dados_disciplina = mysql_fetch_array($sql_nome_disciplina);
	$nome_disciplina = $dados_disciplina["disciplina"];
	
	$sql_cod_disc = mysql_query("SELECT * FROM disciplinas WHERE disciplina LIKE '%$nome_disciplina%' AND anograde LIKE '%$get_anograde%'");
	$codigos_disciplinas = "";
	$contar_codigos = mysql_num_rows($sql_cod_disc);
while($dados_disc = mysql_fetch_array($sql_cod_disc)){
		if($contar_codigos >=2){
			$codigos_disciplinas.="'".$dados_disc["cod_disciplina"]."',";
		} else {
			$codigos_disciplinas.="'".$dados_disc["cod_disciplina"]."'";
		}
		$contar_codigos -=1;
}
$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc IN ($codigos_disciplinas) AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'");
$dados_previsto=mysql_fetch_array($sql_verificar_previsto);
}

?>
<div class="conteudo">
<img src="<?php echo $dados_previsto["arquivo"];?>" width="700" />
</div>
<?php

include("menu/footer.php");
?>

<?php include 'menu/menu.php'; ?>

<?php
include 'includes/conectar.php';



$editor = "";
$turma_disc = $_SESSION["turma_disc"];
$cod_disc = $_SESSION["coddisc"];
$anograde = $_SESSION["anograde"];

if(isset($_GET["cod_ativ"])){
	$_SESSION["cod_ativ"] = $_GET["cod_ativ"];
	$cod_ativ = $_GET["cod_ativ"];
} else {
	$cod_ativ = $_SESSION["cod_ativ"];
}

if(isset($_GET["tipo_ativ"])){
	$_SESSION["tipo_ativ"] = $_GET["tipo_ativ"];
	$tipo_ativ = $_GET["tipo_ativ"];
} else {
	$tipo_ativ = $_SESSION["tipo_ativ"];
}


if(isset($_GET["edicao"])){
	$_SESSION["edicao"] = $_GET["edicao"];
	$edicao = $_GET["edicao"];
} else {
	$_SESSION["edicao"] = 0;
	$edicao = 0;
}


?>
<div class="conteudo">

<div class="central-ead" style="margin-bottom:100px;">
<a href="javascript:history.back()">[Voltar]</a>
<?php
if($edicao == 1){
	echo "<div align=\"right\" style=\"margin-right:50px;\"><a href=\"javascript:abrir('ea_atividade.php?acao=1&turma_disc=$turma_disc&coddisc=$cod_disc&anograde=$anograde');\" title=\"Nova Atividade\"><img src=\"icones/nova_atividade.png\" /></a></div>
";
}

?>
<hr>
<form method="POST" action="ea_confirm_questionario.php">
<?php 
$get_id_bq = $_GET["id_bq"];
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$get_id_bq' ORDER BY id_questao DESC");
$num_questao = 1;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_inativa = $dados_questao["inativo"];
	if($questao_inativa == 1){
		$cor_inativa = "bgcolor=\"red\"";
	} else {
		$cor_inativa = "";	
	}
	
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "
	<table class=\"full_table_list\" width=\"100%\">
	<tr>
		<td align=\"center\" $cor_inativa valign=\"top\" width=\"17%\"><b><font size=\"+2\"><a href=\"javascript:abrir('ea_editar_questao.php?id_questao=$questao_id&cod_questao=$questao_cod');\">[EDITAR]</a> $n_questao - </font></b><td>
		<td colspan=\"2\" valign=\"top\" width=\"80%\"><b><font size=\"+1\">$questao_questao</font></b><td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = $dados_opcoes["valor"];
		$opcaoresposta = trim($dados_opcoes["resposta"]);	
		$letra_opcao = format_letra($num_opcao);
		if($opcaovalor >= 1){
			$cor_resposta = "bgcolor=\"yellow\"";	
		} else {
			$cor_resposta = "";
		}
		echo "
		<tr>
			<td $cor_resposta colspan=\"2\" align=\"right\"><input type=\"radio\" name=\"$questao_cod\" value=\"$opcaoid\"> $letra_opcao </td>
			<td $cor_resposta > $opcaoresposta</td>
		<tr>
		";
		$num_opcao += 1;
	}
	$num_questao +=1;
	
 }




?>
</form>
</div>

</div>

  <?php

   include 'menu/footer.php' ?>

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir? '))
{
location.href="excluir.php?id="+id;
}
else
{
return false;
}
}
//-->

</script>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>

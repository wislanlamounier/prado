<?php include 'menu/menu.php'; ?>

<?php
include 'includes/conectar.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
$post_senha_certa = $_POST["senha_certa"];
$post_senha_dig = $_POST["senha_dig"];

if($post_senha_certa != $post_senha_dig){
	echo "<script language=\"javascript\">
	alert('A senha digitada está incorreta.');
	history.back();
	</script>";
} else {


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

$get_id_quest = $_GET["id_q"];
//pega dados da turma
$sql_turma_d = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = $turma_disc");
$dados_turma_d = mysql_fetch_array($sql_turma_d);
$id_turma = $dados_turma_d["id_turma"];
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_nivel = $dados_turma["nivel"];
$turma_curso = $dados_turma["curso"];
$turma_modulo = $dados_turma["modulo"];
$turma_grupo = $dados_turma["grupo"];
$turma_unidade = $dados_turma["unidade"];
$turma_polo = $dados_turma["polo"];
if($turma_modulo == 1){
$turma_modulo_exib = "I";
}

if($turma_modulo == 2){
$turma_modulo_exib = "II";
}

if($turma_modulo == 3){
$turma_modulo_exib = "II";
}



//pega dados da disciplina
$sql_disc =  mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '$cod_disc' AND anograde LIKE '%$anograde%'");
$dados_disc2 = mysql_fetch_array($sql_disc);
$nome_disciplina = $dados_disc2["disciplina"];


$sql_ativ1 = mysql_query("SELECT * FROM ea_ativ WHERE cod_disc LIKE '$cod_disc' AND ano_grade LIKE '$anograde' AND ordem = 1 ORDER BY ordem_ativ");
$sql_ativ2 = mysql_query("SELECT * FROM ea_ativ WHERE cod_disc LIKE '$cod_disc' AND ano_grade LIKE '$anograde' AND ordem = 2 ORDER BY ordem_ativ");

?>
<div class="conteudo">

<div class="central-ead" style="margin-bottom:100px;">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td bgcolor="#6C6C6C" height="24px" style="color:#FFF"><a href="javascript:history.back()" class="nohover" title="Voltar ao Início"><img src="icones/voltar.png" /></a></td>
<td align="center" bgcolor="#6C6C6C" height="24px" style="color:#FFF"><a href="javascript:history.back()"  class="nohover" title="Voltar ao Início"><font color="#FFFFFF" style="text-decoration:none;" size="-2"><b><?php echo ($turma_nivel.": ".$turma_curso." M&oacute;dulo ".$turma_modulo_exib."<br>".$turma_unidade." / ".$turma_polo);?></b></font></a></td>
<td align="center" bgcolor="#6C6C6C" height="24px" style="color:#FFF"><b><?php echo ($nome_disciplina);?></b></td>
</tr>

</table>
<?php
if($edicao == 1){
	echo "<div align=\"right\" style=\"margin-right:50px;\"><a href=\"javascript:abrir('ea_atividade.php?acao=1&turma_disc=$turma_disc&coddisc=$cod_disc&anograde=$anograde');\" title=\"Nova Atividade\"><img src=\"icones/nova_atividade.png\" /></a></div>
";
}

?>
<hr>
<form method="POST" action="ea_confirm_questionario.php">
<?php 
$sql_questionario = mysql_query("SELECT * FROM ea_questionario WHERE id_questionario = '$get_id_quest'");
$dados_q = mysql_fetch_array($sql_questionario);
$questionario_nquestoes = $dados_q["qtd_questoes"];
$questionario_banco = $dados_q["id_bq"];
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$questionario_banco' ORDER BY rand() LIMIT $questionario_nquestoes");
$num_questao = 1;
while($dados_questao = mysql_fetch_array($sql_questoes)){
	$questao_id = $dados_questao["id_questao"];
	$questao_questao = $dados_questao["questao"];
	$questao_cod = $dados_questao["cod_questao"];
	$questao_tipo = $dados_questao["tipo"];
	$n_questao = str_pad($num_questao, 3,"0", STR_PAD_LEFT);
	echo "
	<table class=\"full_table_list\" width=\"100%\">
	<tr>
		<td align=\"center\" valign=\"top\" width=\"17%\"><b><font size=\"+2\">$n_questao - </font></b><td>
		<td colspan=\"2\" valign=\"top\" width=\"80%\"><b><font size=\"+1\">$questao_questao</font></b><td>
	</tr>";
	
	//PEGA AS RESPOSTAS
	$sql_opcoes = mysql_query("SELECT * FROM ea_resposta WHERE cod_questao LIKE '$questao_cod' ORDER BY rand()");
	$num_opcao = 1;
	while($dados_opcoes = mysql_fetch_array($sql_opcoes)){
		$opcaoid = $dados_opcoes["id_resposta"];
		$opcaovalor = $dados_opcoes["valor"];
		$opcaoresposta = $dados_opcoes["resposta"];	
		$letra_opcao = format_letra($num_opcao);
		echo "
		<tr>
			<td colspan=\"2\" align=\"right\"><input type=\"hidden\" name=\"id_resposta[]\" value=\"$opcaoid\"> <input type=\"hidden\" name=\"id_questionario[]\" value=\"$get_id_quest\"> <input type=\"hidden\" name=\"valor_opcao[]\" value=\"$opcaovalor\"> <input type=\"hidden\" name=\"cod_questao[]\" value=\"$questao_cod\">
			<input type=\"radio\" name=\"$questao_cod\" value=\"$opcaoid\"> $letra_opcao </td>
			<td> $opcaoresposta</td>
		<tr>
		";
		$num_opcao += 1;
	}
	$num_questao +=1;
	
 }


echo "<tr>
		<td colspan=\"3\" align=\"center\"><input type=\"submit\"  value=\"Finalizar Avalia&ccedil;&atilde;o\"></td>
	</tr>";

}
}//fecha o if senha

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

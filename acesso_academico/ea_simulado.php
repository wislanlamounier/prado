<?php 
/* Define o limite de tempo do cache em 180 minutos */
session_cache_expire(180);
include 'menu/menu.php'; ?>

<?php
include 'includes/conectar.php';


$post_senha_certa = 1;
$post_senha_dig = 1;

if($post_senha_certa != $post_senha_dig){
	echo "<script language=\"javascript\">
	alert('A senha digitada est� incorreta.');
	history.back();
	</script>";
} else {


$turma_disc = $_GET["turma_disc"];
$cod_disc = $_GET["cod_disc"];
$tipo = $_GET["tipo"];

$_SESSION["simulado_turma_disc"] = $turma_disc;
$_SESSION["simulado_cod_disc"] = $cod_disc;
$_SESSION["simulado_tipo"] = $tipo;



//pega dados da turma
$sql_turma_d = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = $turma_disc");
$dados_turma_d = mysql_fetch_array($sql_turma_d);
$id_turma = $dados_turma_d["id_turma"];
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_nivel = $dados_turma["nivel"];
$turma_curso = trim($dados_turma["curso"]);
$turma_modulo = $dados_turma["modulo"];
$turma_grupo = $dados_turma["grupo"];
$turma_unidade = $dados_turma["unidade"];
$anograde = $dados_turma["anograde"];
$turma_polo = $dados_turma["polo"];
if($turma_modulo == 1){
$turma_modulo_exib = "I";
}

if($turma_modulo == 2){
$turma_modulo_exib = "II";
}

if($turma_modulo == 3){
$turma_modulo_exib = "III";
}



//pega dados da disciplina
$sql_disc =  mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '$cod_disc' AND anograde LIKE '%$anograde%'");
$dados_disc2 = mysql_fetch_array($sql_disc);
$nome_disciplina = $dados_disc2["disciplina"];


?>
<div class="conteudo">

<div class="central-ead" style="margin-bottom:100px;">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td bgcolor="#6C6C6C" height="24px" style="color:#FFF"><a href="javascript:history.back()" class="nohover" title="Voltar ao In�cio">Voltar</a></td>
<td align="center" bgcolor="#6C6C6C" height="24px" style="color:#FFF"><a href="javascript:history.back()"  class="nohover" title="Voltar ao In�cio"><font color="#FFFFFF" style="text-decoration:none;" size="-2"><b><?php echo ($turma_nivel.": ".$turma_curso." M&oacute;dulo ".$turma_modulo_exib."<br>".$turma_unidade." / ".$turma_polo);?></b></font></a></td>
<td align="center" bgcolor="#6C6C6C" height="24px" style="color:#FFF"><b><?php echo ($nome_disciplina);?></b></td>
</tr>

</table>

<hr>
<form method="POST" action="ea_confirm_simulado.php">
<?php 
$sql_bd = mysql_query("SELECT * FROM view_simulado WHERE nome_bq LIKE '%$nome_disciplina%' AND cursos LIKE '%$turma_curso%' LIMIT 1");
if(mysql_num_rows($sql_bd)==0){
	$sql_bd = mysql_query("SELECT * FROM view_simulado WHERE nome_bq LIKE '%$nome_disciplina%' AND cursos LIKE '%COMUM%' LIMIT 1");
}
$dados_bd = mysql_fetch_array($sql_bd);
$limite_questoes = 10;
//PEGA QUEST�ES BAIXO
$nquestoes_baixo = 5;
$banco_baixo = $dados_bd["id_bq_1"];
//PEGA QUEST�ES M�DIO
$nquestoes_medio = 3;
$banco_medio = $dados_bd["id_bq_2"];
//PEGA QUEST�ES ALTO
$nquestoes_alto = 2;
$banco_alto = $dados_bd["id_bq_3"];

//MONTA QUEST�ES BAIXO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_baixo' AND simulado = 0 AND inativo = 0 ORDER BY id_questao LIMIT $nquestoes_baixo");
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
		<td colspan=\"2\" valign=\"top\" width=\"80%\"><b><font size=\"+1\" style=\"font-family:Arial, Helvetica, sans-serif; color:black;\">$questao_questao</font></b><td>
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
			<td colspan=\"2\" align=\"right\"><input type=\"hidden\" name=\"id_opcao[]\" value=\"$opcaoid\"><input type=\"hidden\" name=\"campo_nome[]\" value=\"$questao_cod\"><input type=\"hidden\" name=\"id_resposta[]\" value=\"$opcaoid\"> <input type=\"hidden\" name=\"valor_opcao[]\" value=\"$opcaovalor\"> <input type=\"hidden\" name=\"cod_questao[]\" value=\"$questao_cod\">
			<input type=\"radio\" name=\"{$questao_cod}_option[]\" value=\"$opcaoid\"> $letra_opcao </td>
			<td> $opcaoresposta</td>
		<tr>
		";
		$num_opcao += 1;
	}
	$num_questao +=1;
	
 }


//MONTA QUEST�ES M�DIO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_medio' AND simulado = 0 ORDER BY id_questao LIMIT $nquestoes_medio");
$num_questao = $num_questao;
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
		<td colspan=\"2\" valign=\"top\" width=\"80%\"><b><font size=\"+1\" style=\"font-family:Arial, Helvetica, sans-serif; color:black;\">$questao_questao</font></b><td>
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
			<td colspan=\"2\" align=\"right\"><input type=\"hidden\" name=\"id_opcao[]\" value=\"$opcaoid\"><input type=\"hidden\" name=\"campo_nome[]\" value=\"$questao_cod\"><input type=\"hidden\" name=\"id_resposta[]\" value=\"$opcaoid\"> <input type=\"hidden\" name=\"valor_opcao[]\" value=\"$opcaovalor\"> <input type=\"hidden\" name=\"cod_questao[]\" value=\"$questao_cod\">
			<input type=\"radio\" name=\"{$questao_cod}_option[]\" value=\"$opcaoid\"> $letra_opcao </td>
			<td> $opcaoresposta</td>
		<tr>
		";
		$num_opcao += 1;
	}
	$num_questao +=1;
	
 }
 
 
//MONTA QUEST�ES ALTO
$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = '$banco_alto' AND simulado = 0 ORDER BY id_questao LIMIT $nquestoes_alto");
$num_questao = $num_questao;
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
		<td colspan=\"2\" valign=\"top\" width=\"80%\" style=\"font-family:Arial, Helvetica, sans-serif; color:black;\"><b><font size=\"+1\"  style=\"font-family:Arial, Helvetica, sans-serif; color:black;\">$questao_questao</font></b><td>
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
			<td colspan=\"2\" align=\"right\"><input type=\"hidden\" name=\"id_opcao[]\" value=\"$opcaoid\"><input type=\"hidden\" name=\"campo_nome[]\" value=\"$questao_cod\"><input type=\"hidden\" name=\"id_resposta[]\" value=\"$opcaoid\"> <input type=\"hidden\" name=\"valor_opcao[]\" value=\"$opcaovalor\"> <input type=\"hidden\" name=\"cod_questao[]\" value=\"$questao_cod\">
			<input type=\"radio\" name=\"{$questao_cod}_option[]\" value=\"$opcaoid\"> $letra_opcao </td>
			<td> $opcaoresposta</td>
		<tr>
		";
		$num_opcao += 1;
	}
	$num_questao +=1;
	
 }






if($num_questao == 1){
	echo "<center>N�o existem quest�es dispon�veis para esse simulado!</center>";
} else {
echo "<tr>
		<td colspan=\"3\" align=\"center\"><input type=\"submit\"  value=\"Finalizar Avalia&ccedil;&atilde;o\"></td>
	</tr>";
	mysql_close();
}

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

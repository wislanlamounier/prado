<?php include 'menu/menu.php'; ?>

  <?php
include 'includes/conectar.php';

$turma_disc = $_SESSION["prova_turma_disc"];
$cod_disc = $_SESSION["prova_cod_disc"];
$prova_tipo = $_SESSION["prova_tipo"];



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
$turma_anograde = trim($dados_turma["anograde"]);
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
$sql_disc =  mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '%$cod_disc%' AND anograde LIKE '%$turma_anograde%'");
$dados_disc2 = mysql_fetch_array($sql_disc);
$nome_disciplina = $dados_disc2["disciplina"];

?>
<div class="conteudo">

<div class="central-ead">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td bgcolor="#6C6C6C" height="24px" style="color:#FFF"><a href="javascript:history.back()" class="nohover" title="Voltar ao In�cio">Voltar</a></td>
<td align="center" bgcolor="#6C6C6C" height="24px" style="color:#FFF"><a href="javascript:history.back()"  class="nohover" title="Voltar ao In�cio"><font color="#FFFFFF" style="text-decoration:none;" size="-2"><b><?php echo ($turma_nivel.": ".$turma_curso." M&oacute;dulo ".$turma_modulo_exib."<br>".$turma_unidade." / ".$turma_polo);?></b></font></a></td>
<td align="center" bgcolor="#6C6C6C" height="24px" style="color:#FFF"><b><?php echo ($nome_disciplina);?></b></td>
</tr>

</table>

<hr>

<?php 
$sql_questionario = mysql_query("SELECT * FROM ea_questionario WHERE id_questionario = '$get_id_quest' AND 
((addtime(now(), '02:00:00')) BETWEEN data_inicio AND data_fim)");
if(mysql_num_rows($sql_questionario)==0){
	header("location:ea_exercicio.php");
} else {
	$dados_questionario = mysql_fetch_array($sql_questionario);
	$questionario_id = $dados_questionario["id_questionario"];
	$questionario_valor = number_format($dados_questionario["valor"],2,",",".");
	$questionario_senha = $dados_questionario["senha"];
	$_SESSION["senha_prova_correta"] = $questionario_senha;
	//PEGA QUEST�ES NIVEL BAIXO
	$idbd_baixo = $dados_questionario["id_bd"];
	$questoes_baixo = $dados_questionario["qtd_questoes"];
	//PEGA QUEST�ES NIVEL M�DIO
	$idbd_medio = $dados_questionario["id_bd2"];
	$questoes_medio = $dados_questionario["qtd_questoes2"];
	//PEGA QUEST�ES NIVEL ALTO
	$idbd_alto = $dados_questionario["id_bd3"];
	$questoes_alto = $dados_questionario["qtd_questoes3"];
	//PEGA TOTAL DE QUEST�ES
	$total_questoes = $questoes_alto + $questoes_baixo + $questoes_medio;
	
	$questionario_inicio = format_data_hora($dados_questionario["data_inicio"]);
	$questionario_fim = format_data_hora($dados_questionario["data_fim"]);
	if($questionario_senha != ""){
		$exib_senha = "password";	
	} else {
		$exib_senha = "hidden";	
	}
	$action = "ea_questionario.php?id_q=$questionario_id";
	if($prova_tipo == "1"){
		$nome_botao = "Iniciar Avalia��o";
	} else {
		$nome_botao = "Iniciar Exercicio";
	}
	echo "
	<form method=\"post\" action=\"$action\">
	<table class=\"full_table_cad\" border=\"1\" align=\"center\">

		<tr>
			<td><b>Quantidade de Quest�es:</b></td>
			<td align=\"center\">$total_questoes quest�es</td>
		<tr>
		<tr>
			<td><b>Valor:</b</td>
			<td align=\"center\">$questionario_valor pontos</td>
		<tr>
		<tr>
			<td><b>In�cio:</b</td>
			<td align=\"center\">$questionario_inicio</td>
		<tr>
		<tr>
			<td><b>Fim:</b</td>
			<td align=\"center\">$questionario_fim</td>
		<tr>
		<tr>
			<td style=\"visibility:$exib_senha\"><b>Senha:</b></td>
			<td style=\"visibility:$exib_senha\" align=\"center\"><input type=\"$exib_senha\" name=\"senha_dig\">
			
		<tr>
		<tr>
			<td colspan=\"2\" align=\"center\"><input type=\"submit\" name=\"iniciar\" value=\"$nome_botao\"></td>
		<tr>
	</table>
	</form>
	";
}
?>
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
</div>
</body>
</html>

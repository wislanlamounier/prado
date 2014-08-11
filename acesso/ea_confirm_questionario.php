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


//SALVA RESPOSTAS DOS ALUNOS
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$quest_id = $_POST[ 'id_questionario' ][0];
	$sql_ver_tentativa = mysql_query("SELECT max(tentativa) as tentativa FROM ea_q_feedback WHERE id_questionario = $quest_id");
	$dados_tentativa = mysql_fetch_array($sql_ver_tentativa);
	$tentativa = $dados_tentativa["tentativa"];
	$x = count( $_POST[ 'cod_questao' ] );
	$i = 0;
	while($i < $x) {
		$select_opcao = $_POST['cod_questao'][$i];
			if(isset($_POST[ "'".$select_opcao."'" ])){
				mysql_query("INSERT INTO ea_q_feedback (id_feedback,matricula,turma_disc, id_questionario,cod_questao,id_resposta,tentativa) VALUES (NULL,'$user_usuario','$turma_disc','".$_POST[ 'id_questionario' ][$i]."','".$_POST[ 'cod_questao' ][$i]."','".$_POST[ "'".$select_opcao."'" ]."','$tentativa')");
			}
		$i= +1;
	}
	echo "<script language=\"javascript\">
	alert('Suas respostas foram salvas com sucesso.');
	</script>";

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

<?php 



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

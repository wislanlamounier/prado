<?php include 'menu/menu.php'; ?>

  <?php
include 'includes/conectar.php';
$editor = "";
session_start();
if(isset($_GET['turma_disc'])){
	$turma_disc = $_GET['turma_disc'];
	$cod_disc = $_GET['coddisc'];
	$anograde = $_GET['anograde'];
	$_SESSION["turma_disc"] = $turma_disc;
	$_SESSION["coddisc"] = $cod_disc;
	$_SESSION["anograde"] = $anograde;
} else {
	$turma_disc = $_SESSION["turma_disc"];
	$cod_disc = $_SESSION["coddisc"];
	$anograde = $_SESSION["anograde"];

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

?>
<div class="conteudo">
<ul id="menu-ead2">
<table width="100%" style="margin-top:-38px;" align="center" cellpadding="4" cellspacing="4">
<tr  bgcolor="#FFFFFF">
	<td align="center"><font size="+1"><b><a style="text-decoration:none; background:none; color:#000;" href="javascript:location.reload()"><?php echo $nome_disciplina?></a></b></font><br>
<font size="-2">(00/00/0000) &agrave; (00/00/0000)</font>
</td>
</tr>
<tr bgcolor="#FFFFFF">
<td>
<?php


$sql_ativ1 = mysql_query("SELECT * FROM ea_ativ WHERE cod_disc LIKE '$cod_disc' AND ano_grade LIKE '$anograde' ORDER BY ordem_ativ");


while($dados_ativ1 = mysql_fetch_array($sql_ativ1)){
	$d_cod_ativ = $dados_ativ1["cod_ativ"];
	$d_cod_disc = $dados_ativ1["cod_disc"];
	$d_ano_grade = $dados_ativ1["ano_grade"];
	$d_tipo = $dados_ativ1["tipo"];
	$d_link = $dados_ativ1["link"];
	$sql_tipo_ativ = mysql_query("SELECT * FROM ea_tipo_ativ WHERE cod_tipo = $d_tipo ");
	$dados_tipo_ativ = mysql_fetch_array($sql_tipo_ativ);
	$ativ_tipo = ($dados_tipo_ativ["tipo"]);
	$ativ_rotulo = $dados_tipo_ativ["rotulo"];
	if($d_link == "#"){
		$ativ_link = $dados_tipo_ativ["link"];
		$target_link = "frame_central_ead";
		$comp_link = "frames_ead/";
	} else {
		$ativ_link = $d_link;
		$target_link = "_blank";
		$comp_link = "";
	}
	if($edicao == 1){
		$editor = "<a href=\"javascript:abrir('editar_ativ.php?turma_disc=$turma_disc&tipo_ativ=$d_tipo&cod_ativ=$d_cod_ativ')\">[E]</a> | <a href=\"javascript:abrir('excluir_ativ.php?turma_disc=$turma_disc&tipo_ativ=$d_tipo&cod_ativ=$d_cod_ativ')\">[X]</a>";
	}
	echo "
	
	<center><div style=\"float:left; margin-right:50px;\"><a style=\"text-decoration: none;\" target=\"$target_link\" href=\"$comp_link$ativ_link?turma_disc=$turma_disc&tipo_ativ=$d_tipo&cod_ativ=$d_cod_ativ&anograde=$anograde&cod_disc=$cod_disc\"><img src=\"icones/$ativ_rotulo\" title=\"$ativ_tipo\" alt=\"$ativ_tipo\" height=\"auto\">$editor<br>
	<font size=\"-2\" style=\"font-family: 'Nunito', sans-serif; color:#666666; text-decoration: none;\"><b<font size=\"-2\">$ativ_tipo</font></b></font></a>
	</div></center>

	
	";
}

echo "<center><div style=\"float:left; margin-right:50px;\"><a style=\"text-decoration: none;\" href=\"javascript:abrir('calendario.php?turma_disc=$turma_disc');\"><img src=\"icones/icone_calendario.png\" title=\"Calendário Acadêmico\" alt=\"Calendário Acadêmico\" height=\"auto\"><br>
	<font size=\"-2\" style=\"font-family: 'Nunito', sans-serif; color:#666666; text-decoration: none;\"><b<font size=\"-2\">Calendário Acadêmico</font></b></font></a>
	</div></center>"
?>

</td>
</tr>
</table>
<?php
if($edicao == 1){
	echo "<div align=\"right\" style=\"margin-right:50px;\"><a href=\"javascript:abrir('ea_atividade.php?acao=1&turma_disc=$turma_disc&coddisc=$cod_disc&anograde=$anograde');\" title=\"Nova Atividade\">[Nova Atividade]</a></div>
";
}

?><hr>
</ul>
<ul>
<iframe width="100%" style="z-index:100;" height="" name="frame_central_ead" frameborder="0" id="frame_central_ead" scrolling="no" src="frames_ead/frame_index.php?cod_disc=<?php echo ($cod_disc);?>&anograde=<?php echo ($anograde);?>&edicao=<?php echo $edicao?>&anograde=<?php echo ($anograde);?>&turma_disc=<?php echo $turma_disc?>"></iframe>
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

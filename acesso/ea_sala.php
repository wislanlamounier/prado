<?php include 'menu/menu.php'; ?>
<div class="conteudo">
<?php
include 'includes/conectar.php';
$id_turma = $_GET["id_turma"];

$sql_sala_disc = mysql_query("SELECT * FROM ced_turma_disc WHERE id_turma = $id_turma");

$sql_turma =  mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_curso = $dados_turma["curso"];
$turma_nivel = $dados_turma["nivel"];
$turma_modulo = $dados_turma["modulo"];
if($turma_modulo == 1){
	$modulo_exib = "I";
}
if($turma_modulo == 2){
	$modulo_exib = "II";
}
if($turma_modulo == 3){
	$modulo_exib = "III";
}
?>
<table width="70%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td colspan="2" align="center" bgcolor="#6C6C6C" style="color:#FFF"><b><?php echo $turma_nivel.": ".$turma_curso." - Mód. ".$modulo_exib;?></b></td>
</tr>
<?php
while($dados_disc = mysql_fetch_array($sql_sala_disc)){
	$td_codturma = $dados_disc["codturma"];
	$td_turmadisc = $dados_disc["codigo"];
	$td_coddisciplina = $dados_disc["disciplina"];
	$td_anograde = $dados_disc["ano_grade"];
	$td_codprof = $dados_disc["cod_prof"];
	$sql_disc =  mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '$td_coddisciplina' AND anograde LIKE '%$td_anograde%'");
	$dados_disc2 = mysql_fetch_array($sql_disc);
	$nome_disciplina = $dados_disc2["disciplina"];
	$rotulo_disciplina = $dados_disc2["rotulo"];
	$sql_prof =  mysql_query("SELECT * FROM acesso_completo WHERE codigo = $td_codprof LIMIT 1");
	$dados_prof = mysql_fetch_array($sql_prof);
	$nome_professor = $dados_prof["aluno"];
	

	echo "
	<tr>
	<td width=\"60%\" align=\"right\"><a href=\"ea_disciplina.php?turma_disc=$td_turmadisc&coddisc=$td_coddisciplina&anograde=$td_anograde\"><img src=\"icones/$rotulo_disciplina\" title=\"$nome_disciplina\" alt=\"$nome_disciplina\" width=\"300px\" height=\"auto\"></td>
	<td style=\"font-size:10px\"><b>Professor:</b> $nome_professor</td>
	</tr>";
}


?>
</table>
</div>
  <?php include 'menu/footer.php' ?>

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
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
</div>
</body>
</html>

<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_central_ead").height = document.getElementById("central").scrollHeight + 35;
     }
    </script>
    
<?php 
include('../includes/conectar.php');
$cod_disc = $_GET["cod_disc"];
$cod_ativ = $_GET["cod_ativ"];
$turma_disc = $_GET["turma_disc"];
$anograde = $_GET["anograde"];
if(isset($_GET["edicao"])){
	$_SESSION["edicao"] = $_GET["edicao"];
	$edicao = $_GET["edicao"];
} else {
	$_SESSION["edicao"] = 0;
	$edicao = 0;
}
$sql_atividade = mysql_query("SELECT * FROM ea_ativ WHERE cod_disc LIKE '$cod_disc' AND ano_grade LIKE '$anograde' AND cod_ativ = '$cod_ativ' ORDER BY ordem_ativ");
$dados_atividade = mysql_fetch_array($sql_atividade);
$conteudo_atividade = $dados_atividade["conteudo"];
$tipo_atividade = $dados_atividade["tipo"];

$sql_tipo_atividade = mysql_query("SELECT * FROM ea_tipo_ativ WHERE  cod_tipo = '$tipo_atividade'");
$dados_tipo_atividade = mysql_fetch_array($sql_tipo_atividade);

$nome_atividade = $dados_tipo_atividade["tipo"];



//verifica fóruns existentes para a turma

$sql_forum = mysql_query("SELECT * FROM ea_forum WHERE cod_ativ = '$cod_ativ' AND turma_disc = '$turma_disc' ORDER BY data_criacao");
$total_forum = mysql_num_rows($sql_forum);
?>
<div id="central">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td colspan="3" bgcolor="#6C6C6C" align="left">
<font color="#FFFFFF" size="+1">
<?php
echo ($nome_atividade);
?>
</font>

</td>
</tr>
</table>

<hr>
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td colspan="3" align="left">
<div class="pagina">
<?php
echo $conteudo_atividade;

?>
<?php
if($total_forum >= 1){
	echo "<table width=\"100%\" class=\"full_table_list\" align=\"center\" border=\"1\">
	<tr>
		<td  bgcolor=\"#6C6C6C\" style=\"color:#FFF\" align=\"center\"><b>ASSUNTO</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\" colspan=\"2\"><b>PERÍODO</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\"><b>VALOR</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\"><b>RESPOSTAS</b></td>
	</tr>
	";
	while($dados_forum = mysql_fetch_array($sql_forum)){
		$forum_titulo = substr($dados_forum["titulo"],0,30);
		$forum_id = $dados_forum["id_forum"];
		$forum_valor = $dados_forum["max_nota"];
		$forum_inicio = substr($dados_forum["data_inicio"],8,2)."/".substr($dados_forum["data_inicio"],5,2)."/".substr($dados_forum["data_inicio"],0,4);
		$forum_fim = substr($dados_forum["data_fim"],8,2)."/".substr($dados_forum["data_fim"],5,2)."/".substr($dados_forum["data_fim"],0,4);
		//CONTADOR DE POSTS NO FÓRUM
		$sql_post_forum = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum = $forum_id ORDER BY data_modif ASC");
		$total_post_forum = mysql_num_rows($sql_post_forum);
		
		
		if($forum_inicio == "//" || $forum_fim == "//"){
			$forum_periodo = "<td align=\"center\" colspan=\"2\"><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">LIVRE</a></b></td>";
		} else {
			$forum_periodo = "<td align=\"center\"><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$forum_inicio</a></b></td>
								<td align=\"center\"><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$forum_fim</a></b></td>";
		}
		if($forum_valor == 0){
			$forum_valor_exib = "NÃO AVALIATIVO";
		} else {
			$forum_valor_exib = number_format($forum_valor,2,",",".")." Pts";
		}
		
		echo "
		<tr><td><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$forum_titulo</a></b></td>
			<a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$forum_periodo</a>
			<td align=\"center\"><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$forum_valor_exib</a></b></td>
			<td align=\"center\"><b><a href=\"frame_exibir_forum.php?id_forum=$forum_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$total_post_forum</a></b></td>
		</tr>";
	}
	echo "</table>";
		
}

?>
<p align="right"><a href="javascript:abrir('topico.php?acao=1&cod_ativ=<?php echo $cod_ativ;?>&turma_disc=<?php echo $turma_disc;?>');">[Novo Tópico]</a>
</p>
</div>

</td>
</tr>
</table>

</div>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
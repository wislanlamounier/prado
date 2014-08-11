<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_central_ead").height = document.getElementById("central").scrollHeight + 35;
     }
    </script>
    
<?php 
include '../menu/tabela_ead.php'; 
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
$sql_estudo_dirigido = mysql_query("SELECT * FROM ea_estudo_dirigido WHERE cod_ativ = '$cod_ativ' AND turma_disc = '$turma_disc' ORDER BY data_criacao");
$total_estudo = mysql_num_rows($sql_estudo_dirigido);
if($total_estudo >= 1){
	echo "<table width=\"100%\" class=\"full_table_list\" align=\"center\" border=\"1\">
	<tr>
		<td  bgcolor=\"#6C6C6C\" style=\"color:#FFF\" align=\"center\"><b>Assunto</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\" colspan=\"2\"><b>Período</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\"><b>Valor</b></td>
		<td  bgcolor=\"#6C6C6C\"  style=\"color:#FFF\" align=\"center\"><b>Envios</b></td>
	</tr>
	";
	while($dados_estudo = mysql_fetch_array($sql_estudo_dirigido)){
		$estudo_titulo = substr($dados_estudo["titulo"],0,30);
		$estudo_id = $dados_estudo["id_estudo"];
		$estudo_valor = format_valor($dados_estudo["max_nota"]);
		$estudo_inicio = format_data_hora($dados_estudo["data_inicio"]);
		$estudo_fim = format_data_hora($dados_estudo["data_fim"]);
		$sql_contar_envios = mysql_query("SELECT * FROM ea_estudo_envio WHERE id_estudo = '$estudo_id'");
		$envios = mysql_num_rows($sql_contar_envios);
		
		echo "
		<tr><td><b><a href=\"frame_exibir_estudo.php?id_estudo=$estudo_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$estudo_titulo</a></b></td>
			<td align=\"center\"><a href=\"frame_exibir_estudo.php?id_estudo=$estudo_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$estudo_inicio</a></td>
			<td align=\"center\"><a href=\"frame_exibir_estudo.php?id_estudo=$estudo_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$estudo_fim</a></td>
			<td align=\"center\"><b><a href=\"frame_exibir_estudo.php?id_estudo=$estudo_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$estudo_valor</a></b></td>
			<td align=\"center\"><b><a href=\"frame_exibir_estudo.php?id_estudo=$estudo_id&cod_ativ=$cod_ativ&anograde=$anograde&coddisc=$cod_disc&turma_disc=$turma_disc\">$envios</a></b></td>
		</tr>";
	}
	echo "</table>";
		
}

?>

<p align="right"><a href="javascript:abrir('cad_estudo.php?acao=1&cod_ativ=<?php echo $cod_ativ;?>&turma_disc=<?php echo $turma_disc;?>');">[Nova Atividade]</a>
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
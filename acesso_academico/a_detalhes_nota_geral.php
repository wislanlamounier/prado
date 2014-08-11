<?php include 'menu/tabela.php'; ?>
<div class="conteudo">
<?php
include 'includes/conectar.php';
$id = $_GET["matricula"];
$codturma = $_GET["td"];

?>
<table class="full_table_list" border="1">
<tr align="center">
<td colspan="5"><b>REGISTRO DE NOTAS</b></td>
</tr>
<tr align="center">
<td><b>Atividade</b></td>
<td><b>Data</b></td>
<td><b>Valor</b></td>
<td><b>Descri&ccedil;&atilde;o</b></td>
<td><b>Nota</b></td>


</tr>
<?php
		$pesquisar = mysql_query("SELECT * FROM ced_turma_ativ WHERE  cod_turma_d = $codturma ORDER BY data");
		$total = mysql_num_rows($pesquisar);
		while($dados_ativ = mysql_fetch_array($pesquisar)){
			$ref_id = $dados_ativ["ref_id"];
			$cod_ativ = $dados_ativ["cod_ativ"];
			$grupo_ativ = $dados_ativ["grupo_ativ"];
			$valor_ativ = $dados_ativ["valor"];
			$data_ativ = substr($dados_ativ["data"],8,2)."/".substr($dados_ativ["data"],5,2)."/".substr($dados_ativ["data"],0,4);
			$desc_ativ = $dados_ativ["descricao"];
			$nome_ativ = mysql_query("SELECT * FROM ced_desc_nota WHERE  codigo = $cod_ativ;");
			$dados_atividade = mysql_fetch_array($nome_ativ);
			$nome_atividade = ($dados_atividade["atividade"]);
			//pesquisa notas anteriores
			$pesq_nota = mysql_query("SELECT * FROM ced_notas WHERE matricula = $id AND ref_ativ = $ref_id AND turma_disc = $codturma");
			$contar_nota = mysql_num_rows($pesq_nota);
			if($contar_nota == 0){
				$nota_aluno = "0,00";
			} else {
				$dados_nota = mysql_fetch_array($pesq_nota);
				$nota_aluno = number_format($dados_nota["nota"],2,",",".");
			}
			
		echo "
		<tr>
			<td align=\"center\">$nome_atividade</font></b></td>
			<td align=\"center\">$data_ativ</font></b></td>
			<td align=\"center\">$valor_ativ</font></b></td>
			<td align=\"center\"><font size=\"-3\">$desc_ativ</font></b></td>
			<td align=\"center\">$nota_aluno</font></b></td>
			
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

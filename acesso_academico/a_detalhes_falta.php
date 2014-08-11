<?php include 'menu/tabela.php'; ?>
<div class="conteudo">
<?php
include 'includes/conectar.php';
$id = $_GET["matricula"];
$codturma = $_GET["td"];

?>
<table class="full_table_list" border="1">
<tr align="center">
<td colspan="2"><b>REGISTRO DE FALTAS</b></td>
</tr>
<tr align="center">
<td><b>Nº Aula</b></td>
<td><b>Data</b></td>

</tr>
<?php
		$pesquisar = mysql_query("SELECT * FROM ced_falta_aluno WHERE  turma_disc = $codturma AND matricula = $id AND status = 'F' AND data IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$codturma') ");
		$total = mysql_num_rows($pesquisar);
		while($dados_falta = mysql_fetch_array($pesquisar)){
			$n_aula = $dados_falta["n_aula"];
			$data_aula = substr($dados_falta["data"],8,2)."/".substr($dados_falta["data"],5,2)."/".substr($dados_falta["data"],0,4);
			
		echo "
		<tr>
			<td align=\"center\">$n_aula</font></b></td>
			<td align=\"center\">$data_aula</font></b></td>
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

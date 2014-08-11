<?php include 'menu/menu.php'; ?>
<div class="conteudo">

  <?php
include 'includes/conectar.php';

$sql_banco = mysql_query("SELECT * FROM ea_banco_questao ORDER BY cursos, nome_bq, grau");

?>
<a href="javascript:abrir('ea_add_questao.php');">[Nova Quest&atilde;o]</a> | <a href="javascript:abrir('ea_add_banco.php');">[Novo Banco de Quest&atilde;o]</a> |
<table class="full_table_list" align="center" width="40%" border="1">
<tr>
	<td align="center"><b>QTD. Quest&otilde;es</b></td>
    <td align="center"><b>Cursos</b></td>
    <td align="center"><b>Banco de Quest&atilde;o</b></td>
    <td align="center"><b>Grau de Dificuldade</b></td>
    <td align="center"><b>A&ccedil;ao</b></td>
</tr>
<?php

while($dados_banco = mysql_fetch_array($sql_banco)){
	$banco_id = $dados_banco["id_bq"];
	$banco_cursos = $dados_banco["cursos"];
	$banco_nome = $dados_banco["nome_bq"];
	$banco_grau = $dados_banco["grau"];
	$sql_questoes = mysql_query("SELECT * FROM ea_questao WHERE id_bq = $banco_id");
	$qtd_questao = mysql_num_rows($sql_questoes);

	echo "
	<tr>
	<td align=\"center\">$qtd_questao</td>
	<td align=\"center\">$banco_cursos</td>
    <td><a href=\"javascript:abrir('ea_add_questao.php?id_bq=$banco_id');\">$banco_nome</a></td>
	<td align=\"center\">$banco_grau</td>
	<td align=\"center\"><a href=\"ea_questoes.php?id_bq=$banco_id\">[Visualizar]</a></td>

</tr>
	";
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
     
      var width = 1000;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>



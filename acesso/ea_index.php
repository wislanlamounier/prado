<?php include 'menu/menu.php'; ?>
<div class="conteudo">

  <?php
include 'includes/conectar.php';

$sql_user = mysql_query("SELECT * FROM ced_turma ORDER BY nivel,curso,modulo,anograde");

?>
<table class="full_table_list" border="1">
<tr>
	<td align="center"><b>Unidade</b></td>
    <td align="center"><b>Polo</b></td>
    <td align="center"><b>N&iacute;vel</b></td>
    <td align="center"><b>Curso</b></td>
    <td align="center"><b>M&oacute;dulo</b></td>
    <td align="center"><b>Per&iacute;odo Letivo</b></td>
    <td align="center"><b>Sala de Aula</b></td>
</tr>
<?php

while($dados_user = mysql_fetch_array($sql_user)){
	$user_turma = $dados_user["cod_turma"];
	$user_turno = $dados_user["turno"];
	$user_polo = $dados_user["polo"];
	$user_unidade = $dados_user["unidade"];
	$user_curso = $dados_user["curso"];
	$user_nivel = $dados_user["nivel"];
	$user_modulo = $dados_user["modulo"];
	$user_grupo = $dados_user["grupo"];
	$user_idturma = $dados_user["id_turma"];
	$user_anograde = $dados_user["anograde"];
	echo "
	<tr>
	<td>$user_unidade</td>
    <td>$user_polo</td>
    <td>$user_nivel</td>
    <td>$user_curso</td>
    <td>$user_modulo</td>
    <td>$user_grupo</td>
	<td align=\"center\"><a href=\"ea_sala.php?id_turma=$user_idturma\">[ACESSAR]</a></td>
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

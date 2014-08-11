
<?php
include('menu/tabela.php');
include('includes/conectar.php');
$id = $_GET["id"];

$re    = mysql_query("select count(*) as total from inscritos where codigo = $id");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("select * from inscritos where codigo = $id");
	$dados = mysql_fetch_array($re);
	$curso2 =  $dados["curso"];
	
	$re2    = mysql_query("SELECT * FROM cursosead WHERE codigo = $curso2");
	$dados2 = mysql_fetch_array($re2);
		
}
?>

<form id="form1" name="form1" method="post" action="salvar_mat.php">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="400" border="0" align="center">
    <tr>
      <td>Nome</td>
      <td><input name="aluno" type="text" class="textBox" id="aluno" value="<?php echo $dados["nome"]; ?>" maxlength="10" readonly="readonly"/></td>
    </tr>
	<tr>
      <td>Unidade</td>
      <td><input name="unidade" type="text" class="textBox" id="unidade" value="<?php echo $dados["unidade"]; ?>" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td>Curso</td>
      <td><input name="curso" type="text" class="textBox" id="curso" value="<?php echo $dados2["tipo"].": ".$dados2["curso"]; ?>" maxlength="10" readonly="readonly"/></td>
    </tr>

    <tr>
      <td width="166">&nbsp;</td>
      <td width="224"><input type="submit" name="Submit" value="Receber Matrícula" style="cursor:pointer;" /></td>
    </tr>
  </table>
</form>

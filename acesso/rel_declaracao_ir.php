
<?php
include('menu/tabela.php');
include('includes/conectar.php');
$matricula = $_GET["matricula"];
$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo =  '$matricula'");
$dados_aluno = mysql_fetch_array($sql_aluno);
$aluno_nome = $dados_aluno["nome"];

?>

<form id="form1" name="form1" method="GET" action="declaracao_ir.php" onsubmit="return confirma(this)">
<input type="hidden" name="matricula" value="<?php echo $matricula; ?>" />
<table class="full_table_cad" align="center">
<tr>
	<td><b>Nome do Aluno:</b></td>
    <td><input type="text" readonly="readonly" width="400px;" name="nome_aluno" value="<?php echo $aluno_nome; ?>" /></td>
</tr>
<tr>
	<td><b>Unidade:</b></td>
    <td><select name="unidade" class="textBox" id="unidade">
    <?php
include 'menu/config_drop.php';?>
    <?php
	if($user_unidade == ""){
		$sql = "SELECT * FROM cc2 WHERE niveltxt LIKE '%GERAL%' ORDER BY nome_filial";
	} else {
		$sql = "SELECT * FROM cc2 WHERE niveltxt LIKE '%GERAL%' AND nome_filial LIKE '%$user_unidade%'";
	}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_filial'] . "'>" . $row['nome_filial'] . "</option>";
}
?>
  </select></td>
</tr>
<tr>
	<td><b>Ano Refer&ecirc;ncia</b></td>
    <td><select  name="ano" style="width:auto;" id="ano" onkeypress="return arrumaEnter(this, event)">
     <option value="0000">AAAA</option>
     <?php $ano = date('Y')-1;
  $anoatual = date('Y');
while($ano<($anoatual+1)){
   echo "<option value='$ano'>$ano</option>";
   $ano++;
}?>
	</select></td>
</tr>
<tr>
	<td colspan="2"><input type="submit" value="GERAR" /></td>
</tr>
</table>
</form>
  <script language="JavaScript">  
function FormataCpf(campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(campo.value);
				vr = vr.replace(".", "");
				vr = vr.replace("/", "");
				vr = vr.replace("-", "");
				tam = vr.length + 1;
				if (tecla != 14)
				{
					if (tam == 4)
						campo.value = vr.substr(0, 3) + '.';
					if (tam == 7)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 6) + '.';
					if (tam == 11)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(7, 3) + '-' + vr.substr(11, 2);
				}
			}   

function FormataData(campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(campo.value);
				vr = vr.replace(".", "");
				tam = vr.length + 1;
				if (tecla != 10)
				{
					if (tam == 3)
						campo.value = vr.substr(0, 2) + '/';
					if (tam == 6)
						campo.value = vr.substr(0, 2) + '/' + vr.substr(3, 6) + '/';
				}
			}   

  
  
function confirma()
{
var conta = form1.conta.value;
if (confirm('Deseja confirmar a baixa na conta: '+conta))
{
}
else
{
 return false;
}
}
//-->
</script>
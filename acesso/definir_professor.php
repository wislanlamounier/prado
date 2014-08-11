
<?php

$id = $_GET["id"];

include 'menu/tabela.php';
?>

<form id="form1" name="form1" method="post" action="salvar_def_prof.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="430" border="0" align="center" class="full_table_cad">
    <tr>
      <td width="116">Tipo de Ocorr&ecirc;ncia</td>
      <td width="304"><select style="width:auto;"name="professor" class="textBox" id="professor" onkeypress="return arrumaEnter(this, event)">
        <option value="selecione">- Selecione o Professor -</option>
        <?php
include 'menu/config_drop.php';?>
        <?php
$sql = "SELECT * FROM cliente_fornecedor where tipo = 1 ORDER BY nome";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['codigo'] . "'>" . $row['nome'] . "</option>";
}
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
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
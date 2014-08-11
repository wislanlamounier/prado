
<?php
include('includes/conectar.php');
$id = $_GET["id"];


$re    = mysql_query("select count(*) as total from users where id_user = $id AND nivel >=2");	
$total = mysql_result($re, 0, "total");

if($id ==1){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.close();
    </SCRIPT>");
}

if($total == 1) {
	$re    = mysql_query("select * from users where id_user = $id AND nivel >=2");
	
	$dados = mysql_fetch_array($re);
	$nivel = $dados["nivel"];
	$senhaant = $dados["senha"];
	$re3    = mysql_query("select * from nivel_user where nivel = $nivel");
	
	$dados3 = mysql_fetch_array($re3);
	$nomenivel = strtoupper(utf8_encode($dados3["funcao"]));
	
		
}
include 'menu/tabela.php';
?>
S
<form id="form1" name="form1" method="post" action="salvar_edi_user.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="nivelant" value="<?php echo $nivel; ?>" />
<input type="hidden" name="senha" value="<?php echo $senhaant; ?>" />
  <table width="350" border="0" align="center" class="full_table_edit">
  	<tr bgcolor="#CCCCCC" align="center">
	<td colspan="2"><strong>N&iacute;vel Atual: <?php echo $nomenivel; ?></strong></td></tr>
    <tr>
      <td>N&iacute;vel de Acesso</td>
      <td><select name="novonivel" class="textBox" id="novonivel">
        <option value="<?php echo $nivel; ?>" selected="selected">Manter N&iacute;vel</option>
        <?php
include("menu/config_drop.php");?>
        <?php
$sql = "SELECT * FROM nivel_user ORDER BY funcao";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['nivel'] . "'>" . strtoupper($row['funcao']) . "</option>";
}
?>
      </select></td>
    </tr>
    <tr>
      <td>Nome</td>
      <td><input name="nome" type="text" class="textBox" id="nome" value="<?php echo $dados["nome"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Usu&aacute;rio</td>
      <td><input name="usuario" type="text" class="textBox" id="usuario" value="<?php echo $dados["usuario"]; ?>" maxlength="100"/></td>
    </tr>

    <tr>
      <td>Senha</td>
      <td><input name="senha" type="text" class="textBox" id="senha" value="<?php echo $dados["senha"]; ?>" maxlength="30"/></td>
    </tr>
    <tr>
    <td>Mudar Senha</td>
    <td><input name="mudar" type="checkbox" id="mudar" value="1" /></td> 
    </tr>
    <tr>
      <td></td>
      <td width="224"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
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
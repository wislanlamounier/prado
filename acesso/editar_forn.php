
<?php
include('menu/tabela.php');

include('includes/conectar.php');
$id = $_GET["id"];
$re    = mysql_query("select count(*) as total from cliente_fornecedor where codigo = $id");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("select * from cliente_fornecedor where codigo = $id");
	
	$dados = mysql_fetch_array($re);
}
?>
<style>
<!--
.textBox { border:1px solid gray; width:200px;} 
-->
</style>
<div class="conteudo">
<form id="form1" name="form1" method="post" action="salvar_edi_forn.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="400" border="0" align="center">
    <tr>
      <td>Nome</td>
      <td><input name="nome" type="text" class="textBox" id="nome" value="<?php echo $dados["nome"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Nome Fantasia</td>
      <td><input name="fantasia" type="text" class="textBox" id="fantasia" value="<?php echo $dados["nome_fantasia"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>E-mail</td>
      <td><input name="email" type="text" class="textBox" id="email" value="<?php echo $dados["email"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Telefone</td>
      <td><input name="telefone" type="text" class="textBox" id="telefone" value="<?php echo $dados["telefone"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Outro Telefone</td>
      <td><input name="telefone2" type="text" class="textBox" id="telefone2" value="<?php echo $dados["telefone2"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>CPF / CNPJ</td>
      <td><input name="cpf" type="text" class="textBox" id="cpf" value="<?php echo $dados["cpf_cnpj"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>RG</td>
      <td><input name="rg" type="text" class="textBox" id="rg" value="<?php echo $dados["rg"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>CEP</td>
      <td><input name="cep" type="text" class="textBox" id="cep" value="<?php echo $dados["cep"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>UF</td>
      <td><input name="uf" type="text" class="textBox" id="uf" value="<?php echo $dados["uf"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Cidade</td>
      <td><input name="cidade" type="text" class="textBox" id="cidade" value="<?php echo $dados["cidade"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Endere&ccedil;o</td>
      <td><input name="endereco" type="text" class="textBox" id="endereco" value="<?php echo $dados["endereco"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>N&ordm;</td>
      <td><input name="numero" type="text" class="textBox" id="numero" value="<?php echo $dados["numero"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Complemento</td>
      <td><input name="complemento" type="text" class="textBox" id="complemento" value="<?php echo $dados["complemento"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td></td>
      <td width="224"><input type="submit" name="Submit" value="Salvar" style="cursor:pointer;"/></td>
    </tr>
  </table>

</form>
</div>
<?php
include('menu/footer.php');
?>
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
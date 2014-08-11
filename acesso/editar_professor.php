<?php
include ('menu/tabela.php');
?>
<?php
include ('includes/conectar.php');
$id = $_GET["id"];

$re    = mysql_query("select count(*) as total from cliente_fornecedor where codigo = $id");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("SELECT A.*, B.email as email_aluno FROM ced_professor A INNER JOIN alunos B ON A.cod_user = B.codigo WHERE codigo = $id");
	$dados = mysql_fetch_array($re);
	
	
	$sql_senha = mysql_query("SELECT * FROM acesso where codigo = $id");
	$dados2 = mysql_fetch_array($sql_senha);
		
}
?>

<form id="form1" name="form1" method="post" action="salvar_edi_prof.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="400" border="0" align="center">
    <tr>
      <td>Nome</td>
      <td><input name="nome" type="text" class="textBox" id="nome" value="<?php echo $dados["Nome"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>E-mail</td>
      <td><input name="email" type="text" class="textBox" id="email" value="<?php echo $dados["email_aluno"]; ?>" maxlength="100"/></td>
    </tr>
     <tr>
      <td>CPF</td>
      <td><input name="cpf" type="text" class="textBox" id="cpf" value="<?php echo $dados["CPF"]; ?>" maxlength="100"/></td>
    </tr>
     <tr>
      <td>Nascimento</td>
      <td><input name="nascimento" type="text" class="textBox" id="nascimento" value="<?php echo $dados["Nascimento"]; ?>" maxlength="100"/></td>
    </tr>
     <tr>
      <td>Documento</td>
      <td><input name="documento" type="text" class="textBox" id="documento" value="<?php echo $dados["Documento"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Emissor</td>
      <td><input name="emissor" type="text" class="textBox" id="emissor" value="<?php echo $dados["Emissor"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Telefone</td>
      <td><input name="telefone" type="text" class="textBox" id="telefone" value="<?php echo $dados["Telefone"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Endereco</td>
      <td><input name="endereco" type="text" class="textBox" id="endereco" value="<?php echo $dados["Endereco"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Bairro</td>
      <td><input name="bairro" type="text" class="textBox" id="bairro" value="<?php echo $dados["Bairro"]; ?>" maxlength="100"/></td>
    </tr>
     <tr>
      <td>Cidade</td>
      <td><input name="cidade" type="text" class="textBox" id="cidade" value="<?php echo $dados["Cidade"]; ?>" maxlength="100"/></td>
    </tr>
     <tr>
      <td>UF</td>
      <td><input name="uf" type="text" class="textBox" id="uf" value="<?php echo $dados["UF"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Senha</td>
      <td><input name="senha" type="text" class="textBox" id="senha" value="<?php echo $dados2["senha"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td></td>
      <td width="224"><input type="submit" name="Submit" value="Salvar" style="cursor:pointer;"/></td>
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
<?php include 'menu/menu.php' ?>
<?php
$buscar = $_GET["buscar"];
$tipo_cliente = $_GET["tipo_cliente"];

?>
<div class="conteudo">
<center><strong><font size="+1">T&iacute;tulos a Receber - <input class="botao" type="button" name="acessar" id="acessar" onClick="javascript:pesquisar()" value="PESQUISAR TITULO" /></font></strong></center>
<hr />
<form id="form1" name="form1" method="get" action="buscar_receitas.php">
Nome: 
    <input type="text" value="<?php echo $buscar;?>" name="buscar" id="buscar" />
  <input type="submit" name="Filtrar" id="Buscar" value="Pesquisar" />
  <br>
  <input type="radio" name="tipo_cliente" checked id="tipo_cliente" value="1"> Aluno | <input type="radio" name="tipo_cliente" id="tipo_cliente" value="2"> Cliente/Fornecedor

</form>
<form id="form1" name="form1" method="get" action="data_receitas.php">
  De: 
  <input type="date" name="dataini" id="dataini" />
At&eacute;: 
<input type="date" name="datafin" id="datafin" />
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
<table width="100%" border="1" class="full_table_list">
	<tr>
		<td><div align="center"><strong>MATR&Iacute;CULA</strong></div></td>
        <td><div align="center"><strong>NOME</strong></div></td>
        <td><div align="center"><strong>RESP. FINANCEIRO</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';

if($user_unidade == 0){
	$sql = mysql_query("SELECT distinct codigo,aluno,financeiro FROM g_cliente_fornecedor WHERE aluno LIKE '%$buscar%' OR financeiro LIKE '%$buscar%' ORDER BY aluno");
	$sql2 = mysql_query("SELECT * FROM cliente_fornecedor WHERE (nome LIKE '%$buscar%' OR nome_fantasia LIKE '%$buscar%') AND codigo NOT IN (select codigo from alunos)");
} else {
	$sql = mysql_query("SELECT distinct codigo,aluno,financeiro FROM g_cliente_fornecedor WHERE (aluno LIKE '%$buscar%' OR financeiro LIKE '%$buscar%') AND unidade LIKE '%$user_unidade%' ORDER BY aluno");
	$sql2 = mysql_query("SELECT * FROM cliente_fornecedor WHERE (nome LIKE '%$buscar%' OR nome_fantasia LIKE '%$buscar%') AND codigo NOT IN (select codigo from alunos)");
}
// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
$count2 = mysql_num_rows($sql2);

// conta quantos registros encontrados com a nossa especificação
if ($count == 0&&$count2 == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    alert('NENHUM RESULTADO ENCONTRADO');
    history.back();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	if($tipo_cliente == 1){
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idcli			 = $dados["codigo"];
		$nome			 = (strtoupper($dados["aluno"]));
		$financeiro			 = (strtoupper($dados["financeiro"]));
        echo "
	<tr>
		<td align=\"center\"><b>$idcli</b></td>
		<td>&nbsp;<a href='buscar_receitas2.php?id=$idcli&aluno=$nome'>$nome</a></td>
		<td>&nbsp;$financeiro</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
	}
	if($tipo_cliente == 2){
	while ($dados2 = mysql_fetch_array($sql2)) {
        // enquanto houverem resultados...
		$idcli			 = $dados2["codigo"];
		$nome			 = strtoupper($dados2["nome"]);
		$financeiro			 = strtoupper($dados2["nome_fantasia"]);
        echo "
	<tr>
		<td align=\"center\"><b>$idcli</b></td>
		<td>&nbsp;<a href='buscar_receitas2.php?id=$idcli&aluno=$nome'>$nome</a></td>
		<td>&nbsp;$financeiro</td>
		\n";
        // exibir a coluna nome e a coluna email
	}
    }
}

?>

</table>
</div>
<?php include 'menu/footer.php' ?>
</div>
<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o titulo? '))
{
location.href="apagar_receita.php?id="+id;
}
else
{
return false;
}
}

function usuario(id){
alert("o nº de usuário é: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (id){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");
	URL = "editar2.php?id="+id+"&data="+data;
} while (data == null || data == "");
if(confirm ("Deseja mesmo efetuar a baixa do titulo para a data:  "+data))
{
window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
}
else
{

}

}
</SCRIPT>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
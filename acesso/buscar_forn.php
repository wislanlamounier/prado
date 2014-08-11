<?php include 'menu/menu.php'; 
$busca = $_GET["buscar"];
?>
<div class="conteudo">
<center><strong><font size="+1">Listar Cliente / Fornecedor</font></strong></center>
<hr />
<form id="form2" name="form1" method="get" action="buscar_forn.php">
  Nome:
  <input type="text" name="buscar" id="buscar" />
  <input type="submit" name="Buscar" id="Buscar" value="Pesquisar" />
</form>
<table class="full_table_list2" border"1" align="center">
	<tr style="font-size:17px">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
		<td><div align="center"><strong>Cliente / Fornecedor</strong></div></td>
        <td><div align="center"><strong>Telefones</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';



$sql = mysql_query("SELECT * FROM cliente_fornecedor WHERE tipo = 2 AND nome like '%$busca%' ORDER BY nome ");



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='index.php';
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo          = $dados["codigo"];
		$nome          = strtoupper($dados["nome"]);
		$tel          = $dados["telefone"];
		$tel2          = $dados["telefone2"];
        echo "
	<tr>
		<td align='center'>&nbsp;<a href=\"javascript:abrir('editar_forn.php?id=$codigo')\">[Editar]</a></td>
		<td>&nbsp;$nome</a></td>
		<td>&nbsp;$tel / $tel2</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
</table>
</div>
<?php include 'menu/footer.php' ?>

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o cliente/fornecedor? '))
{
location.href="apagar_forn.php?id="+id;
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

function baixa (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar_forn.php?id="+data,'_blank');
}
else
{
return;
}

}
</SCRIPT>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
<?php include 'menu/tabela.php'; ?>
<?PHP 
$p_nome = $_POST["buscar"];
$p_tipo = $_GET["tipo"];?>
<div class="conteudo">
<form id="form2" name="form1" method="post" onsubmit="validarAction(this);return false;">
  Nome:
  <input type="text" name="buscar" value="<?php echo $p_nome;?>" id="buscar" />
  <select style="width:300px;"name="tipo" class="textBox" id="tipo" onkeypress="return arrumaEnter(this, event)">
    <option value="pesquisar_caluno.php">Aluno</option>
    <option value="pesquisar_cfornecedor.php?tipo=2">Cliente / Fornecedor</option>
    <option value="pesquisar_cfornecedor.php?tipo=4">Funcionário</option>
    
  </select>
  <input type="submit" name="button" id="button" value="Buscar" />
</form>
<table class="full_table_list3" border"1" align="center">
	<tr style="font-size:17px">
		<td><div align="center"><strong>NOME</strong></div></td>
        <td><div align="center"><strong>NOME FANTASIA</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';
$sql = mysql_query("SELECT * FROM cliente_fornecedor WHERE (nome LIKE '%$p_nome%' OR nome_fantasia LIKE '%$p_nome%') AND tipo = '$p_tipo' ORDER BY nome ");



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    history.back();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo          = $dados["codigo"];
		$nome          = utf8_encode(strtoupper($dados["nome"]));
		$nome_f          = utf8_encode(strtoupper($dados["nome_fantasia"]));
        echo "
	<tr>
		<td><a href=\"#\" onclick=\"enviar('$codigo');enviar2('$nome');\">$nome</a></td>
		<td><a href=\"#\" onclick=\"enviar('$codigo');enviar2('$nome');\">$nome_f</a></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
</table>
<?php include 'menu/footer.php' ?>
</div>
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
function enviar(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor').value = valor;
}
function enviar2(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor2').value = valor;
this.close();
}
</script>
    </script>
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
     $(document).ready(function() {
   
   $("#button").click(function() {
      var theURL = $("#select").val();
window.location = theURL;
});
       
});
     </script>
     
     <script>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script> 
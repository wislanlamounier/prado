<?php include 'menu/menu.php'; ?>
<div class="conteudo">
<table class="full_table_list" border="1" cellspacing="3">
	<tr style="font-size:17px">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
		<td><div align="center"><strong>Usuário</strong></div></td>
        <td><div align="center"><strong>Professor</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';
$sql = mysql_query("SELECT * FROM ced_professor ORDER BY Nome");



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
		$codigo = $dados["cod_user"];
		$nome          = strtoupper(utf8_encode($dados["Nome"]));
        echo "
	<tr>
		<td align='center'>&nbsp;<a href=\"editar_professor.php?id=$codigo\" target=\"_blank\">[Editar]</a></td>
		<td>&nbsp;$codigo</td>
		<td>&nbsp;$nome</td>
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
window.open("editar2.php?id="+data,'_blank');
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
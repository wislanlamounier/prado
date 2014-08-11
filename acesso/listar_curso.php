<?php include 'menu/tabela.php';
$id = $_GET["id"]; ?>
<div class="conteudo">
<a href="cad_curso.php?id=<?php echo $id;?>">[NOVO CURSO]</a>
<table class="full_table_list" border="1" cellspacing="3">
	<tr style="font-size:17px">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
		<td><div align="center"><strong>Turno</strong></div></td>
        <td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>Ano/M&oacute;dulo</strong></div></td>
        <td><div align="center"><strong>Grupo/Semestre</strong></div></td>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Polo</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';

$sql = mysql_query("select * from geral WHERE codigo = $id");



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
		$matricula          = ($dados["codigo"]);
		$ref_curso          = ($dados["ref_id"]);
		$turno          = ($dados["turno"]);
		$nivel          = ($dados["nivel"]);
		$curso          = ($dados["curso"]);
		$modulo          = ($dados["modulo"]);
		$grupo          = ($dados["grupo"]);
		$unidade          = ($dados["unidade"]);
		$polo          = ($dados["polo"]);
		
        echo "
	<tr>
		<td align='center'>&nbsp;<a href=javascript:abrir('alterar_curso.php?codigo=$ref_curso')>[EDITAR]</a></td>
		<td>&nbsp;$turno</td>
		<td>&nbsp;$nivel: <b>$curso</b></td>
		<td align='center'>&nbsp;$modulo</td>
		<td>&nbsp;$grupo</td>
		<td><center>$unidade</center></td>
		<td>&nbsp;$polo</td>
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
     
      var width = 900;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
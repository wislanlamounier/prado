<?php include 'menu/menu.php'; ?>
<div class="conteudo">
<form id="form2" name="form1" method="GET" action="buscar_aluno.php">
  Nome:
  <input type="text" name="buscar" id="buscar" />
  <input type="submit" name="a" id="a" value="Buscar" />
</form>
<table class="full_table_list" border="1" cellspacing="3">
	<tr style="font-size:17px">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
		<td><div align="center"><strong>Matr&iacute;cula</strong></div></td>
        <td><div align="center"><strong>Aluno</strong></div></td>
        <td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Polo</strong></div></td>
        <td><div align="center"><strong>Data de Matr&iacute;cula</strong></div></td>
	</tr>

<?php
include 'includes/conectar2.php';
include 'includes/sql.php';


$busca = $_GET["buscar"];
$sql = buscar_aluno($busca,$user_unidade, $user_empresa); //Função que determina o sql

$query = $mysqli->query($sql);
$count = $query->num_rows;
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='index.php';
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($dados = $query->fetch_array(MYSQLI_ASSOC)) {
        // enquanto houverem resultados...
		$matricula          = $dados["matricula"];
		$aluno          = $dados["nome"];
		$curso          = strtoupper($dados["curso"]);
		$unidade_aluno         = $dados["unidade"];
		$polo         = $dados["polo"];
		$dt_matricula = substr($dados["Dtpaga"],8,2)."/".substr($dados["Dtpaga"],5,2)."/".substr($dados["Dtpaga"],0,4);
        echo "
	<tr>
		<td align='center'>&nbsp;<a href=\"ficha.php?codigo=$matricula\" target=\"_blank\">[FICHA DO ALUNO]</a></td>
		<td>&nbsp;$matricula</td>
		<td>&nbsp;$aluno</td>
		<td>&nbsp;$curso</td>
		<td><center>$unidade_aluno</center></td>
		<td>&nbsp;$polo</td>
		<td><center>$dt_matricula</center></td>
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
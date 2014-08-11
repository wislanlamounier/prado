<?php include 'menu/tabela.php';
$matricula = $_GET["codigo"]; ?>
<div class="conteudo">
<form action="gerar_declaracao.php" method="GET">
<table class="full_table_list" width="100%" align="center">
<?php
include 'includes/conectar.php';

$sql_cursos = mysql_query("select * from curso_aluno WHERE matricula = $matricula");
$sql_declaracoes = mysql_query("select * from ced_declaracoes");


$count_cursos = mysql_num_rows($sql_cursos);
if($count_cursos >=1){
	echo "<tr>
		<td colspan=\"7\" align='center'><b>Cursos Contratados</b></td>
		
	</tr>";
}
// conta quantos registros encontrados com a nossa especificação

    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($dados_curso = mysql_fetch_array($sql_cursos)) {
        // enquanto houverem resultados...
		$matricula          = ($dados_curso["matricula"]);
		$ref_curso          = ($dados_curso["ref_id"]);
		$turno          = ($dados_curso["turno"]);
		$nivel          = format_curso($dados_curso["nivel"]);
		$curso          = format_curso($dados_curso["curso"]);
		$modulo          = ($dados_curso["modulo"]);
		$grupo          = ($dados_curso["grupo"]);
		$unidade          = ($dados_curso["unidade"]);
		$polo          = ($dados_curso["polo"]);
		
        echo "
	<tr>
		<td align='center'><input name=\"curso_id\" id=\"curso_id\" type=\"radio\" value=\"$ref_curso\"></td>
		<td>&nbsp;$turno</td>
		<td>&nbsp;$nivel: <b>$curso</b></td>
		<td align='center'>&nbsp;$modulo</td>
		<td>&nbsp;$grupo</td>
		<td><center>$unidade</center></td>
		<td>&nbsp;$polo</td>
	</tr>
";
        // exibir a coluna nome e a coluna email
    }
if(mysql_num_rows($sql_declaracoes)>=1){
	echo "<tr>
		<td colspan=\"7\" align='center'><b>SELECIONE O MODELO ABAIXO</b></td>
	</tr>";
}
	while ($dados_declaracoes = mysql_fetch_array($sql_declaracoes)) {
        // enquanto houverem resultados...
		$id_declaracao          = ($dados_declaracoes["id_declaracao"]);
		$req_turma          = ($dados_declaracoes["req_turma"]);
		$nome_declaracao          = ($dados_declaracoes["nome_declaracao"]);

		
        echo "
	<tr style=\"border: 1px solid;\">
		<td style=\"border: 1px solid;\" align='center'><input name=\"modelo\" id=\"modelo\" type=\"radio\" value=\"$id_declaracao\">
		<input name=\"req_turma\" id=\"req_turma\" type=\"hidden\" value=\"$req_turma\">
		<input name=\"matricula\" id=\"matricula\" type=\"hidden\" value=\"$matricula\"></td>
		<td colspan=\"6\" style=\"border: 1px solid;\">$nome_declaracao</td>
	</tr>";
	}

?>
<tr>
<td><b>Per&iacute;odo:</b></td>
<td colspan="6" align="center"><input type="date" name="inicio_periodo" /> a <input type="date" name="fim_periodo" /> <br /><font size="-2"><b>Preencha a data de per&iacute;odo, somente se for necess&aacute;rio.</b></font></td>
</tr>
<tr>
<td><b>CH Est&aacute;gio:</b></td>
<td colspan="6"><input type="text" name="ch_estagio" /> <br /><font size="-2"><b>Preencha caso seja declara&ccedil;&atilde;o de est&aacute;gio</b></font></td>
</tr>
<tr>
<td colspan="7" align="center"><input type="submit" value="Gerar Declara&ccedil;&atilde;o" /></td>
</tr>
</table>
</form>
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
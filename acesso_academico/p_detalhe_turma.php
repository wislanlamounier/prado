<?php include 'menu/tabela.php' ?>
<?php
include 'includes/conectar.php';


$turma = $_GET["id"];
$p_turno = $_GET["turno"];
$p_polo = $_GET["polo"];
$id_turma = $_GET["id_turma"];
$turma_pesq = mysql_query("SELECT * FROM ced_turma WHERE cod_turma LIKE '$turma' AND turno = '$p_turno' AND polo = '$p_polo' AND id_turma = '$id_turma'");
$dados_turma = mysql_fetch_array($turma_pesq);
$max_aluno = $dados_turma["max_aluno"];
$nivel = $dados_turma["nivel"];
$curso = $dados_turma["curso"];
$modulo = $dados_turma["modulo"];
$unidade = $dados_turma["unidade"];
$grupo = $dados_turma["grupo"];
$polo = $dados_turma["polo"];
$turno = $dados_turma["turno"];
if($modulo == 1){
	$moduloexib = "I";
}
if($modulo == 2){
	$moduloexib = "II";
}
if($modulo == 3){
	$moduloexib = "III";
}
if($modulo == 4){
	$moduloexib = "IV";
}
?>
<div class="filtro"><center><a href="javascript:window.print()">[IMPRIMIR]</a></center>
</div>
<div class="conteudo">
<table width="100%" border="1" class="full_table_list" align="center">
		<tr>
    <th><img src="images/logo-color.png" width="70" /><br />Pincel At&ocirc;mico <br /><font size="-5"><?php echo date("d/m/Y h:m:s");?></font></th>
    <th colspan="2"><center><?php echo "Ano / Módulo: ".$moduloexib; ?><br /><?php echo "[".$turma."] ".$nivel.": ".$curso;?><br /><?php echo $turno;?></center></th>
    
    </tr>
		<tr>
        <td bgcolor="#ABABAB"><div align="center"><strong>Matr&iacute;cula</strong></div></td>
        <td bgcolor="#ABABAB"><div align="center"><strong>Nome</strong></div></td>
	</tr>

<?php


$sql = mysql_query("SELECT * FROM alunos WHERE codigo IN (SELECT matricula FROM ced_turma_aluno WHERE codturma='$turma' AND turno like '$turno' AND polo ='$p_polo') ORDER BY nome");



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$enturmado = mysql_num_rows($sql);
$vagas = $max_aluno - $enturmado;
// conta quantos registros encontrados com a nossa especificação
if ($enturmado == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM ALUNO FOI ENTURMADO NESSA TURMA. VOCÊ AINDA PODE ENTURMAR $vagas ALUNOS NESSA TURMA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem

    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$matricula          = $dados["codigo"];
		$nome          = strtoupper($dados["nome"]);
		
        echo "
		
	<tr style=\"font-size:10px;\">
		<td ><center>$matricula</center></td>
		<td>$nome</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
</tr>
		<tr>
        <td bgcolor="#ABABAB" colspan="2"><strong><?php echo $enturmado;?> Alunos</strong></td>
	</tr>
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

function baixa (id){
var data;
do {
    data = prompt ("Qual a data de pagamento?");
} while (data == null || data == "");
if(confirm ("Deseja mesmo efetuar a baixa do titulo para a data:  "+data))
{
location.href="baixa_receita.php?id="+id+"&data="+data;
}
else
{

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
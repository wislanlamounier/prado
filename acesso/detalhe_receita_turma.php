<?php include 'menu/menu.php' ?>
<?php
include 'includes/conectar.php';


$turma = $_GET["id"];
$id_turma = $_GET["id_turma"];
$get_inicio = $_GET["inicio"];
$get_fim = $_GET["fim"];
$get_turno = $_GET["turno"];
$get_grupo = $_GET["grade"];

$turma_pesq = mysql_query("SELECT * FROM ced_turma WHERE cod_turma LIKE '$turma' AND turno = '$get_turno' AND grupo = '$get_grupo'");
$dados_turma = mysql_fetch_array($turma_pesq);
$max_aluno = $dados_turma["max_aluno"];
$nivel = $dados_turma["nivel"];
$curso = $dados_turma["curso"];
$modulo = $dados_turma["modulo"];
$unidade = $dados_turma["unidade"];
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
<div class="conteudo">
<form method="GET" action="gerar_receita_turma.php">
  Unidade:
    <select name="unidade" class="textBox" id="unidade">
    <option  value="<?php echo $unidade;?>" selected="selected"><?php echo $unidade;?></option>
    <?php
include("menu/config_drop.php");?>
    <?php
$sql_p = "SELECT distinct unidade FROM unidades WHERE categoria > 0 OR unidade LIKE '%ead%' ORDER BY unidade";
$result = mysql_query($sql_p);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
  </select>
  
  De
  <input name="dataini" type="date" value="<?php echo $get_inicio;?>" />
at&eacute; <input name="datafin" type="date"  value="<?php echo $get_fim;?>"/> 
<input type="submit" name="Buscar" id="Buscar" value="Pesquisar" />
</form>
<center><strong><font size="+1">Relat&oacute;rio: Receitas / Turma</font></strong></center>
<hr />
<table width="100%" border="1" class="full_table_list" align="center">
		<tr>
    <th><img src="images/logo-color.png" width="70" /><br />Pincel At&ocirc;mico <br /><font size="-5"><?php echo date("d/m/Y h:m:s");?></font></th>
    <th colspan="2"><center><?php echo "Ano / Módulo: ".$moduloexib; ?><br /><?php echo "[".$turma."] ".$nivel.": ".$curso;?><br /><?php echo $turno;?></center></th>
    
    </tr>
		<tr>
        <td bgcolor="#ABABAB"><div align="center"><strong>Matr&iacute;cula</strong></div></td>
        <td bgcolor="#ABABAB"><div align="center"><strong>Nome</strong></div></td>
        <td bgcolor="#ABABAB"><div align="center"><strong>Recebimento</strong></div></td>
	</tr>

<?php


$sql = mysql_query("SELECT * FROM alunos WHERE codigo IN (SELECT matricula FROM ced_turma_aluno WHERE codturma='$turma' AND turno = '$turno' AND id_turma = $id_turma) ORDER BY nome");


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
	$valor2= 0;
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$matricula          = $dados["codigo"];
		$nome          = utf8_encode(strtoupper($dados["nome"]));
		
		$sql_receita = mysql_query("SELECT SUM(valor_pagto) as recebimento_total FROM titulos WHERE cliente_fornecedor = $matricula AND tipo = 2 AND conta NOT LIKE '%LT%' AND (data_pagto BETWEEN '$get_inicio' AND '$get_fim')");
		$verificar_receita = mysql_num_rows($sql_receita);
		if($verificar_receita >= 0){
			$dados_recebimento = mysql_fetch_array($sql_receita);
			$receita_aluno = number_format($dados_recebimento["recebimento_total"],2,",",".");
			$valor_receita = $dados_recebimento["recebimento_total"];
		} else {
			$receita_aluno = "0,00";
			$valor_receita = 0;
		}
		$recebimento_turma = $valor2 + $valor_receita;
		$valor2 = $recebimento_turma;
        echo "
		
	<tr style=\"font-size:10px;\">
		<td ><center>$matricula</center></td>
		<td>$nome</td>
		<td align=\"right\"><b>R$ $receita_aluno</b></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
</tr>
		<tr>
        <td bgcolor="#ABABAB" colspan="2"><strong><?php echo $enturmado;?> Alunos<br /></strong></td>
        <td bgcolor="#ABABAB" align="right"><font color="blue"><b>Receita da Turma: R$ <?php echo number_format($recebimento_turma,2,",",".");?></b></font></td>
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
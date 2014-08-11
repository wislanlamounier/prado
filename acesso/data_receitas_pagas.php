<?php include 'menu/menu.php' ?>
<?php 
$inicio = $_GET['dataini'];
$fim = $_GET['datafin'];
$unidade = $_GET['unidade'];
if($unidade == "*"){
	if($user_unidade == ""){
		$comp_sql = "";
	} else {
		$comp_sql = "AND conta_nome LIKE '%$user_unidade%'";
	}
	$nome_conta = "Geral";
} else {
	$comp_sql = "AND conta_nome LIKE '%$unidade%'";
	$nome_conta = $unidade;
}
?>
<div class="conteudo">
<center><strong><font size="+1">T&iacute;tulos Recebidos</font><br /><?php echo $nome_conta;?></strong></center>
<hr />
<form id="form1" name="form1" method="get" action="data_receitas_pagas.php">
 Unidade: 
    <select name="unidade" class="textBox" id="unidade" style="width:auto;">
    <option value="*" selected="selected">- Selecione a Unidade -</option>
    <?php
include ('menu/config_drop.php');?>
    <?php
if($user_unidade == ""){
	$sql = "SELECT distinct unidade FROM unidades ORDER BY unidade";
} else {
	$sql = "SELECT distinct unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' ORDER BY unidade";
}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
  </select>
  De: 
  <input type="date" name="dataini" id="dataini" value="<?php echo $inicio;?>"/>
At&eacute;: 
<input type="date" name="datafin" id="datafin" value="<?php echo $fim;?>" />
<input type="submit" name="Filtrar" id="Filtrar" value="Filtrar" />
</form>
<table width="100%" border="1" class="full_table_list">
	<tr>
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
		<td><div align="center"><strong>Aluno</strong></div></td>
        <td><div align="center"><strong>Cliente / Fornecedor</strong></div></td>
        <td><div align="center"><strong>Parcela</strong></div></td>
        <td><div align="center"><font color="blue"><strong>Vencimento</strong></font></div></td>
        <td><div align="center"><font color="blue"><strong>Valor</strong></font></div></td>
        <td><div align="center"><strong>Data de Efetiva&ccedil;&atilde;o</strong></div></td>
        <td><div align="center"><strong>Valor Efetivado</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';
$sql = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND valor_pagto > 0 $comp_sql ORDER BY data_pagto, conta, nome");

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
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = substr((strtoupper($dados["nome"])),0,30)."...";
		$parcela          = $dados["parcela"];
		$conta          = $dados["conta_nome"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = $dados["valor"]+$dados["juros1"]+$dados["juros2"]+$dados["juros3"]+$dados["juros4"];
		$valortitulofinal	= number_format($valortitulo, 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = number_format($dados["valor_pagto"], 2, ',', '.');
		$ccusto          = $dados["c_custo"];
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
		$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo = $idcli");
		if(mysql_num_rows($sql_aluno)>=1){
			$dados_aluno = mysql_fetch_array($sql_aluno);
			$nome_aluno = $dados_aluno["nome"];
		} else {
			$nome_aluno = "CLIENTE / FORNECEDOR";	
		}
        echo "
	<tr>
		<td align='center'><a href=\"javascript:abrir('ver_titulo.php?id=$idtitulo')\">[Visualizar]</a></td>
		<td><a href='buscar_receitas2.php?id=$idcli&aluno=$cliente'>$nome_aluno</a></td>
		<td><a href='buscar_receitas2.php?id=$idcli&aluno=$cliente'>$cliente</a></td>
		<td><center>$parcela</center></td>
		<td><center><font color=\"blue\">$venc</font></center></td>
		<td align=\"right\"><font color=\"blue\"><b>R$ $valortitulofinal</b></font></td>
		<td><center>$pagamento</center></td>
		<td align=\"right\"><b>R$ $valorpagt</b></td>
		<td>$conta</td>
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
//-->

</script>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
<?php include 'menu/menu.php' ?>
<?php 
$inicio = $_GET['dataini'];
$conta = $_GET['conta'];
$fim = $_GET['datafin'];

if($conta == "*"){
	if($user_unidade == ""){
		$sql_filtro = "";
	} else {
		$sql_filtro = "AND conta_nome LIKE '%$user_unidade%'";
	}
	$conta_nome = "Geral";
} else {
	$sql_filtro = "AND conta LIKE '$conta'";
	$sql_conta = mysql_query("SELECT * FROM contas WHERE ref_conta = '$conta'");
	$dados_conta = mysql_fetch_array($sql_conta);
	$conta_nome = $dados_conta["conta"];
}


?>
<div class="conteudo">
<center><strong><font size="+1">T&iacute;tulos Pagos</font></strong></center>
<hr />
<form id="form1" name="form1" method="get" action="data_despesas_pagas.php">
Conta: 
    <select name="conta" class="textBox" id="conta" style="width:auto;">
    <option value="<?php echo $conta; ?>" selected="selected"><?php echo $conta_nome;?></option>
    <option value="*">Geral</option>
    <?php
include ('menu/config_drop.php');?>
    <?php
if($user_unidade == ""){
	$sql = "SELECT * FROM contas ORDER BY conta";
} else {
	$sql = "SELECT * FROM contas WHERE conta LIKE '%$user_unidade%' ORDER BY conta";
}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['ref_conta'] . "'>" . $row['conta'] . "</option>";
}
?>
  </select>
  De: 
  <input type="date" name="dataini" id="dataini" value="<?php echo $inicio;?>"/>
At&eacute;: 
<input type="date" name="datafin" id="datafin" value="<?php echo $fim;?>" />
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
<table width="100%" border="1" class="full_table_list">
	<tr>
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
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
$sql = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 1 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND valor_pagto <> '' $sql_filtro ORDER BY data_pagto,conta, nome");

$sql_sum = mysql_query("SELECT SUM( valor_pagto ) as total FROM geral_titulos WHERE tipo_titulo = 1 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND valor_pagto <> '' $sql_filtro ORDER BY data_pagto, nome");
$dados_sum = mysql_fetch_array($sql_sum);
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
		$cliente          = substr(strtoupper($dados["nome"]),0,20)."...";
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
        echo "
	<tr>
		<td align='center'>&nbsp;<a href=\"javascript:abrir('ver_titulo.php?id=$idtitulo')\">[Visualizar]</a></td>
		<td>$cliente</td>
		<td align=\"center\">$parcela</td>
		<td align=\"center\"><font color=\"blue\">$venc</font></td>
		<td align=\"right\"><b><font color=\"blue\">R$ $valortitulofinal</font></b></td>
		<td align=\"center\">$pagamento</td>
		<td align=\"right\"><b>R$ $valorpagt</b></center></td>
		<td>$conta</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
<tr>
		<td colspan="8"><strong>Valor Total Efetivado: R$ <?php echo number_format($dados_sum["total"], 2, ',', '.');?></strong></td>
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
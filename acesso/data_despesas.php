<?php include 'menu/menu.php' ?>
<?php 
$conta = $_GET['conta'];
$inicio = $_GET['dataini'];
$fim = $_GET['datafin'];
if($conta == "*"){
	$exibir_conta = "Geral";
	if($user_unidade == ""){
		$com_sql = ""; //complemento de sql
	} else {
		$com_sql = "AND conta_nome LIKE '%$user_unidade%'"; //complemento de sql
	}
} else {
	$sql_conta = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$conta'");
	$dados_conta = mysql_fetch_array($sql_conta);
	$exibir_conta = $dados_conta["conta"];
	$com_sql = "AND conta = '$conta'"; //complemento de sql
}
?>
<div class="conteudo">
<center><strong><font size="+1">T&iacute;tulos a Pagar</font></strong></center>
<hr />
<form id="form1" name="form1" method="get" action="data_despesas.php">
 Conta: 
    <select name="conta" class="textBox" id="conta" style="width:auto;">
    <option value="<?php echo $conta;?>" selected="selected"><?php echo $exibir_conta;?></option>
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
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';
$sql = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 1 AND (vencimento BETWEEN '$inicio' AND '$fim') AND (valor_pagto = 0 OR data_pagto = '') $com_sql ORDER BY vencimento, conta");
$despesa = mysql_query("SELECT SUM( valor ) as despesapaga FROM geral_titulos WHERE tipo_titulo = 1 AND (vencimento BETWEEN '$inicio' AND '$fim') AND (valor_pagto = 0 OR data_pagto = '') $com_sql");

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
	while ($l = mysql_fetch_array($despesa)) {
		$despesaapagar = $l["despesapaga"];
	}
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = substr(strtoupper($dados["nome"]),0,20)."...";
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = $dados["valor"]+$dados["juros1"]+$dados["juros2"]+$dados["juros3"]+$dados["juros4"]+$dados["acrescimo"];
		$valortitulofinal	= number_format($valortitulo, 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = $dados["valor_pagto"];
		$ccusto          = $dados["c_custo"];
		$conta          = $dados["conta_nome"];
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
		if(trim($user_nivel) != 1&&trim($user_nivel) != 2&&trim($user_nivel) != 3&&trim($user_nivel) != 4 ){
			$comp_excluir = "";
		} else {
			$comp_excluir = "<a href=\"javascript:aviso($idtitulo)\">[Excluir]</a>";
		}
        echo "
	<tr>
		<td align='center'>&nbsp;<a href=\"javascript:abrir('editar2.php?id=$idtitulo')\">[Editar]</a> $comp_excluir</td>
		<td>&nbsp;$cliente</td>
		<td><center>$parcela</center></td>
		<td><center>$venc</center></td>
		<td align=\"right\"><b>R$ $valortitulofinal</b></td>
		<td><center>&nbsp;$conta</center></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
<tr>
<td colspan="7"><b><font color="#CC0000">PREVIS&Atilde;O DE DESPESA:</font> R$  <?php echo number_format($despesaapagar, 2, ',', '.')?></b></td>
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
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
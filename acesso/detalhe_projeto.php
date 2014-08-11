<?php
include 'includes/conectar.php';
$projeto = $_GET["projeto"];
$sql_projeto = mysql_query("SELECT * FROM projetos WHERE codigo LIKE '$projeto'");
$dados_projeto = mysql_fetch_array($sql_projeto);
$nome_projeto = $dados_projeto["projeto"];
$desc_projeto = $dados_projeto["descricao"];
$valor_projeto = $dados_projeto["valor"];
$inicio_projeto = substr($dados_projeto["inicio"],8,2)."/".substr($dados_projeto["inicio"],5,2)."/".substr($dados_projeto["inicio"],0,4);
$final_projeto = substr($dados_projeto["final"],8,2)."/".substr($dados_projeto["final"],5,2)."/".substr($dados_projeto["final"],0,4);



?>
<?php include 'menu/menu.php' ?>
<div class="conteudo">
<center><strong><font size="+1">Relat&oacute;rio: Projetos</font></strong></center>
<hr />
<div class="filtro">
  <form method="GET" action="detalhe_projeto.php">
    Projeto:
    <select name="projeto" class="textBox" id="projeto">
      <?php
include 'menu/config_drop.php';?>
      <?php
$sql = "SELECT * FROM projetos ORDER BY projeto";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['codigo'] . "'>" . $row['projeto'] . "</option>";
}
?>
    </select>
    <input type="submit" name="Buscar" id="Buscar" value="Pesquisar" />
  </form>
</div>
<table width="100%"  class="full_table_list" border="1">
	<tr> 
    	<td colspan="2" align="center"><img src="images/logo-color.png" width="70"/></td>
        <td colspan="6" align="center"><font size="+1"><strong><?php echo $nome_projeto; ?></strong></font><BR />
      
<br />
<strong>Per&iacute;odo:</strong> <?php echo $inicio_projeto;?> at&eacute;  <?php echo $final_projeto;?></td>
    </tr>
	<tr>
		<td><div align="center"><strong> T&iacute;tulo</strong></div></td>

        <td><div align="center"><strong>DT VENC.</strong></div></td>
        <td><div align="center"><strong>VLR T&iacute;tulo</strong></div></td>
 
        <td><div align="center"><strong>DT PGTO/REC</strong></div></td>
        <td><div align="center"><strong>VLR PGTO/REC</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
  </tr>

<?php
include 'includes/conectar.php';
$date = date("Y-m-d");



//TODAS AS CONTAS

$saldoanterior = 0;
$receitaant = 0;
$despesaant = 0;
	
$sql = mysql_query("SELECT * FROM geral_titulos WHERE projeto = '$projeto' ORDER BY data_pagto");
$despesa = mysql_query("SELECT SUM( valor_pagto ) as despesaatual FROM geral_titulos WHERE data_pagto <> '' AND projeto = '$projeto' AND tipo_titulo = 1");
$receita2 = mysql_query("SELECT SUM( valor_pagto ) as receitaatual FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND projeto = '$projeto'");

$despesa_pendente = mysql_query("SELECT SUM( valor ) as despesapendente FROM geral_titulos WHERE data_pagto LIKE '' AND projeto = '$projeto' AND tipo_titulo = 1");

	




// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='projetos.php';
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem	
	

	
	
    while ($l = mysql_fetch_array($despesa)) {
		$despesaatual = $l["despesaatual"];
	}
    while ($l = mysql_fetch_array($receita2)) {
		$receitaatual = $l["receitaatual"];
	}
	while ($l = mysql_fetch_array($despesa_pendente)) {
		$despesapendente = $l["despesapendente"];
	}
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = strtoupper($dados["nome"]);
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = number_format($dados["valor"], 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = number_format($dados["valor_pagto"], 2, ',', '.');
		$tipotitulo          = $dados["tipo_titulo"];
		$ccusto          = $dados["c_custo"];
		$conta_nome          = $dados["conta_nome"];
		$saldo          = number_format($dados["saldo"], 2, ',', '.');
		$processamento          = $dados["processamento"];
		$procdia = substr($processamento,8,2);
		$procmes = substr($processamento,5,2);
		$procano = substr($processamento,0,4);
		$dataproc = $procdia."/".$procmes."/".$procano;
		$horaproc = substr($processamento,11,8);
		$receita  		= ($receitaatual - $despesaatual) + $saldoanterior;
		if($tipotitulo == 2 || $tipotitulo == 99){
			$tipo = "<font color='blue'><b>+</b></font>";
			$cor = "<font color='black'>R$ $valorpagt</font>";
		}
		if($tipotitulo == 1){
			$tipo = "<font color='red'><b>-</b></font>";
			$cor = "<font color='red'>R$ $valorpagt</font>";
		}
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
        echo "
	<tr align='center'>
		<td>&nbsp;<a href=\"javascript:abrir('editar2.php?id=$idtitulo')\">$idtitulo</a></td>
		<td>&nbsp;$venc</td>
		<td align=\"right\">&nbsp;R$ $valortitulo</td>
		<td>$pagamento</td>
		<td align=\"right\">&nbsp;<strong>$tipo</strong> $cor</td>
		<td>&nbsp;$conta_nome</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

<tr>
<td colspan="9"><strong>Previs&atilde;o de Despesa:</strong><font color="#FF0000"> R$ <?php echo number_format($valor_projeto, 2, ',', '.'); ?></font><br /><br />
  <strong>Despesa Realizada:</strong><font color="#FF0000"> R$ <?php echo number_format($despesaatual, 2, ',', '.'); ?></font><br>
  <strong>Despesa Pendente:</strong><font color="#FF0000"> R$ <?php echo number_format($despesapendente, 2, ',', '.'); ?></font><br><strong>Total de Receita:</strong> <font color="#0000FF">R$ <?php echo number_format($receitaatual, 2, ',', '.'); ?></font><br></td>
</tr>
</table>
</div>
<?php include 'menu/footer.php' ?>


<script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
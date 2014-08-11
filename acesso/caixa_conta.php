<?php
include 'includes/conectar.php';
$conta = $_GET["conta"];
$dataini = $_GET["dataini"];
$diaini = substr($dataini,8,2);
$mesini = substr($dataini,5,2);
$anoini = substr($dataini,0,4);
$datainifinal = $diaini."/".$mesini."/".$anoini;

$datafin = $_GET["datafin"];
$diafin = substr($datafin,8,2);
$mesfin = substr($datafin,5,2);
$anofin = substr($datafin,0,4);
$datafinfinal = $diafin."/".$mesfin."/".$anofin;
$conta2 = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$conta'");
$conta3 = mysql_fetch_array($conta2);
$contafinal = $conta3["conta"];
$banco = $conta3["banco"];
$agencia = $conta3["agencia"];
$n_conta = $conta3["n_conta"];
$banco1 = mysql_query("SELECT * FROM bancos WHERE codigo LIKE '$banco'");
$banco2 = mysql_fetch_array($banco1);
$bancofinal = $banco2["banco"];
if($conta == "*"){
	$contafinal = "TODOS";
}



?>
<script type='text/javascript' src='http://cedtec.com.br/js/jquery.toastmessage-min.js'></script>
<?php include 'menu/menu.php' ?>
<div class="conteudo">
<center><strong><font size="+1">Relat&oacute;rio: Extrato de Contas</font></strong></center>
<hr />
<div class="filtro">
<form method="GET" action="caixa_conta.php">
  Conta:
    <select name="conta" class="textBox" id="conta">
    <?php
include("menu/config_drop.php");?>
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
  
  De
  <input name="dataini" type="date" value="<?php echo $dataini;?>"/>
at&eacute; <input name="datafin" type="date" value="<?php echo $datafin;?>"/> 
<input type="submit" name="Buscar" id="Buscar" value="Buscar" />
</form></div>
<table width="100%"  class="full_table_list">
	<tr> 
    	<td colspan="2"><img src="images/logo-color.png"  /></td>
        <td colspan="6"><center><strong>EXTRATO DE CONTA - CEDTEC</strong><center><BR />
          <strong>Conta:</strong> <?php echo $contafinal;?> - <strong>Banco:</strong> <?php echo $bancofinal;?> - <strong>Ag&ecirc;ncia/Conta:</strong></strong> <?php echo $agencia;?>/<?php echo $n_conta;?>
<br />
<strong>Per&iacute;odo:</strong> <?php echo $datainifinal;?> at&eacute;  <?php echo $datafinfinal;?></td>
    </tr>
	<tr>
		<td width="8%" align="center"><div align="center"><strong>Tipo de T&iacute;tulo</strong></div></td>
		<td width="8%"><div align="center"><strong> T&iacute;tulo</strong></div></td>

        <td width="16%"><div align="center"><strong>Vencimento</strong></div></td>
        <td width="17%"><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
 
        <td width="16%"><div align="center"><strong>Data de Pagamento</strong></div></td>
        <td width="18%"><div align="center"><strong>Valor</strong></div></td>
        <td width="17%"><div align="center"><strong>Saldo</strong></div></td>
  </tr>

<?php
include 'includes/conectar.php';
$date = date("Y-m-d");


//OUTRAS CONTAS
if($conta != "*"&&$dataini == ""&&$datafin == ""){
	$saldoanterior = 0;
	
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE conta like '$conta' AND data_pagto <>'' ORDER BY data_pagto, tipo_titulo DESC");
	$despesa = mysql_query("SELECT SUM( valor_pagto ) as despesaatual FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND conta like '%$conta%'");
	$receita2 = mysql_query("SELECT SUM( valor_pagto ) as receitaatual FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%'");
	$receita3 = mysql_query("SELECT SUM( valor ) as areceber FROM geral_titulos WHERE data_pagto = '' AND (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%'");
	
}



//OUTRAS CONTAS - PERIODO INICIAL
if($conta != "*"&&$dataini != ""&&$datafin == ""){
	$despesaant = mysql_query("SELECT SUM( valor_pagto ) as despesaant FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND data_pagto < '$dataini' AND conta like '%$conta%'");
	$receitaant = mysql_query("SELECT SUM( valor_pagto ) as receitaant FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND data_pagto < '$dataini' AND conta like '%$conta%'");

	$l = mysql_fetch_array($receitaant);
	$receitaant = $l["receitaant"];
	$l = mysql_fetch_array($despesaant);
	$despesaant = $l["despesaant"];
	$saldoanterior = $receitaant - $despesaant;
	
	
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE conta like '%$conta%' AND data_pagto >= '$dataini' AND data_pagto <>'' ORDER BY data_pagto, tipo_titulo DESC");
	$despesa = mysql_query("SELECT SUM( valor_pagto ) as despesaatual FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND conta like '%$conta%' AND data_pagto >= '$dataini'");
	$receita2 = mysql_query("SELECT SUM( valor_pagto ) as receitaatual FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%' AND data_pagto >= '$dataini'");
	$receita3 = mysql_query("SELECT SUM( valor ) as areceber FROM geral_titulos WHERE data_pagto = '' AND (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%' AND data_pagto >= '$dataini'");
	
}


//OUTRAS CONTAS - PERIODO FINAL
if($conta != "*"&&$dataini == ""&&$datafin != ""){
	$despesaant = mysql_query("SELECT SUM( valor_pagto ) as despesaant FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND data_pagto < '$dataini' AND conta like '%$conta%'");
	$receitaant = mysql_query("SELECT SUM( valor_pagto ) as receitaant FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND data_pagto < '$dataini' AND conta like '%$conta%'");
	
	$l = mysql_fetch_array($receitaant);
	$receitaant = $l["receitaant"];
	$l = mysql_fetch_array($despesaant);
	$despesaant = $l["despesaant"];
	$saldoanterior = $receitaant - $despesaant;
	
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE conta like '%$conta%' AND data_pagto =< '$datafin' AND data_pagto <>'' ORDER BY data_pagto, tipo_titulo DESC");
	$despesa = mysql_query("SELECT SUM( valor_pagto ) as despesaatual FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND conta like '%$conta%' AND data_pagto =< '$datafin'");
	$receita2 = mysql_query("SELECT SUM( valor_pagto ) as receitaatual FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%' AND data_pagto =< '$datafin'");
	$receita3 = mysql_query("SELECT SUM( valor ) as areceber FROM geral_titulos WHERE data_pagto = '' AND (tipo_titulo=2 OR tipo_titulo=99) AND conta like '%$conta%' AND data_pagto =< '$datafin'");
	
}

//OUTRAS CONTAS - PERIODO INICIAL E FINAL
if($conta != '*'&&$dataini != ""&&$datafin != ""){
	$despesaant = mysql_query("SELECT SUM( valor_pagto ) as despesaant FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND data_pagto < '$dataini' AND conta like '%$conta%'");
	$receitaant = mysql_query("SELECT SUM( valor_pagto ) as receitaant FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND data_pagto < '$dataini' AND conta like '%$conta%'");
	
	$l = mysql_fetch_array($receitaant);
	$receitaant = $l["receitaant"];
	$l = mysql_fetch_array($despesaant);
	$despesaant = $l["despesaant"];
	$saldoanterior = $receitaant - $despesaant;
	
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE data_pagto BETWEEN '$dataini' AND '$datafin' AND conta like '%$conta%' AND data_pagto <>'' ORDER BY data_pagto, tipo_titulo DESC");
	$despesa = mysql_query("SELECT SUM( valor_pagto ) as despesaatual FROM geral_titulos WHERE data_pagto <> '' AND tipo_titulo = 1 AND data_pagto BETWEEN '$dataini' AND '$datafin' AND conta like '%$conta%'");
	$receita2 = mysql_query("SELECT SUM( valor_pagto ) as receitaatual FROM geral_titulos WHERE (tipo_titulo=2 OR tipo_titulo=99) AND data_pagto BETWEEN '$dataini' AND '$datafin' AND conta like '%$conta%'");
	$receita3 = mysql_query("SELECT SUM( valor ) as areceber FROM geral_titulos WHERE data_pagto = '' AND (tipo_titulo=2 OR tipo_titulo=99) AND data_pagto BETWEEN '$dataini' AND '$datafin' AND conta like '%$conta%'");
	
	
}



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='caixa.php';
    </SCRIPT>");
} else {
    // senão
	
    while ($l = mysql_fetch_array($despesa)) {
		$despesaatual = $l["despesaatual"];
	}
    while ($l = mysql_fetch_array($receita2)) {
		$receitaatual = $l["receitaatual"];
	}
    while ($l = mysql_fetch_array($receita3)) {
		$areceber = $l["areceber"];
	}
	
	$valor2 = $saldoanterior;//
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
		//$saldo          = number_format($dados["saldo"], 2, ',', '.');
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
			$saldo = $valor2 + $dados["valor_pagto"];
			$saldo_exib = number_format($saldo,2,",",".");
		}
		if($tipotitulo == 1){
			$tipo = "<font color='red'><b>-</b></font>";
			$cor = "<font color='red'>R$ $valorpagt</font>";
			$saldo = $valor2 - $dados["valor_pagto"];
			$saldo_exib = number_format($saldo,2,",",".");
		}
		$valor2 = $saldo;
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
        echo "
	<tr align='center'>
		<td align='center'>&nbsp;<strong>$tipo</strong></td>
		<td>&nbsp;<a href=\"javascript:abrir('editar2.php?id=$idtitulo')\">$idtitulo</a></td>
		<td>&nbsp;$venc</td>
		<td>&nbsp;R$ $valortitulo</td>
		<td>&nbsp;$pagamento</td>
		<td>&nbsp;<strong>$tipo</strong> $cor</td>
		<td><b>R$ $saldo_exib</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

<tr>
<td colspan="9"><strong>Saldo em Conta:</strong> <font color="#0000FF">R$ <?php echo $saldo_exib; ?></font></td>
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
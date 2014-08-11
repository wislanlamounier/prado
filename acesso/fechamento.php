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
<?php include 'menu/menu.php' ?>
<div class="conteudo" align="center">
<center><strong><font size="+1">Relatório: Fechamento de Conta</font></strong></center>
<hr />
<p><strong>Conta:</strong> <?php echo $contafinal;?> - <strong>Banco:</strong> <?php echo $bancofinal;?> - <strong>Ag&ecirc;ncia/Conta:</strong></strong> <?php echo $agencia;?>/<?php echo $n_conta;?>
<br />
<strong>Período:</strong> <?php echo $datainifinal;?> até  <?php echo $datafinfinal;?>
<form method="get" action="fechamento.php">
  Conta:
    <select name="conta" class="textBox" id="conta">
    <option value="selecione" selected="selected">- Selecione a Conta -</option>
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
  <input name="dataini" type="date" />
at&eacute; <input name="datafin" type="date" /> 
<input type="submit" name="Buscar" id="Buscar" value="Buscar" />
</form>
<table width="100%"  class="full_table_cad">
	<tr>
		<td width="5%" align="center"><div align="center"><strong>Tipo de Receita</strong></div></td>
		<td><div align="center"><strong> Data de Fechamento</strong></div></td>

        <td><div align="center"><strong>Valor</strong></div></td>
       
  </tr>

<?php
include 'includes/conectar.php';
$date = date("Y-m-d");


if($conta =='selecione'){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ DEVE SELECIONAR A CONTA')
    history.go(-1);
    </SCRIPT>");
	return;
}



//TODAS AS CONTAS
if($conta == '*'&&$dataini == ""&&$datafin == ""){
	
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' GROUP BY tipo, data_pagto ORDER BY data_pagto");
	
	
}
//TODAS AS CONTAS - PERIODO INICIAL
if($conta == '*'&&$dataini != ""&&$datafin == ""){
	
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND data_pagto >='$dataini' GROUP BY tipo, data_pagto ORDER BY data_pagto");

}

//TODAS AS CONTAS - PERIODO FINAL
if($conta == '*'&&$dataini == ""&&$datafin != ""){
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND data_pagto <='$datafin' GROUP BY tipo, data_pagto ORDER BY data_pagto");
	
	
}


//OUTRAS CONTAS
if($conta != "*"&&$dataini == ""&&$datafin == ""){
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND conta =  '$conta' GROUP BY tipo, data_pagto ORDER BY data_pagto");
	
}



//OUTRAS CONTAS - PERIODO INICIAL
if($conta != "*"&&$dataini != ""&&$datafin == ""){
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND conta =  '$conta' AND data_pagto >='$dataini' GROUP BY tipo, data_pagto ORDER BY data_pagto");
	
}


//OUTRAS CONTAS - PERIODO FINAL
if($conta != "*"&&$dataini == ""&&$datafin != ""){
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND conta =  '$conta' AND data_pagto <='$datafin' GROUP BY tipo, data_pagto ORDER BY data_pagto");
	
}

//OUTRAS CONTAS - PERIODO INICIAL E FINAL
if($conta != '*'&&$dataini != ""&&$datafin != ""){
	$extrato = mysql_query("SELECT SUM( valor_pagto ) AS VALOR, data_pagto AS DATA, tipo as TIPO FROM titulos WHERE data_pagto <>  '' AND conta =  '$conta' AND (data_pagto BETWEEN '$dataini' AND '$datafin') GROUP BY tipo, data_pagto ORDER BY data_pagto");
}



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($extrato);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    history.back();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem

    while ($dados = mysql_fetch_array($extrato)) {
        // enquanto houverem resultados...
		$valor          = $dados["VALOR"];
		$valorfinal		= number_format($valor, 2, ',', '.');
		$data			 = $dados["DATA"];
		$tipotitulo          = $dados["TIPO"];
		$dia = substr($data,8,2);
		$mes = substr($data,5,2);
		$ano = substr($data,0,4);
		$datafinal = $dia."/".$mes."/".$ano;
		if($tipotitulo == 2 || $tipotitulo == 99){
			$tipo = "<font color='blue'><b>+</b></font>";
			$cor = "<font color='black'>R$ $valorfinal</font>";
		}
		if($tipotitulo == 1){
			$tipo = "<font color='red'><b>-</b></font>";
			$cor = "<font color='red'>R$ $valorfinal</font>";
		}
        echo "
	<tr align='center'>
		<td align='center'>&nbsp;<strong>$tipo</strong></td>
		<td>&nbsp;$datafinal</td>
		<td>&nbsp;<a href=\"javascript:abrir('detalhe_fechamento.php?data=$data&tipo=$tipotitulo&conta=$conta')\">$tipo  $cor</a></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
</table>
</div>
<?php include 'menu/footer.php' ?>


<script language="JavaScript">
    function abrir(URL) {
     
      var width = 900;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
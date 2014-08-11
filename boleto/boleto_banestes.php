<?php require_once('Connections/local.php'); ?>
<?php require_once('conectar.php'); ?>
<title>Boleto CEDTEC Virtual</title>
<div align="center"><a href="javascript:window.print()">Imprimir essa P&aacute;gina </a>
<a href="javascript:window.print()"><img src="clique.gif" width="36" height="36" /></a></div>
<?php


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
//

//

$maxRows_Recordset1 = 100;
$pageNum_Recordset1 = 0;
if (isset($_GET['pageNum_Recordset1'])) {
  $pageNum_Recordset1 = $_GET['pageNum_Recordset1'];
}
$startRow_Recordset1 = $pageNum_Recordset1 * $maxRows_Recordset1;

$colname_Recordset1 = "-1";
$codigo = $_GET['id'];
$cliente = $_GET['id2'];
$parcela = $_GET['p'];


	mysql_select_db($database_local, $local);
	//
	$query_Recordset1 = sprintf("SELECT * FROM cliente_fornecedor WHERE codigo LIKE '$cliente'", GetSQLValueString("%" . $colname_Recordset1 . "%", "text"));

	$query_limit_Recordset1 = sprintf("%s LIMIT %d, %d", $query_Recordset1, $startRow_Recordset1, $maxRows_Recordset1);
	$Recordset1 = mysql_query($query_limit_Recordset1, $local) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	
	
 
if (isset($_GET['totalRows_Recordset1'])) {
  $totalRows_Recordset1 = $_GET['totalRows_Recordset1'];
} else {
  $all_Recordset1 = mysql_query($query_Recordset1);
  $totalRows_Recordset1 = mysql_num_rows($all_Recordset1);
}
$totalPages_Recordset1 = ceil($totalRows_Recordset1/$maxRows_Recordset1)-1;

if ( $totalRows_Recordset1 == 0) 
echo"<script laguage='javascript'>alert('Sem Resultados!!!');history.go(-1);</script>";

?>

<?php
//VARIAVEIS NOVAS - BOLETOS GERADOS PELO PINCEL ATÔMICO
$re    = mysql_query("select count(*) as total FROM geral_titulos WHERE id_titulo LIKE '$codigo' AND parcela LIKE '$parcela'");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("SELECT * FROM geral_titulos WHERE id_titulo LIKE '$codigo' AND parcela LIKE '$parcela'");
	
	$dados = mysql_fetch_array($re);	
	$atual = date("Y-m-d");
	$cc_tit = $dados["c_custo"];
	$contape = $dados["conta"];
	$contasel = mysql_query("SELECT * FROM contas WHERE ref_conta = '$contape'");
	$dadosconta = mysql_fetch_array($contasel);
	$razao = $dadosconta["razao"];
	$cnpj_empresa = $dadosconta["cnpj"];
	$cc_titulo = substr($cc_tit,2,2);
	$valoratual = $dados["valor"];
	$juros1 = $dados["juros1"];
	$juros2 = $dados["juros2"];
	$juros3 = $dados["juros3"];
	$juros4 = $dados["juros4"];
	$desconto = $dados["desconto"];
	$acrescimo = $dados["acrescimo"];
	$pago = $dados["data_pagto"];
	$recebido = $dados["valor_pagto"];
	$dia = substr($dados["vencimento"],8,2);
	$mes = substr($dados["vencimento"],5,2);
	$ano = substr($dados["vencimento"],0,4);
	//INICIA CALCULO DINÂMICO DE JUROS
		
		$sql_calculo = mysql_query("SELECT t1.id_titulo, t1.vencimento, t1.valor, t1.dias_atraso, 
		t1.multa, t1.juros_dia, t1.honorario,
		t1.multa+t1.juros_dia+t1.honorario as acrescimos_totais,
		t1.valor+t1.multa+t1.juros_dia+t1.honorario as valor_calculado
		
		FROM (
		SELECT id_titulo, vencimento,data_pagto, valor_pagto, valor, DATEDIFF(NOW(), vencimento) as dias_atraso,  status,
		
		IF(DATEDIFF(NOW(), vencimento) >=1,0.02*valor,0) as multa,
		IF(DATEDIFF(NOW(), vencimento) >=1,((DATEDIFF(NOW(), vencimento)-1)* 0.00233)*(valor),0) as juros_dia,
		IF(DATEDIFF(NOW(), vencimento) >=11,0.10*(valor+(((DATEDIFF(NOW(), vencimento)-1)* 0.00233)*valor)+(0.02*valor)),0) as honorario

		
		
		FROM titulos 
		) as t1
		WHERE (t1.data_pagto = '' OR t1.data_pagto IS NULL) AND t1.status = 0 AND t1.id_titulo = $codigo");
		if(mysql_num_rows($sql_calculo)==1){
			$dados_calculo = mysql_fetch_array($sql_calculo);
			$juros1 = $dados_calculo["multa"];
			$juros2 = $dados_calculo["juros_dia"];
			$juros3 = $dados_calculo["honorario"];
			$juros4 = 0;
		} else {
			$juros1 = 0;
			$juros2 = 0;
			$juros3 = 0;
			$juros4 = 0;	
		}
		
	mysql_query("UPDATE titulos SET juros1 = '$juros1', juros2 = '$juros2', juros3 = '$juros3', juros4 = '$juros4' WHERE id_titulo = '$codigo'");
	$meses = 0;
	$diaatual = date("d");
	if($pago <> ""){
		echo"<script laguage='javascript'>alert('ESTE BOLETO JÁ FOI PAGO');
		window.close();</script>";
	}
	
	$dia_atual = date("d");
	$mes_atual = date("m");
	$ano_atual = date("Y");
	$timestamp_atual = mktime(0,0,0,$mes_atual,$dia_atual,$ano_atual); 
	$timestamp_2 = mktime(0,0,0,$mes,$dia,$ano); 
	$dias_atraso = ($timestamp_atual - $timestamp_2 ) / (60 * 60 * 24);
	/*if($mes <> date("m")&&$ano <= date("Y")){
		$meses = date("m") - $mes;
		$dias = ($diaatual - $dia)+(30*$meses);
	} else {
		$meses = 0;
		$dias = ($diaatual - $dia)+(30*$meses);
	}*/
	
	if($dias_atraso >=12&&$pago == ""&&$contape <> 'B00CB'){
		mysql_query("UPDATE titulos SET conta = 'B00CB' WHERE id_titulo LIKE '$codigo'");
		echo"<script laguage='javascript'>
			window.close();
			window.opener.location.reload();</script>";
	}
	if($contape == "B00CB"){
		$desc_boleto = $dados["descricao"];	
	} else {
		$desc_boleto = "";	
	}
	

	
		

}


$re2    = mysql_query("select count(*) as total FROM contas WHERE ref_conta LIKE '$contape'");	
$total = mysql_result($re2, 0, "total");

if($total == 1) {
	$re2    = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$contape'");
	$dados2 = mysql_fetch_array($re2);	
}

$re3    = mysql_query("select count(*) as total FROM cc2 WHERE c_banco LIKE '$contape'");	
$total2 = mysql_result($re3, 0, "total");

if($total == 1) {
	$re3    = mysql_query("SELECT * FROM cc2 WHERE c_banco LIKE '$contape'");
	$dados3 = mysql_fetch_array($re3);	
}

?>



<?php
function CalculaDigitoMod11($NumDado, $NumDig, $LimMult){

  $Dado = $NumDado;
  for($n=1; $n<=$NumDig; $n++){
    $Soma = 0;
    $Mult = 2;
    for($i=strlen($Dado) - 1; $i>=0; $i--){
      $Soma += $Mult * intval(substr($Dado,$i,1));
      if(++$Mult > $LimMult) $Mult = 2;
    }
    $Dado .= strval(fmod(fmod(($Soma * 10), 11), 10));
  }
  return substr($Dado, strlen($Dado)-$NumDig);
}

$dvnum = CalculaDigitoMod11($row_Recordset1['codigo'], 2, 12);
$codigocli = $row_Recordset1['codigo'];
$nome = $row_Recordset1['nome'];
$rg = $row_Recordset1['cpf_cnpj'];
$endereco = $row_Recordset1['endereco'];
$cidade = $row_Recordset1['cep'];
$cep = $row_Recordset1['cep'];
$valor = $dados["valor"] + + $juros1 + $juros2+ $juros3 + $juros4 +$dados["acrescimo"] - (($dados["valor"]*$dados["desconto"])/100);

if($dados["vencimento"] < $atual){
	$dia = substr($atual,8,2);
	$mes = substr($atual,5,2);
	$ano = substr($atual,0,4);
	$valor = $dados["valor"] + $juros1 + $juros2+ $juros3 + $juros4 +$dados["acrescimo"] ;
 
} else {
	$vencimento = $dados["vencimento"];
	$dia = substr($vencimento,8,2);
	$mes = substr($vencimento,5,2);
	$ano = substr($vencimento,0,4);
	$valor = $dados["valor"] + + $juros1 + $juros2+ $juros3 + $juros4 +$dados["acrescimo"]- (($dados["valor"]*$dados["desconto"])/100);

	}

$parcelas = $dados["parcela"];
$codigoboleto = $dados["id_titulo"];
$conferirvalor = stripos($valor,",");
if($conferirvalor == true){
	$valortotal == $valor;
	}
if($conferirvalor == false){
	$valortotal = number_format($valor, 2, ',', '');
	}
// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 1;
$taxa_boleto = 0.00;
$data_venc = $dia."/".$mes."/".$ano;
//$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = $valor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

$dadosboleto["nosso_numero"] = "$codigoboleto";  // Nosso numero sem o DV - REGRA: Máximo de 8 caracteres!
$dadosboleto["numero_documento"] = "00$codigoboleto";	// Num do pedido ou do documento
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valortotal; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "$nome    --- CNPJ/CPF : $rg";
$dadosboleto["endereco1"] = "Endereco :  $endereco ";
$dadosboleto["endereco2"] = "CEP: $cep  ";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "Matrícula: $cliente<br>Parcela $parcela referente ao curso CEDTEC<br> $desc_boleto";
$dadosboleto["demonstrativo2"] = "Acréscimo - R$ ".number_format($acrescimo, 2, ',', '');
$dadosboleto["demonstrativo3"] = "CEDTEC virtual: www.cedtec.com.br";
$dadosboleto["instrucoes1"] = "- Sr. Caixa, ";
$dadosboleto["instrucoes2"] = "- Não receber após o Vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: cedtecvirtual@cedtecvirtual.com.br";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema de Pré Matrícula CEDTEC - www.cedtec.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS DA SUA CONTA - BANESTES
$dadosboleto["conta"] = $dados2["n_conta"]; 	// Num da conta corrente
$dadosboleto["agencia"] = $dados2["agencia"]; 	    // Num da agência

// DADOS PERSONALIZADOS - BANESTES
$dadosboleto["carteira"] = "11"; // Carteira do Tipo COBRANÇA SEM REGISTRO (Carteira 00) - Não é Carteira 11
$dadosboleto["tipo_cobranca"] = "2";  // 2- Sem registro; 
									  // 3- Caucionada; 
									  // 4,5,6 e 7-Cobrança com registro

// SEUS DADOS
$dadosboleto["identificacao"] = $razao;
$dadosboleto["cpf_cnpj"] = $dados3["cnpj"];
$dadosboleto["endereco"] = $dados3["endereco"].chr(10)."-".chr(10).$dados3["bairro"].chr(10)."- CEP".chr(10).$dados3["cep"];
$dadosboleto["cidade_uf"] = $dados3["cidade"];
$dadosboleto["cedente"] = $razao;

// NÃO ALTERAR!
include("include/funcoes_banestes.php"); 
include("include/layout_banestes.php");
?>

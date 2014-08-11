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
	$cc_titulo = substr($cc_tit,2,2);
	$valoratual = $dados["valor"];
	$doc_fiscal = substr($dados["nfe"],2,10);
	
	$juros1 = $dados["juros1"];
	$juros2 = $dados["juros2"];
	$juros3 = $dados["juros3"];
	$juros4 = $dados["juros4"];
	$conta = $dados["conta"];
	$conta_lt = substr($dados["conta"],3,2);
	$contadados    = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$conta'");
	$dadosconta = mysql_fetch_array($contadados);
	$desconto = (($dados["desconto"]*$dados["valor"])/100);
	$acrescimo = $dados["acrescimo"];
	$pago = trim($dados["data_pagto"]);
	$datadoc = $dados["dt_doc"];
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
		$dias = ($diaatual - $dia)+(30*$meses);}*/
	
	if($dias_atraso >=12&&$pago == ""&&$conta <> 'B00CB'&&$conta_lt<>"LT"&&$doc_fiscal <> "REM-201402"){
		mysql_query("UPDATE titulos SET conta = 'B00CB' WHERE id_titulo LIKE '$codigo'");
		echo"<script laguage='JavaScript'>
		window.close();
		window.opener.location.reload();</script>";
	}
	
	
}


$re2    = mysql_query("select count(*) as total FROM cc2 WHERE id_filial LIKE '$cc_titulo'");	
$total = mysql_result($re2, 0, "total");

if($total == 1) {
	$re2    = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$cc_titulo'");
	$dados2 = mysql_fetch_array($re2);	
}

$codigocli = $row_Recordset1['codigo'];
$nome = $row_Recordset1['nome'];
$realuno    = mysql_query("SELECT * FROM alunos WHERE codigo LIKE '$codigocli'");
$dadosaluno = mysql_fetch_array($realuno);
$alunonome = strtoupper(($dadosaluno["nome"]));
$responsavel = strtoupper(($dadosaluno["nome_fin"]));
$responsavel_cpf = $dadosaluno["cpf_fin"];
$rg = $row_Recordset1['cpf_cnpj'];
if(trim($responsavel)==''){
$reresp    = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo LIKE '$codigocli'");
$dadosresp = mysql_fetch_array($reresp);
$responsavel = strtoupper(($dadosresp["nome"]));
$responsavel_cpf = strtoupper(($dadosresp["cpf_cnpj"]));
}
	
$juros4 = 0; //JUOS ALTERADO CONFORME PERTEL ADVOGADOS
$endereco = $row_Recordset1['endereco'];
$cidade = $row_Recordset1['cep'];
$cep = $row_Recordset1['cep'];
$valor_desconto = ($dados["valor"] + $dados["juros1"] + $dados["juros2"]+ $dados["juros3"] + $dados["juros4"] +$dados["acrescimo"]) - (($dados["desconto"]*$dados["valor"])/100);
$valor = ($dados["valor"] + $dados["juros1"] + $dados["juros2"]+ $dados["juros3"] + $dados["juros4"] +$dados["acrescimo"]);

if($dados["juros1"] >= 1){
	$vencimento = $dados["vencimento"];
	$dia = substr($atual,8,2);
	$diadesconto = $dados["dia_desc"];
	$mes = substr($atual,5,2);
	$ano = substr($atual,0,4);
} else {
	$vencimento = $dados["vencimento"];
	$dia = substr($vencimento,8,2);
	$mes = substr($vencimento,5,2);
	$diadesconto = $dados["dia_desc"];
	$ano = substr($vencimento,0,4);}

if(substr($conta,3,2) == "EA"){
	$diadesconto = $dia;
}

$parcelas = $dados["parcela"];
$codigoboleto = $dados["id_titulo"];
$conferirvalor = stripos($valor,",");
if($conferirvalor == true){
	$valortotal == $valor;
	$valortotal_desconto == $valor_desconto;
	}
if($conferirvalor == false){
	$valortotal = number_format($valor, 2, ',', '');
	$valortotal_desconto = number_format($valor_desconto, 2, ',', '');
	}

?>


<?php
// +----------------------------------------------------------------------+
// | BoletoPhp - Versão Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo está disponível sob a Licença GPL disponível pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Você deve ter recebido uma cópia da GNU Public License junto com     |
// | esse pacote; se não, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaborações de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de João Prado Maia e Pablo Martins F. Costa                |
// |                                                                      |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------------+
// | Equipe Coordenação Projeto BoletoPhp: <boletophp@boletophp.com.br>         |
// | Desenvolvimento Boleto Santander-Banespa : Fabio R. Lenharo                |
// +----------------------------------------------------------------------------+


// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

// DADOS DO BOLETO PARA O SEU CLIENTE
$dias_de_prazo_para_pagamento = 1;
$taxa_boleto = 0;
$data_venc = $dia."/".$mes."/".$ano;
//date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
$valor_cobrado = "$valortotal"; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
$valor_cobrado_desconto = "$valortotal_desconto";
$valor_cobrado = str_replace(",", ".",$valor_cobrado);
$valor_cobrado_desconto = str_replace(",", ".",$valor_cobrado_desconto);
$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
$valor_boleto_desconto=number_format($valor_cobrado_desconto, 2, ',', '');

$dadosboleto["nosso_numero"] = $codigoboleto;  // Nosso numero sem o DV - REGRA: Máximo de 7 caracteres!
$dadosboleto["numero_documento"] = "00$codigoboleto";	// Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = substr($datadoc,8,2)."/".substr($datadoc,5,2)."/".substr($datadoc,0,4); // Data de emissão do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "$responsavel    --- CNPJ/CPF : $responsavel_cpf";
$dadosboleto["endereco1"] = "Endereco :  $endereco";
$dadosboleto["endereco2"] = "CEP: $cep  ";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "<b>Matrícula: $cliente - Aluno:</b> $alunonome <br>- Para pagamento até o dia $diadesconto/$mes/$ano receber valor de R$ $valor_boleto_desconto.  ";
$dadosboleto["demonstrativo3"] = "Acréscimo - R$ ".number_format($acrescimo, 2, ',', '')."<br>Desconto - R$ ".number_format($desconto, 2, ',', '');
$dadosboleto["demonstrativo2"] = "- Após $diadesconto/$mes/$ano receber valor de R$ $valor_boleto.<br>- Após $dia/$mes/$ano receber valor de R$ $valor_boleto acrescido dos encargos.";
$dadosboleto["instrucoes1"] = "<b>Aluno:</b> $alunonome <br>- Para pagamento até o dia $diadesconto/$mes/$ano receber valor de R$ $valor_boleto_desconto.  ";
$dadosboleto["instrucoes2"] = "- Após $diadesconto/$mes/$ano receber valor de R$ $valor_boleto.<br>- Não receber após vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: comunicacao@cedtec.com.br";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Pincel Atômico - www.cedtec.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
if(trim($dadosconta["agencia"]) == "552"){
	echo "
	<script language=\"javascript\">
	alert('Este boleto foi inv&aacute;lidado, tente imprimi-lo novamente. ');
	window.close();
	window.opener.location.reload();
	</script>";	
}

// DADOS PERSONALIZADOS - SANTANDER BANESPA
$dadosboleto["codigo_cliente"] = $dadosconta["cedente"]; // Código do Cliente (PSK) (Somente 7 digitos)
$dadosboleto["ponto_venda"] = $dadosconta["agencia"]; // Ponto de Venda = Agencia
$dadosboleto["carteira"] = "101";  // Cobrança Simples - SEM Registro
$dadosboleto["carteira_descricao"] = "101SRCR";  // Descrição da Carteira

// SEUS DADOS
$dadosboleto["identificacao"] =  $dadosconta["razao"];
$dadosboleto["cpf_cnpj"] = substr($dadosconta["cnpj"],0,2).".".substr($dadosconta["cnpj"],2,3).".".substr($dadosconta["cnpj"],5,3)."/".substr($dadosconta["cnpj"],8,4)."-".substr($dadosconta["cnpj"],12,2);
$dadosboleto["endereco"] ='' ;//$dados2["endereco"].chr(10)."-".chr(10).$dados2["bairro"].chr(10)."- CEP".chr(10).$dados2["cep"];
$dadosboleto["cidade_uf"] ='' ;//$dados2["cidade"];
$dadosboleto["cedente"] = $dadosconta["razao"];

// NÃO ALTERAR!
include("include/funcoes_santander_banespa.php"); 
include("include/layout_santander_banespa.php");
?>

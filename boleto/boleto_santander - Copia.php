<?php require_once('Connections/local.php'); ?>
<?php require_once('conectar.php'); ?>
<title>Boleto CEDTEC Virtual</title>
<div align="center"><a href="javascript:window.print()">Imprimir essa P�gina </a>
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
//VARIAVEIS NOVAS - BOLETOS GERADOS PELO PINCEL AT�MICO
$re    = mysql_query("select count(*) as total FROM titulos WHERE id_titulo LIKE '$codigo' AND parcela LIKE '$parcela'");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("SELECT * FROM titulos WHERE id_titulo LIKE '$codigo' AND parcela LIKE '$parcela'");
	$dados = mysql_fetch_array($re);	
	$atual = date("Y-m-d");
	$cc_tit = $dados["c_custo"];
	$cc_titulo = substr($cc_tit,2,2);
	$valoratual = $dados["valor"];
	$juros1 = $dados["juros1"];
	$juros2 = $dados["juros2"];
	$juros3 = $dados["juros3"];
	$juros4 = $dados["juros4"];
	$desconto = (($dados["desconto"]*$dados["valor"])/100);
	$acrescimo = $dados["acrescimo"];
	$pago = $dados["data_pagto"];
	$datadoc = $dados["dt_doc"];
	$recebido = $dados["valor_pagto"];
	$dia = substr($dados["vencimento"],8,2);
	$mes = substr($dados["vencimento"],5,2);
	$ano = substr($dados["vencimento"],0,4);
	$meses = 0;
	$diaatual = date("d");
	if($pago <> ""){
		echo"<script laguage='javascript'>alert('ESTE BOLETO J� FOI PAGO');
		window.close();</script>";}
	
	
	if($mes <> date("m")&&$ano == date("Y")){
		$meses = date("m") - $mes;
		$dias = ($diaatual - $dia)+(30*$meses);
	} else {
		$meses = 0;
		$dias = ($diaatual - $dia)+(30*$meses);}
	
	
	
	//JUROS DE 0,23% AP�S A DATA DE VENCIMENTO POR DIA
	if($dados["vencimento"] < $atual&&$recebido ==""&&$ano == date("Y")){
		$juros2 = ($dados["valor"]*0.00233)*$dias;
		mysql_query("UPDATE titulos SET juros2 = $juros2 WHERE id_titulo LIKE '$codigo'");
		
		}
		
	//JUROS DE 5% AP�S 5 DIAS DE ATRASO
	if($dias >= 5&&$juros3 == 0&&$recebido ==""&&$ano == date("Y")){
		$juros3 = $dados["valor"]*0.05;
		mysql_query("UPDATE titulos SET juros3 = $juros3 WHERE id_titulo LIKE '$codigo'");
		}
		
	//JUROS DE 10% AP�S 30 DIAS DE ATRASO
	if($dias >= 30&&$juros4 == 0&&$recebido ==""&&$ano == date("Y")){
		$juros4 = $dados["valor"]*0.10;
		mysql_query("UPDATE titulos SET juros4 = $juros4 WHERE id_titulo LIKE '$codigo'");
		}
		
	//JUROS DE 2% AP�S O VENCIMENTO
	if($dias >=1&&$juros1 == 0&&$recebido ==""&&$ano == date("Y")){
		$juros1 = ($dados["valor"])*0.02;
		$descfinal = $dados["descricao"].chr(10)."| EM ATRASO | MULTA GERADA PELO SISTEMA";
		mysql_query("UPDATE titulos SET juros1 = '$juros1', descricao = '$descfinal' WHERE id_titulo LIKE $codigo");
		}
	
	if($_GET['refreshed'] != 'yes'){ 
echo "<meta http-equiv=\"refresh\" content=\"0;url={$_SERVER['REQUEST_URI']}&refreshed=yes\">";
	$jurostotal = $juros1+$juros2+$juros3+$juros4;
	mysql_query("INSERT INTO juros (id_titulo, valor_original, juros_total) VALUES ('$codigo', '$valoratual', '$jurostotal')");
	 
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
$rg = $row_Recordset1['cpf_cnpj'];
$endereco = $row_Recordset1['endereco'];
$cidade = $row_Recordset1['cep'];
$cep = $row_Recordset1['cep'];
$valor_desconto = ($dados["valor"] + $dados["juros1"] + $dados["juros2"]+ $dados["juros3"] + $dados["juros4"] +$dados["acrescimo"]) - (($dados["desconto"]*$dados["valor"])/100);
$valor = ($dados["valor"] + $dados["juros1"] + $dados["juros2"]+ $dados["juros3"] + $dados["juros4"] +$dados["acrescimo"]);

if($dados["juros1"] >= 1){
	$vencimento = $dados["vencimento"];
	$dia = substr($atual,8,2);
	$diadesconto = '05';
	$mes = substr($atual,5,2);
	$ano = substr($atual,0,4);
} else {
	$vencimento = $dados["vencimento"];
	$dia = substr($vencimento,8,2);
	$mes = substr($vencimento,5,2);
	$diadesconto = '05';
	$ano = substr($vencimento,0,4);}

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
// | BoletoPhp - Vers�o Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo est� dispon�vel sob a Licen�a GPL dispon�vel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voc� deve ter recebido uma c�pia da GNU Public License junto com     |
// | esse pacote; se n�o, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colabora��es de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Jo�o Prado Maia e Pablo Martins F. Costa                |
// |                                                                      |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+

// +----------------------------------------------------------------------------+
// | Equipe Coordena��o Projeto BoletoPhp: <boletophp@boletophp.com.br>         |
// | Desenvolvimento Boleto Santander-Banespa : Fabio R. Lenharo                |
// +----------------------------------------------------------------------------+


// ------------------------- DADOS DIN�MICOS DO SEU CLIENTE PARA A GERA��O DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formul�rio c/ POST, GET ou de BD (MySql,Postgre,etc)	//

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

$dadosboleto["nosso_numero"] = $codigoboleto;  // Nosso numero sem o DV - REGRA: M�ximo de 7 caracteres!
$dadosboleto["numero_documento"] = "00$codigoboleto";	// Num do pedido ou nosso numero
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = substr($datadoc,8,2)."/".substr($datadoc,5,2)."/".substr($datadoc,0,4); // Data de emiss�o do Boleto
$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula

// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = "$nome    --- CNPJ/CPF : $rg";
$dadosboleto["endereco1"] = "Endereco :  $endereco";
$dadosboleto["endereco2"] = "CEP: $cep  ";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "- Para pagamento at� o dia $diadesconto/$mes/$ano receber valor de R$ $valor_boleto_desconto.  ";
$dadosboleto["demonstrativo3"] = "Acr�scimo - R$ ".number_format($acrescimo, 2, ',', '')."<br>Desconto - R$ ".number_format($desconto, 2, ',', '');
$dadosboleto["demonstrativo2"] = "- Ap�s $diadesconto/$mes/$ano receber valor de R$ $valor_boleto.<br>- Ap�s $dia/$mes/$ano receber valor de R$ $valor_boleto acrescido dos encargos.";
$dadosboleto["instrucoes1"] = "- Para pagamento at� o dia $diadesconto/$mes/$ano receber valor de R$ $valor_boleto_desconto.  ";
$dadosboleto["instrucoes2"] = "- Ap�s $diadesconto/$mes/$ano receber valor de R$ $valor_boleto.<br>- Ap�s $dia/$mes/$ano receber valor de R$ $valor_boleto acrescido dos encargos.";
$dadosboleto["instrucoes3"] = "- Em caso de d�vidas entre em contato conosco: comunicacao@cedtec.com.br";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Pincel At�mico - www.cedtec.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //


// DADOS PERSONALIZADOS - SANTANDER BANESPA
$dadosboleto["codigo_cliente"] = "6359051"; // C�digo do Cliente (PSK) (Somente 7 digitos)
$dadosboleto["ponto_venda"] = "4751"; // Ponto de Venda = Agencia
$dadosboleto["carteira"] = "101";  // Cobran�a Simples - SEM Registro
$dadosboleto["carteira_descricao"] = "101SRCR";  // Descri��o da Carteira

// SEUS DADOS
$dadosboleto["identificacao"] = "CEDTEC - Centro de Desenvolvimento T�cnico";
$dadosboleto["cpf_cnpj"] = $dados2["cnpj"];
$dadosboleto["endereco"] = $dados2["endereco"].chr(10)."-".chr(10).$dados2["bairro"].chr(10)."- CEP".chr(10).$dados2["cep"];
$dadosboleto["cidade_uf"] = $dados2["cidade"];
$dadosboleto["cedente"] = "Centro de Desenvolvimento T�cnico";

// N�O ALTERAR!
include("include/funcoes_santander_banespa.php"); 
include("include/layout_santander_banespa.php");
?>

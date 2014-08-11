<?php 
function numeroEscrito($n) {
 
    $numeros[1][0] = '';
    $numeros[1][1] = 'um';
    $numeros[1][2] = 'dois';
    $numeros[1][3] = 'três';
    $numeros[1][4] = 'quatro';
    $numeros[1][5] = 'cinco';
    $numeros[1][6] = 'seis';
    $numeros[1][7] = 'sete';
    $numeros[1][8] = 'oito';
    $numeros[1][9] = 'nove';
 
    $numeros[2][0] = '';
    $numeros[2][10] = 'dez';
    $numeros[2][11] = 'onze';
    $numeros[2][12] = 'doze';
    $numeros[2][13] = 'treze';
    $numeros[2][14] = 'quatorze';
    $numeros[2][15] = 'quinze';
    $numeros[2][16] = 'dezesseis';
    $numeros[2][17] = 'dezesete';
    $numeros[2][18] = 'dezoito';
    $numeros[2][19] = 'dezenove';
    $numeros[2][2] = 'vinte';
    $numeros[2][3] = 'trinta';
    $numeros[2][4] = 'quarenta';
    $numeros[2][5] = 'cinquenta';
    $numeros[2][6] = 'sessenta';
    $numeros[2][7] = 'setenta';
    $numeros[2][8] = 'oitenta';
    $numeros[2][9] = 'noventa';
 
    $numeros[3][0] = '';
    $numeros[3][1] = 'cento';
    $numeros[3][2] = 'duzentos';
    $numeros[3][3] = 'trezentos';
    $numeros[3][4] = 'quatrocentos';
    $numeros[3][5] = 'quinhentos';
    $numeros[3][6] = 'seiscentos';
    $numeros[3][7] = 'setecentos';
    $numeros[3][8] = 'oitocentos';
    $numeros[3][9] = 'novecentos';
 
    $qtd = strlen($n);
 
    $compl[0] = ' mil ';
    $compl[1] = ' milhão ';
    $compl[2] = ' milhões ';
    $numero = "";
    $casa = $qtd;
    $pulaum = false;
    $x = 0;
    for ($y = 0; $y < $qtd; $y++) {
 
        if ($casa == 5) {
 
            if ($n[$x] == '1') {
 
                $indice = '1' . $n[$x + 1];
                $pulaum = true;
            } else {
 
                $indice = $n[$x];
            }
 
            if ($n[$x] != '0') {
 
                if (isset($n[$x - 1])) {
 
                    $numero .= ' e ';
                }
 
                $numero .= $numeros[2][$indice];
 
                if ($pulaum) {
 
                    $numero .= ' ' . $compl[0];
                }
            }
        }
 
        if ($casa == 4) {
 
            if (!$pulaum) {
 
                if ($n[$x] != '0') {
 
                    if (isset($n[$x - 1])) {
 
                        $numero .= ' e ';
                    }
                }
            }
 
            $numero .= $numeros[1][$n[$x]] . ' ' . $compl[0];
        }
 
        if ($casa == 3) {
 
            if ($n[$x] == '1' && $n[$x + 1] != '0') {
 
                $numero .= 'cento ';
            } else {
 
                if ($n[$x] != '0') {
 
                    if (isset($n[$x - 1])) {
 
                        $numero .= ' e ';
                    }
 
                    $numero .= $numeros[3][$n[$x]];
                }
            }
        }
 
        if ($casa == 2) {
 
            if ($n[$x] == '1') {
 
                $indice = '1' . $n[$x + 1];
                $casa = 0;
            } else {
 
                $indice = $n[$x];
            }
 
            if ($n[$x] != '0') {
 
                if (isset($n[$x - 1])) {
 
                    $numero .= ' e ';
                }
 
                $numero .= $numeros[2][$indice];
            }
        }
 
        if ($casa == 1) {
 
            if ($n[$x] != '0') {
                if ($numeros[1][$n[$x]] <= 10)
                    $numero .= ' ' . $numeros[1][$n[$x]];
                else
                    $numero .= ' e ' . $numeros[1][$n[$x]];
            } else {
 
                $numero .= '';
            }
        }
 
        if ($pulaum) {
 
            $casa--;
            $x++;
            $pulaum = false;
        }
 
        $casa--;
        $x++;
    }
 
    return $numero;
}
function escreverValorMoeda($n){
    //Converte para o formato float 
    if(strpos($n, ',') !== FALSE){
        $n = str_replace('.','',$n); 
        $n = str_replace(',','.',$n);
    }
 
    //Separa o valor "reais" dos "centavos"; 
    $n = explode('.',$n);
 
    return ucfirst(numeroEscrito($n[0])). ' reais' . ((isset($n[1]) && $n[1] > 0)?' e '.numeroEscrito($n[1]).' centavos.':'');
 
}

?>


<?php require_once('Connections/local.php'); ?>
<?php require_once('conectar.php'); ?>
<title>Boleto CEDTEC Virtual</title>
<div align="center"><a href="javascript:window.print()">Imprimir essa Página </a>
<a href="javascript:window.print()"><img src="clique.gif" width="36" height="36" /></a></div>
<p>
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

if(date("m") == 1){
	$mesescrito = "Janeiro";}
if(date("m") == 2){
	$mesescrito = "Fevereiro";}
if(date("m") == 3){
	$mesescrito = "Março";}
if(date("m") == 4){
	$mesescrito = "Abril";}
if(date("m") == 5){
	$mesescrito = "Maio";}
if(date("m") == 6){
	$mesescrito = "Junho";}
if(date("m") == 7){
	$mesescrito = "Julho";}
if(date("m") == 8){
	$mesescrito = "Agosto";}
if(date("m") == 9){
	$mesescrito = "Setembro";}
if(date("m") == 10){
	$mesescrito = "Outubro";}
if(date("m") == 11){
	$mesescrito = "Novembro";}
if(date("m") == 12){
	$mesescrito = "Dezembro";}



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
	$conta = $dados["conta"];
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
	$meses = 0;
	$diaatual = date("d");
	
	
	if($mes <> date("m")&&$ano == date("Y")){
		$meses = date("m") - $mes;
		$dias = ($diaatual - $dia)+(30*$meses);
	} else {
		$meses = 0;
		$dias = ($diaatual - $dia)+(30*$meses);}
	
	
	
	//JUROS DE 0,23% APÓS A DATA DE VENCIMENTO POR DIA
	if($dados["vencimento"] < $atual&&$recebido ==""&&$ano == date("Y")){
		$juros2 = ($dados["valor"]*0.00233)*$dias;
		mysql_query("UPDATE titulos SET juros2 = $juros2 WHERE id_titulo LIKE '$codigo'");
		
		}
		
	//JUROS DE 5% APÓS 5 DIAS DE ATRASO
	if($dias >= 5&&$juros3 == 0&&$recebido ==""&&$ano == date("Y")){
		$juros3 = $dados["valor"]*0.05;
		mysql_query("UPDATE titulos SET juros3 = $juros3 WHERE id_titulo LIKE '$codigo'");
		}
		
	//JUROS DE 10% APÓS 30 DIAS DE ATRASO
	if($dias >= 30&&$juros4 == 0&&$recebido ==""&&$ano == date("Y")){
		$juros4 = $dados["valor"]*0.10;
		mysql_query("UPDATE titulos SET juros4 = $juros4 WHERE id_titulo LIKE '$codigo'");
		}
		
	//JUROS DE 2% APÓS O VENCIMENTO
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


$re2    = mysql_query("select count(*) as total FROM cc2 WHERE c_banco LIKE '$contape'");	
$total = mysql_result($re2, 0, "total");

if($total >= 1 ||$total == 0 ) {
	$contape2 = substr($contape,3,2);
	$re3    = mysql_query("SELECT * FROM cc2 WHERE c_banco LIKE '$contape' OR id_filial LIKE '$contape2' LIMIT 1");
	$dados3 = mysql_fetch_array($re3);	
}


$codigocli = $row_Recordset1['codigo'];
$re4    = mysql_query("SELECT * FROM geral WHERE codigo LIKE '$codigocli' ORDER BY modulo DESC LIMIT 1");
$dados4 = mysql_fetch_array($re4);	
$nome = $row_Recordset1['nome'];
$modulo = $dados4['modulo'];
$nivel = $dados4['nivel'];
$curso = $dados4['curso'];
$rg = $row_Recordset1['cpf_cnpj'];
$endereco = $row_Recordset1['endereco'];
$cidade = $row_Recordset1['cep'];
$cep = $row_Recordset1['cep'];
$valor_desconto = ($dados["valor"] + $dados["juros1"] + $dados["juros2"]+ $dados["juros3"] + $dados["juros4"] +$dados["acrescimo"]) - (($dados["desconto"]*$dados["valor"])/100);
$valor = ($dados["valor_pagto"]);

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
$dadosboleto["sacado"] = "$nome    --- CNPJ/CPF : $rg";
$dadosboleto["endereco1"] = "Endereco :  $endereco";
$dadosboleto["endereco2"] = "CEP: $cep  ";

// INFORMACOES PARA O CLIENTE
$dadosboleto["demonstrativo1"] = "- Para pagamento até o dia $diadesconto/$mes/$ano receber valor de R$ $valor_boleto_desconto.  ";
$dadosboleto["demonstrativo3"] = "Acréscimo - R$ ".number_format($acrescimo, 2, ',', '')."<br>Desconto - R$ ".number_format($desconto, 2, ',', '');
$dadosboleto["demonstrativo2"] = "- Após $diadesconto/$mes/$ano receber valor de R$ $valor_boleto.<br>- Após $dia/$mes/$ano receber valor de R$ $valor_boleto acrescido dos encargos.";
$dadosboleto["instrucoes1"] = "- Para pagamento até o dia $diadesconto/$mes/$ano receber valor de R$ $valor_boleto_desconto.  ";
$dadosboleto["instrucoes2"] = "- Após $diadesconto/$mes/$ano receber valor de R$ $valor_boleto.<br>- Após $dia/$mes/$ano receber valor de R$ $valor_boleto acrescido dos encargos.<br>- Multa de 2% após o vencimento";
$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: comunicacao@cedtec.com.br";
$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Pincel Atômico - www.cedtec.com.br";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "";		
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "DM";


// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


// DADOS PERSONALIZADOS - SANTANDER BANESPA
$dadosboleto["codigo_cliente"] = $dadosconta["cedente"]; // Código do Cliente (PSK) (Somente 7 digitos)
$dadosboleto["ponto_venda"] = $dadosconta["agencia"]; // Ponto de Venda = Agencia
$dadosboleto["carteira"] = "101";  // Cobrança Simples - SEM Registro
$dadosboleto["carteira_descricao"] = "101SRCR";  // Descrição da Carteira

// SEUS DADOS
$dadosboleto["identificacao"] =  $dadosconta["razao"];
$dadosboleto["cpf_cnpj"] = $dadosconta["cnpj"];
$dadosboleto["endereco"] = $dados3["endereco"].chr(10)."-".chr(10).$dados3["bairro"].chr(10)."- CEP".chr(10).$dados3["cep"];
$dadosboleto["cidade_uf"] = $dados3["cidade"]." - ". $dados3["uf"];
$dadosboleto["cedente"] = $dadosconta["razao"];

// NÃO ALTERAR!


?>
</p>
<table width="100%" border="1" style="border-style:double;">
  <tr>
    <td colspan="2" align="center"><img src="imagens/logopincel.png" width="80" /></td>
    <td width="76%" align="center" valign="middle"><h2>Comprovante de Pagamento</h2></td>
  </tr>
  
  <tr>
    <td width="12%" height="25" align="center"><font size="-3"><?php echo date("d/m/Y");?></font></td>
    <td width="12%" align="center"><font size="-3"><?php echo date("h:i:s");?></font></td>
    <td><font size="-1"><b>Empresa:</b> <?php echo $dadosboleto["identificacao"];?><br />
    <b>CNPJ: </b> <?php echo $dadosboleto["cpf_cnpj"];?><br />
    <b>Endereço:</b> <?php echo $dadosboleto["endereco"];?> |  <?php echo $dadosboleto["cidade_uf"];?></font></td>
  </tr>
  <tr>
    <td colspan="3"><p>Recebemos de <?php echo strtoupper($nome);?>, matr&iacute;culado(a) no <?php echo $modulo;?>&ordm; M&Oacute;DULO do curso <?php echo strtoupper($nivel);?>: <?php echo strtoupper($curso);?>, a quantia de R$<?php echo number_format($dados["valor_pagto"], 2, ',', '.');?> (<?php echo escreverValorMoeda(number_format($dados["valor_pagto"], 2, ',', '.'));?>) referente ao pagamento de:</p>
      <table width="100%" border="1">
        <tr bgcolor="#CCCCCC">
          <th scope="col">Parcela(s)</th>
          <th scope="col">Vencimento</th>
          <th scope="col">Valor Principal</th>
          <th scope="col">Desconto</th>
          <th scope="col">Juros e Multa</th>
          <th scope="col">Pagamento</th>
          <th scope="col">Valor Pago</th>
        </tr>
        <tr>
          <td align="center"><?php echo $dados["parcela"];?></td>
          <td align="center"><?php echo substr($dados["vencimento"],8,2)."/".substr($dados["vencimento"],5,2)."/".substr($dados["vencimento"],0,4);?></td>
          <td align="center">R$ <?php echo number_format($dados["valor"], 2, ',', '.');?></td>
          <td align="center">R$ <?php echo number_format(($dados["valor"]*$dados["desconto"])/100, 2, ',', '.');?></td>
          <td align="center">R$ <?php echo number_format($dados["juros1"]+$dados["juros2"]+$dados["juros3"]+$dados["juros4"], 2, ',', '.');?></td>
          <td align="center"><?php echo substr($dados["data_pagto"],8,2)."/".substr($dados["data_pagto"],5,2)."/".substr($dados["data_pagto"],0,4);?></td>
          <td align="center">R$ <?php echo number_format($dados["valor_pagto"], 2, ',', '.');?></td>
          
        </tr>
      </table>
      <p><br />
    </p></td>
  </tr>
  
</table>
<p><font size="-1"><?php echo $dadosboleto["cidade_uf"];?></font> , <?php echo date("d");?> de <?php echo $mesescrito;?> de <?php echo date("Y");?></p>
<p align="center">&nbsp;</p>
<p align="center">_________________________________<br />
  Setor Financeiro</p>

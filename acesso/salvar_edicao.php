
<?php
include('includes/conectar.php');
include('menu/tabela.php');
if($_SERVER["REQUEST_METHOD"] == "POST") {
$id           = $_POST["id"];
$pagamento         = $_POST["dtpag"];
$recebido         = $_POST["valor"];
$vencimento         = $_POST["vencimento"];
$valordoc         = $_POST["valordoc"];
$acrescimo         = $_POST["acrescimo"];
$desconto         = $_POST["desconto"];
$juros1         = $_POST["juros1"];
$juros2         = $_POST["juros2"];
$juros3         = $_POST["juros3"];
$juros4         = $_POST["juros4"];
$dia_desc         = str_pad($_POST["dia_desc"], 2, "0", STR_PAD_LEFT);;
$conta         = $_POST["conta"];
$nfe         = $_POST["nfe"];
$data_doc         = $_POST["dt_doc"];
$descricao         = $_POST["descricao"];
$tipo = $_POST["tipo"];
$processamento = date("Y-m-d H:i:s:U");
$valordocfinal		= str_replace(",",".",$valordoc);
$recebidofinal		= str_replace(",",".",$recebido);
$juros1final		= str_replace(",",".",$juros1);
$juros2final		= str_replace(",",".",$juros2);
$juros3final		= str_replace(",",".",$juros3);
$juros4final		= str_replace(",",".",$juros4);
$acrescimofinal		= str_replace(",",".",$acrescimo);
$descontofinal		= str_replace(",",".",$desconto);

if($conta == "selecione"){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
		window.alert('VOCÊ DEVE SELECIONAR A CONTA');
		history.back();
		</SCRIPT>");
		return;
		}


if(isset($_POST["ativo"])&&$recebido == 0){
	$status = 1;
} else {
	$status = 0;
}


	



$re    = mysql_query("select * from geral_titulos where id_titulo = $id");
	
$dados = mysql_fetch_array($re);
$pago = trim($dados["data_pagto"]);


//FAZ O UPDATE DA TABELA TITULOS
if($pago == "" || $user_nivel == 1 || $user_nivel == 2 || $user_nivel == 3 || $user_nivel == 4){
	
//zera o processamento do titulo
mysql_query("UPDATE titulos SET processamento = '0000-00-00' WHERE id_titulo = $id");

//VERIFICA SALDO ANTERIOR E FAZ O CALCULO

$saldo    = mysql_query("SELECT REPLACE(FORMAT(saldo, 2),',','') as SALDO FROM titulos WHERE processamento = ( SELECT MAX( processamento ) FROM titulos WHERE valor_pagto >  0 AND data_pagto <> '' AND conta = '$conta' )");
$saldofin = mysql_fetch_array($saldo);
$saldofinal2 = $saldofin["SALDO"];

//NOVO SALDO
if($tipo == 2 || $tipo == 99){
	$saldofinal = $saldofinal2 + $recebidofinal;
	$saldofinal3 = number_format($saldofinal, 2, '.','');
}
if($tipo == 1){
	$saldofinal = $saldofinal2 - $recebidofinal;
	$saldofinal3 = number_format($saldofinal, 2, '.','');
	}
// usuário
$user 				=$_SESSION['MM_Username'];
$atual = date("Y-m-d H:i:s");
$ipativo = $_SERVER["REMOTE_ADDR"];
//pega o cliente
	$sql_cliente = mysql_query("SELECT * FROM titulos where id_titulo = $id");
	$dados_cliente = mysql_fetch_array($sql_cliente);
	$cliente = $dados_cliente["nome"];
	$parcela = $dados_cliente["parcela"];
if(substr($nfe,2,3)=="REM"&&$parcela==1){
	$p_curso = mysql_query("SELECT * FROM curso_aluno WHERE matricula = '$cliente' AND grupo LIKE '%2014%' ORDER BY ref_id DESC LIMIT 1");
	$dados_pcurso = mysql_fetch_array($p_curso);
	$p_nivel = $dados_pcurso["nivel"]; 
	$p_curso = $dados_pcurso["curso"]; 
	$p_modulo = $dados_pcurso["modulo"] + 1; 
	$p_grupo = "2014/02";
	$p_turno = $dados_pcurso["turno"];
	$p_unidade = $dados_pcurso["unidade"];
	$p_polo = $dados_pcurso["polo"];
	mysql_query("INSERT INTO curso_aluno (ref_id, matricula, nivel, curso, modulo, grupo, turno, unidade, polo, grupo2)
								 VALUES (NULL, '$cliente', '$p_nivel', '$p_curso', '$p_modulo', '$p_grupo', '$p_turno', '$p_unidade', '$p_polo', '$p_grupo')");
}
//UPDATE
	if(@mysql_query("UPDATE titulos SET documento_fiscal = '$nfe', dt_doc = '$data_doc', data_pagto = '$pagamento',dia_desc = '$dia_desc',status = '$status',
	valor_pagto = '$recebidofinal', vencimento='$vencimento', descricao= '$descricao',valor= '$valordocfinal',juros1= '$juros1final',juros2= '$juros2final',juros3= '$juros3final',juros4= '$juros4final',acrescimo='$acrescimofinal',desconto='$descontofinal', conta = '$conta', saldo = '$saldofinal3', processamento = '$processamento' WHERE id_titulo = $id")) {
	
		if(mysql_affected_rows() == 1){
			mysql_query("INSERT INTO logs (usuario,data_hora,cod_acao,acao,ip_usuario)
VALUES ('$user','$atual','05','BAIXOU O TÍTULO $id NO VALOR DE R$ $recebidofinal - CONTA: $conta','$ipativo');");
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('TITULO ALTERADO COM SUCESSO');
			window.close();
			window.opener.location.reload();
			</SCRIPT>");
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível receber o título.";
			exit;
		}	
		@mysql_close();
	}
} else {
//teste
	if(@mysql_query("UPDATE titulos SET descricao= '$descricao',status = '$status', vencimento = '$vencimento',valor= '$valordocfinal',juros1= '$juros1final',juros2= '$juros2final',juros3= '$juros3final',juros4= '$juros4final' WHERE id_titulo = $id")) {
	
		if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('DESCRIÇÃO DO TITULO ALTERADA COM SUCESSO');
			window.close();
			window.opener.location.reload();
		</SCRIPT>");
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível receber o título.";
			exit;
		}	
		@mysql_close();
	}
}

}
?>
<a href="javascript:window.close()">Fechar</a>
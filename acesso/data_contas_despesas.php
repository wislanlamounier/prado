<?php include 'menu/menu.php' ?>
<?php 
$conta = $_GET['conta'];
$inicio = $_GET['dataini'];
$fim = $_GET['datafin'];
$transacao = $_GET['transacao'];
$empresa = $_GET['empresa'];
$trocarIsso = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ',);
$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','O','U','U','U','Y',);
$unidade = str_replace($trocarIsso, $porIsso, $_GET['unidade']);
if ($empresa == "*") {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ DEVE SELECIONAR UMA EMPRESA')
    window.location.href='contas_apagar.php';
    </SCRIPT>");
	return;
}
if ($inicio == "" || $fim =="") {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ DEVE SELECIONAR UM PERÍODO')
    window.location.href='contas_apagar.php';
    </SCRIPT>");
	return;
}
include 'includes/conectar.php';
$pesq_conta = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$conta'");
$dados = mysql_fetch_array($pesq_conta);
$pesq_emp = mysql_query("SELECT * FROM cc1 WHERE id_empresa LIKE '$empresa'");
$dados2 = mysql_fetch_array($pesq_emp);
if($unidade == "*"){
	$contaexib = "Contas (".$dados2['nome_cc1'].")";
} else {
	$contaexib = $dados["conta"];
	}
if($unidade <> "*"){
	$contaexib = "Contas (".strtoupper($unidade).")";
	}
if($transacao == "*"){
	$transacaoexib="Todas";	
	$sql_order = "ORDER BY vencimento, nome";
}
if($transacao == "<>"){
	$transacaoexib="Pagas";	
	$sql_order = "ORDER BY data_pagto, nome";
	$sql_filtro = "(data_pagto BETWEEN '$inicio' AND '$fim')";
}
if($transacao == "="){
	$transacaoexib="A Pagar";	
	$sql_order = "ORDER BY vencimento, nome";
	$sql_filtro = "(vencimento BETWEEN '$inicio' AND '$fim')";
}
if($user_unidade == ""){
	$comp_sql = "";
} else {
	$comp_sql = "AND conta_nome LIKE '%$user_unidade%'";
}

?>
<div class="conteudo">
<center><strong><font size="+1">Relat&oacute;rio: Contas a Pagar / Pagas</font></strong></center>
<hr />
<div class="filtro">
<form id="form1" name="form1" method="GET" action="data_contas_despesas.php">
Empresa: 
    <select name="empresa" class="textBox" id="empresa">
    <option value="*" selected="selected">Selecione</option>
    <?php
include("menu/config_drop.php");?>
    <?php
	if($user_empresa == 0){
		$sql = "SELECT * FROM cc1 ORDER BY nome_cc1";
	} else {
		$sql = "SELECT * FROM cc1 WHERE id_empresa = $user_empresa ORDER BY nome_cc1";
	}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_empresa'] . "'>" . $row['nome_cc1'] . "</option>";
}
?>
  </select>
  Unidade: 
    <select name="unidade" class="textBox" id="unidade">
  </select>
  Conta: 
    <select name="conta" class="textBox" id="conta">
    <option value="*" selected="selected">Geral</option>
  </select>
    <br />De:
<input type="date" name="dataini" id="dataini" value=""/>
At&eacute;: 
<input type="date" name="datafin" id="datafin" value="" />
Transa&ccedil;&atilde;o: 
    <select name="transacao" class="textBox" id="transacao">
    <option value="<>">Pagas</option>
    <option value="=">A Pagar</option>
  </select>
<input type="submit" name="Filtrar" id="Filtrar" value="Filtrar" />
</form>
<center><a href="javascript:window.print()">[IMPRIMIR]</a></center>
</div>
<table width="100%" border="1" class="full_table_receitas">
	<tr>
    <th colspan="2"><img src="images/logo-color.png" width="70" /><br />Pincel At&ocirc;mico <br /><font size="-5"><?php echo date("d/m/Y h:m:s");?></font></th>
    <th colspan="6">Relat&oacute;rio de Despesas (<?php echo $transacaoexib;?>)<br />Conta: <?php echo $contaexib; ?><br /> Per&iacute;odo: <?php echo substr($inicio,8,2)."/".substr($inicio,5,2)."/".substr($inicio,0,4) ;?> at&eacute; <?php echo substr($fim,8,2)."/".substr($fim,5,2)."/".substr($fim,0,4) ;?></th>
    
    </tr>
	<tr>
		<td><div align="center"><strong>T&iacute;tulo</strong></div></td>
		<td><div align="center"><strong>Fornecedor</strong></div></td>
        <td><div align="center"><strong>Descri&ccedil;&atilde;o</strong></div></td>
        <td style="color:#03C"><div align="center"><strong>Vencimento</strong></div></td>
        <td style="color:#03C"><div align="center"><strong>Valor</strong></div></td>
        <td><div align="center"><strong>Efetiva&ccedil;&atilde;o</strong></div></td>
        <td><div align="center"><strong>Valor</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
	</tr>

<?php


//TODAS UNIDADES
if($unidade=="*"&&$transacao =="*"&&$conta <>"*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE $sql_filtro AND tipo_titulo = 1 AND conta LIKE '$conta' AND empresa LIKE '$empresa' $comp_sql $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE (vencimento BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND tipo_titulo = 1 AND (valor_pagto = 0 OR data_pagto ='') AND empresa LIKE $comp_sql '$empresa'");
	$despesa2 = mysql_query("SELECT SUM( valor ) as despesapaga FROM geral_titulos WHERE (data_pagto BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND tipo_titulo = 1 AND (valor_pagto > 0 OR data_pagto <>'') AND empresa LIKE $comp_sql '$empresa'");
}
if($unidade=="*"&&$transacao =="*"&&$conta =="*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE $sql_filtro AND tipo_titulo = 1 AND empresa LIKE '$empresa' $comp_sql $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE (vencimento BETWEEN '$inicio' AND '$fim') AND tipo_titulo = 1 AND (valor_pagto = 0 OR data_pagto ='') AND empresa LIKE '$empresa' $comp_sql");
	$despesa2 = mysql_query("SELECT SUM( valor ) as despesapaga FROM geral_titulos WHERE (data_pagto BETWEEN '$inicio' AND '$fim') AND tipo_titulo = 1 AND (valor_pagto > 0 OR data_pagto <>'') AND empresa LIKE '$empresa' $comp_sql");
}
if($unidade=="*"&&$transacao <>"*"&&$conta =="*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE $sql_filtro OR (vencimento BETWEEN '$inicio' AND '$fim')) AND tipo_titulo = 1 AND data_pagto $transacao '' AND empresa LIKE '$empresa' $comp_sql $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE (vencimento BETWEEN '$inicio' AND '$fim') AND tipo_titulo = 1 AND (valor_pagto = 0 OR data_pagto ='') AND empresa LIKE '$empresa' $comp_sql");
	$despesa2 = mysql_query("SELECT SUM( valor ) as despesapaga FROM geral_titulos WHERE ((data_pagto BETWEEN '$inicio' AND '$fim') OR (vencimento BETWEEN '$inicio' AND '$fim')) AND tipo_titulo = 1 AND (valor_pagto > 0 OR data_pagto <>'') AND empresa LIKE '$empresa' $comp_sql");
}
if($unidade=="*"&&$transacao <>"*"&&$conta <>"*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE $sql_filtro OR (vencimento BETWEEN '$inicio' AND '$fim')) AND tipo_titulo = 1 AND conta LIKE '$conta' AND data_pagto $transacao '' AND empresa LIKE '$empresa' $comp_sql $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE (vencimento BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND tipo_titulo = 1 AND (valor_pagto = 0 OR data_pagto ='') AND empresa LIKE '$empresa' $comp_sql");
	$despesa2 = mysql_query("SELECT SUM( valor ) as despesapaga FROM geral_titulos WHERE ((data_pagto BETWEEN '$inicio' AND '$fim') OR (vencimento BETWEEN '$inicio' AND '$fim')) AND conta LIKE '$conta' AND tipo_titulo = 1 AND (valor_pagto > 0 OR data_pagto <>'') AND empresa LIKE '$empresa' $comp_sql");
}

//UNIDADES SELECIONADAS
if($unidade<>"*"&&$transacao =="*"&&$conta <>"*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE $sql_filtro AND tipo_titulo = 1 AND conta LIKE '$conta' AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'  $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE (vencimento BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND tipo_titulo = 1 AND (valor_pagto = 0 OR data_pagto ='') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
	$despesa2 = mysql_query("SELECT SUM( valor ) as despesapaga FROM geral_titulos WHERE (data_pagto BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND tipo_titulo = 1 AND (valor_pagto > 0 OR data_pagto <>'') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
}
if($unidade<>"*"&&$transacao =="*"&&$conta =="*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE $sql_filtro AND tipo_titulo = 1 AND conta_nome LIKE '%$unidade%' $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE (vencimento BETWEEN '$inicio' AND '$fim') AND tipo_titulo = 1 AND (valor_pagto = 0 OR data_pagto ='') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
	$despesa2 = mysql_query("SELECT SUM( valor ) as despesapaga FROM geral_titulos WHERE (data_pagto BETWEEN '$inicio' AND '$fim') AND tipo_titulo = 1 AND (valor_pagto > 0 OR data_pagto <>'') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
}
if($unidade<>"*"&&$transacao <>"*"&&$conta =="*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE $sql_filtro AND tipo_titulo = 1 AND data_pagto $transacao '' AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa' $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE (vencimento BETWEEN '$inicio' AND '$fim') AND tipo_titulo = 1 AND (valor_pagto = 0 OR data_pagto ='') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
	$despesa2 = mysql_query("SELECT SUM( valor ) as despesapaga FROM geral_titulos WHERE ((data_pagto BETWEEN '$inicio' AND '$fim') OR (vencimento BETWEEN '$inicio' AND '$fim')) AND tipo_titulo = 1 AND (valor_pagto > 0 OR data_pagto <>'') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
}
if($unidade<>"*"&&$transacao <>"*"&&$conta <>"*"){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE $sql_filtro AND tipo_titulo = 1 AND conta LIKE '$conta' AND data_pagto $transacao '' AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa' $sql_order");
	$despesa = mysql_query("SELECT SUM( valor ) as despesapagar FROM geral_titulos WHERE (vencimento BETWEEN '$inicio' AND '$fim') AND conta LIKE '$conta' AND tipo_titulo = 1 AND (valor_pagto = 0 OR data_pagto ='') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
	$despesa2 = mysql_query("SELECT SUM( valor ) as despesapaga FROM geral_titulos WHERE ((data_pagto BETWEEN '$inicio' AND '$fim') OR (vencimento BETWEEN '$inicio' AND '$fim')) AND conta LIKE '$conta' AND tipo_titulo = 1 AND (valor_pagto > 0 OR data_pagto <>'') AND conta_nome LIKE '%$unidade%' AND empresa LIKE '$empresa'");
}

$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='index.php';
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($l = mysql_fetch_array($despesa)) {
		$despesapagar = $l["despesapagar"];
	}
	while ($l = mysql_fetch_array($despesa2)) {
		$despesapaga = $l["despesapaga"];
	}
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = substr($dados["nome"],0,15);
		$descricao          = strtoupper(substr($dados["descricao"],0,30));
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = number_format($dados["valor"], 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = number_format($dados["valor_pagto"], 2, ',', '.');
		$ccusto          = $dados["c_custo"];
		$conta          = $dados["conta_nome"];
		$atual = date("Y-m-d");
		if($dados["valor_pagto"] == 0&&$vencimento < $atual){
			$cor = "#F08080";
		} else {
			$cor = "";
		}
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
        echo "
	<tr style=\"background:$cor\">
		<td align='center'><a href=\"javascript:abrir('editar2.php?id=$idtitulo')\">$idtitulo</a></td>
		<td>$cliente...</td>
		<td>$descricao...</td>
		<td style='color:#03C' align='center'>$venc</td>
		<td style='color:#03C' align='right'>R$ $valortitulo</td>
		<td align='center'>$pagamento</td>
		<td align='right'>R$ $valorpagt</td>
		<td>$conta</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

<tr>
<td colspan="9">
  <strong><font color="#009966">Contas Pagas:</strong> R$ <?php echo number_format($despesapaga, 2, ',', '.'); ?></font><br />
  <strong><font color="#CC0033">Contas a Pagar:</strong> R$ <?php echo number_format($despesapagar, 2, ',', '.'); ?></font>
  
  
  
  
  </td>
  
</tr>
</table>
<?php include 'menu/footer.php' ?>
</div>
<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o titulo? '))
{
location.href="apagar_despesas.php?id="+id;
}
else
{
return false;
}
}

function usuario(id){
alert("o nº de usuário é: "+id);
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
    
    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
	    <script type="text/javascript">
		$(function(){
			$('#empresa').change(function(){
				if( $(this).val() ) {
					$('#unidade').hide();
					$('.carregando').show();
					$.getJSON('unidade.ajax.php?search=',{empresa: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="*">Geral</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].unidade + '">' + j[i].unidade + '</option>';
						}	
						$('#unidade').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#unidade').html('<option value="*">Geral</option>');
				}
			});
		});
		</script>
<script type="text/javascript">
		$(function(){
			$('#unidade').change(function(){
				if( $(this).val() ) {
					$('#conta').hide();
					$('.carregando').show();
					$.getJSON('contas.ajax.php?search=',{unidade: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="*">Geral</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].ref_conta + '">' + j[i].conta + '</option>';
						}	
						$('#conta').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#conta').html('<option value="*">Geral</option>');
				}
			});
		});
		</script>
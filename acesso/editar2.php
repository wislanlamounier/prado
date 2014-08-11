
<?php
include('menu/tabela.php');
include('includes/conectar.php');
$id = $_GET["id"];
$re    = mysql_query("select count(*) as total from geral_titulos where id_titulo = $id");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("select * from geral_titulos where id_titulo = $id");
	
	$dados = mysql_fetch_array($re);
	$conta = $dados["conta"];

	
	$re2    = mysql_query("select * from contas where ref_conta like '$conta'");
	$dados2 = mysql_fetch_array($re2);
	$saldo    = mysql_query("SELECT REPLACE(FORMAT(saldo, 2),',','') as SALDO FROM titulos WHERE processamento = ( SELECT MAX( processamento ) FROM titulos WHERE valor_pagto <>  '' AND conta = '$conta' )");
	$saldofin = mysql_fetch_array($saldo);
	$saldofinal = $saldofin["SALDO"];
		
}
?>

<form id="form1" name="form1" method="post" action="salvar_edicao.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table class="full_table_list" width="100%" border="1" align="center">
  	<tr style="background:#0C9">
    <td colspan="2" style="border:1px #030303" align="center"><b>Dados do T&iacute;tulo</b></td>
    <td colspan="2" align="center"><b>Dados de Baixa</b></td>
    </tr>
    <tr>
    <td colspan="4"><strong>
      <input type="hidden" name="tipo" id="tipo" value="<?php echo $dados["tipo_titulo"] ?>" readonly="readonly"/>
    </strong></td>
    </tr>
    <tr bgcolor="#F7F7F7">
      <td><strong>T&iacute;tulo</strong></td>
      <td><input name="titulo" type="text" class="textBox2" id="titulo" value="<?php echo $dados["id_titulo"]; ?>" maxlength="10" readonly="readonly"/></td>
	<td  bgcolor="#C1FFC1"><strong>Conta: <font color="red">*</font></strong></td>
    <td bgcolor="#C1FFC1"><select name="conta" class="textBox2" id="conta">
      <option value="<?php echo $dados2["ref_conta"]?>"><?php echo $dados2["conta"]?></option>
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
      </select></td>
    
    </tr>
  <tr  bgcolor="#F7F7F7">
      <td><strong>Cliente / Fornecedor</strong></td>
      <td><input name="cliente" type="text" class="textBox22" id="cliente" value="<?php echo $dados["nome"]; ?>" maxlength="100" readonly="readonly"/></td>
	  <td  bgcolor="#C1FFC1"><strong>Data de Pagamento</strong></td>
      <td  bgcolor="#C1FFC1"><input name="dtpag" type="date" class="textBox2" id="dtpag" value="<?php echo $dados["data_pagto"]; ?>" maxlength="10" /></td>
    
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Nota Fiscal</strong></td>
      <td><input name="nfe" type="text" id="nfe" value="<?php echo $dados["nfe"]; ?>" /></td>
      <td  bgcolor="#C1FFC1"><strong>Valor Efetivado</strong></td>
      <td  bgcolor="#C1FFC1"><input name="valor" type="text" class="textBox2" id="valor" value="<?php echo $dados["valor_pagto"]; ?>" maxlength="10" /></td>
    </tr>
	<tr  bgcolor="#F7F7F7">
      <td><strong>Data do Documento</strong></td>
      <td><input name="dt_doc" rows="5" type="date" class="textBox2" id="dt_doc" value="<?php echo $dados["dt_doc"]; ?>" /></td>
      <td colspan="2" align="center" style="background:#0C9"><strong>Descri&ccedil;&atilde;o</strong></td>
    </tr>
	<tr  bgcolor="#F7F7F7">
      <td><strong>Vencimento do Documento</strong></td>
      <td><input name="vencimento" type="date" class="textBox2" id="vencimento" value="<?php echo $dados["vencimento"]; ?>" maxlength="100" /></td>
      <td colspan="2" rowspan="10" valign="top" align="center"><textarea name="descricao" rows="5" style="width:90%" class="textBox2" id="descricao"><?php echo $dados["descricao"]; ?></textarea></td>
    </tr>	
    <tr  bgcolor="#F7F7F7">
      <td><strong>Valor do Documento</strong></td>
      <td><input name="valordoc" type="text" class="textBox2" id="valordoc" value="<?php echo $dados["valor"]; ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td colspan="2" align="center" style="background:#0C9"><b>Acr&eacute;scimos e Descontos</b></td>
      </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Dia de Desconto</strong></td>
      <td><input name="dia_desc" type="text" class="textBox2" id="dia_desc" value="<?php echo $dados["dia_desc"]; ?>" maxlength="2" /></td>
      
    </tr>
    
    <tr  bgcolor="#F7F7F7">
      <td><strong>Acr&eacute;scimo</strong></td>
      <td><input name="acrescimo" type="text" class="textBox2" id="acrescimo" value="<?php echo $dados["acrescimo"]; ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Desconto</strong></td>
      <td><input name="desconto" type="text" class="textBox2" id="desconto" value="<?php echo $dados["desconto"]; ?>" maxlength="20"/></td>
    </tr>
	<tr  bgcolor="#F7F7F7">
	  <td><strong>Juros (Ap&oacute;s Vencimento)</strong></td>
	  <td><input name="juros1" type="text" class="textBox2" id="juros1" value="<?php echo $dados["juros1"]; ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Juros (Por dia de Atraso)</strong></td>
      <td><input name="juros2" type="text" class="textBox2" id="juros2" value="<?php echo $dados["juros2"]; ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Juros (5 dias de atraso)</strong></td>
      <td><input name="juros3" type="text" class="textBox2" id="juros3" value="<?php echo $dados["juros3"]; ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td><strong>Juros (30 dias de atraso)</strong></td>
      <td><input name="juros4" type="text" class="textBox2" id="juros4" value="<?php echo $dados["juros4"]; ?>" maxlength="20"/></td>
    </tr>
    <tr  bgcolor="#F7F7F7">
      <td colspan="4" align="center"><input name="tipo" type="hidden" class="textBox2" id="tipo" value="<?php echo $dados["tipo_titulo"]; ?>" maxlength="10" />
      <input type="submit" name="Submit" value="Salvar" style="cursor:pointer;"/></td>
    </tr>
  </table>
</form>

<script language="JavaScript">  
function FormataCpf(campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(campo.value);
				vr = vr.replace(".", "");
				vr = vr.replace("/", "");
				vr = vr.replace("-", "");
				tam = vr.length + 1;
				if (tecla != 14)
				{
					if (tam == 4)
						campo.value = vr.substr(0, 3) + '.';
					if (tam == 7)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 6) + '.';
					if (tam == 11)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(7, 3) + '-' + vr.substr(11, 2);
				}
			}   

function FormataData(campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(campo.value);
				vr = vr.replace(".", "");
				tam = vr.length + 1;
				if (tecla != 10)
				{
					if (tam == 3)
						campo.value = vr.substr(0, 2) + '/';
					if (tam == 6)
						campo.value = vr.substr(0, 2) + '/' + vr.substr(3, 6) + '/';
				}
			}   

  
  
function confirma()
{
var conta = form1.conta.value;
if (confirm('Deseja confirmar a baixa na conta: '+conta))
{
}
else
{
 return false;
}
}
//-->
</script>

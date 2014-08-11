<?php 
include ('menu/tabela.php');
?>
<?php
include('includes/conectar.php');
$id = $_GET["id"];
$id2 = $_GET["id2"];


$re    = mysql_query("select count(*) as total from view_tit_ccusto where id_titulo = $id AND id_custo = $id2");	
$total = mysql_result($re, 0, "total");

if($total == 1) {
	$re    = mysql_query("select * from view_tit_ccusto where id_titulo = $id AND id_custo = $id2");
	$dados = mysql_fetch_array($re);
	$b_cc1 = $dados["cc1"];
	$b_cc2 = $dados["cc2"];
	$b_cc3 = $dados["cc3"];
	$b_cc4 = $dados["cc4"];
	$b_cc5 = $dados["cc5"];
	$b_cc6 = $dados["cc6"];
	
	
	//BUSCA NOME CC1
		$sql_cc1 = mysql_query("SELECT * FROM cc1 WHERE id_empresa = '$b_cc1'");
		$d_cc1 = mysql_fetch_array($sql_cc1);
		$nome_cc1 = $d_cc1["nome_cc1"];
		if(trim($nome_cc1) == ""){
			$nome_cc1 = "----";
		}
		
		//BUSCA NOME CC2
		$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial = '$b_cc2'");
		$d_cc2 = mysql_fetch_array($sql_cc2);
		$nome_cc2 = $d_cc2["nome_filial"];
		if(trim($nome_cc2) == ""){
			$nome_cc2 = "----";
		}
		
		//BUSCA NOME CC3
		$sql_cc3 = mysql_query("SELECT * FROM cc3 WHERE id_cc3 = '$b_cc3'");
		$d_cc3 = mysql_fetch_array($sql_cc3);
		$nome_cc3 = $d_cc3["nome_cc3"];
		if(trim($nome_cc3) == ""){
			$nome_cc3 = "----";
		}
		
		
		//BUSCA NOME CC4
		$sql_cc4 = mysql_query("SELECT * FROM cc4 WHERE cc4 = '$b_cc4'");
		$d_cc4 = mysql_fetch_array($sql_cc4);
		$nome_cc4 = $d_cc4["nome_cc4"];
		if(trim($nome_cc4) == ""){
			$nome_cc4 = "----";
		}
		
		//BUSCA NOME CC5
		$sql_cc5 = mysql_query("SELECT * FROM cc5 WHERE cc5 = '$b_cc5' AND id_cc5 = '$b_cc4'");
		$d_cc5 = mysql_fetch_array($sql_cc5);
		$nome_cc5 = $d_cc5["nome_cc5"];
		if(trim($nome_cc5) == ""){
			$nome_cc5 = "----";
		}
		
		//BUSCA NOME CC6
		$sql_cc6 = mysql_query("SELECT * FROM cc6 WHERE id_cc6 = '$b_cc6'");
		$d_cc6 = mysql_fetch_array($sql_cc6);
		$nome_cc6 = $d_cc6["nome_cc6"];
		if(trim($nome_cc6) == ""){
			$nome_cc6 = "----";
		}


		
}
?>

<form id="form1" name="form1" method="post" action="salvar_ed_custo.php" onsubmit="return confirma(this)">
<br />
<table width="100%" border="0" class="full_table_cad" align="center">
<tr align="center">
    <td colspan="2">
      <b>Título</b>
    <input type="text" name="titulo" id="titulo" readonly="readonly" value="<?php echo $dados["id_titulo"];?>" /></td></td>
  </tr>
<tr align="center">
    <td colspan="2">
      <b>Pagamento</b>
    <input type="text" name="titulo" id="titulo" readonly="readonly" value="<?php echo substr($dados["data_pagto"],8,2)."/".substr($dados["data_pagto"],5,2)."/".substr($dados["data_pagto"],0,4);?>" /></td></td>
  </tr>
<tr align="center">
    <td colspan="2">
      <b>Valor</b>
    <input type="text" name="titulo" id="titulo" readonly="readonly" value="<?php echo number_format($dados["valor"],2,",",".");?>" /></td></td>
  </tr>
<tr align="center">
    <td colspan="2">
      <b>Descricao</b>
      <textarea name="titulo" readonly="readonly" id="titulo"><?php echo $dados["descricao"];?></textarea>
      
      <input type="hidden" name="cod_titulo" id="cod_titulo" value="<?php echo $id;?>" />
      <input type="hidden" name="id_custo" id="id_custo" value="<?php echo $id2;?>" /></td></td>
  </tr>
  <tr>
    <th scope="col">Centro de Custo (Antigo)</th>
    <th scope="col">Centro de Custo (Novo)</th>
  </tr>
  
  
  <tr align="center">
    <td>
      <input type="text" name="cc1a" id="cc1a" readonly="readonly" value="<?php echo $nome_cc1;?>" /></td>
    <td><select name="cc1" class="textBox" id="cc1" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc1;?>">SELECIONE A EMPRESA</option>
      <?php
include("menu/config_drop.php");?>
      <?php
if($user_empresa == 0){
		$sql = "SELECT * FROM cc1 ";
	  } else {
		$sql = "SELECT * FROM cc1 WHERE id_empresa = $user_empresa ";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_empresa'] . "'>" . $row['nome_cc1'] . "</option>";
}
?>
    </select></td>
    </tr>
  <tr align="center">
    <td><input type="text" name="cc2a" id="cc2a" readonly="readonly" value="<?php echo $nome_cc2;?>"/></td>
    <td><select name="cc2" class="textBox" id="cc2" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc2;?>">SELECIONE A FILIAL</option>
      <?php
include("menu/config_drop.php");?>>
      <?php
 if($user_unidade == ""){
		$sql = "SELECT * FROM cc2 WHERE niveltxt like '%GERAL%' ORDER BY nome_filial ";
	  } else {
		$sql = "SELECT * FROM cc2 WHERE niveltxt like '%GERAL%' AND nome_filial LIKE '%$user_unidade%' ORDER BY nome_filial ";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_filial'] . "'>" . $row['nome_filial'] . "</option>";
}
?>
    </select></td>
    </tr>
  <tr align="center">
    <td><input type="text" name="cc3a" id="cc3a" readonly="readonly" value="<?php echo $nome_cc3;?>" /></td>
    <td><select name="cc3" class="textBox" id="cc3" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc3;?>">SELECIONE</option>
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT * FROM cc3 ORDER BY id_cc3";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_cc3'] . "'>" . $row['nome_cc3'] . "</option>";
}
?>
    </select></td>
    </tr>
  <tr align="center">
    <td><input type="text" name="cc4a" id="cc4a" readonly="readonly" value="<?php echo $nome_cc4;?>" /></td>
    <td><select name="cc4" class="textBox" id="cc4" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc4;?>">SELECIONE</option>
    </select></td>
    </tr>
  <tr align="center">
    <td><input type="text" name="cc5a" id="cc5a" readonly="readonly" value="<?php echo $nome_cc5;?>" /></td>
    <td><select name="cc5" class="textBox" id="cc5" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc5;?>">SELECIONE</option>
    </select></td>
    </tr>
  <tr align="center">
    <td><input type="text" name="cc6a" id="cc6a" readonly="readonly" value="<?php echo $nome_cc6;?>"/></td>
    <td><select name="cc6" class="textBox" id="cc6" onkeypress="return arrumaEnter(this, event)">
      <option value="<?php echo $b_cc6;?>">SELECIONE</option>
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT * FROM cc6 ORDER BY id_cc6";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_cc6'] . "'>" . $row['nome_cc6'] . "</option>";
}
?>
    </select></td>
    </tr>
</table>
<center><input type="submit" name="Submit" value="Salvar" style="cursor:pointer;"/></center>
 

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

    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
	    <script type="text/javascript">
		$(function(){
			$('#cc3').change(function(){
				if( $(this).val() ) {
					$('#cc4').hide();
					$('.carregando').show();
					$.getJSON('cc4.ajax.php?search=',{cc3: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cc4 + '">' + j[i].nome_cc4 + '</option>';
						}	
						$('#cc4').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#cc4').html('<option value="">ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Å“ CC4 ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Å“</option>');
				}
			});
		});
		</script>
        




	    <script type="text/javascript">
		$(function(){
			$('#cc4').change(function(){
				if( $(this).val() ) {
					$('#cc5').hide();
					$('.carregando').show();
					$.getJSON('cc5.ajax.php?search=',{cc4: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cc5 + '">' + j[i].nome_cc5 + '</option>';
						}	
						$('#cc5').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#cc5').html('<option value="">ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Å“ CC5 ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Å“</option>');
				}
			});
		});
		</script>
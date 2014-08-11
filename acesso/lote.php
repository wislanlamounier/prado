<?php
include 'includes/conectar.php';

?>
<?php include 'menu/menu.php'; ?>



<div class="conteudo">
<center><strong><font size="+1">LOTE XML</font></strong></center>
<hr />
<form id="form1" name="form1" method="get" action="listar_lote.php">
  <font size="+2" style="text-align:left"></font>
  <table width="85%"border="0" align="center" cellspacing="5" class="full_table_cad" style="text-align:left">
    <tr>
    <td>Unidade:</td>
    <td><select name="unidade" class="textBox" id="unidade" onkeypress="return arrumaEnter(this, event)">
      <?php
include 'menu/config_drop.php';?>
      <?php
	  if($user_unidade == ""){
		$sql = "SELECT distinct unidade FROM unidades WHERE categoria > 0";
	  } else {
		$sql = "SELECT distinct unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' AND categoria > 0";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
    </select></td>
    <td width="37%" align="center"><select name="cc1" class="textBox" id="cc1" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE A EMPRESA</option>
      <?php
include 'menu/config_drop.php';?>
      <?php
	  if($user_empresa == 0){
		$sql = "SELECT * FROM cc1 ";
	  } else {
		 $sql = "SELECT * FROM cc1 WHERE id_empresa = $user_empresa";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_empresa'] . "'>" . $row['nome_cc1'] . "</option>";
}
?>
    </select></td>
  </tr>
  <tr>
    <td>Tipo:</td>
    <td><select name="tipo" class="textBox" id="tipo" onkeypress="return arrumaEnter(this, event)">
      <option value="2">Receita</option>
    </select></td>
    <td align="center"><select name="cc2" class="textBox" id="cc2" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE A FILIAL</option>
      <?php
include 'menu/config_drop.php';?>
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
  <tr>
    <td>Início:</td>
    <td><input type="date" required="required" name="inicio" id="inicio" onkeypress="return arrumaEnter(this, event)" /></td>
    <td align="center"><select name="cc3" class="textBox" id="cc3" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE</option>
      <?php
include 'menu/config_drop.php';?>
      <?php
$sql = "SELECT * FROM cc3 ORDER BY id_cc3";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_cc3'] . "'>" . $row['nome_cc3'] . "</option>";
}
?>
    </select></td>
    </tr>
  <tr>
    <td>Fim:</td>
    <td><input type="date" required="required" name="fim" id="fim" onkeypress="return arrumaEnter(this, event)" /></td>
    <td align="center"><select name="cc4" class="textBox" id="cc4" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE</option>
    </select></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><select name="cc5" class="textBox" id="cc5" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE</option>
    </select></td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><select name="cc6" class="textBox" id="cc6" onkeypress="return arrumaEnter(this, event)">
      <option value="">SELECIONE</option>
      <?php
include 'menu/config_drop.php';?>
      <?php
$sql = "SELECT * FROM cc6 ORDER BY id_cc6";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_cc6'] . "'>" . $row['nome_cc6'] . "</option>";
}
?>
    </select></td>
    </tr>

  
  <tr>
    <td colspan="3" align="center"><input type="submit" name="buscar" id="buscar" value="Buscar" /></td>
  </tr>
</table>

</form>
</div>
<?php include 'menu/footer.php' ?>

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
					$('#cc4').html('<option value="">– CC4 –</option>');
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
					$('#cc5').html('<option value="">– CC5 –</option>');
				}
			});
		});
		</script>
        
        
        
	    <script type="text/javascript">
		$(function(){
			$('#tipo').change(function(){
				if( $(this).val() ) {
					$('#fornecedor').hide();
					$('.carregando').show();
					$.getJSON('a1.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].codigo + '">' + j[i].nome + '</option>';
						}	
						$('#fornecedor').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#fornecedor').html('<option value="">– Cliente-Fornecedor –</option>');
				}
			});
		});
		</script>
        
<script language="javascript">
function arrumaEnter (field, event) {
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode == 13) {
var i;
for (i = 0; i < field.form.elements.length; i++)
if (field == field.form.elements[i])
break;
i = (i + 1) % field.form.elements.length;
field.form.elements[i].focus();
return false;
}
else
return true;
}
</script>
    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 900;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
    
<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check').checked){  
        document.getElementById('projeto').disabled = false;  
    } else {  
        document.getElementById('projeto').disabled = true;  
    }  
}  
</script> 
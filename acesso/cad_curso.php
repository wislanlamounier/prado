
<?php

$id = $_GET["id"];

include 'menu/tabela.php';
include 'includes/conectar.php';
?>

<form id="form1" name="form1" method="post" action="salvar_curso.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="430" border="0" align="center" class="full_table_cad">
        <td width="116">Matr&iacute;cula</td>
      <td width="304"><input name="nome" type="text" readonly="readonly" class="textBox" id="nome" value="<?php echo $id; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>N&iacute;vel</td>
      <td><select style="width:300px;"name="tipo" class="textBox" id="tipo" onKeyPress="return arrumaEnter(this, event)">
        
	<option value="Selecione">- Selecione o Tipo -</option>	
	<?php
			include('menu/config_drop.php');?>
        <?php
$sql = "SELECT distinct tipo FROM cursosead ORDER BY tipo";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . ($row['tipo']) . "'>" . (($row['tipo'])) . "</option>";
}
?>
      </select></td>
    </tr>
   <tr>
      <td>Curso</td>
      <td><select style="width:300px;"name="curso" class="textBox" id="curso" onKeyPress="return arrumaEnter(this, event)">
        
      </select></td>
    </tr>
   <tr>
      <td>M&oacute;dulo</td>
      <td><select style="width:300px;"name="mod" class="textBox" id="mod" onKeyPress="return arrumaEnter(this, event)">
        <option value="1" selected="selected">M&oacute;dulo I</option>
        <option value="2">M&oacute;dulo II</option>
        <option value="3">M&oacute;dulo III</option>
        
      </select></td>
    </tr>
    <tr>
      <td>Turno</td>
      <td><select style="width:300px;"name="turno" class="textBox" id="turno" onKeyPress="return arrumaEnter(this, event)">
        <?php
$sql = "SELECT distinct turno FROM cursosead ORDER BY turno";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['turno'] . "'>" . (($row['turno'])) . "</option>";
}
?>
      </select></td>
    </tr>
    <tr>
      <td>Grupo</td>
      <td><select style="width:300px;"name="grupo" class="textBox" id="grupo" onKeyPress="return arrumaEnter(this, event)">

        <?php
$sql = "SELECT distinct grupo FROM grupos ORDER BY vencimento";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . (($row['grupo'])) . "</option>";
}
?>
      </select></td>
    </tr>
    
    <tr>
      <td>Unidade</td>
      <td><select style="width:300px;"name="unidade" class="textBox" id="unidade" onKeyPress="return arrumaEnter(this, event)">
   
        <?php
$sql = "SELECT distinct unidade FROM unidades ORDER BY unidade";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . strtoupper($row['unidade']) . "'>" . strtoupper($row['unidade']) . "</option>";
}
?>
      </select></td>
    </tr>
<tr>
      <td>Polo (somente se for unidade EAD)</td>
      <td><select style="width:300px;"name="polo" class="textBox" id="polo" onKeyPress="return arrumaEnter(this, event)">
        <?php
$sql = "SELECT distinct unidade FROM unidades WHERE unidade NOT LIKE 'EAD' ORDER BY unidade";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . strtoupper($row['unidade']) . "'>" . strtoupper($row['unidade']) . "</option>";
}
?>
      </select></td>
    </tr>
    
<tr>
      <td>Gerar Financeiro</td>
      <td><select style="width:300px;"name="fin" class="textBox" id="fin" onKeyPress="return arrumaEnter(this, event)">
       <option value="2" selected="selected">N&atilde;o</option>
       <option value="1">Sim</option>
      
      
      </select></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>
  </table>

</form>

    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
	    <script type="text/javascript">
		$(function(){
			$('#tipo').change(function(){
				if( $(this).val() ) {
					$('#curso').hide();
					$('.carregando').show();
					$.getJSON('a1.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].curso + '">' + j[i].curso + '</option>';
						}	
						$('#curso').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso').html('<option value="selecione">– Selecione o Curso –</option>');
				}
			});
		});
		</script>

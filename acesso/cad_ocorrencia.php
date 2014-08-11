
<?php

$id = $_GET["id"];

include 'menu/tabela.php';
include 'includes/conectar.php';
?>

<form id="form1" name="form1" method="post" action="salvar_ocorrencia.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
  <table width="430" border="0" align="center" class="full_table_cad">
        <td width="116">Matr&iacute;cula</td>
      <td width="304"><input name="nome" type="text" readonly="readonly" class="textBox" id="nome" value="<?php echo $id; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Data</td>
      <td><input name="data" type="date" class="textBox" id="data" value="<?php echo date("Y-m-d")?>"  maxlength="100"/></td>
    </tr>
    <tr>
      <td>Tipo de Ocorr&ecirc;ncia</td>
      <td><select style="width:300px;"name="tipo" class="textBox" id="tipo" onkeypress="return arrumaEnter(this, event)">
        <option value="Selecione">- Selecione o Tipo -</option>
        <?php
include("menu/config_drop.php");?>
        <?php
$sql = "SELECT * FROM tipo_ocorrencia ORDER BY id";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . utf8_encode(($row['ocorrencia'])) . "</option>";
}
?>
      </select></td>
    </tr>
    
    <tr>
      <td>Turma</td>
      <td><input type="checkbox" id="check" onclick="habilitar();"  /><select disabled="disabled" style="width:600px;"name="turma" class="textBox" id="turma" onkeypress="return arrumaEnter(this, event)">
        <option value="0">- Escola a Turma -</option>
        <?php
include("menu/config_drop.php");?>
        <?php
$sql = "SELECT * FROM ced_turma_aluno A INNER JOIN ced_turma B ON A.id_turma = B.id_turma WHERE matricula = $id ORDER BY A.anograde";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_turma'] . "'>" . $row['nivel'] .": ".$row['curso'] ." (".$row['cod_turma'] . ") - " . $row['grupo'] . "</option>";
}
?>
      </select></td>
    </tr>

    <tr valign="top">
      <td>Ocorr&ecirc;ncia</td>
      <td><textarea name="ocorrencia" cols="20" rows="10" style="width:400px"class="textBox" id="ocorrencia"></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>
  </table>

</form>

<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check').checked){  
        document.getElementById('turma').disabled = false;  
    } else {  
        document.getElementById('turma').disabled = true;  
    }  
}  
</script> 
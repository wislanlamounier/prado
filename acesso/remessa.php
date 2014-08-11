<?php include 'menu/menu.php' ?>
<div class="conteudo">
<center><strong><font size="+1">Arquivo Remessa</font></strong></center>
<hr />
<form method="POST" action="gerar_remessa.php">
  Conta:
    <select name="conta" class="textBox" id="conta" style="width:350px;">
    <option value="selecione" selected="selected">- Selecione a Conta -</option>
    <?php
include 'menu/config_drop.php';?>
    <?php
	if($user_unidade == ""){
		$sql = "SELECT * FROM contas WHERE conta LIKE '%santander%' ORDER BY id_conta";
	} else {
		$sql = "SELECT * FROM contas WHERE conta LIKE '%santander%' AND conta LIKE '%$user_unidade%' ORDER BY id_conta";
	}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['ref_conta'] . "'>" . $row['conta'] . "</option>";
}
?>
  </select>
  
  De
  <input name="dataini" type="date" />
at&eacute; <input name="datafin" type="date" /> 
<input type="submit" name="Buscar" id="Buscar" value="Gerar Remessa" />
</form>
</div>
<?php include 'menu/footer.php' ?>

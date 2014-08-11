<?php include 'menu/menu.php' ?>
<script type='text/javascript' src='http://cedtec.com.br/js/jquery.toastmessage-min.js'></script>
<div class="conteudo">
<center><strong><font size="+1">Relat&oacute;rio: Extrato de Contas</font></strong></center>
<hr />
<form method="GET" action="caixa_conta.php">
  Conta:
    <select name="conta" class="textBox" id="conta">
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
  </select>
  
  De
  <input name="dataini" type="date" />
at&eacute; <input name="datafin" type="date" /> 
<input type="submit" name="Buscar" id="Buscar" value="Buscar" />
</form>
<BR />
<div align="center"><font size="+1" style="font-family:Verdana, Geneva, sans-serif">PARA EXIBIR RESULTADOS REALIZE A PESQUISA ACIMA.</font></div>

<BR />
</div>
<?php include 'menu/footer.php' ?>

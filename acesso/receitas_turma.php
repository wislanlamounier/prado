<?php include 'menu/menu.php' ?>
<div class="conteudo">
<center><strong><font size="+1">Relatório: Receitas / Turma</font></strong></center>
<hr />
<form method="GET" action="gerar_receita_turma.php">
  Unidade:
    <select name="unidade" class="textBox" id="unidade">
    <option value="selecione" selected="selected">- Selecione a Unidade -</option>
    <?php
include("menu/config_drop.php");?>
    <?php
	if($user_unidade == ""){
		$sql = "SELECT distinct unidade FROM unidades WHERE categoria > 0 OR unidade LIKE '%ead%' ORDER BY unidade";
	} else {
		$sql = "SELECT distinct unidade FROM unidades WHERE categoria > 0 AND unidade LIKE '%$user_unidade%' OR unidade LIKE '%ead%' ORDER BY unidade";
	}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
  </select>
  
  De
  <input name="dataini" type="date" />
at&eacute; <input name="datafin" type="date" /> 
<input type="submit" name="Buscar" id="Buscar" value="Pesquisar" />
</form>
<BR />
<div align="center"><font size="+1" style="font-family:Verdana, Geneva, sans-serif">PARA EXIBIR RESULTADOS REALIZE A PESQUISA ACIMA.</font></div>

<BR />
</div>
<?php include 'menu/footer.php' ?>

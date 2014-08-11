<?php include 'menu/menu.php' ?>
<div class="conteudo">
<center><strong><font size="+1">Relatório: Projetos</font></strong></center>
<hr />
<form method="GET" action="detalhe_projeto.php">
  Projeto:
    <select name="projeto" class="textBox" id="projeto">
    <?php
include 'menu/config_drop.php';?>
    <?php
$sql = "SELECT * FROM projetos ORDER BY projeto";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['codigo'] . "'>" . $row['projeto'] . "</option>";
}
?>
  </select>
  
  
<input type="submit" name="Buscar" id="Buscar" value="Pesquisar" />
</form>
<BR />
<div align="center"><font size="+1" style="font-family:Verdana, Geneva, sans-serif">PARA EXIBIR RESULTADOS REALIZE A PESQUISA ACIMA.</font></div>

<BR />
</div>
<?php include 'menu/footer.php' ?>

<?php include 'menu/menu.php' ?>
<div class="conteudo">
<center><strong><font size="+1">T&iacute;tulos a Pagar</font></strong></center>
<hr />
<form id="form1" name="form1" method="get" action="data_despesas.php">
  Conta: 
    <select name="conta" class="textBox" id="conta" style="width:auto;">
    <option value="*" selected="selected">- Selecione a Conta -</option>
    <?php
include ('menu/config_drop.php');?>
    <?php
if($user_unidade == ""){
	$sql = "SELECT * FROM contas ORDER BY conta";
} else {
	$sql = "SELECT * FROM contas WHERE conta LIKE '%$user_unidade%' ORDER BY conta";
}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['ref_conta'] . "'>" . utf8_encode($row['conta']) . "</option>";
}
?>
  </select>
    De:
<input type="date" name="dataini" id="dataini" value=""/>
At&eacute;: 
<input type="date" name="datafin" id="datafin" value="" />
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
<BR />
<div align="center"><font size="+1" style="font-family:Verdana, Geneva, sans-serif">PARA EXIBIR RESULTADOS SELECIONE O PER&Iacute;ODO ACIMA.</font></div>

<BR />
</div>
<?php include 'menu/footer.php' ?>

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o titulo? '))
{
location.href="apagar_despesa.php?id="+id;
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
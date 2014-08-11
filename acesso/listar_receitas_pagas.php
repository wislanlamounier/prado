<?php include 'menu/menu.php'; ?>
<div class="conteudo">
<center><strong><font size="+1">T&iacute;tulos Recebidos</font></strong></center>
<hr />
<form id="form1" name="form1" method="get" action="data_receitas_pagas.php">
 Unidade: 
    <select name="unidade" class="textBox" id="unidade" style="width:auto;">
    <option value="*" selected="selected">- Selecione a Unidade -</option>
    <?php
include ('menu/config_drop.php');?>
    <?php

if($user_unidade == ""){
	$sql = "SELECT distinct unidade FROM unidades ORDER BY unidade";
} else {
	$sql = "SELECT distinct unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' ORDER BY unidade";
}

$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
  </select>

 
  De: 
  <input type="date" name="dataini" id="dataini" />
At&eacute;: 
<input type="date" name="datafin" id="datafin" />
<input type="submit" name="Filtrar" id="Filtrar" value="Filtrar" />
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
location.href="apagar_receita.php?id="+id;
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

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar2.php?id="+data,'_blank');
}
else
{
return;
}

}
</SCRIPT>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
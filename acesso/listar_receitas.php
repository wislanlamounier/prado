<?php include 'menu/menu.php'; ?>
<script type='text/javascript' src='http://cedtec.com.br/js/jquery.toastmessage-min.js'></script>
<div class="conteudo">
<center>
<strong><font size="+1">T&iacute;tulos a Receber</font></strong> - <input class="botao" type="button" name="acessar" id="acessar" onClick="javascript:pesquisar()" value="PESQUISAR TITULO" />

</center>
<hr />
<form id="form2" name="form1" method="get" action="buscar_receitas.php">
  Nome:
  <input type="text" name="buscar" id="buscar" />
  <input type="submit" name="Buscar" id="Buscar" value="Pesquisar" />
  <br>
<input type="radio" name="tipo_cliente" id="tipo_cliente" checked value="1"> Aluno | <input type="radio" name="tipo_cliente" id="tipo_cliente" value="2"> Cliente/Fornecedor
</form>
<form id="form1" name="form1" method="get" action="data_receitas.php">
  De: 
  <input type="date" name="dataini" id="dataini" />
At&eacute;: 
<input type="date" name="datafin" id="datafin" />
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
<BR />
<div align="center"><font size="+1" style="font-family:Verdana, Geneva, sans-serif">PARA EXIBIR RESULTADOS REALIZE A PESQUISA DESEJADA ACIMA.</font></div>

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
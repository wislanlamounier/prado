<?php include 'menu/tabela.php'; ?>
<div class="conteudo">
<form id="form2" name="form1" method="post" onsubmit="validarAction(this);return false;">
  Nome:
  <input type="text" name="buscar" id="buscar" />
  <select style="width:300px;"name="tipo" class="textBox" id="tipo" onkeypress="return arrumaEnter(this, event)">
    <option value="pesquisar_caluno.php">Aluno</option>
    <option value="pesquisar_cfornecedor.php?tipo=2">Cliente / Fornecedor</option>
    <option value="pesquisar_cfornecedor.php?tipo=4">Funcionário</option>
    
  </select>
  <input type="submit" name="button" id="button" value="Buscar" />
</form>

<?php include 'menu/footer.php' ?>
</div>
<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o cliente/fornecedor? '))
{
location.href="apagar_forn.php?id="+id;
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
window.open("editar_forn.php?id="+data,'_blank');
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
function enviar(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor').value = valor;
this.close();
}
function enviar2(valor){
//nome = id do campo que irá receber o valor, esse campo deve da pagina que gerou o popup
//opener é elemento que faz a vinculação/referencia entre a window pai com a window filho ou popup
opener.document.getElementById('fornecedor2').value = valor;
this.close();
}
</script>
    </script>
    
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script> 
    
<?php include 'menu/menu.php'; ?>
<div class="conteudo">
<form id="form2" name="form1" method="post" action="buscar_interessado.php">
  Nome:
  <input type="text" name="buscar" id="buscar" />
  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
</form>


</div>
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

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
<?php include 'menu/footer.php' ?>

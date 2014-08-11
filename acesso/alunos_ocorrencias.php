<?php include 'menu/menu.php'; ?>
<div class="conteudo">
<form id="form2" name="form1" method="post" action="filtrar_ocorrencia.php">
      <select name="grupo" class="textBox" id="grupo" onKeyPress="return arrumaEnter(this, event)">
        <option value="selecione">- Selecione o Grupo - </option>
        <?php
include('includes/config_drop.php')?>
        <?php
$sql = "SELECT * FROM grupos ORDER BY vencimento";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . (($row['grupo'])) . "</option>";
}
?>
      </select>
      <select name="polo" class="textBox" id="polo" onKeyPress="return arrumaEnter(this, event)">
      <option value="selecione">- Selecione a Unidade -</option>	
        <?php
		if($user_unidade == "EAD"){
			$sql = "SELECT distinct unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' OR unidade LIKE '%EAD%' ORDER BY unidade";
		} else {
			$sql = "SELECT distinct unidade FROM unidades WHERE unidade LIKE '%$user_unidade%' AND categoria > 0 OR unidade LIKE '%EAD%'  ORDER BY unidade";
		}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . ($row['unidade']) . "'>" . (($row['unidade'])) . "</option>";
}
?>
      </select>
      
      <select name="tipo" class="textBox" id="tipo" onKeyPress="return arrumaEnter(this, event)">
        <option value="selecione">- Tipo de Ocorrência - </option>
        <?php
$sql = "SELECT * FROM tipo_ocorrencia ORDER BY ocorrencia";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id'] . "'>" . (($row['ocorrencia'])) . "</option>";
}
?>
      </select>
  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
</form>
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
    
    </script>

    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
	    <script type="text/javascript">
		$(function(){
			$('#tipo').change(function(){
				if( $(this).val() ) {
					$('#curso').hide();
					$('.carregando').show();
					$.getJSON('a1.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="selecione">- Selecione o Curso -</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].curso + '">' + j[i].curso + '</option>';
						}	
						$('#curso').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso').html('<option value="selecione">– Selecione o Curso –</option>');
				}
			});
		});
		</script>
        
<script language='JavaScript'>
function validarAction(frm){
   frm.action = frm.layout.value;
   frm.submit();
}
  </script>
<?php include 'menu/menu.php' ?>
<div class="conteudo">
<center><strong><font size="+1">Relat&oacute;rio: Títulos / Processamento</font></strong></center>
<hr />
<div class="filtro">
<form id="form1" name="form1" method="GET" action="data_processamento.php">
  Conta: 
    <select name="conta" class="textBox" id="conta">
    <option value="*" selected="selected">Geral</option>
    <?php
include 'menu/config_drop.php';?>
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
    <br />Data:
<input type="date" name="data" id="data" value="" required="required"/>
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
</div>
<BR />
<div align="center"><font size="+1" style="font-family:Verdana, Geneva, sans-serif">PARA EXIBIR RESULTADOS REALIZE A PESQUISA ACIMA.</font></div>
<div align="center"><BR />
</div>
</div>
<?php include 'menu/footer.php' ?>

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o titulo? '))
{
location.href="apagar_despesas.php?id="+id;
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
    
    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
	    <script type="text/javascript">
		$(function(){
			$('#empresa').change(function(){
				if( $(this).val() ) {
					$('#unidade').hide();
					$('.carregando').show();
					$.getJSON('unidade.ajax.php?search=',{empresa: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="*">Geral</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].unidade + '">' + j[i].unidade + '</option>';
						}	
						$('#unidade').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#unidade').html('<option value="*">Geral</option>');
				}
			});
		});
		</script>
<script type="text/javascript">
		$(function(){
			$('#unidade').change(function(){
				if( $(this).val() ) {
					$('#conta').hide();
					$('.carregando').show();
					$.getJSON('contas.ajax.php?search=',{unidade: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="*">Geral</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].ref_conta + '">' + j[i].conta + '</option>';
						}	
						$('#conta').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#conta').html('<option value="*">Geral</option>');
				}
			});
		});
		</script>
<?php include 'menu/menu.php' ?>
<div class="conteudo">
<center><strong><font size="+1">Relat&oacute;rio: Contas a Pagar / Pagas</font></strong></center>
<hr />
<div class="filtro">
<form id="form1" name="form1" method="GET" action="data_contas_despesas.php">
Empresa: 
    <select name="empresa" class="textBox" id="empresa">
    <option value="*" selected="selected">Selecione</option>
    <?php
include 'menu/config_drop.php';?>
    <?php
	if($user_empresa == 0){
		$sql = "SELECT * FROM cc1 ORDER BY nome_cc1";
	} else {
		$sql = "SELECT * FROM cc1 WHERE id_empresa = $user_empresa ORDER BY nome_cc1";	
	}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_empresa'] . "'>" . $row['nome_cc1'] . "</option>";
}
?>
  </select>
  Unidade: 
    <select name="unidade" class="textBox" id="unidade">
  </select>
  Conta: 
    <select name="conta" class="textBox" id="conta">
    <option value="*" selected="selected">Geral</option>
  </select>
    <br />De:
<input type="date" name="dataini" id="dataini" value=""/>
At&eacute;: 
<input type="date" name="datafin" id="datafin" value="" />
Transa&ccedil;&atilde;o: 
    <select name="transacao" class="textBox" id="transacao">
    <option value="<>">Pagas</option>
    <option value="=">A Pagar</option>
  </select>
<input type="submit" name="Filtrar" id="Filtrar" value="Filtrar" />
</form>
<BR />
<div align="center"><font size="+1" style="font-family:Verdana, Geneva, sans-serif">PARA EXIBIR RESULTADOS REALIZE A PESQUISA ACIMA.</font></div>
<div align="center"><font size="-1" style="font-family:Verdana, Geneva, sans-serif">Neste relat&oacute;rio n&atilde;o s&atilde;o exibidas as contas transit&oacute;rias.</font></div>

<BR />
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
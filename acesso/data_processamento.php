<?php include 'menu/menu.php';
$get_conta = $_GET["conta"];
$get_data = $_GET["data"];
include('includes/conectar.php');
$sql_processamento = mysql_query("SELECT * FROM geral_titulos WHERE processamento LIKE '%$get_data%' AND conta LIKE '$get_conta' AND data_pagto <> '' ORDER BY processamento ASC");

?>
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
<input type="date" name="data" id="data" value="<?php echo $get_data;?>"/>
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
</div>


<table class="full_table_list" width="100%" border="1">
<tr>
<td align="center"><b>T&iacute;tulo</b></td>
<td align="center"><b>Cliente / Fornecedor</b></td>
<td align="center"><b>Vencimento</b></td>
<td align="center"><b>Valor</b></td>
<td align="center"><b>Data de Pagamento</b></td>
<td align="center"><b>Valor Efetivado</b></td>
<td align="center"><b>Conta</b></td>
<td align="center"><b>Processamento</b></td>
</tr>
<?php
while($dados_proc = mysql_fetch_array($sql_processamento)){
	$id_titulo = $dados_proc["id_titulo"];
	$processamento = substr($dados_proc["processamento"],8,2)."/".substr($dados_proc["processamento"],5,2)."/".substr($dados_proc["processamento"],0,4)." ".substr($dados_proc["processamento"],11,8);
	$vencimento = substr($dados_proc["vencimento"],8,2)."/".substr($dados_proc["vencimento"],5,2)."/".substr($dados_proc["vencimento"],0,4);
	$data_pagto = substr($dados_proc["data_pagto"],8,2)."/".substr($dados_proc["data_pagto"],5,2)."/".substr($dados_proc["data_pagto"],0,4);
	$valor = number_format($dados_proc["valor"],2,",",".");
	$valor_pagto = number_format($dados_proc["valor_pagto"],2,",",".");
	$conta = $dados_proc["conta_nome"];
	
	
	//SELECIONA O CLIENTE
	$cod_cliente = $dados_proc["codigo"];
	$sql_cliente = mysql_query("SELECT * FROM alunos WHERE codigo = '$cod_cliente'");
	if(mysql_num_rows($sql_cliente)== 0){
		$sql_cliente2 = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = '$cod_cliente'");
	} else {
		$sql_cliente2 = mysql_query("SELECT * FROM alunos WHERE codigo = '$cod_cliente'");
	}
	$dados_cliente = mysql_fetch_array($sql_cliente2);
	$nome_cliente = substr($dados_cliente["nome"],0,20)."...";
	
	echo "<tr>
		<td align=\"center\"><a href=\"javascript:abrir('editar.php?id=$id_titulo')\">$id_titulo</a></td>
		<td>$nome_cliente</td>
		<td align=\"center\">$vencimento</td>
		<td align=\"right\">$valor</td>
		<td align=\"center\">$data_pagto</td>
		<td align=\"right\">$valor_pagto</td>
		<td>$conta</td>
		<td align=\"center\">$processamento</td>
		
	</tr>";
	
}
?>


</table>

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
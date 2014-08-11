<?php include 'menu/menu.php' ?>
<div class="conteudo">
<form method="GET" action="buscar_turmas.php">
  Grupo:
    <select name="grupo" class="textBox" id="grupo">
    <option value="nenhum">Escolha o Grupo</option>
    <?php
include("menu/config_drop.php");?>
    <?php
	if($user_unidade == ""){
		$sql = "SELECT distinct grupo FROM ced_turma ORDER BY grupo";
	} else {
		$sql = "SELECT distinct grupo FROM ced_turma WHERE unidade LIKE '%$user_unidade%' ORDER BY grupo";
	}
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . $row['grupo'] . "</option>";
}
?>
  </select>

  
  
<input type="submit" name="Buscar" id="Buscar" value="Buscar" />
</form>
</div>
<?php include 'menu/footer.php' ?>



    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
	    <script type="text/javascript">
		$(function(){
			$('#grupo').change(function(){
				if( $(this).val() ) {
					$('#turma').hide();
					$('.carregando').show();
					$.getJSON('turma.ajax.php?search=',{grupo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cod_turma + '">' + '[' + j[i].cod_turma + '] ' + j[i].nivel + ': '+ j[i].curso +' - (MOD. '+ j[i].modulo +')' +' - '+ j[i].unidade +' / '+ j[i].polo +'</option>';
						}	
						$('#turma').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#turma').html('<option value="">– Selecione a Turma –</option>');
				}
			});
		});
		</script>
<?php include 'menu/menu.php'; ?>
<?php 

include 'includes/conectar.php';

$buscar = $_GET["grupo"];
if($user_unidade == ""){
	$sql = mysql_query("SELECT * FROM ced_turma WHERE grupo LIKE '%$buscar%' ORDER BY grupo,nivel, curso, modulo");
} else {
	$sql = mysql_query("SELECT * FROM ced_turma WHERE grupo LIKE '%$buscar%' AND unidade LIKE '%$user_unidade%' ORDER BY grupo, nivel,curso, modulo");
}

// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);

?>
<div class="conteudo">
<form id="form2" name="form1" method="GET" action="buscar_turmas.php">
    Grupo:
    <select name="grupo" class="textBox" id="grupo">
    <option value="">Escolha o Grupo</option>
    <?php
include ("menu/config_drop.php");?>
    <?php
if($user_unidade == ""){
		$sql2 = "SELECT distinct grupo FROM ced_turma ORDER BY grupo";
	} else {
		$sql2 = "SELECT distinct grupo FROM ced_turma WHERE unidade LIKE '%$user_unidade%' ORDER BY grupo";
	}
$result = mysql_query($sql2);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . $row['grupo'] . "</option>";
}
?>
  </select>
  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
  <label><strong>Turmas Encontradas:</strong> <?php echo $count; ?></label>
</form>
<table width="100%" border="1" class="full_table_list" style="font-size:12px">
	<tr>
    	
        <td><div align="center"><strong>Turma</strong></div></td>
        <td><div align="center"><strong>N&iacute;vel</strong></div></td>
		<td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>M&oacute;dulo</strong></div></td>
        <td><div align="center"><strong>Turno</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Polo</strong></div></td>
        
	</tr>

<?php

// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA TURMA ENCONTRADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$id_turma	   = $dados["id_turma"];
		$codigo	   = $dados["cod_turma"];
		$modulo	   = $dados["modulo"];
		$grupo	   = $dados["grupo"];
		$nivel	   = $dados["nivel"];
		$curso	   = $dados["curso"];
		$unidade	   = $dados["unidade"];
		$polo	   = $dados["polo"];
		$turno	   = strtoupper($dados["turno"]);
		
        echo "
	<tr>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><b><center>$codigo</b></center></a></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\">$nivel</td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$curso</center></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$modulo</center></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$turno</center></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$grupo</center></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$unidade</center></td>
		<td><a href=\"buscar_turma.php?grupo=$grupo&turma=$codigo&turno=$turno&polo=$polo&id_turma=$id_turma\"><center>$polo</center></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

</table>
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

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>


</div>
</body>
</html>

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

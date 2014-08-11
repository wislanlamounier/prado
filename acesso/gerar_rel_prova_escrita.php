<?php
include ('menu/menu.php');// inclui o menu

$get_curso = $_GET["curso"];
$nivel = $_GET["nivel"];
$nquestoes_baixo = $_GET["nquestoes_baixo"];
$nquestoes_medio = $_GET["nquestoes_medio"];
$nquestoes_alto = $_GET["nquestoes_alto"];
$get_valor = format_valor($_GET["valor"]);
$get_data = format_data($_GET["data"]);
$get_anograde = $_GET["anograde"];

if(isset($get_anograde)){
	$filtro_anograde = "anograde LIKE '%$get_anograde%' AND ";
} else {
	$filtro_anograde = "";
}

if(isset($get_curso)){
	$filtro_curso = "curso LIKE '%$get_curso%' AND ";
} else {
	$filtro_curso = "";
}

if(isset($nivel)){
	$filtro_nivel = "nivel LIKE '%$nivel%'";
} else {
	$filtro_nivel = "";
}


$filtro_completo = $filtro_anograde.$filtro_curso.$filtro_nivel;
$sql_disciplinas = mysql_query("SELECT * FROM disciplinas WHERE $filtro_completo");

?>
<div class="conteudo">
<table class="full_table_list" width="100%">
<tr>
	<td align="center"><b>N&iacute;vel</b></td>
    <td align="center"><b>Curso</b></td>
    <td align="center"><b>Ano / M&oacute;dulo</b></td>
    <td align="center"><b>Disciplina</b></td>
    <td align="center"><b>Ano / Grade</b></td>
    <td align="center"><b>Avalia&ccedil;&atilde;o</b></td>
</tr>
<?php
while($dados_disciplina = mysql_fetch_array($sql_disciplinas)){
	$disciplina_cod = $dados_disciplina["cod_disciplina"];
	$disciplina_nome = $dados_disciplina["disciplina"];
	$disciplina_nivel = $dados_disciplina["nivel"];
	$disciplina_curso = $dados_disciplina["curso"];
	$disciplina_modulo = $dados_disciplina["modulo"];
	$disciplina_anograde = $dados_disciplina["anograde"];
	echo "
	<tr>
		<td align=\"center\">$disciplina_nivel</td>
		<td align=\"center\">$disciplina_curso</td>
		<td align=\"center\">$disciplina_modulo</td>
		<td align=\"center\">$disciplina_nome</td>
		<td align=\"center\">$disciplina_anograde</td>
		<td align=\"center\"><a href=\"gerar_prova_escrita.php?curso=$disciplina_curso&modulo=$disciplina_modulo&cod_disc=$disciplina_cod&nquestoes_baixo=$nquestoes_baixo&nquestoes_medio=$nquestoes_medio&nquestoes_alto=$nquestoes_alto&anograde=$get_anograde&valor=$get_valor&data=$get_data\">
		[Gerar Avalia&ccedil;&atilde;o]</a></td>
	</tr>
	";
}
$get_curso = $_GET["curso"];
$cod_disc = $_GET["cod_disc"];
$nquestoes_baixo = $_GET["nquestoes_baixo"];
$nquestoes_medio = $_GET["nquestoes_medio"];
$nquestoes_alto = $_GET["nquestoes_alto"];
$get_valor = format_valor($_GET["valor"]);
$get_data = format_data($_GET["data"]);
$get_anograde = $_GET["anograde"];
?>
</table>
</div>

<?php
include ('menu/footer.php');?>

<script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
	    <script type="text/javascript">
		$(function(){
			$('#nivel').change(function(){
				if( $(this).val() ) {
					$('#curso').hide();
					$('.carregando').show();
					$.getJSON('a1.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="">- Selecione o Curso -</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].curso + '">' + j[i].curso + '</option>';
						}	
						$('#curso').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso').html('<option value="">– Selecione o Curso –</option>');
				}
			});
		});
		</script>
<?php include 'menu/menu.php'; ?>
<?php 

include 'includes/conectar.php';

$buscar = $_GET["grupo"];

$sql = mysql_query("SELECT * FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
 WHERE ct.grupo LIKE '%$buscar%' AND ctd.cod_prof = '$user_usuario'");


// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);

?>
<div class="conteudo">

<table width="100%" border="1" class="full_table_list" style="font-size:12px">
	<tr>
    	<td><div align="center"><strong>Turma</strong></div></td>
        <td><div align="center"><strong>Disciplina</strong></div></td>
		<td><div align="center"><strong>Carga Hor&aacute;ria</strong></div></td>
        <td><div align="center"><strong>Di&aacute;rio</strong></div></td>
        <td><div align="center"><strong>Avalia&ccedil;&otilde;es</strong></div></td>
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
		$cod_turma	   = $dados["codturma"];
		$turma_disciplina	   = $dados["codigo"];
		$cod_disciplina	   = $dados["disciplina"];
		$ano_grade	   = $dados["ano_grade"];
		$id_turma	   = $dados["id_turma"];
	
		//DADOS DA TURMA
		$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE anograde LIKE '%$ano_grade%' AND cod_turma = '$cod_turma' AND id_turma = $id_turma");
		$dados_turma = mysql_fetch_array($sql_turma);
		$nivel = $dados_turma["nivel"];
		$curso = $dados_turma["curso"];
		$modulo = $dados_turma["modulo"];
		$unidade = $dados_turma["unidade"];
		$polo = $dados_turma["polo"];
		$turno = $dados_turma["turno"];
		$id_turma = $dados_turma["id_turma"];
		$max_alunos = $dados_turma["max_aluno"];
		
		//DADOS DA DISCIPLINA
		$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE anograde LIKE '%$ano_grade%' AND cod_disciplina = '$cod_disciplina'");
		$dados_disc = mysql_fetch_array($sql_disc);
		$nome_disc = $dados_disc["disciplina"];
		$ch_disc = $dados_disc["ch"];
		
        echo "
	<tr>
		<td><a href=\"javascript:abrir('p_detalhe_turma.php?id=$cod_turma&turno=$turno&polo=$polo&id_turma=$id_turma')\" >[".$cod_turma."] ".strtoupper($nivel).": ".strtoupper($curso)." - (MOD. ".strtoupper($modulo).") - ".strtoupper($unidade)." / ".strtoupper($polo)."</a></center></a></td>
		<td>$nome_disc </td>
		<td><center>$ch_disc</center></td>
		<td><a href=\"p_listar_aulas.php?id=$turma_disciplina&id_turma=$id_turma\"><center>Chamada</center></a></td>
		<td><a href=\"p_aluno_turma.php?id=$turma_disciplina&id_turma=$id_turma\"><center>Avalia&ccedil;&otilde;es</center></a></td>
		\n";
        
    }
}

?>

</table>
</div>

<?php include 'menu/footer.php' ?>


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

<?php include 'menu/tabela.php'; ?>
<div class="filtro" align="center"><a href="javascript:window.print()">[IMPRIMIR]</a></div>
<?php 
$turma_d = $_GET["id"];
$id_turma = $_GET["id_turma"];
include 'includes/conectar.php';
//ATUALIZA NOTAS
 if( isset ( $_POST[ 'Submit' ] ) ) {
		              for( $i = 0 , $x = count( $_POST[ 'mat_aluno' ] ) ; $i < $x ; ++ $i ) {
						  $pesquisar = mysql_query("SELECT * FROM ced_notas WHERE  matricula = '".$_POST[ 'mat_aluno' ][ $i ]."' AND ref_ativ = '".$_POST[ 'ref_ativ' ][ $i ]."' AND turma_disc = '".$_POST[ 'cod_t_d' ][ $i ]."' ;");
						  $total = mysql_num_rows($pesquisar);
						  if($total == 0){
							mysql_query("INSERT INTO ced_notas (matricula,ref_ativ,turma_disc, nota) VALUES ('".$_POST[ 'mat_aluno' ][ $i ]."', '".$_POST[ 'ref_ativ' ][ $i ]."', '".$_POST[ 'cod_t_d' ][ $i ]."','".$_POST[ 'nota' ][ $i ]."');");
						  } else {
							mysql_query("UPDATE ced_notas SET nota = '".$_POST[ 'nota' ][ $i ]."' WHERE matricula = '".$_POST[ 'mat_aluno' ][ $i ]."' AND ref_ativ = '".$_POST[ 'ref_ativ' ][ $i ]."' AND turma_disc = '".$_POST[ 'cod_t_d' ][ $i ]."';");
						  }
						 
		              }
				echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('NOTAS ATUALIZADAS')
						</SCRIPT>");	 
		       }



//SELECIONA OS ALUNOS

$sql = mysql_query("SELECT * FROM v_aluno_disc WHERE turma_disc = $turma_d ORDER BY nome");

//PEGA O CODIGO E GRUPO DA TURMA
$turma_pesq1 = mysql_query("SELECT A.*, B.grupo as grupo FROM ced_turma_disc A INNER JOIN ced_turma B ON B.cod_turma = A.codturma where A.codigo LIKE '$turma_d' AND B.id_turma = $id_turma");
$dados_turma1 = mysql_fetch_array($turma_pesq1);
$grupo_turma = $dados_turma1["grupo"];
$cod_turma = $dados_turma1["codturma"];
$cod_disciplina = $dados_turma1["disciplina"];
$grade_disciplina = $dados_turma1["ano_grade"];
$cod_prof = $dados_turma1["cod_prof"];
$id_turma = $dados_turma1["id_turma"];

//PEGA O NOME DO PROFESSOR
$prof_pesq = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = $cod_prof");
$dados_prof = mysql_fetch_array($prof_pesq);
$nome_professor = $dados_prof["nome"];


//PEGA OS DADOS DA TURMA
$turma_pesq2 = mysql_query("SELECT * FROM ced_turma WHERE cod_turma LIKE '$cod_turma' AND grupo LIKE '$grupo_turma' AND id_turma = $id_turma");
$dados_turma2 = mysql_fetch_array($turma_pesq2);
$cod_turma = $dados_turma2["cod_turma"];
$grupo_turma = $dados_turma2["grupo"];
$nivel_turma = $dados_turma2["nivel"];
$curso_turma = $dados_turma2["curso"];
$modulo_turma = $dados_turma2["modulo"];
$unidade_turma = $dados_turma2["unidade"];
$polo_turma = $dados_turma2["polo"];
$inicio_turma = $dados_turma2["inicio"];
$fim_turma = $dados_turma2["fim"];


//PEGA OS DADOS DA DISCIPLINA
$disc_pesq = mysql_query("SELECT * FROM disciplinas WHERE anograde = '$grade_disciplina' AND cod_disciplina = '$cod_disciplina'");
$dados_disc = mysql_fetch_array($disc_pesq);
$nome_disciplina = $dados_disc["disciplina"];
$ch_disciplina = $dados_disc["ch"];


// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);

?>

<?php
$sql2 = mysql_query("SELECT * FROM ced_desc_nota WHERE subgrupo LIKE '0' AND grupo NOT LIKE 'C'");
$count2 = mysql_num_rows($sql2);
?>

<form action="#"  method="post">
<table width="100%" border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px">

    
    <tr>
    <th colspan="2"><img src="images/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count2;?>">Registro de Conteúdos</th>
    </tr>
    
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Módulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $unidade_turma;?> <?php echo $polo_turma;?> - <?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
<table width="100%" border="1">
    <tr style="font-size:12px; line-height:10px">
    	<td class="table_num"><div align="center" class="table_tamanho1"><strong>Aula</strong></div></td>
        <td class="table_nome"><div align="center"  class="table_tamanho1"><strong>Data</strong></div></td>
        <td><div align="center"  class="table_tamanho1"><strong>Conte&uacute;dos Trabalhados</strong></div></td>
    </tr>
<?php 
$p_lancamento = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d");

while($l = mysql_fetch_array($p_lancamento)){
	$data_aula = substr($l["data_aula"],8,2)."/".substr($l["data_aula"],5,2)."/".substr($l["data_aula"],0,4);
	$n_aula = trim($l["n_aula"]);
	$p_cont = mysql_query("SELECT * FROM conteudo_previsto WHERE anograde LIKE '%$grade_disciplina%' AND cod_disciplina LIKE '%$cod_disciplina%' AND naula LIKE '$n_aula'");

	//pega o conteudo previsto
	$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc LIKE '%$cod_disciplina%' AND ano_grade LIKE '%$grade_disciplina%' AND n_aula LIKE '$n_aula'");
if(mysql_num_rows($sql_verificar_previsto)==1){
	$dados_previsto=mysql_fetch_array($sql_verificar_previsto);
} else {
	$sql_nome_disciplina = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '%$cod_disciplina%' AND anograde LIKE '%$grade_disciplina%' LIMIT 1");
	$dados_disciplina = mysql_fetch_array($sql_nome_disciplina);
	$nome_disciplina = $dados_disciplina["disciplina"];
	
	$sql_cod_disc = mysql_query("SELECT * FROM disciplinas WHERE disciplina LIKE '%$nome_disciplina%' AND anograde LIKE '%$grade_disciplina%'");
	$codigos_disciplinas = "";
	$contar_codigos = mysql_num_rows($sql_cod_disc);
while($dados_disc = mysql_fetch_array($sql_cod_disc)){
		if($contar_codigos >=2){
			$codigos_disciplinas.="'".$dados_disc["cod_disciplina"]."',";
		} else {
			$codigos_disciplinas.="'".$dados_disc["cod_disciplina"]."'";
		}
		$contar_codigos -=1;
}
$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc IN ($codigos_disciplinas) AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'");
$dados_previsto=mysql_fetch_array($sql_verificar_previsto);
}
	
	
	$conteudo = $dados_previsto["previsto"];
	echo "<tr>
	<td class=\"table_tamanho2\" align=\"center\">
	$n_aula
	</td>
	<td class=\"table_tamanho2\" align=\"center\">
	$data_aula
	</td>
	<td class=\"table_tamanho2\">
	$conteudo
	</td>
	
	</tr>";
}


?>
</table>

<table class="full_table_list" border="1" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">
<tr>
<td colspan="4" align="center"><div style="font-size:10px; font-family:Arial, Helvetica, sans-serif">OBSERVA&Ccedil;&Otilde;ES</div></td>
</tr>

<?php
$p_obs = mysql_query("SELECT * FROM ced_turma_obs WHERE turma_disc = $turma_d AND matricula = 0");

if(mysql_num_rows($p_obs)>=1){
	echo "<tr>
			<td align=\"center\"><b>DATA</b></td>
			<td align=\"center\" colspan=\"3\"><b>DESCRI&Ccedil;&Atilde;O</b></td>
		</tr>";
	while($dados_obs = mysql_fetch_array($p_obs)){
		$id_obs = $dados_obs["id_obs"];
		$data_obs = substr($dados_obs["data_obs"],8,2)."/".substr($dados_obs["data_obs"],5,2)."/".substr($dados_obs["data_obs"],0,4);
		$obs = $dados_obs["obs"];
		echo "<tr>
			<td align=\"center\>$data_obs</td>
			<td colspan=\"3\">$obs</td>
		</tr>";
	
	}
} else {
	echo "<tr>
			<td colspan=\"4\" style=\"line-height:70px\"></td>
		</tr>
		";
}


?>



<tr>
<td>
<br />
<div align="center">___/___/____<br />Data</div>
</td>
<td>
<br />
<div align="center">______________________<br />Docente</div>
</td>

<td>
<br />
<div align="center">___/___/____<br />Data</div>
</td>

<td>
<br />
<div align="center">______________________<br />Dire&ccedil;&atilde;o Pedag&oacute;gica</div>
</td>

</tr>
</table>

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

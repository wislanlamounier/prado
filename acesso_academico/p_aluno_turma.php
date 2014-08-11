<?php include 'menu/menu.php'; ?>
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

$sql = mysql_query("SELECT DISTINCT vad.matricula, vad.nome FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_d 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");

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
<div class="conteudo">
<div><font size="+2"><a href="p_listar_aulas.php?id=<?php echo $turma_d;?>&id_turma=<?php echo $id_turma;?>">Di&aacute;rio</a></font></div>
<?php
$sql2 = mysql_query("SELECT * FROM ced_desc_nota WHERE subgrupo LIKE '0'");
$count2 = mysql_num_rows($sql2);
?>

<form action="#"  method="post">
<table width="100%" border="1" class="full_table_list" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">

    
    <tr>
    <th colspan="2"><img src="images/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count2;?>">Registro de Avalia&ccedil;&otilde;es e Resultado</th>
    </tr>
    
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Módulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Turma:<br /><?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
<table width="100%" border="1" class="full_table_list"  style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">
    <tr style="font-size:12px;">
    	<td width="50px"><div align="center"><strong>N&ordm;</strong></div></td>
        <td width="300px"><div align="center"><strong>Nome</strong></div></td>
        
<?php 




if ($count2 == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($dados2 = mysql_fetch_array($sql2)) {
        // enquanto houverem resultados...
		$cod_atividade = $dados2["codigo"];
		$grupo_ativi = $dados2["grupo"];
		$atividade = $dados2["atividade"];
		$max_nota_ativ = $dados2["max_nota"];
        echo "
		<td><div align=\"center\"><strong><a href=\"javascript:abrir('p_lancar_atividade.php?ativ=$grupo_ativi&turma=$turma_d&grupo=$grupo_turma');\">$atividade</a></strong></div></td>
		
		\n";
        // exibir a coluna nome e a coluna email
    }
	
}
;?>
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
	$i = 0;
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];

		$i +=1;
        echo "
	<tr>
		<td><b><center>$i</b></center></td>
		<td>$nome</td>
		
		
		\n";
		$sql2 = mysql_query("SELECT * FROM ced_desc_nota WHERE subgrupo LIKE '0'");
		$count2 = mysql_num_rows($sql2);
		$count3= $count2+2;
		while ($dados2 = mysql_fetch_array($sql2)) {
			// enquanto houverem resultados...
			//pesquisa notas anteriores

				// enquanto houverem resultados...
				$cod_atividade = $dados2["codigo"];
				$grupo_ativi = $dados2["grupo"];
				$atividade = $dados2["atividade"];
				
				//PESQUISA NOTA POR ATIVIDADE
				$pesq_nota = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $codigo AND turma_disc = $turma_d AND grupo = '$grupo_ativi' AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
				$contar_nota = mysql_num_rows($pesq_nota);
				if($contar_nota == 0){
					$nota_aluno = "0,00";
				} else {
					$dados_nota = mysql_fetch_array($pesq_nota);
					$nota_aluno = number_format($dados_nota["notafinal"], 2, ',', '');
				}
		
				echo "
				<td align=\"center\"><a href=\"javascript:abrir('p_lancar_nota.php?td=$turma_d');\">$nota_aluno</a></b></td>";
			
		}
		
        // exibir a coluna nome e a coluna email
    }
	echo "<tr>
<td colspan=\"$count3\">$count alunos.</td></tr>";
}

?>
</form>
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

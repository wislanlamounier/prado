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
$min_nota = $dados_turma2["min_nota"];
$min_falta = $dados_turma2["min_freq"];


//PEGA OS DADOS DA DISCIPLINA
$disc_pesq = mysql_query("SELECT * FROM disciplinas WHERE anograde = '$grade_disciplina' AND cod_disciplina = '$cod_disciplina'");
$dados_disc = mysql_fetch_array($disc_pesq);
$nome_disciplina = $dados_disc["disciplina"];
$ch_disciplina = $dados_disc["ch"];


$max_falta = ($ch_disciplina*$min_falta)/100;
//x=ch*min_falta/100

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
    <th colspan="<?php echo $count2;?>">Registro de Avalia&ccedil;&otilde;es e Resultado</th>
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
    	<td class="table_num"><div align="center" class="table_tamanho1"><strong>N&ordm;</strong></div></td>
        <td class="table_nome"><div align="center"  class="table_tamanho1"><strong>Nome</strong></div></td>
        <td><div align="center"  class="table_tamanho1"><strong>Faltas</strong></div></td>
        
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
		<td><div align=\"center\" class=\"table_tamanho1\"><strong>$atividade</strong></div></td>
		
		\n";
        // exibir a coluna nome e a coluna email
    }
	echo "<td align=\"center\"  class=\"table_tamanho1\"><b>Soma das Avalia&ccedil;&otilde;es</b></td>
	<td align=\"center\"  class=\"table_tamanho1\"><b>Recupera&ccedil;&atilde;o</b></td>
	<td align=\"center\"  class=\"table_tamanho1\"><b>Nota Final</b></td>
	<td align=\"center\" class=\"table_tamanho1\"><b>Resultado</b></td>";
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
		$turma_disciplina = $dados["turma_disc"];
		$i +=1;
		$exib_i= str_pad($i, 2,"0", STR_PAD_LEFT);
        echo "
	<tr style=\"line-height:10px\">
		<td class=\"table_tamanho1\"><b><center>$exib_i</b></center></td>
		<td class=\"table_tamanho2\"><b>$nome</b></td>
		
		
		\n";
		$sql_cancel = mysql_query("SELECT * FROM ocorrencias WHERE matricula = $codigo AND id_turma = $id_turma AND (n_ocorrencia = 1 OR n_ocorrencia = 2 OR n_ocorrencia = 10) LIMIT 1");
		$count_cancel = mysql_num_rows($sql_cancel);
	
		if($count_cancel >=1){
			$dados_cancel = mysql_fetch_array($sql_cancel);
			$data_cancel = substr($dados_cancel["data"],8,2)."/".substr($dados_cancel["data"],5,2)."/".substr($dados_cancel["data"],0,4);
			$id_ocorrencia = $dados_cancel["n_ocorrencia"];
			$sql_ocorrencia = mysql_query("SELECT * FROM tipo_ocorrencia WHERE id = $id_ocorrencia");
			$dados_ocorrencia = mysql_fetch_array($sql_ocorrencia);
			$nome_ocorrencia = $dados_ocorrencia["nome"];
			echo "<td colspan=\"6\" class=\"table_tamanho2\" align=\"center\">$nome_ocorrencia em $data_cancel.</td>
			<td class=\"table_tamanho2\" align=\"center\" bgcolor=\"#E9E9E9\">$nome_ocorrencia</td>";
		} else {
		//PEGA AS FALTAS
		$sql_falta = mysql_query("SELECT COUNT(*) as falta_total FROM ced_falta_aluno WHERE matricula = '$codigo' AND turma_disc = '$turma_d' AND status LIKE 'F' AND data IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$turma_d')");
		$dados_falta = mysql_fetch_array($sql_falta);
		$falta         = $dados_falta["falta_total"];
		
		//PEGAR FALTAS
		echo "<td class=\"table_tamanho2\"><center>$falta</center></td>";
		
		
		$sql2 = mysql_query("SELECT * FROM ced_desc_nota WHERE subgrupo LIKE '0' AND grupo NOT LIKE 'C'");
		$count2 = mysql_num_rows($sql2);
		$count3= $count2+2;
		$soma_avaliacoes = 0;	
		
		
		
		while ($dados2 = mysql_fetch_array($sql2)) {
			// enquanto houverem resultados...
			//pesquisa notas anteriores

				// enquanto houverem resultados...
				$cod_atividade = $dados2["codigo"];
				$grupo_ativi = $dados2["grupo"];
				$atividade = $dados2["atividade"];
				
				//PESQUISA NOTA POR ATIVIDADE
				$pesq_nota = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $codigo AND turma_disc = $turma_d AND grupo = '$grupo_ativi' AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ) ");
				$contar_nota = mysql_num_rows($pesq_nota);
				if($contar_nota == 0){
					$nota_aluno = "0,00";
					$nota1 = 0;
				} else {
					$dados_nota = mysql_fetch_array($pesq_nota);
					$nota_aluno = number_format($dados_nota["notafinal"], 2, ',', '');
					$nota1 = $dados_nota["notafinal"];
				}
				$soma_avaliacoes = $soma_avaliacoes +$nota1;
				if($soma_avaliacoes >=$min_nota){
					$nota_final = number_format($soma_avaliacoes, 2, ',', '');
					$nota_final2 = $soma_avaliacoes;
				} else {
					$pesq_nota = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $codigo AND turma_disc = $turma_d AND grupo = 'C'  AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
					$nota_final = number_format($dados_nota2["notafinal"], 2, ',', '');
					$nota_final2 = $dados_nota2["notafinal"];
				}
				
				
				echo "
				<td class=\"table_tamanho2\" align=\"center\">$nota_aluno</b></td>";
			
		}
		
		$pesq_nota3 = mysql_query("SELECT SUM(nota)as notafinal FROM ced_notas WHERE matricula = $codigo AND turma_disc = $turma_d AND grupo = 'C'  AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
		$dados_nota3 = mysql_fetch_array($pesq_nota3);
		$contar_nota3 = $dados_nota3["notafinal"];
		if($contar_nota3 == 0){
			$nota_rec = "0,00";
			$nota_rec2 = 0;
		} else {
			$nota_rec = number_format($dados_nota3["notafinal"], 2, ',', '');
			$nota_rec2 = $dados_nota3["notafinal"];
		}
		
		
		if($nota_final2 >=$min_nota&&$falta <= $max_falta){
			$resultado = "Aprovado";
		} else {
			$resultado = "Reprovado";
		}
		if($soma_avaliacoes > 0){
			$nota_parcial = number_format($soma_avaliacoes,2,",",".");
			$nota_parcial2 = $soma_avaliacoes;
		} else {
			$nota_parcial = "0,00";
			$nota_parcial2 = 0;
		}
		if($nota_rec2 <= $nota_parcial2){
			$nota_final = $nota_parcial;
		} else {
			$nota_final = $nota_rec;
		}
		if($nota_final <= $nota_parcial2){
			$nota_final = $nota_parcial;
		}
		
		echo "
		<td class=\"table_tamanho2\" align=\"center\">$nota_parcial</td>
		<td class=\"table_tamanho2\" align=\"center\">$nota_rec</td>
		<td class=\"table_tamanho2\" align=\"center\">$nota_final</td>
		<td class=\"table_tamanho2\" align=\"center\">$resultado</td>";
        // exibir a coluna nome e a coluna email
    }
}

} //fecha tudo
?>
</form>
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

<?php include 'menu/tabela.php'; ?>
<div class="filtro" align="center"><a href="javascript:window.print()">[IMPRIMIR]</a></div>
<?php 
$id_turma = $_GET["id"];
include 'includes/conectar.php';

//SELECIONA OS ALUNOS

$sql = mysql_query("SELECT DISTINCT vad.matricula, vad.nome FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.id_turma = $id_turma 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");


//PEGA OS DADOS DA TURMA
$turma_pesq2 = mysql_query("SELECT * FROM ced_turma WHERE  id_turma = $id_turma");
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



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);

?>

<?php
$sql2 = mysql_query("SELECT * FROM ced_turma_disc WHERE id_turma = $id_turma");
$count2 = mysql_num_rows($sql2);
?>

<form action="#"  method="post">
<table width="100%" border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px">

    
    <tr>
    <th colspan="2"><img src="images/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count2;?>">Ata de Resultados Finais</th>
    </tr>
    
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Módulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $unidade_turma;?> <?php echo $polo_turma;?> - <?php echo $cod_turma;?></b></td>
    </tr>
	</table>
    
<table width="100%" border="1">
    <tr style="font-size:12px; line-height:10px">
    	<td class="table_num" rowspan="2"><div align="center" class="table_tamanho1"><strong>N&ordm;</strong></div></td>
        <td class="table_nome" rowspan="2"><div align="center"  class="table_tamanho1"><strong>Nome</strong></div></td>
        
        
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
		$cod_tdisc = $dados2["codigo"];
		$cod_disciplina = $dados2["disciplina"];
		$ano_grade = $dados2["ano_grade"];
		$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina ='$cod_disciplina' AND anograde= '$ano_grade'");
		$dados_disc = mysql_fetch_array($sql_disc);
		$nome_disciplina = $dados_disc["disciplina"];
        echo "
		<td colspan=\"2\" style=\"line-height:10px\"><div align=\"center\" class=\"table_tamanho1\"><strong>$nome_disciplina</strong></div><br>
		
		</td>
	
		
		
		
		\n";
        // exibir a coluna nome e a coluna email
    }
	$contador = $count2;
	//<td rowspan=\"2\"><div align=\"center\" class=\"table_tamanho1\"><strong>Resultado</strong></div>
	echo "
	
	</td><tr style=\"line-height:10px\">";
	 while ($contador >=1) {
		 echo"
  <td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#C0C0C0\"><b>Faltas</b></td>
  <td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#EAEAEA\"><b>Nota</b></td>";
  $contador -=1;
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
		$turma_disciplina = $dados["turma_disc"];
		$i +=1;
		$exib_i= str_pad($i, 2,"0", STR_PAD_LEFT);
        echo "
	<tr style=\"line-height:10px\">
		<td class=\"table_tamanho1\"><b><center>$exib_i</b></center></td>
		<td class=\"table_tamanho2\"><b>$nome</b></td>
		
		
		\n";
		
		//verifica ocorrencias	
		$sql_cancel = mysql_query("SELECT * FROM ocorrencias WHERE matricula = $codigo AND id_turma = $id_turma AND (n_ocorrencia = 1 OR n_ocorrencia = 2 OR n_ocorrencia = 10) LIMIT 1");
		$count_cancel = mysql_num_rows($sql_cancel);
	
		if($count_cancel >=1){
			$dados_cancel = mysql_fetch_array($sql_cancel);
			$data_cancel = substr($dados_cancel["data"],8,2)."/".substr($dados_cancel["data"],5,2)."/".substr($dados_cancel["data"],0,4);
			$id_ocorrencia = $dados_cancel["n_ocorrencia"];
			$sql_ocorrencia = mysql_query("SELECT * FROM tipo_ocorrencia WHERE id = $id_ocorrencia");
			$dados_ocorrencia = mysql_fetch_array($sql_ocorrencia);
			$nome_ocorrencia = $dados_ocorrencia["nome"];
			$contador2 = $count2*2;
			echo "<td colspan=\"$contador2\" class=\"table_tamanho1\" align=\"center\">$nome_ocorrencia em $data_cancel</td>";
		} else {
		//PEGA OS DADOS DAS DISCIPLINAS
		$sql3 = mysql_query("SELECT * FROM ced_turma_disc WHERE id_turma = $id_turma");
		while ($dados3 = mysql_fetch_array($sql3)) {
        // enquanto houverem resultados...
			$cod_tdisc2 = $dados3["codigo"];
			$cod_disciplina2 = $dados3["disciplina"];
			$ano_grade2 = $dados3["ano_grade"];
			//PEGA AS NOTAS DA DISCIPLINA
			$pesq_nota = mysql_query("SELECT SUM(nota) as notafinal FROM ced_notas WHERE matricula = $codigo AND turma_disc = $cod_tdisc2 AND grupo <> 'C'  AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
			$dados_nota2 = mysql_fetch_array($pesq_nota);
			$nota1 = $dados_nota2["notafinal"];
			if($nota1 < $min_nota){
				$pesq_rec = mysql_query("SELECT SUM(nota) as notafinal FROM ced_notas WHERE matricula = $codigo AND turma_disc = $cod_tdisc2 AND grupo = 'C'  AND ref_ativ IN (SELECT ref_id FROM ced_turma_ativ)");
				$dados_rec = mysql_fetch_array($pesq_rec);
				$nota_final1 = $dados_rec["notafinal"];
			} else {
				$nota_final1 = $nota1;
			}
			
			if($nota_final1 <= $nota1){//verifica se a nota da recuperação é menor que soma das notas
				$nota_final1 = $nota1;
			}
			
			$nota_final = number_format($nota_final1, 2, ',', '');
			
			
			
			//PEGA AS FALTAS
			$sql_falta = mysql_query("SELECT COUNT(*) as falta_total FROM ced_falta_aluno WHERE matricula = '$codigo' AND turma_disc = '$cod_tdisc2' AND status LIKE 'F' AND data IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$cod_tdisc2');");
			$dados_falta = mysql_fetch_array($sql_falta);
			$falta         = $dados_falta["falta_total"];
		
		
			echo "<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#C0C0C0\">$falta</td>
			
			<td class=\"table_tamanho1\" align=\"center\" bgcolor=\"#EAEAEA\">$nota_final</td>";
		}
	
	}
} //fecha tudo
}
?>
</form>
</table>

<table class="full_table_list" border="1" style="font-size:10px; font-family:Arial, Helvetica, sans-serif;">
<tr>
<td colspan="4" align="center"><div style="font-size:10px; font-family:Arial, Helvetica, sans-serif">OBSERVA&Ccedil;&Otilde;ES</div></td>
</tr>

<?php
$p_obs = mysql_query("SELECT * FROM ced_turma_obs WHERE id_turma = $id_turma AND matricula = 0");

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

<?php include 'menu/tabela.php'; ?>
<div class="filtro" align="center"><a href="javascript:window.print()">[IMPRIMIR]</a></div>
<?php 
$turma_d = $_GET["id"];
$id_turma = $_GET["id_turma"];
include 'includes/conectar.php';


$sql = mysql_query("SELECT DISTINCT vad.matricula, vad.nome FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_d 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");

//PEGA O CODIGO E GRUPO DA TURMA
$turma_pesq1 = mysql_query("select * from ced_view_tdt where codigo LIKE '$turma_d'");
$dados_turma1 = mysql_fetch_array($turma_pesq1);
$grupo_turma = $dados_turma1["grupo"];
$cod_turma = $dados_turma1["codturma"];
$cod_disciplina = $dados_turma1["disciplina"];
$grade_disciplina = $dados_turma1["ano_grade"];
$cod_prof = $dados_turma1["cod_prof"];

//PEGA O NOME DO PROFESSOR
$prof_pesq = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = $cod_prof");
$dados_prof = mysql_fetch_array($prof_pesq);
$nome_professor = $dados_prof["nome"];


//PEGA OS DADOS DA TURMA
$turma_pesq2 = mysql_query("SELECT * FROM ced_turma WHERE id_turma LIKE '$id_turma'");
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
$nome_disciplina2 = $dados_disc["disciplina"];
$ch_disciplina = $dados_disc["ch"];


// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);

?>

<table border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
  
  
  <tr>
    <th colspan="2"><img src="images/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count;?>">Registro de Frequ&ecirc;ncia</th>
    </tr>
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Mo&acute;dulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $unidade_turma;?> / <?php echo $polo_turma;?> - <?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina2);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
<table border="1" style="line-height:10px">
<thead>


	<tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >M<br />&ecirc;<br />s</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = 1;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=40) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$mes_aula = substr($dados_data["data_aula"],5,2);
		} else {
		$mes_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$mes_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?>  
    	
    </tr>
    <tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >D<br />i<br />a</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = 1;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=40) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$dia_aula = substr($dados_data["data_aula"],8,2);
		} else {
		$dia_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$dia_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?> 
    	
    </tr>
    
    <tr height="10">
    
    	<th class="table_num"><div align="center" class="table_div1"> <strong>N&ordm;</strong></div></th>
        <th class="table_nome"><div align="center" class="table_div1" ><strong>Nome</strong></font></div></th>
        <th><div align="center" class="table_div1" >Aula</div></th>

    
        
<?php 




if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = 1;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=40) {
		
		$exib_contar= str_pad($ch_contar, 3,"0", STR_PAD_LEFT);
        // enquanto houverem resultados...
        echo "
		<th><div class=\"table_div1\"><strong>$exib_contar</a></font></strong></div></th>
		\n";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
;?>       
	</tr></thead>

<tbody>
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
	
	$sql1 = mysql_query("SELECT DISTINCT vad.matricula, vad.nome, vad.turma_disc FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_d 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		$turma_disciplina = $dados["turma_disc"];
		$i +=1;
		$exib_i= str_pad($i, 2,"0", STR_PAD_LEFT);
        echo "
	<tr>
		<td><div class=\"table_div1\"><b><center>$exib_i</b></center></div></td>
		<td colspan=\"2\"><div class=\"table_div1\"><b>$nome</b></div></td>
		
		
		\n";
		
		$count3= $count+2;
		$ch_contar2 = 1;
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
			echo "<td colspan=\"$ch_disciplina\" class=\"table_tamanho2\" align=\"center\">$nome_ocorrencia em $data_cancel.</td>";
		} else {
		while ($ch_contar2 <= $ch_disciplina&&$ch_contar2 <=40) {
			//PEGA DATA DA AULA E LANÇA P/F
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc = '$turma_d' AND matricula = '$codigo'");
			$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc = '$turma_d' AND matricula = '$codigo' AND DATA IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$turma_d')");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			$total = mysql_num_rows($falta_sql);
			if($total == 1){
				$falta_dados = mysql_fetch_array($falta_sql);
			$exibir_falta = $falta_dados["status"];
						if ( $exibir_falta == 'P')
							{ $exibir_falta = '.';}
			
			} else {
				$exibir_falta = ".";
			}
		
			//if($exibir_falta == "J"){
			//	$cor = "green";
			//}
			//if($exibir_falta == "P"){
			//	$cor = "";
			//}
			//PESQUISA SE O ALUNO TEM APROVEITAMENTO
			//<td align=\"center\" bgcolor=\"$cor\">$exibir_falta</td>"; // atual  --> <td align=\"center\">$exibir_falta</td>";			
			echo "
			<td align=\"center\"><div class=\"table_div1\"><b>$exibir_falta</b></font></div></td>";
			
			$ch_contar2 +=1;
			
		}
        // exibir a coluna nome e a coluna email
    }
}
}
?>
</tbody>
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

<?php 
if($ch_disciplina >40){ //CARGA MAIOR QUE 40 HORAS
	echo "<div style=\"page-break-after: always; \"></div>";
	$count = mysql_num_rows($sql);
	$ini_ch = 41;
	$fim_ch = 80;
?>


<table border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
  
  
  <tr>
    <th colspan="2"><img src="img/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count;?>">Registro de Frequ&ecirc;ncia</th>
    </tr>
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Mo&acute;dulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $unidade_turma;?> / <?php echo $polo_turma;?> - <?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina2);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
<table border="1" style="line-height:10px">
<thead>


	<tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >M<br />&ecirc;<br />s</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$mes_aula = substr($dados_data["data_aula"],5,2);
		} else {
		$mes_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$mes_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?>  
    	
    </tr>
    <tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >D<br />i<br />a</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$dia_aula = substr($dados_data["data_aula"],8,2);
		} else {
		$dia_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$dia_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?> 
    	
    </tr>
    
    <tr height="10">
    
    	<th class="table_num"><div align="center" class="table_div1"> <strong>N&ordm;</strong></div></th>
        <th class="table_nome"><div align="center" class="table_div1" ><strong>Nome</strong></font></div></th>
        <th><div align="center" class="table_div1" >Aula</div></th>

    
        
<?php 




if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$exib_contar= str_pad($ch_contar, 3,"0", STR_PAD_LEFT);
        // enquanto houverem resultados...
        echo "
		<th><div class=\"table_div1\"><strong>$exib_contar</a></font></strong></div></th>
		\n";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
;?>       
	</tr></thead>

<tbody>
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
	
	$sql1 = mysql_query("SELECT DISTINCT vad.matricula, vad.nome, vad.turma_disc FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_d 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");
    while ($dados = mysql_fetch_array($sql1)) {
        // enquanto houverem resultados...
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		$turma_disciplina = $dados["turma_disc"];
		$i +=1;
		$exib_i= str_pad($i, 2,"0", STR_PAD_LEFT);
        echo "
	<tr>
		<td><div class=\"table_div1\"><b><center>$exib_i</b></center></div></td>
		<td colspan=\"2\"><div class=\"table_div1\"><b>$nome</b></div></td>
		
		
		\n";
		
		$count3= $count+2;
		$ch_contar2 = $ini_ch;
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
			echo "<td colspan=\"$ch_disciplina\" class=\"table_tamanho2\" align=\"center\">$nome_ocorrencia em $data_cancel.</td>";
		} else {
		
		while ($ch_contar2 <= $ch_disciplina&&$ch_contar2 <=$fim_ch) {
			//PEGA DATA DA AULA E LANÇA P/F
			$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc = '$turma_d' AND matricula = '$codigo' AND DATA IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$turma_d')");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE  turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			$total = mysql_num_rows($falta_sql);
			if($total == 1){
				$falta_dados = mysql_fetch_array($falta_sql);
			$exibir_falta = $falta_dados["status"];
						if ( $exibir_falta == 'P')
							{ $exibir_falta = '.';}
			
			} else {
				$exibir_falta = ".";
			}
		
			//if($exibir_falta == "J"){
			//	$cor = "green";
			//}
			//if($exibir_falta == "P"){
			//	$cor = "";
			//}
			//PESQUISA SE O ALUNO TEM APROVEITAMENTO
			//<td align=\"center\" bgcolor=\"$cor\">$exibir_falta</td>"; // atual  --> <td align=\"center\">$exibir_falta</td>";			
			echo "
			<td align=\"center\"><div class=\"table_div1\"><b>$exibir_falta</b></font></div></td>";
			
			$ch_contar2 +=1;
			
		}
        // exibir a coluna nome e a coluna email
    }
}
}
?>
</tbody>
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


<?php 
} // FECHA O IF
?> 



<?php 
if($ch_disciplina >80){ //CARGA MAIOR QUE 80 HORAS
	echo "<div style=\"page-break-after: always; \"></div>";
	$count = mysql_num_rows($sql);
	$ini_ch = 81;
	$fim_ch = 120;
?>


<table border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
  
  
  <tr>
    <th colspan="2"><img src="img/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count;?>">Registro de Frequ&ecirc;ncia</th>
    </tr>
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Mo&acute;dulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $unidade_turma;?> / <?php echo $polo_turma;?> - <?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina2);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
<table border="1" style="line-height:10px">
<thead>


	<tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >M<br />&ecirc;<br />s</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$mes_aula = substr($dados_data["data_aula"],5,2);
		} else {
		$mes_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$mes_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?>  
    	
    </tr>
    <tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >D<br />i<br />a</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$dia_aula = substr($dados_data["data_aula"],8,2);
		} else {
		$dia_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$dia_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?> 
    	
    </tr>
    
    <tr height="10">
    
    	<th class="table_num"><div align="center" class="table_div1"> <strong>N&ordm;</strong></div></th>
        <th class="table_nome"><div align="center" class="table_div1" ><strong>Nome</strong></font></div></th>
        <th><div align="center" class="table_div1" >Aula</div></th>

    
        
<?php 




if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$exib_contar= str_pad($ch_contar, 3,"0", STR_PAD_LEFT);
        // enquanto houverem resultados...
        echo "
		<th><div class=\"table_div1\"><strong>$exib_contar</a></font></strong></div></th>
		\n";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
;?>       
	</tr></thead>

<tbody>
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
	
	$sql1 = mysql_query("SELECT DISTINCT vad.matricula, vad.nome, vad.turma_disc FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_d 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");
    while ($dados = mysql_fetch_array($sql1)) {
        // enquanto houverem resultados...
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		$turma_disciplina = $dados["turma_disc"];
		$i +=1;
		$exib_i= str_pad($i, 2,"0", STR_PAD_LEFT);
        echo "
	<tr>
		<td><div class=\"table_div1\"><b><center>$exib_i</b></center></div></td>
		<td colspan=\"2\"><div class=\"table_div1\"><b>$nome</b></div></td>
		
		
		\n";
		
		$count3= $count+2;
		$ch_contar2 = $ini_ch;
		
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
			echo "<td colspan=\"$ch_disciplina\" class=\"table_tamanho2\" align=\"center\">$nome_ocorrencia em $data_cancel.</td>";
		} else {
		while ($ch_contar2 <= $ch_disciplina&&$ch_contar2 <=$fim_ch) {
			//PEGA DATA DA AULA E LANÇA P/F
			$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc = '$turma_d' AND matricula = '$codigo' AND DATA IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$turma_d')");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE  turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			$total = mysql_num_rows($falta_sql);
			if($total == 1){
				$falta_dados = mysql_fetch_array($falta_sql);
			$exibir_falta = $falta_dados["status"];
						if ( $exibir_falta == 'P')
							{ $exibir_falta = '.';}
			
			} else {
				$exibir_falta = ".";
			}
		
			//if($exibir_falta == "J"){
			//	$cor = "green";
			//}
			//if($exibir_falta == "P"){
			//	$cor = "";
			//}
			//PESQUISA SE O ALUNO TEM APROVEITAMENTO
			//<td align=\"center\" bgcolor=\"$cor\">$exibir_falta</td>"; // atual  --> <td align=\"center\">$exibir_falta</td>";			
			echo "
			<td align=\"center\"><div class=\"table_div1\"><b>$exibir_falta</b></font></div></td>";
			
			$ch_contar2 +=1;
			
		}
        // exibir a coluna nome e a coluna email
    }
}
}
?>
</tbody>
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


<?php 
} // FECHA O IF
?>




<?php 
if($ch_disciplina >120){ //CARGA MAIOR QUE 120 HORAS
	echo "<div style=\"page-break-after: always; \"></div>";
	$count = mysql_num_rows($sql);
	$ini_ch = 121;
	$fim_ch = 160;
?>


<table border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
  
  
  <tr>
    <th colspan="2"><img src="img/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count;?>">Registro de Frequ&ecirc;ncia</th>
    </tr>
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Mo&acute;dulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $unidade_turma;?> / <?php echo $polo_turma;?> - <?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina2);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
<table border="1" style="line-height:10px">
<thead>


	<tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >M<br />&ecirc;<br />s</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$mes_aula = substr($dados_data["data_aula"],5,2);
		} else {
		$mes_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$mes_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?>  
    	
    </tr>
    <tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >D<br />i<br />a</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$dia_aula = substr($dados_data["data_aula"],8,2);
		} else {
		$dia_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$dia_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?> 
    	
    </tr>
    
    <tr height="10">
    
    	<th class="table_num"><div align="center" class="table_div1"> <strong>N&ordm;</strong></div></th>
        <th class="table_nome"><div align="center" class="table_div1" ><strong>Nome</strong></font></div></th>
        <th><div align="center" class="table_div1" >Aula</div></th>

    
        
<?php 




if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$exib_contar= str_pad($ch_contar, 3,"0", STR_PAD_LEFT);
        // enquanto houverem resultados...
        echo "
		<th><div class=\"table_div1\"><strong>$exib_contar</a></font></strong></div></th>
		\n";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
;?>       
	</tr></thead>

<tbody>
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
	
	$sql1 = mysql_query("SELECT DISTINCT vad.matricula, vad.nome, vad.turma_disc FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_d 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");
    while ($dados = mysql_fetch_array($sql1)) {
        // enquanto houverem resultados...
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		$turma_disciplina = $dados["turma_disc"];
		$i +=1;
		$exib_i= str_pad($i, 2,"0", STR_PAD_LEFT);
        echo "
	<tr>
		<td><div class=\"table_div1\"><b><center>$exib_i</b></center></div></td>
		<td colspan=\"2\"><div class=\"table_div1\"><b>$nome</b></div></td>
		
		
		\n";
		
		$count3= $count+2;
		$ch_contar2 = $ini_ch;
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
			echo "<td colspan=\"$ch_disciplina\" class=\"table_tamanho2\" align=\"center\">$nome_ocorrencia em $data_cancel.</td>";
		} else {
		while ($ch_contar2 <= $ch_disciplina&&$ch_contar2 <=$fim_ch) {
			//PEGA DATA DA AULA E LANÇA P/F
			$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc = '$turma_d' AND matricula = '$codigo' AND DATA IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$turma_d')");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE  turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			$total = mysql_num_rows($falta_sql);
			if($total == 1){
				$falta_dados = mysql_fetch_array($falta_sql);
			$exibir_falta = $falta_dados["status"];
						if ( $exibir_falta == 'P')
							{ $exibir_falta = '.';}
			
			} else {
				$exibir_falta = ".";
			}
		
			//if($exibir_falta == "J"){
			//	$cor = "green";
			//}
			//if($exibir_falta == "P"){
			//	$cor = "";
			//}
			//PESQUISA SE O ALUNO TEM APROVEITAMENTO
			//<td align=\"center\" bgcolor=\"$cor\">$exibir_falta</td>"; // atual  --> <td align=\"center\">$exibir_falta</td>";			
			echo "
			<td align=\"center\"><div class=\"table_div1\"><b>$exibir_falta</b></font></div></td>";
			
			$ch_contar2 +=1;
			
		}
        // exibir a coluna nome e a coluna email
    }
}
}
?>
</tbody>
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


<?php 
} // FECHA O IF
?>



<?php 
if($ch_disciplina >160){ //CARGA MAIOR QUE 160 HORAS
	echo "<div style=\"page-break-after: always; \"></div>";
	$count = mysql_num_rows($sql);
	$ini_ch = 161;
	$fim_ch = 200;
?>


<table border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
  
  
  <tr>
    <th colspan="2"><img src="img/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count;?>">Registro de Frequ&ecirc;ncia</th>
    </tr>
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Mo&acute;dulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $unidade_turma;?> / <?php echo $polo_turma;?> - <?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina2);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
<table border="1" style="line-height:10px">
<thead>


	<tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >M<br />&ecirc;<br />s</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$mes_aula = substr($dados_data["data_aula"],5,2);
		} else {
		$mes_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$mes_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?>  
    	
    </tr>
    <tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >D<br />i<br />a</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$dia_aula = substr($dados_data["data_aula"],8,2);
		} else {
		$dia_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$dia_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?> 
    	
    </tr>
    
    <tr height="10">
    
    	<th class="table_num"><div align="center" class="table_div1"> <strong>N&ordm;</strong></div></th>
        <th class="table_nome"><div align="center" class="table_div1" ><strong>Nome</strong></font></div></th>
        <th><div align="center" class="table_div1" >Aula</div></th>

    
        
<?php 




if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$exib_contar= str_pad($ch_contar, 3,"0", STR_PAD_LEFT);
        // enquanto houverem resultados...
        echo "
		<th><div class=\"table_div1\"><strong>$exib_contar</a></font></strong></div></th>
		\n";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
;?>       
	</tr></thead>

<tbody>
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
	
	$sql1 = mysql_query("SELECT DISTINCT vad.matricula, vad.nome, vad.turma_disc FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_d 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");
    while ($dados = mysql_fetch_array($sql1)) {
        // enquanto houverem resultados...
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		$turma_disciplina = $dados["turma_disc"];
		$i +=1;
		$exib_i= str_pad($i, 2,"0", STR_PAD_LEFT);
        echo "
	<tr>
		<td><div class=\"table_div1\"><b><center>$exib_i</b></center></div></td>
		<td colspan=\"2\"><div class=\"table_div1\"><b>$nome</b></div></td>
		
		
		\n";
		
		$count3= $count+2;
		$ch_contar2 = $ini_ch;
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
			echo "<td colspan=\"$ch_disciplina\" class=\"table_tamanho2\" align=\"center\">$nome_ocorrencia em $data_cancel.</td>";
		} else {
		while ($ch_contar2 <= $ch_disciplina&&$ch_contar2 <=$fim_ch) {
			//PEGA DATA DA AULA E LANÇA P/F
			$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc = '$turma_d' AND matricula = '$codigo' AND DATA IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$turma_d')");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE  turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			$total = mysql_num_rows($falta_sql);
			if($total == 1){
				$falta_dados = mysql_fetch_array($falta_sql);
			$exibir_falta = $falta_dados["status"];
						if ( $exibir_falta == 'P')
							{ $exibir_falta = '.';}
			
			} else {
				$exibir_falta = ".";
			}
		
			//if($exibir_falta == "J"){
			//	$cor = "green";
			//}
			//if($exibir_falta == "P"){
			//	$cor = "";
			//}
			//PESQUISA SE O ALUNO TEM APROVEITAMENTO
			//<td align=\"center\" bgcolor=\"$cor\">$exibir_falta</td>"; // atual  --> <td align=\"center\">$exibir_falta</td>";			
			echo "
			<td align=\"center\"><div class=\"table_div1\"><b>$exibir_falta</b></font></div></td>";
			
			$ch_contar2 +=1;
			
		}
        // exibir a coluna nome e a coluna email
    }
}
}
?>
</tbody>
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


<?php 
} // FECHA O IF
?>





<?php 
if($ch_disciplina >200){ //CARGA MAIOR QUE 200 HORAS
	echo "<div style=\"page-break-after: always; \"></div>";
	$count = mysql_num_rows($sql);
	$ini_ch = 201;
	$fim_ch = 240;
?>


<table border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
  
  
  <tr>
    <th colspan="2"><img src="img/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count;?>">Registro de Frequ&ecirc;ncia</th>
    </tr>
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Mo&acute;dulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $unidade_turma;?> / <?php echo $polo_turma;?> - <?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina2);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
<table border="1" style="line-height:10px">
<thead>


	<tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >M<br />&ecirc;<br />s</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$mes_aula = substr($dados_data["data_aula"],5,2);
		} else {
		$mes_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$mes_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?>  
    	
    </tr>
    <tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >D<br />i<br />a</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$dia_aula = substr($dados_data["data_aula"],8,2);
		} else {
		$dia_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$dia_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?> 
    	
    </tr>
    
    <tr height="10">
    
    	<th class="table_num"><div align="center" class="table_div1"> <strong>N&ordm;</strong></div></th>
        <th class="table_nome"><div align="center" class="table_div1" ><strong>Nome</strong></font></div></th>
        <th><div align="center" class="table_div1" >Aula</div></th>

    
        
<?php 




if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$exib_contar= str_pad($ch_contar, 3,"0", STR_PAD_LEFT);
        // enquanto houverem resultados...
        echo "
		<th><div class=\"table_div1\"><strong>$exib_contar</a></font></strong></div></th>
		\n";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
;?>       
	</tr></thead>

<tbody>
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
	
	$sql1 = mysql_query("SELECT DISTINCT vad.matricula, vad.nome, vad.turma_disc FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_d 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");
    while ($dados = mysql_fetch_array($sql1)) {
        // enquanto houverem resultados...
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		$turma_disciplina = $dados["turma_disc"];
		$i +=1;
		$exib_i= str_pad($i, 2,"0", STR_PAD_LEFT);
        echo "
	<tr>
		<td><div class=\"table_div1\"><b><center>$exib_i</b></center></div></td>
		<td colspan=\"2\"><div class=\"table_div1\"><b>$nome</b></div></td>
		
		
		\n";
		
		$count3= $count+2;
		$ch_contar2 = $ini_ch;
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
			echo "<td colspan=\"$ch_disciplina\" class=\"table_tamanho2\" align=\"center\">$nome_ocorrencia em $data_cancel.</td>";
		} else {
		while ($ch_contar2 <= $ch_disciplina&&$ch_contar2 <=$fim_ch) {
			//PEGA DATA DA AULA E LANÇA P/F
			$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc = '$turma_d' AND matricula = '$codigo' AND DATA IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$turma_d')");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE  turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			$total = mysql_num_rows($falta_sql);
			if($total == 1){
				$falta_dados = mysql_fetch_array($falta_sql);
			$exibir_falta = $falta_dados["status"];
						if ( $exibir_falta == 'P')
							{ $exibir_falta = '.';}
			
			} else {
				$exibir_falta = ".";
			}
		
			//if($exibir_falta == "J"){
			//	$cor = "green";
			//}
			//if($exibir_falta == "P"){
			//	$cor = "";
			//}
			//PESQUISA SE O ALUNO TEM APROVEITAMENTO
			//<td align=\"center\" bgcolor=\"$cor\">$exibir_falta</td>"; // atual  --> <td align=\"center\">$exibir_falta</td>";			
			echo "
			<td align=\"center\"><div class=\"table_div1\"><b>$exibir_falta</b></font></div></td>";
			
			$ch_contar2 +=1;
			
		}
        // exibir a coluna nome e a coluna email
    }
}
}
?>
</tbody>
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


<?php 
} // FECHA O IF

?>




<?php 
if($ch_disciplina >240){ //CARGA MAIOR QUE 240 HORAS
	echo "<div style=\"page-break-after: always; \"></div>";
	$count = mysql_num_rows($sql);
	$ini_ch = 241;
	$fim_ch = 280;
?>


<table border="1" class="full_table_list" style="font-size:7px; font-family:Arial, Helvetica, sans-serif; line-height:10px">
  
  
  <tr>
    <th colspan="2"><img src="img/logo-cedtec.png" /></th>
    <th colspan="<?php echo $count;?>">Registro de Frequ&ecirc;ncia</th>
    </tr>
    <tr>
    <td colspan="2"><b>Curso:<br /><?php echo strtoupper($nivel_turma).": ".strtoupper($curso_turma)." - Mo&acute;dulo ".strtoupper($modulo_turma);?></b></td>
    <td><b>Ano/Semestre:<br /><?php echo $grupo_turma;?></b></td>
    <td><b>Unidade / Polo - Turma<br /><?php echo $unidade_turma;?> / <?php echo $polo_turma;?> - <?php echo $cod_turma;?></b></td>
    </tr>
    <tr>
    <td colspan="2"><b>Componente Curricular:<br /><?php echo strtoupper($nome_disciplina2);?></b></td>
    <td><b>Docente:<br /><?php echo $nome_professor;?></b></td>
    <td><b>C.H:<br /><?php echo $ch_disciplina;?> h.</b></td>
    </tr>
	</table>
    
<table border="1" style="line-height:10px">
<thead>


	<tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >M<br />&ecirc;<br />s</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$mes_aula = substr($dados_data["data_aula"],5,2);
		} else {
		$mes_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$mes_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?>  
    	
    </tr>
    <tr>
    	<th colspan="2">
        </th>
        <th class="table_tamanho1"><div align="center" class="table_div1" >D<br />i<br />a</div></th>
<?php //PEGA O MES

if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$p_data = mysql_query("SELECT * FROM ced_data_aula WHERE turma_disc = $turma_d AND n_aula = $ch_contar");
		if(mysql_num_rows($p_data) == 1){
		$dados_data = mysql_fetch_array($p_data);
		$dia_aula = substr($dados_data["data_aula"],8,2);
		} else {
		$dia_aula = "--";
		}

        // enquanto houverem resultados...
        echo "
		<td><div class=\"table_div1\"><strong>$dia_aula</a></font></strong></div></td>
		";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
?> 
    	
    </tr>
    
    <tr height="10">
    
    	<th class="table_num"><div align="center" class="table_div1"> <strong>N&ordm;</strong></div></th>
        <th class="table_nome"><div align="center" class="table_div1" ><strong>Nome</strong></font></div></th>
        <th><div align="center" class="table_div1" >Aula</div></th>

    
        
<?php 




if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA ATIVIDADE FOI LANÇADA PARA A TURMA SELECIONADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	$ch_contar = $ini_ch;
    while ($ch_contar <= $ch_disciplina&&$ch_contar <=$fim_ch) {
		
		$exib_contar= str_pad($ch_contar, 3,"0", STR_PAD_LEFT);
        // enquanto houverem resultados...
        echo "
		<th><div class=\"table_div1\"><strong>$exib_contar</a></font></strong></div></th>
		\n";
		$ch_contar +=1;
        // exibir a coluna nome e a coluna email
    }
	
}
;?>       
	</tr></thead>

<tbody>
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
	
	$sql1 = mysql_query("SELECT DISTINCT vad.matricula, vad.nome, vad.turma_disc FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_d 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");
    while ($dados = mysql_fetch_array($sql1)) {
        // enquanto houverem resultados...
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		$turma_disciplina = $dados["turma_disc"];
		$i +=1;
		$exib_i= str_pad($i, 2,"0", STR_PAD_LEFT);
        echo "
	<tr>
		<td><div class=\"table_div1\"><b><center>$exib_i</b></center></div></td>
		<td colspan=\"2\"><div class=\"table_div1\"><b>$nome</b></div></td>
		
		
		\n";
		
		$count3= $count+2;
		$ch_contar2 = $ini_ch;
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
			echo "<td colspan=\"$ch_disciplina\" class=\"table_tamanho2\" align=\"center\">$nome_ocorrencia em $data_cancel.</td>";
		} else {
		while ($ch_contar2 <= $ch_disciplina&&$ch_contar2 <=$fim_ch) {
			//PEGA DATA DA AULA E LANÇA P/F
			$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc = '$turma_d' AND matricula = '$codigo' AND DATA IN (SELECT data_aula FROM ced_data_aula WHERE turma_disc = '$turma_d')");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE  turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			//$falta_sql = mysql_query("SELECT * FROM ced_falta_aluno WHERE n_aula = $ch_contar2 AND turma_disc like '%$turma_d%' AND matricula = '$codigo'");
			$total = mysql_num_rows($falta_sql);
			if($total == 1){
				$falta_dados = mysql_fetch_array($falta_sql);
			$exibir_falta = $falta_dados["status"];
						if ( $exibir_falta == 'P')
							{ $exibir_falta = '.';}
			
			} else {
				$exibir_falta = ".";
			}
		
			//if($exibir_falta == "J"){
			//	$cor = "green";
			//}
			//if($exibir_falta == "P"){
			//	$cor = "";
			//}
			//PESQUISA SE O ALUNO TEM APROVEITAMENTO
			//<td align=\"center\" bgcolor=\"$cor\">$exibir_falta</td>"; // atual  --> <td align=\"center\">$exibir_falta</td>";			
			echo "
			<td align=\"center\"><div class=\"table_div1\"><b>$exibir_falta</b></font></div></td>";
			
			$ch_contar2 +=1;
			
		}
        // exibir a coluna nome e a coluna email
    }
}
}
?>
</tbody>
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


<?php 
} // FECHA O IF
?>



</div></div>

<script language= 'javascript'>
<!--

function usuario(id){
alert("o nº de usuário é: "+id);
}
//-->

</script>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 900;
      var height = 800;
     
      var left = 400;
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

<STYLE>
    thead { display: table-header-group; }
    tfoot { display: table-footer-group; }
</STYLE>
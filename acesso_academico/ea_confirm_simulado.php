<?php 

include 'menu/menu.php'; ?>

<?php
include 'includes/conectar.php';


$turma_disc = $_SESSION["simulado_turma_disc"];
$cod_disc = $_SESSION["simulado_cod_disc"];
$tipo = $_SESSION["simulado_tipo"];


//pega dados da turma
$sql_turma_d = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = $turma_disc");
$dados_turma_d = mysql_fetch_array($sql_turma_d);
$id_turma = $dados_turma_d["id_turma"];
$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma");
$dados_turma = mysql_fetch_array($sql_turma);
$turma_nivel = $dados_turma["nivel"];
$turma_curso = $dados_turma["curso"];
$turma_modulo = $dados_turma["modulo"];
$turma_grupo = $dados_turma["grupo"];
$turma_unidade = $dados_turma["unidade"];
$anograde = $dados_turma["anograde"];
$turma_polo = $dados_turma["polo"];
if($turma_modulo == 1){
$turma_modulo_exib = "I";
}

if($turma_modulo == 2){
$turma_modulo_exib = "II";
}

if($turma_modulo == 3){
$turma_modulo_exib = "III";
}



//pega dados da disciplina
$sql_disc =  mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '$cod_disc' AND anograde LIKE '%$anograde%'");
$dados_disc2 = mysql_fetch_array($sql_disc);
$nome_disciplina = $dados_disc2["disciplina"];

//SALVA RESPOSTAS DOS ALUNOS
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$matricula = $user_usuario;
	$sql_ver_tentativa = mysql_query("SELECT max(tentativa) as tentativa FROM ea_simu_feedback WHERE turma_disc = '$turma_disc' AND matricula = $matricula");
	$dados_tentativa = mysql_fetch_array($sql_ver_tentativa);
	$tentativa = $dados_tentativa["tentativa"];
	
	
		for( $i = 0 , $x = count( $_POST[ 'cod_questao' ] ) ; $i < $x ; ++ $i ) {
			$cod_questao = $_POST[ 'cod_questao' ][$i];
			$id_resposta = $_POST[$cod_questao.'_option'];
			$id_opcao = $_POST[ 'id_opcao' ][$i];
			$valor = $_POST[ 'valor_opcao' ][$i];
			$tentativa_final = $tentativa + 1;
			if(isset($id_resposta)){
			foreach($id_resposta as $indice => $questao_select){
				$resposta = $questao_select;
				if(trim($resposta) != "F"){
					mysql_query("INSERT INTO ea_simu_feedback (id_feedback, turma_disc, cod_questao, id_opcao, resposta, matricula, tentativa,valor) VALUES (NULL,
					'$turma_disc', '$cod_questao', '$id_opcao', '$resposta', '$matricula', '$tentativa_final','$valor')");
				}
			}
			}
	}
	echo "<script language=\"javascript\">
	alert('Suas respostas foram salvas com sucesso.');
	</script>";
	 
	
	
$sql_dados_prova = mysql_query("SELECT matricula, turma_disc, sum(valor) as total, tentativa from ea_simu_feedback 
WHERE id_opcao = resposta AND matricula = '$matricula' AND turma_disc = '$turma_disc'
GROUP BY matricula, turma_disc, tentativa");

}
?>
<div class="conteudo">

<div class="central-ead" style="margin-bottom:100px;">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td bgcolor="#6C6C6C" height="24px" style="color:#FFF"><a href="javascript:history.back()" class="nohover" title="Voltar ao In�cio"><img src="icones/voltar.png" /></a></td>
<td align="center" bgcolor="#6C6C6C" height="24px" style="color:#FFF"><a href="javascript:history.back()"  class="nohover" title="Voltar ao In�cio"><font color="#FFFFFF" style="text-decoration:none;" size="-2"><b><?php echo ($turma_nivel.": ".$turma_curso." M&oacute;dulo ".$turma_modulo_exib."<br>".$turma_unidade." / ".$turma_polo);?></b></font></a></td>
<td align="center" bgcolor="#6C6C6C" height="24px" style="color:#FFF"><b><?php echo ($nome_disciplina);?></b></td>
</tr>

</table>

<hr>
<?php
if(mysql_num_rows($sql_dados_prova) >=1){
	echo "<table class=\"full_table_cad\" align=\"center\" border=\"1\">
	<tr>
		<td align=\"center\"><b>Disciplina</b></td>
		<td align=\"center\"><b>Tentativa</b></td>
		<td align=\"center\"><b>Revis�o</b></td>
	</tr>
	";
	while($dados_provas = mysql_fetch_array($sql_dados_prova)){
		$prova_disciplina = $dados_provas["turma_disc"];
		$prova_max = 10;
		$prova_corretas = ($dados_provas["acerto_total"]/$prova_max)/10;
		$prova_tentativa = $dados_provas["tentativa"];	
		
		
			
		echo "<tr>
			<td>$nome_disciplina</td>
			<td align=\"center\">$prova_tentativa</td>
			<td align=\"center\"><a href=\"revisao_simulado.php?tentativa=$prova_tentativa&&turma_disc=$prova_disciplina\">[REVIS�O]</a></td>
		<tr>";
	}
	mysql_close();
}


?>


</div>

</div>

  <?php

   include 'menu/footer.php' ?>

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir? '))
{
location.href="excluir.php?id="+id;
}
else
{
return false;
}
}
//-->

</script>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>

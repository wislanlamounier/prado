<?php include 'menu/menu.php' ?>
<div class="conteudo">
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
$turma        = strtoupper($_POST["turma_sigla"]);
$grupo        = $_POST["grupo"];
$nivel        = trim(remover_acentos($_POST["nivel"]));
$curso        = trim(remover_acentos($_POST["curso"]));
$polo        = trim(remover_acentos($_POST["polo"]));
$unidade        = trim(remover_acentos($_POST["unidade"]));

$inicio        = $_POST["inicio"];
$final        = $_POST["final"];
$anograde        = $_POST["grade"];
$modulo        = $_POST["modulo"];
$turno        = $_POST["turno"];


include('includes/conectar.php');


$sql_sig_curso = mysql_query("SELECT * FROM tbl_turma1 WHERE curso LIKE '%$curso%' AND nivel LIKE '%$nivel%'");
$dados_curso = mysql_fetch_array($sql_sig_curso);
$sigla_curso = $dados_curso["sigla_curso"];
if(trim($unidade) == "EAD"){
	$nome = strtoupper(substr($unidade,0,2)).$sigla_curso.$modulo.$turma;
} else {
	$nome = strtoupper(substr($polo,0,2)).$sigla_curso.$modulo.$turma;
}


$ver = mysql_query("SELECT * FROM ced_turma WHERE cod_turma LIKE '$nome' AND nivel LIKE '$nivel' AND unidade LIKE '%$unidade%' AND polo LIKE '%$polo%' AND curso LIKE '%$curso%' AND modulo LIKE '%$modulo%' AND grupo LIKE '%$grupo%' AND turno LIKE '%$turno%'");
$contar_turma = mysql_num_rows($ver);

if ($contar_turma >= 1) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('TURMA $turma JÁ EXISTE PARA O PERIODO INFORMADO');
	history.back();
    </SCRIPT>");
	return;
}



if(@mysql_query("INSERT INTO ced_turma (cod_turma,grupo,nivel,curso,modulo,unidade,polo,turno,anograde, inicio, fim ) VALUES ('$nome' , '$grupo','$nivel','$curso','$modulo','$unidade','$polo','$turno','$anograde','$inicio','$final')")) {


	if(mysql_affected_rows() == 1){
		//PESQUISA DISCIPLINAS DA TURMA
		$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE curso LIKE '%$curso%' AND nivel LIKE '%$nivel%' AND modulo LIKE '%$modulo%' AND anograde LIKE '%$anograde%'");
		
		//cadastra as disciplinas do aluno
		while ($dados2 = mysql_fetch_array($sql_disc)){
			$ver_id = mysql_query("SELECT * FROM ced_turma WHERE cod_turma LIKE '$nome' AND nivel LIKE '$nivel' AND unidade LIKE '%$unidade%' AND polo LIKE '%$polo%' AND curso LIKE '%$curso%' AND modulo LIKE '%$modulo%' AND grupo LIKE '%$grupo%' AND turno LIKE '%$turno%'");
			$ver_dados = mysql_fetch_array($ver_id);
			$id_turma = $ver_dados["id_turma"];
			$disciplina          = $dados2["cod_disciplina"];
			mysql_query("INSERT INTO  ced_turma_disc (codturma, disciplina, ano_grade, polo,id_turma,turno) VALUES ('$nome',  '$disciplina', '$anograde', '$polo', '$id_turma','$turno');");
		}
		echo "Turma <b>$nome</b> - $unidade / $polo - $nivel em $curso cadastrada com sucesso!<br />";
	}
} else {
	if(mysql_errno() == 1062) {
		echo $erros[mysql_errno()];
		exit;
	} else {	
		echo "Erro nao foi possivel efetuar o registro";
		exit;
	}	
	@mysql_close();
}

}
?>
<a href="cad_turma.php">Voltar</a>
</div>
<?php include('menu/footer.php');
?>
<?php
include('menu/tabela.php');
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "GET") {
$matricula = $_GET["matricula"];
$turma = $_GET["turma"];
$grupo = $_GET["grupo"];


if(mysql_query("DELETE FROM ced_turma_aluno WHERE matricula = $matricula AND codturma LIKE '%$turma%'")) {
	if(mysql_affected_rows() == 1){
		mysql_query("DELETE FROM ced_aluno_disc WHERE matricula = $matricula");
		echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('ALUNO DESENTURMADO COM SUCESSO');
    history.back(1);
    </SCRIPT>");
	}	
}
} else {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('ALUNO NÃO PODE SER DESENTURMADO');
    history.back(1);
    </SCRIPT>");
}


?>
<BR />
<a href="javascript:history.back();location.reload()">Voltar</a>
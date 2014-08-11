<?php
include('menu/tabela.php');
include('includes/conectar.php');
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$matricula           = $_POST["id"];
	$tipo = strtoupper(($_POST["tipo"]));
	$ocorrencia = ($_POST["ocorrencia"]); 
	$data = $_POST["data"]; 
	
	if(isset($_POST["turma"])){
		$id_turma =$_POST["turma"];
	} else {
		$id_turma = "";
	}
	if($tipo == 1&&$id_turma == ""){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('PARA CANCELAR O ALUNO VOCÊ DEVE ESCOLHER A TURMA');
			history.back();
			</SCRIPT>");
			return;
	}
	
$turma_disc = "";




if(@mysql_query("INSERT INTO ocorrencias (matricula, n_ocorrencia, ocorrencia, data,id_turma,turma_disc)
VALUES ('$matricula','$tipo','$ocorrencia','$data','$id_turma','$turma_disc')")) {
	
	if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('OCORRENCIA INSERIDA COM SUCESSO');
			window.close();
			window.opener.location.reload();
			</SCRIPT>");
			return;
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível atualizar os dados.";
			exit;
		}	
		@mysql_close();
	}



}
?>
<a href="javascript:window.close()">Fechar</a>
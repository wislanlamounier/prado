<?php 
include ('menu/tabela.php');?>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
$id           = $_POST["id"];
$professor         = $_POST["professor"];


include ('includes/conectar.php');

if(@mysql_query("UPDATE ced_turma_disc SET cod_prof = '$professor' WHERE codigo = $id")) {
	
		if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Professor definido com sucesso!');
			window.close();
			window.opener.location.reload()
			</SCRIPT>");
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível definir o professor";
			exit;
		}	
		@mysql_close();
	}

}
?>
<a href="javascript:window.close()">Fechar</a>
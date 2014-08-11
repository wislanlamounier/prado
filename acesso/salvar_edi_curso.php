
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$id           = $_POST["id"];
	$modulo = strtoupper(($_POST["modulo"]));
	$curso = strtoupper(($_POST["curso"])); 
	$nivel = strtoupper(($_POST["nivel"]));
	$grupo = strtoupper(($_POST["grupo"])); 
	$polo = strtoupper(($_POST["polo"])); 
	$turno = strtoupper(($_POST["turno"])); 

include('includes/conectar.php');
if(isset($_POST["mudar"])){
	$statusfinal = 1;
}else {
	$statusfinal = 0;
}



if(@mysql_query("UPDATE geral SET curso = '$curso', modulo = '$modulo', nivel = '$nivel' , grupo = '$grupo', polo = '$polo', turno = '$turno' WHERE ref_id = '$id'")) {
	
	if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Dados atualizados com sucesso');
			window.close();
			opener.reload();
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
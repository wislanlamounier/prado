<?php
include('menu/tabela.php');
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
$titulo           = $_POST["cod_titulo"];
$id_custo         = $_POST["id_custo"];
$cc1         = $_POST["cc1"];
$cc2         = $_POST["cc2"];
$cc3         = $_POST["cc3"];
$cc4         = $_POST["cc4"];
$cc5         = $_POST["cc5"];
$cc6         = $_POST["cc6"];




include('includes/conectar.php');
if(isset($_POST["ativo"])&&$recebido == 0){
	$status = 1;
} else {
	$status = 0;
}


	







	


//UPDATE
	if(@mysql_query("UPDATE c_custo SET cc1 = '$cc1',cc2 = '$cc2',cc3 = '$cc3',
	cc4 = '$cc4', cc5='$cc5', cc6= '$cc6' WHERE codigo = $titulo AND id_custo = $id_custo")) {
	
		if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('CENTRO DE CUSTO ALTERADO COM SUCESSO');
			window.close();
			window.opener.location.reload();
			</SCRIPT>");
		}	
	
	} else {
		if(mysql_errno() == 1062) {
			echo $erros[mysql_errno()];
			exit;
		} else {	
			echo "Não foi possível alterar o título.";
			exit;
		}	
		@mysql_close();
	}

}
?>
<a href="javascript:window.close()">Fechar</a>
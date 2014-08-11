
<?php
include('includes/conectar.php');
if($_SERVER["REQUEST_METHOD"] == "POST") {
$id           = $_POST["id"];
$nome         = $_POST["nome"];
$fantasia         = $_POST["fantasia"];
$email         = $_POST["email"];
$tel         = $_POST["telefone"];
$tel2         = $_POST["telefone2"];
$cpf         = $_POST["cpf"];
$rg         = $_POST["rg"];
$cep         = $_POST["cep"];
$uf         = $_POST["uf"];
$cidade         = $_POST["cidade"];
$endereco         = $_POST["endereco"];
$num         = $_POST["numero"];
$complemento         = $_POST["complemento"];




if(@mysql_query("UPDATE cliente_fornecedor SET nome = '$nome',nome_fantasia = '$fantasia',
	email = '$email', telefone='$tel', telefone2= '$tel2',cpf_cnpj= '$cpf',rg= '$rg',cep= '$cep',uf= '$uf',cidade= '$cidade',endereco='$endereco',numero='$num', complemento = '$complemento' WHERE codigo = $id")) {
	
		if(mysql_affected_rows() == 1){
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Dados atualizados com sucesso');
			window.close();
			opener.reload();
			</SCRIPT>");
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
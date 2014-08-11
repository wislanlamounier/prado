<?php include('menu/tabela.php');
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
$id           = $_POST["id"];
$email         = $_POST["email"];


$nome         = $_POST["nome"];
$cpf         = $_POST["cpf"];
$nascimento         = $_POST["nascimento"];
$documento         = $_POST["documento"];
$emissor         = $_POST["emissor"];
$telefone         = $_POST["telefone"];
$endereco         = $_POST["endereco"];
$bairro         = $_POST["bairro"];
$cidade         = $_POST["cidade"];
$uf         = $_POST["uf"];

$senha         = $_POST["senha"];


include('includes/conectar.php');

mysql_query("UPDATE acesso SET senha = '$senha' WHERE codigo = $id");
if(@mysql_query("UPDATE ced_professor SET email = '$email', CPF = '$cpf', Nome = '$nome', Nascimento = '$nascimento', Documento = '$documento',
Emissor = '$emissor', Telefone = '$telefone', Endereco = '$endereco', Bairro = '$bairro',Cidade = '$cidade', UF = '$uf'  WHERE cod_user = $id")) {
	
		if(mysql_affected_rows() == 1){
			mysql_query("UPDATE acesso_completo SET email_aluno = '$email' WHERE codigo = $id");
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
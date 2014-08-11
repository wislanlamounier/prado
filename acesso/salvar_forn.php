<?php include 'menu/menu.php' ?>
<div class="conteudo">
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
$nome        = $_POST["nome"];
$fantasia        = $_POST["fantasia"];
$email         = $_POST["email"];
$cpf      = $_POST["cpf"];
$rg      = $_POST["rg"];
$telefone      = $_POST["tel"];
$telefone2      = $_POST["tel2"];
$endereco      = $_POST["rua"];
$numero      = $_POST["num"];
$complemento      = $_POST["comp"];
$cep      = $_POST["cep"];
$uf      = $_POST["uf"];
$cidade      = $_POST["cidade"];
$tipo      = $_POST["tipo"];
if($tipo == 1){
	$curso ="CLIENTE";
	$turma ="CLIENTE";	
}
if($tipo == 2){
	$curso ="FORNECEDOR";
	$turma ="FORNECEDOR";	
}
if($tipo == 3){
	$curso ="ALUNO";
	$turma ="ALUNO";	
}
if($tipo == 4){
	$curso ="FUNCIONÁRIO";
	$turma ="FUNCIONÁRIO";	
}

include('includes/conectar.php');
if(@mysql_query("INSERT INTO inscritos (codigo,cpf,noticia) VALUES (NULL , '$cpf','MANUAL')")) {

	if(mysql_affected_rows() == 1){
		echo "Cliente / Fornecedor cadastrado com sucesso.<br />";
		$re2 = mysql_query("SELECT * FROM inscritos WHERE cpf LIKE '%$cpf%' AND noticia LIKE 'MANUAL' ORDER BY codigo DESC LIMIT 1");
		while($dados = mysql_fetch_array($re2)) {
			$cod2 = $dados["codigo"];
			}
			mysql_query("INSERT INTO cliente_fornecedor VALUES ('$cod2' , UPPER('$fantasia') ,UPPER('$nome') , '$email','$telefone','$telefone2','$cpf', '$rg','$uf','$cidade','$endereco','$numero','$complemento', '$cep','$tipo','$curso','$turma')");
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
<a href="cad_forn.php">Voltar</a>
</div>
<?php include('includes/footer.php');?>
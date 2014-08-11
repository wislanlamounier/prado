<?php include 'menu/menu.php';
include('includes/conectar.php'); ?>
<div class="conteudo">
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
$nome        = strtoupper($_POST["nome"]);
$desc        = $_POST["desc"];
$empresa        = $_POST["empresa"];
$valor        = str_replace(",",".",$_POST["valor"]);
$inicio        = $_POST["inicio"];
$final        = $_POST["final"];



if(@mysql_query("INSERT INTO projetos (codigo,empresa,projeto,descricao,valor,inicio,final) VALUES (NULL , '$empresa','$nome','$desc','$valor','$inicio','$final')")) {

	if(mysql_affected_rows() == 1){
		echo "Projeto <b>$nome</b> cadastrado com sucesso!<br />";
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
<a href="cad_projeto.php">Voltar</a>
</div>
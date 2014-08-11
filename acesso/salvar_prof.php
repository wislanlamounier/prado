<?php include 'menu/menu.php' ?>
<div class="conteudo">

<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
$nome        = $_POST["nome"];
$email         = $_POST["email"];
$cpf      = $_POST["cpf"];
$rg      = $_POST["rg"];
$emissor      = $_POST["emissor"];
$admissao      = $_POST["admissao"];
$bairro      = $_POST["bairro"];
$telefone      = $_POST["tel"];
$endereco      = $_POST["rua"];
$uf      = $_POST["uf"];
$cidade      = $_POST["cidade"];
$tipo      = $_POST["tipo"];
if($tipo == 1){
	$curso ="PROFESSOR";
	$turma ="PROFESSOR";	
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
if(@mysql_query("INSERT INTO ced_professor (cod_user, CPF,Nome, Nascimento, Civil, Documento, Emissor, Telefone, Admissao, Endereco, Bairro, Cidade, UF, email)
VALUES (NULL , '$cpf','$nome', '$nascimento', '$civil', '$rg', '$emissor', '$telefone','$admissao','$endereco','$bairro','$cidade','$uf','$email')")) {

	if(mysql_affected_rows() == 1){
		echo "Professor cadastrado com sucesso.<br />";
		$ver = mysql_query("select * from ced_professor where cpf LIKE '%$cpf%' LIMIT 1");
		$dados_ver = mysql_fetch_array($ver);
		$cod2 = $dados_ver["cod_user"];
		$nome_usuario = strtoupper(strstr($nome," ",-60));
		$sobrenome_usuario = strtoupper(strstr($nome," "));
		include('includes/conectar_md.php');
		mysql_query("INSERT INTO ced_user (username,password, firstname,lastname, email,city, country, lang, timezone, confirmed,mnethostid) VALUES ('$cod2',MD5('$cod2'),'$nome_usuario','$sobrenome_usuario','$email','PROFESSOR','BR','pt_br',99,1,1)");
		
		$conferiremail = stripos($email,"@");
		$conferiremail2 = stripos($email,".");
		if($conferiremail == false || $conferiremail2 == false){
			$destinatario ="cobranca@cedtec.com.br";
		} else {
			$destinatario = "$email";
			}
		
		$assunto = "[CEDTEC] SISTEMA ACADÊMICO";
		$corpo = "
		<html>
		<head>
		  <title>[CEDTEC] SISTEMA ACADÊMICO</title>
		</head>
		<body>
		<h2>Caro Professor(a) $nome_usuario,</h2>
		<p>Seja bem-vindo ao CEDTEC.<br>
		  <br>
		  Para sua comodidade segue abaixo seus dados de acesso ao sistema acadêmico como professor.</p>
		<br>
		Usuário: $cod2
		Senha: $cod2
		";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 
		//endereço do remitente
		$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";
		 
		//endereço de resposta, se queremos que seja diferente a do remitente
		$headers .= "Reply-To: comunicacao@cedtec.com.br". "\r\n";
			 
		//endereços que receberão uma copia oculta
		$headers .= "Bcc: cob.cedtec@gmail.com". "\r\n";
		mail($destinatario,$assunto,$corpo,$headers);
		echo "Foi enviado email para $nome_usuario ($destinatario).";
		
		
		
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
<a href="cad_professor.php">Voltar</a>
</div>

<?php
include('menu/footer.php');?>
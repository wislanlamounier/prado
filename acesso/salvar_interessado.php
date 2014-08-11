<?php
include('includes/conectar.php');
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$id           = $_POST["id"];
	$nome = strtoupper($_POST["nome"]);
	$civil = strtoupper($_POST["civil"]); 
	$nacionalidade = strtoupper($_POST["nacionalidade"]); 
	$email = $_POST["email"]; 
	$cpf = strtoupper($_POST["cpf"]);
	$rg = strtoupper($_POST["rg"]); 
	$nascimento = strtoupper($_POST["nascimento"]); 
	$cep = strtoupper($_POST["cep"]); 
	$cidade = strtoupper($_POST["cidade"]); 
	$bairro = strtoupper($_POST["bairro"]); 
	$uf = strtoupper($_POST["uf"]); 
	$endereco = strtoupper($_POST["rua"]); 
	$complemento = strtoupper($_POST["complemento"]); 
	$telefone = strtoupper($_POST["telefone"]); 
	$celular = strtoupper($_POST["celular"]); 
	$mae = strtoupper($_POST["mae"]); 
	$pai = strtoupper($_POST["pai"]); 
	
	//DADOS FINANCEIRO
	$nome_fin = strtoupper($_POST["nome_fin"]);
	$rg_fin = strtoupper($_POST["rg_fin"]);
	$email_fin = $_POST["email_fin"];
	$cpf_fin = strtoupper($_POST["cpf_fin"]); 
	$cep_fin = strtoupper($_POST["cep_fin"]); 
	$uf_fin = strtoupper($_POST["uf_fin"]);
	$cidade_fin = strtoupper($_POST["cidade_fin"]);
	$bairro_fin = strtoupper($_POST["bairro_fin"]);
	$end_fin = strtoupper($_POST["rua_fin"]);
	$comp_fin = strtoupper($_POST["comp_fin"]);
	$nasc_fin = strtoupper($_POST["nasc_fin"]);
	$nacio_fin = strtoupper($_POST["nacio_fin"]);
	$tel_fin = strtoupper($_POST["tel_fin"]);
	
	//DADOS FIADOR
	$nome_fia = strtoupper($_POST["nome_fia"]);
	$rg_fia = strtoupper($_POST["rg_fia"]);
	$email_fia = $_POST["email_fia"];
	$cpf_fia = strtoupper($_POST["cpf_fia"]); 
	$cep_fia = strtoupper($_POST["cep_fia"]); 
	$uf_fia = strtoupper($_POST["uf_fia"]);
	$cidade_fia = strtoupper($_POST["cidade_fia"]);
	$bairro_fia = strtoupper($_POST["bairro_fia"]);
	$end_fia = strtoupper($_POST["rua_fia"]);
	$nasc_fia = strtoupper($_POST["nasc_fia"]);
	$nacio_fia = strtoupper($_POST["nacio_fia"]);
	$tel_fia = strtoupper($_POST["tel_fia"]);
	
	$nome_conj = strtoupper($_POST["nome_conj"]);
	$rg_conj = strtoupper($_POST["rg_conj"]);
	$cpf_conj = strtoupper($_POST["cpf_conj"]); 
	$nasc_conj = strtoupper($_POST["nasc_conj"]);
	$nacio_conj = strtoupper($_POST["nacio_conj"]);



if(isset($_POST["mudar"])){
	$statusfinal = 1;
}else {
	$statusfinal = 0;
}



if(@mysql_query("UPDATE inscritos SET nome = '$nome', email = '$email', rg = '$rg', cpf='$cpf',nascimento = '$nascimento', civil='$civil',
telefone = '$telefone',celular = '$celular', nacionalidade='$nacionalidade',pai = '$pai', mae='$mae', cep='$cep',uf='$uf', cidade='$cidade',bairro='$bairro', endereco='$endereco',
complemento='$complemento', nome_fin='$nome_fin',nasc_fin='$nasc_fin', cpf_fin='$cpf_fin',uf_fin='$uf_fin',rg_fin='$rg_fin', cep_fin='$cep_fin',
end_fin='$end_fin', cidade_fin='$cidade_fin',bairro_fin='$bairro_fin', tel_fin='$tel_fin',comp_fin='$comp_fin', nacio_fin='$nacio_fin',
email_fin='$email_fin', nome_fia='$nome_fia',nasc_fia='$nasc_fia', cpf_fia='$cpf_fia',rg_fia='$rg_fia', cep_fia='$cep_fia',
end_fia='$end_fia', cidade_fia='$cidade_fia',uf_fia='$uf_fia', bairro_fia='$bairro_fia',nacio_fia='$nacio_fia',tel_fia='$tel_fia', email_fia='$email_fia',
nome_conj='$nome_conj', nasc_conj='$nasc_conj',cpf_conj='$cpf_conj', rg_conj='$rg_conj',nacio_conj='$nacio_conj' WHERE codigo = $id")) {
	
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
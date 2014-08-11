<?php
include("menu/tabela.php");
include("includes/conectar.php");
?>
<?php
	$id           = $_GET["id"];
if(trim($id) != ""){
		





if(@mysql_query("UPDATE acesso SET senha = 'cedtec', status = '1' WHERE codigo = $id")) {
	
	if(mysql_affected_rows() == 1){
		include('includes/conectar_md.php');
		mysql_query("UPDATE ced_user SET password=MD5('cedtec') WHERE username='$id'" );
			echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('SENHA RESETADA COM SUCESSO');
			window.close();
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

	} else {
		echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('ERRO, CONTATE O ADMINISTRADOR DO SISTEMA');
			window.close();
			</SCRIPT>");
			return;
	}
?>
<a href="javascript:window.close()">Fechar</a>
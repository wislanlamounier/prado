<?php
include("menu/menu.php");
include_once ("includes/Redimensiona.php");

if (isset($_POST['acao']) && $_POST['acao']=="Salvar"){
	
	$foto = $_FILES['foto'];	
	$redim = new Redimensiona();
	$src=$redim->Redimensionar($foto, 34, "images/perfil",$user_usuario);
	
	$sql_verificar_usuario = mysql_query("SELECT * FROM acessos_completos WHERE usuario = '$user_usuario'");
	if(mysql_num_rows($sql_verificar_usuario)==1){
		if(mysql_query("UPDATE acessos_completos SET foto_perfil = '$src' WHERE usuario = '$user_usuario'")){
		if(mysql_affected_rows()==1){
			echo "<script language=\"javascript\">
			alert('Foto de Perfil Alterada Com Sucesso!!  Para visualizar acesse novamente o sistema');</script>";
		}
	}
	} else {
	if(mysql_query("UPDATE users SET foto_perfil = '$src' WHERE usuario = '$user_usuario'")){
		if(mysql_affected_rows()==1){
			echo "<script language=\"javascript\">
			alert('Foto de Perfil Alterada Com Sucesso!! Para visualizar acesse novamente o sistema');</script>";
		}
	}
	}
	
}

?>
<div class="conteudo">
<form method="post" action="" enctype="multipart/form-data">
	<label>Foto: <input type="file" name="foto" /></label>    
    <input type="submit" value="Salvar" />
    <input type="hidden" name="acao" value="Salvar" />
</form>
<?php
if (isset($_POST['acao']) && $_POST['acao']=="cadastrar"){
	echo "<img src=\"$src\">";
}

?>
</div>
<?php

include("menu/footer.php");
?>

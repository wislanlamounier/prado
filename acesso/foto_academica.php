<?php
include("menu/tabela.php");
include("includes/conectar.php");
include_once ("includes/Redimensiona.php");
$matricula = $_GET["id"];
if (isset($_POST['acao']) && $_POST['acao']=="Salvar"){
	
	$foto = $_FILES['foto'];	
	$redim = new Redimensiona();
	$src=$redim->Redimensionar($foto, 100, "images/perfil_academico",$matricula);
	
	$sql_verificar_perfil = mysql_query("SELECT * FROM acessos_completos WHERE usuario = '$matricula'");
	if(mysql_num_rows($sql_verificar_perfil)==1){
		$dados_perfil = mysql_fetch_array($sql_verificar_perfil);
		if(mysql_query("UPDATE acessos_completos SET foto_academica = '$src' WHERE usuario = '$matricula'")){
		if(mysql_affected_rows()==1){
			echo "<script language=\"javascript\">
			alert('Foto Alterada!!');
			window.close();
			window.opener.location.reload()</script>";
		}
	}

	}
}
$sql_verificar_perfil = mysql_query("SELECT * FROM acessos_completos WHERE usuario = '$matricula'");
if(mysql_num_rows($sql_verificar_perfil)==1){
	$dados_perfil = mysql_fetch_array($sql_verificar_perfil);
}

?>
<div class="conteudo">
<a href="foto_academica2.php?id=<?php echo $matricula;?>">[Tirar Foto]</a> | <a href="foto_academica.php?id=<?php echo $matricula;?>">[Escolher Foto no Computador]</a>
<div align="center"><img src="<?php echo $dados_perfil["foto_academica"];?>" height="100" width="100" /></div>
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

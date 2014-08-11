<?php
include("menu/menu.php");
include_once ("includes/Redimensiona.php");

if (isset($_POST['acao']) && $_POST['acao']=="Salvar"){
	
	$foto = $_FILES['foto'];	
	$redim = new Redimensiona();
	$src=$redim->Redimensionar($foto, 34, "images/perfil");
	
}

?>

<form method="post" action="" enctype="multipart/form-data">
	<label>Foto: <input type="file" name="foto" /></label>    
    <input type="submit" value="Salvar" />
    <input type="hidden" name="acao" value="Salvar" />
</form>
<?php
if (isset($_POST['acao']) && $_POST['acao']=="cadastrar"){
	echo "<img src=\"$src\">";
}

include("menu/footer.php");
?>

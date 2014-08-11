<?php
include("menu/tabela.php");
include("includes/conectar.php");
include_once ("includes/Redimensiona.php");
$get_anograde = $_GET["anograde"];
$get_cod_disc = $_GET["cod_disc"];
$get_aula = $_GET["aula"];
$nome_arquivo = $get_cod_disc."_".$get_aula."-".substr($get_anograde,0,4);
if (isset($_POST['acao']) && $_POST['acao']=="Salvar"){
	
	$foto = $_FILES['foto'];	
	$previsto = $_POST["previsto"];
	$redim = new Redimensiona();
	$src=$redim->Redimensionar($foto, 700, "../planejamentos",$nome_arquivo);
	$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc LIKE '%$get_cod_disc%' AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'");
	if(mysql_num_rows($sql_verificar_previsto)>=1){
		$dados_previsto = mysql_fetch_array($sql_verificar_previsto);
		if(mysql_query("UPDATE conteudo_previsto SET arquivo = '$src' WHERE cod_disc LIKE '%$get_cod_disc%' AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'")){
		if(mysql_affected_rows()>=1){
			echo "<script language=\"javascript\">
			alert('Planejamento atualizado!!');
			window.close();
			window.opener.location.reload()</script>";
		}
	}

	} else {
		if(mysql_query("INSERT INTO conteudo_previsto (n_aula, cod_disc, ano_grade, arquivo, previsto) VALUES ('$get_aula', '$get_cod_disc', '$get_anograde', '$src', '$previsto')")){
		if(mysql_affected_rows()==1){
			echo "<script language=\"javascript\">
			alert('Planejamento inserido!!');
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
<div align="center"><img src="<?php echo $dados_perfil["foto_academica"];?>" height="100" width="100" /></div>
<form method="post" action="" enctype="multipart/form-data">
	<label>Arquivo: <input type="file" name="foto" /></label>
    <textarea name="previsto" class="ckeditor"></textarea>   
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

<?php include 'menu/menu.php'; ?>
<?php include ('includes/conectar.php');

if( isset ( $_POST[ 'salvar_senha' ] ) ) {
$usuario_ativo = $_POST["usuario"];
$senha_atual = $_POST["senha"];
$nova_senha = $_POST["n_senha"];
$c_nova_senha = $_POST["cn_senha"];


$sql_senha = mysql_query("SELECT * FROM users WHERE usuario LIKE '$usuario_ativo' AND senha = '$senha_atual'");
$sql_verificar = mysql_num_rows($sql_senha);

if($sql_verificar == 1){
	if($nova_senha == $c_nova_senha){
		$sql_att_senha = mysql_query("UPDATE users SET senha = '$nova_senha' WHERE usuario LIKE '$usuario_ativo' AND senha LIKE '$senha_atual'");
		echo "<script language=\"javascript\">
		alert('Senha atualizada com sucesso!!');
		</script>";
		//ATUALIZA SENHA MOODLE
	include('includes/conectar_md.php');
	mysql_query("UPDATE ced_user SET password=MD5('$nova_senha') WHERE username='$usuario_ativo'" );
	} else {
		echo "<script language=\"javascript\">
		alert('Dados de acesso não conferem tente novamente.!!');
		</script>";
	}
} else {//se não achar resultados pesquisa em acesso_completo
	
	
$sql_senha2 = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$usuario_ativo' AND senha = '$senha_atual'");
$sql_verificar2 = mysql_num_rows($sql_senha2);
if($sql_verificar2 == 1){
	if($nova_senha == $c_nova_senha){
		$sql_att_senha = mysql_query("UPDATE acessos_completos SET senha = '$nova_senha' WHERE usuario LIKE '$usuario_ativo' AND senha = '$senha_atual'");
		echo "<div align=\"center\" style=\"background:green;color:white;\">SENHA ATUALIZADA COM SUCESSO</div>";
		include('includes/conectar_md.php');
	mysql_query("UPDATE ced_user SET password=MD5('$nova_senha') WHERE username='$usuario_ativo'" );
	} else {
		echo "<div align=\"center\" style=\"background:red;color:white;\">DADOS NÃO CONFEREM, TENTE NOVAMENTE</div>";
		return;
		exit;
	}
if($sql_verificar2 == 2){
	echo "<div align=\"center\" style=\"background:red;color:white;\">DADOS NÃO CONFEREM, TENTE NOVAMENTE</div>";
}


}
}
};


?>
<div class="conteudo">
<form method="post" action="#">
<table class="full_table_cad" align="center">
<tr>
<td width="132">Usuário</td>
<td width="356"><input name="user" type="text" value="<?php echo $_SESSION['MM_Username'];?>" readonly="readonly" /></td>
</tr>
<input name="usuario" type="hidden" value="<?php echo $_SESSION['MM_Username'];?>" />
<tr>
<td>Senha Atual:</td>
<td><input name="senha" type="password" /></td>
</tr>
<tr>
<td>Nova Senha:</td>
<td><input name="n_senha" type="password" /></td>
</tr>
<tr>
<td>Confirmar Senha:</td>
<td><input name="cn_senha" type="password" /></td>
</tr>
<tr>
<td colspan="2" align="center"><input name="salvar_senha" id="salvar_senha" type="submit" value="Confirmar" /></td>

</tr>
</table>
</form>
</div>
  <?php include 'menu/footer.php' ?>

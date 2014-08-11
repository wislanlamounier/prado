<body onLoad="frmLogin.submit();">
<?php include 'menu/menu.php'; ?>
<div class="conteudo">

<?php 
//conecta banco de dados cedtec

include('includes/conectar.php');


$usuario =  (int)$user_usuario;
$senha =  $user_senha;
?>

<center>AGUARDE ENQUANTO PROCESSAMOS O SEU ACESSO</center>
<div class="nota" align="center" style="visibility:hidden">
<FORM id="frmLogin" onSubmit="return validarFormularioLogin(this)" method="post" 
action="http://50.97.48.229/~cedtecvi/digital/login/index.php" target="_top">
<div class="g-destaque-form-item">
  <div class="g-destaque-form-input">
    <p>Usu&aacute;rio
      <input name="username" type="text" class="g-destaque-input" id="ob" value="<?php echo $usuario;?>" size="7" 
maxlength="160" tooltiptext="Informe o usu&aacute;rio e senha de seu cadastro no Portal" />
      Senha
      <input name="password" type="password" class="g-destaque-input" id="ob2" value="<?php echo $senha;?>" size="7" 
maxlength="20" tooltiptext="Digite a senha definida por voc&ecirc;" />
      <span class="g-destaque-form-label">
    <input class="g-destaque-btn-blue" title="Acessar" value="Acessar" type="submit" />
      </span>
  </div>
</div><INPUT 
name="TABLE" value="CLIENTE" type="hidden">
				<INPUT name="ACTION" value="LOGIN" 
type="hidden">
</FORM>
</div>
</div>
<?php include 'menu/footer.php' ?>

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir? '))
{
location.href="excluir.php?id="+id;
}
else
{
return false;
}
}
//-->

</script>

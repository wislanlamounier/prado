<?php require_once('Connections/conexao.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}



if (isset($_POST['usuario'])) {
  $loginUsername=$_POST['usuario'];
  $password=$_POST['senha'];
  $MM_fldUserAuthorization = "nivel";
  include('conectar.php');
  $login_usuario = (int)$loginUsername;
  $aluno_sql = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$login_usuario' AND senha LIKE '$password'");
  $total_aluno = mysql_num_rows($aluno_sql);
  if($total_aluno>=1){
	  $usuario_login = (int)$loginUsername;
	  $usuario_senha = $password;
	$sql_final =  "SELECT * FROM acessos_completos WHERE  usuario='$usuario_login' AND senha='$usuario_senha'";
	$redirect = "acesso_academico/index.php";
  } else {
	  $sql_final =  "SELECT * FROM users WHERE  usuario='$loginUsername' AND senha='$password'";
		$redirect = "acesso/index.php";
  }
  
  
  $MM_redirectLoginSuccess = $redirect;
  $MM_redirectLoginFailed = "index.php?erro=1";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexao, $conexao);
  	
  $LoginRS__query=sprintf($sql_final,
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conexao) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'nivel');
	$loginStrName = mysql_result($LoginRS,0,'nome');
	$loginAcessos = mysql_result($LoginRS,0,'acessos');
	$loginId_user = mysql_result($LoginRS,0,'id_user');
	$loginEmail = mysql_result($LoginRS,0,'email');
	$loginUnidade = mysql_result($LoginRS,0,'unidade');
	$loginEmpresa = mysql_result($LoginRS,0,'empresa');
	$loginFoto = mysql_result($LoginRS,0,'foto_perfil');
	$loginSenha = mysql_result($LoginRS,0,'senha');
	
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
	$_SESSION['MM_Nome'] = $loginStrName;	
	$_SESSION['MM_Acessos'] = $loginAcessos;
	$_SESSION['MM_iduser'] = $loginId_user;	 
	$_SESSION['MM_email'] = $loginEmail;
	$_SESSION['MM_unidade'] = $loginUnidade;
	$_SESSION['MM_empresa'] = $loginEmpresa;
	$_SESSION['MM_Foto'] = $loginFoto;
	$_SESSION['MM_Senha'] = $loginSenha;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
 
if(isset($_GET["erro"])){
	$erro = $_GET["erro"];
} else {
	$erro = 0;
}
?>
<head>
  <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/main.css">
  <style type="text/css">
  body,td,th {
	font-family: Montserrat, Arial;
}
  </style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
<title>Pincel At&ocirc;mico</title>
</head>
<body onUnload="document.getElementById('carregando').style.display=''"> 

  <div class="login">
  <img src="images/logo_pincel.png">
<?php 
if($erro==1){
	echo "<div class=\"erro\">Usuário ou senha inválidos, tente novamente.</div><br>";
}
?>
<div class="carregando" id="carregando" style="display:none;"> Carregando aguarde... </div>
  
  <form action="<?php echo $loginFormAction; ?>" method="POST">
    <div class="input">
      <div class="blockinput">
        <i class="icon-envelope-alt"><img height="20" src="images/icone_usuario.png"></i><input name="usuario" type="text" placeholder="Usuário / Matrícula">
      </div>
      <div class="blockinput">
        <i style="margin-top:10px;"><img height="20" src="images/icone_senha.png"></i><input name="senha"  type="password" placeholder="Senha">
      </div>
      </div>
       
       <center><button type="submit" onClick="document.getElementById('carregando').style.display=''">Acessar</button></center>
  </form>
  
  <center><a href="javascript:abrir('lembrar_senha.php');" style="color:blue; font-family:Arial, Helvetica, sans-serif">Esqueceu sua senha?<br> Clique aqui para recuperar.</a></center>
  </div>
       <footer>
            <a href="http://cedtec.com.br" target="_blank" class="stuts">&copy; Copyright 2013 - Escola T&eacute;cnica CEDTEC. Todos os direitos reservados.</a>
        </footer>
</body>


<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
function pesquisar (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while(data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar2.php?id="+data,'_blank');
}
else
{
exit;
}

}

function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
}
</SCRIPT>
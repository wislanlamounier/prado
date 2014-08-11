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
  $MM_redirectLoginSuccess = "acesso/index.php";
  $MM_redirectLoginFailed = "index.php?erro=1";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexao, $conexao);
  	
  $LoginRS__query=sprintf("SELECT * FROM users WHERE usuario=%s AND senha=%s",
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
</head>
<body> 

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
  </div>
       <footer>
            <a href="http://cedtec.com.br" target="_blank" class="stuts">© Copyright 2013 - Escola Técnica CEDTEC. Todos os direitos reservados.</a>
        </footer>
</body>
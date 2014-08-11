<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php include("../includes/conectar.php");

//pega as variaveis dos usuarios
$user_usuario = $_SESSION['MM_Username'];
$user_nivel = $_SESSION['MM_UserGroup'];
$user_empresa = $_SESSION['MM_empresa'];
$user_unidade = $_SESSION['MM_unidade'];
$user_email = $_SESSION['MM_email'];
$user_acessos = $_SESSION['MM_Acessos'];
$user_iduser = $_SESSION['MM_iduser'];
$user_nome = $_SESSION['MM_Nome'];

/*
//pega o nome da pagina atual
$pagina_2 = explode("/",$_SERVER['PHP_SELF']);
$x = count($pagina_2) - 1;
$pagina_atual = $pagina_2[$x];

//verifica se possui permisão para acessar pagina
$sql_pagina =mysql_query("SELECT * FROM ced_submenu WHERE link LIKE '%$pagina_atual%' LIMIT 1");
$contar_pagina = mysql_fetch_array($sql_pagina);
if($contar_pagina == 0){
	$sql_pagina =mysql_query("SELECT * FROM ced_menu WHERE link LIKE '%$pagina_atual%'  LIMIT 1");
}

$dados_pagina = mysql_fetch_array($sql_pagina);
$pagina_acesso = $dados_pagina["acessos"];
$pagina_pessoas = $dados_pagina["id_pessoas"];
$verificar_permissao = strpos($pagina_acesso, $user_acessos);
if($verificar_permissao!== false){
	echo "";//permitido
} else {
	echo "<script language= \"JavaScript\">
	alert('ACESSO NEGADO - USUÁRIO SEM PERMISSÃO DE ACESSO A ESSA PAGINA');
	history.back();
</script>";
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel='stylesheet' type='text/css' href='../css/layout.css' />
<link rel='stylesheet' type='text/css' href='../css/imprimir.css' media="print" />
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="http://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
        <script src="../js/gmaps.js" type="text/javascript"></script>
        <script src="../js/cep.js" type="text/javascript"></script>
        <link href="../css/bootstrap.css" rel="stylesheet" />

        <script>
            $(function(){
                wscep({map: 'map1',auto:true});
                wsmap('08615-000','555','map2');
            })
        </script>
        <script type='text/javascript' src='ckeditor/ckeditor.js'></script>
<script type='text/javascript' src='ckeditors/adapters/jquery.js'></script>
<script type='text/javascript' src='ckeditor/plugins/div/dialogs/div.js'></script>
<script>

	$(function()
	{
		var config = {};

		$('.ckeditor').ckeditor(config);
	});
</script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<link rel='stylesheet' type='text/css' href='../css/menu.css' />
<link rel='stylesheet' type='text/css' media='print' href='../css/imprimir.css' />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script type='text/javascript' src='ckeditor/ckeditor.js'></script>
<script type='text/javascript' src='ckeditor/adapters/jquery.js'></script>
<script type='text/javascript' src='ckeditor/plugins/div/dialogs/div.js'></script>
<script>

	$(function()
	{
		var config = {};

		$('.ckeditor').ckeditor(config);
		
	});
	
CKEDITOR.replace( 'editor',{
    filebrowserBrowseUrl : 'ckeditor/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?type=Images',
    filebrowserFlashBrowseUrl : 'ckeditor/ckfinder/ckfinder.html?type=Flash',
    filebrowserUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Files',
    filebrowserImageUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Images',
    filebrowserFlashUploadUrl : 'ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&amp;type=Flash'
} )
</script>

<title>SISTEMA FINANCEIRO - PINCEL AT&Ocirc;MICO</title>
</head>

<?php
include('../menu/funcoes.php');
?>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
<?php
//initialize the session
if (!isset($_SESSION)) {
	session_cache_expire(200000);
	$cache_expire = session_cache_expire();
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
	session_cache_expire(200000);
$cache_expire = session_cache_expire();
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
<?php include("includes/conectar.php");

//pega as variaveis dos usuarios
$user_usuario = (int)$_SESSION['MM_Username'];
$user_nivel = $_SESSION['MM_UserGroup'];
$user_empresa = $_SESSION['MM_empresa'];
$user_unidade = $_SESSION['MM_unidade'];
$user_email = $_SESSION['MM_email'];
$user_acessos = $_SESSION['MM_Acessos'];
$user_iduser = $_SESSION['MM_iduser'];
$user_nome = $_SESSION['MM_Nome'];
$user_foto = $_SESSION['MM_Foto'];
$user_senha = $_SESSION['MM_Senha'];

if(isset($_GET["id_turma"])){
	$get_id_turma = $_GET["id_turma"];
	$sql_get_turma = " AND ct.id_turma = '$get_id_turma'";
} else {
	$get_id_turma = "";
	$sql_get_turma = "";
}

$sql_turmas_user = mysql_query("
SELECT ct.id_turma, ct.anograde
FROM ced_turma_aluno cta
INNER JOIN ced_turma ct
ON cta.id_turma = ct.id_turma
WHERE cta.matricula LIKE '$user_usuario' $sql_get_turma
ORDER BY cta.anograde, ct.modulo DESC LIMIT 1");
if(mysql_num_rows($sql_turmas_user)>=1){
$dados_turmas_user = mysql_fetch_array($sql_turmas_user);
$user_turma_id_turma = $dados_turmas_user["id_turma"];
$user_turma_anograde = $dados_turmas_user["anograde"];
} else {
	$user_turma_id_turma = "";
	$user_turma_anograde = "";
}

$sql_turma_dados =  mysql_query("SELECT * FROM ced_turma WHERE id_turma = '$user_turma_id_turma' ");
if(mysql_num_rows($sql_turma_dados)>=1){
	$dados_turma_aluno = mysql_fetch_array($sql_turma_dados);
	$aluno_unidade = trim($dados_turma_aluno["unidade"]);
	$aluno_modulo = trim($dados_turma_aluno["modulo"]);
} else {
	$aluno_unidade = "";
	$aluno_modulo = "";
}



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
<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8" />
        <title>Pincel Atômico - Sistema Acadêmico</title>
        <link rel="stylesheet" href="css/layout.css" type="text/css">
        <link rel="stylesheet" href="css/menu.css" type="text/css">
        <link rel="stylesheet" href="css/imprimir.css" type="text/css" media="print">
<script type='text/javascript' src='js/ckeditor.js'></script>
<script type='text/javascript' src='js/adapters/jquery.js'></script>
<script type='text/javascript' src='js/plugins/div/dialogs/div.js'></script>
<script>

	$(function()
	{
		var config = {};

		$('.ckeditor').ckeditor(config);
	});
</script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="http://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
        <script src="js/gmaps.js" type="text/javascript"></script>
        <script src="js/cep.js" type="text/javascript"></script>
        <link href="css/bootstrap.css" rel="stylesheet" />
        <link href="css/960.css" rel="stylesheet" />
        <script>
            $(function(){
                wscep({map: 'map1',auto:true});
                wsmap('08615-000','555','map2');
            })
        </script>

    </head>
    <body oncontextmenu='return false' onselectstart='return false' ondragstart='return false'>

            <ul id="nav">
            <li class="nohover"><div><a style="text-decoration:none; background:none;" id="nohover" href="index.php"><img src="images/logo_pincel_branca.png" /></div></a></li>
            <li></li>
<?php 

$sql_menu = mysql_query("SELECT * FROM ced_menu WHERE acessos LIKE '%$user_acessos%' OR id_pessoas LIKE '%$user_iduser%' ORDER BY ordem");
while($dados_menu = mysql_fetch_array($sql_menu)){
	$id_menu = $dados_menu["id_menu"];
	$nome_menu = $dados_menu["menu"];
	$icone_menu = utf8_encode($dados_menu["icone"]);
	$submenu_menu = $dados_menu["submenu"];
	$link_menu = utf8_encode($dados_menu["link"]);
	if($submenu_menu == 1){
		echo "<li><a href=\"$link_menu\"><span><img src=\"images/icones/$icone_menu\" />$nome_menu</span></a>
                    <div class=\"subs\">
                            <ul>";
		$sql_submenu = mysql_query("SELECT * FROM ced_submenu WHERE id_menu = $id_menu AND id_submenu = 0 AND (acessos LIKE '%$user_acessos%' OR id_pessoas LIKE '%$user_iduser%') ORDER BY ordem");
		while($dados_submenu = mysql_fetch_array($sql_submenu)){
			$id_submenu = $dados_submenu["id_sub"];
			$nome_submenu = $dados_submenu["nome_submenu"];
			$link_submenu = $dados_submenu["link"];
			$submenu_submenu = $dados_submenu["submenu"];
			if($submenu_submenu == 1){
				echo "
			<li><a href=\"$link_submenu\"><span><img src=\"images/icones/$icone_menu\" /> $nome_submenu</span></a>
			<div class=\"subs\">
                 <ul>
			";
				$sql_submenu2 = mysql_query("SELECT * FROM ced_submenu WHERE id_menu = '$id_menu' AND id_submenu = $id_submenu AND (acessos LIKE '%$user_acessos%' OR id_pessoas LIKE '%$user_iduser%') ORDER BY ordem");
				while($dados_submenu2 = mysql_fetch_array($sql_submenu2)){
					$nome_submenu2 = $dados_submenu2["nome_submenu"];
					$link_submenu2 = $dados_submenu2["link"];
					echo "
					<li><a href=\"$link_submenu2\"><img src=\"images/icones/$icone_menu\" /> $nome_submenu2</a></li>";
				}
			echo "
                 </ul></div></li>";
				 
				 		
			} else {
				echo "<li><a href=\"$link_submenu\"><img src=\"images/icones/$icone_menu\" />$nome_submenu</a></li>";
			}
		}//fecha whiçe
	echo "</ul></div></li>";
	
	
	} else {//se não tem submenu
	echo "<li><a href=\"$link_menu\"><img src=\"images/icones/$icone_menu\" />$nome_menu</a></li>";
	}
}
?>
                
          
            <li style="position:absolute; left:80%"><a href="#"><span><img src="<?php echo $user_foto ;?>" /> <?php echo $user_nome ;?> (<?php echo $user_usuario ;?>)</span></a>
                    <div class="subs">
                            <ul>
                                <li><a href="alterar_perfil.php"><img src="images/icones/senha.png" /> Alterar Perfil</a></li>
                                <li><a href="alterar_senha.php"><img src="images/icones/senha.png" /> Alterar Senha</a></li>
                                <li><a href="<?php echo $logoutAction ?>"><img src="images/icones/sair.png" /> Sair</a></li>
                            </ul>
                    </div>
              </li>
            
            </ul>




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

<?php
include('menu/funcoes.php');
?>


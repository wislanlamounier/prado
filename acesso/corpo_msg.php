<?php
include ('menu/tabela.php');// inclui o menu
include ('includes/conectar.php');// inclui o menu
$get_idmsg = $_GET["id"];
if($get_idmsg == 0){
	echo "
<center><font size=\"+1\">ABRA UMA MENSAGEM AO LADO</font></center><hr />
";
} else {
$sql_msg = mysql_query("SELECT * FROM msgs WHERE id_msg = $get_idmsg");
$dados_msg=mysql_fetch_array($sql_msg);
$msg_texto = $dados_msg["texto"];
$msg_enviado = strtoupper($dados_msg["enviado"]);
echo "
<center><font size=\"+1\">$msg_enviado</font></center><hr />

$msg_texto
";
mysql_query("UPDATE msgs SET visto = 0 WHERE id_msg = $get_idmsg");
mysql_query("INSERT INTO ver_msgs (id_ver, id_user, id_msg) VALUES (NULL,'$user_iduser','$get_idmsg')");

}

?>


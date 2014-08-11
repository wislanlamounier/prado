<?php
include ('menu/tabela.php');
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "GET") {
include('includes/conectar.php');
$id = $_GET["id"];




$verif    = mysql_query("select * from titulos where id_titulo = $id");
$verif2 = mysql_fetch_array($verif);
$pago = $verif2["valor_pagto"];

$atual = date("Y-m-d");
$ipativo = $_SERVER["REMOTE_ADDR"];

if($pago == 0 || $user_nivel == 1 || $user_nivel == 2 || $user_nivel==3 || $user_nivel==4){
if(mysql_query("delete from titulos where id_titulo = $id")) {
	if(mysql_affected_rows() == 1){
		mysql_query("INSERT INTO logs (usuario,data_hora,cod_acao,acao,ip_usuario)
	VALUES ('$usuario','$atual','06','EXCLUIU O TÍTULO $id','$ipativo');");
		echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('TITULO DELETADO COM SUCESSO');
    history.back(1);
    </SCRIPT>");
	}	
}
} else {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOC&Ecirc; N&Atilde;O TEM PERMISSÃO PARA EXCLUIR T&Iacute;TULOS');
    history.back(1);
    </SCRIPT>");
}

}

?>
<BR />
<a href="javascript:history.back();location.reload()">Voltar</a>
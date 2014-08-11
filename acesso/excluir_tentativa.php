<?php
include ('menu/tabela.php');
?>
<?php
if($_SERVER["REQUEST_METHOD"] == "GET") {
include('includes/conectar.php');
$matricula = $_GET["matricula"];
$questionario = $_GET["questionario"];
$tentativa = $_GET["tentativa"];
$atual = date("Y-m-d");
$ipativo = $_SERVER["REMOTE_ADDR"];

if(mysql_query("delete from ea_q_feedback where matricula = '$matricula' AND id_questionario = '$questionario' AND tentativa = '$tentativa'")) {
	if(mysql_affected_rows() == 1){
		mysql_query("INSERT INTO logs (usuario,data_hora,cod_acao,acao,ip_usuario)
	VALUES ('$user_usuario','$atual','09','EXCLUIU A TENTATIVA $tentativa DO ALUNO $matricula REFERENTE AO QUESTIONARIO $questionario','$ipativo');");
		echo "<SCRIPT LANGUAGE='JavaScript'>
    alert('TENTATIVA EXCLUIDA COM SUCESSO');
    window.close();
    </SCRIPT>";
	}	
}
} else {
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOC&Ecirc; N&Atilde;O TEM PERMISSÃO PARA EXCLUIR TENTATIVAS');
    history.back(1);
    </SCRIPT>");
}


?>
<BR />
Tentativa excluida
<a href="javascript:window.close()">Fechar</a>
<?php 
$host = 'mysql1.cedtec.com.br'; // endereço do seu mysql
$user = 'cedtecvi_pincel'; // usuário
$pass = 'BDPA2013ced'; // senha
$con = mysql_connect($host,$user,$pass); // função de conexão
$db = 'cedtecvi_pincel'; // nome do banco de dados
mysql_select_db($db,$con) or print mysql_error(); // seleção do banco de dados

?>
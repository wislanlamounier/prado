<?php 
$host2 = 'mysql1.cedtec.com.br'; // endereço do seu mysql
$user2 = 'cedtecvi_digmoo'; // usuário
$pass2 = 'di9U9Z1gt9'; // senha
$con2 = mysql_connect($host2,$user2,$pass2); // função de conexão
$db2 = 'cedtecvi_digmoo'; // nome do banco de dados
mysql_select_db($db2,$con2) or print mysql_error(); // seleção do banco de dados
?>
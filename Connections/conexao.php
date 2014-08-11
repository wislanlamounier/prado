<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexao = "mysql1.cedtec.com.br";
$database_conexao = "cedtecvi_pincel";
$username_conexao = "cedtecvi_pincel";
$password_conexao = "BDPA2013ced";
$conexao = mysql_pconnect($hostname_conexao, $username_conexao, $password_conexao) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
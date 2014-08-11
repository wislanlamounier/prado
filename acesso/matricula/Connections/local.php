<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_PRADOSIS = "mysql1.cedtec.com.br";
$database_PRADOSIS = "cedtecvi_pincel";
$username_PRADOSIS = "cedtecvi_pincel";
$password_PRADOSIS = "BDPA2013ced";
$PRADOSIS = mysql_pconnect($hostname_PRADOSIS, $username_PRADOSIS, $password_PRADOSIS) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
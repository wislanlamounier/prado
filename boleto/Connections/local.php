<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_local = "mysql1.cedtec.com.br";
$database_local = "cedtecvi_pincel";
$username_local = "cedtecvi_pincel";
$password_local = "BDPA2013ced";
$local = mysql_pconnect($hostname_local, $username_local, $password_local) or trigger_error(mysql_error(),E_USER_ERROR); 

?>
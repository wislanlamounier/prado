<?php
/*
*Nome: Sistema de Cadastro 1.0
*Autor: Caio C�sar
*Descri��o: Verifica se e poss�vel conectar ao banco de dado
*/
//nome do servidor
$host = "mysql1.cedtec.com.br";
//nome de usu�rio
$user = "cedtecvi_pincel";
//senha de usu�rio
$senha = "BDPA2013ced";
//nome do banco de dados
$dbname = "cedtecvi_pincel";

//conectar ao banco de dados
mysql_connect($host, $user, $senha) or die("N�o foi poss�vel conectar-se com o banco de dados.");
//seleciona o banco de dados
mysql_select_db($dbname) or die("N�o foi poss�vel selecionar o banco de dados.");

?>
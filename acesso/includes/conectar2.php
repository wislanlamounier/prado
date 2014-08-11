<?php

$servidor = 'mysql1.cedtec.com.br';
$usuario = 'cedtecvi_pincel';
$senha = 'BDPA2013ced';
$banco = 'cedtecvi_pincel';

// Conecta-se ao banco de dados MySQL
$mysqli = new mysqli($servidor, $usuario, $senha, $banco);

// Caso algo tenha dado errado, exibe uma mensagem de erro
if (mysqli_connect_errno()) trigger_error(mysqli_connect_error());

?>
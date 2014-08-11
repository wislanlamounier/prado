<?php
include("menu/tabela.php");
include("includes/conectar.php");
include_once ("includes/Redimensiona.php");
$matricula = $_GET["id"];

?>
<div class="conteudo">
<a href="foto_academica2.php?id=<?php echo $matricula;?>">[Tirar Foto]</a> | <a href="foto_academica.php?id=<?php echo $matricula;?>">[Escolher Foto no Computador]</a>
<hr />
<iframe src="croflash.swf?matricula=<?php echo $matricula;?>" width="300" height="300"></iframe>
<?php

include("menu/footer.php");
?>

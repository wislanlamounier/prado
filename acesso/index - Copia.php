<?php
include ('menu/menu.php');// inclui o menu
$get_nivel = $_GET["nivel"];
$get_curso = $_GET["curso"];

?>
<div class="conteudo">
<?php echo $get_nivel." ".$get_curso;
?>
</div>
<?php
include ('menu/footer.php');?>
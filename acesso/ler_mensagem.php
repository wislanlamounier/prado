<?php
include ('menu/menu.php');// inclui o menu
if(isset($_GET["id"])){
	$get_id = $_GET["id"];
} else {
	$get_id = 0;
}
?>

<div class="conteudo">
<center><font size="+2">Central de Mensagens</font></center>
<hr />
<div style="float:left; margin-right:10px; width:30%">
<iframe name="titulos_msg" width="400px;" height="50%" src="titulos_msgs.php"></iframe>
</div>

<div style="float:left; width:62%">
<iframe src="corpo_msg.php?id=<?php echo $get_id;?>" name="corpo_msg" height="50%" width="100%"></iframe>
</div>

</div>
<?php
include ('menu/footer.php');?>
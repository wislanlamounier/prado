<div class="conteudo">
  <?php
include('includes/conectar.php');
$id_ativ = $_GET["id"];

//conecta banco de dados moodle
if($id_ativ >= 1){
	mysql_query("DELETE FROM ced_turma_ativ WHERE ref_id = $id_ativ");
	echo "<script language=\"javascript\">
	alert('ATIVIDADE EXCLUIDA COM SUCESSO');
	window.close();
	</script>";
}
?>

</div>

<?php include 'menu/footer.php' ?>

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir? '))
{
location.href="excluir.php?id="+id;
}
else
{
return false;
}
}
//-->

</script>
</div>
</body>
</html>

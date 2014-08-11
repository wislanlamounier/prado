<?php include 'menu/tabela.php';
?>
<div class="conteudo">
<?php
$id = $_GET["id"]; 
include 'includes/conectar.php';
$nova_senha = date("his");

$sql_questionario = mysql_query("select * from ea_questionario WHERE id_questionario = $id");

$count = mysql_num_rows($sql_questionario);
if($count == 1){
	$dados_questionario = mysql_fetch_array($sql_questionario);
	$questionario_turma_disc = $dados_questionario["turma_disc"];
	mysql_query("UPDATE ea_questionario SET senha = '$nova_senha' WHERE id_questionario = $id");
	echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('Senha da atividade resetada com sucesso!!');
				window.location.href='abrir_avaliacao.php?turma_disc=$questionario_turma_disc';
			</SCRIPT>");
}


?>
</div>
<?php include 'menu/footer.php' ?>

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o titulo? '))
{
location.href="apagar_receita.php?id="+id;
}
else
{
return false;
}
}

function usuario(id){
alert("o nº de usuário é: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar2.php?id="+data,'_blank');
}
else
{
return;
}

}
</SCRIPT>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 900;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
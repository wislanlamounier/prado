<?php include 'menu/tabela.php'; 
include('includes/conectar.php');



if( $_SERVER['REQUEST_METHOD'] == 'POST') {
	$post_curso = strtoupper($_POST["curso"]);
	$post_disciplina = $_POST["disciplina"];
	$post_grau = $_POST["grau"];
	mysql_query("INSERT INTO ea_banco_questao (id_bq, cursos, nome_bq, grau) VALUES (NULL, '$post_curso', '$post_disciplina', '$post_grau')");

	
		echo "
		<script language=\"javascript\">alert('Banco inserido com sucesso!');
		</script>";
		
}
?>


<div class="conteudo">
<form action="#" method="post">
<table class="full_table_list" width="100%">
<tr>
	<td><b>Curso:</b></td>
    <td><?php 
		$sql = "SELECT distinct curso FROM cursosead ORDER BY curso";
		$result = mysql_query($sql);
		echo "<select name=\"curso\" style=\"width:auto\" class=\"textBox\" id=\"curso\" onKeyPress=\"return arrumaEnter(this, event)\">";
		echo "<option value='COMUM'>COMUM</option>";
		while ($row = mysql_fetch_array($result)) {
			echo "<option value='" . $row['curso'] . "'>" . $row['curso'] ."</option>";
		}
		echo "</select>";

	
	?>
    </td>
</tr>
<tr>
	<td><b>Disciplina:</b></td>
    <td><?php 
		$sql = "SELECT distinct disciplina FROM disciplinas ORDER BY disciplina";
		$result = mysql_query($sql);
		echo "<select name=\"disciplina\" style=\"width:auto\" class=\"textBox\" id=\"disciplina\" onKeyPress=\"return arrumaEnter(this, event)\">";
		while ($row = mysql_fetch_array($result)) {
			echo "<option value='" . $row['disciplina'] . "'>" . $row['disciplina'] ."</option>";
		}
		echo "</select>";

	
	?>
    </td>
</tr>
<tr>
	<td><b>Grau:</b></td>
    <td><?php 
		$sql = "SELECT distinct grau FROM ea_banco_questao ORDER BY grau";
		$result = mysql_query($sql);
		echo "<select name=\"grau\" style=\"width:auto\" class=\"textBox\" id=\"grau\" onKeyPress=\"return arrumaEnter(this, event)\">";
		while ($row = mysql_fetch_array($result)) {
			echo "<option value='" . $row['grau'] . "'>" . $row['grau'] ."</option>";
		}
		echo "</select>";

	
	?>
    </td>
</tr>

 <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>

</table>

 </form>
</div>
  <?php include 'menu/footer.php' ?>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var $link = $('#add_opcao');
				var $model = $link.prev('.clone');
				$link.click(function(){
					var $clone = $model.clone(false);
					$(this).before($clone);
					$clone.wrap('<div class="wrapper"></div>')
							.after('<a href="javascript:void(0)" class="remove">Remover</a>')
							.addClass('added')
							.parent()
							.hide()
							.fadeIn();
				});
				
				$('a.remove').live('click', function(){
					$(this).parent().fadeOut('normal', function(){
						$(this).remove();
					});
				});
			});
		</script>


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

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
</div>
</body>
</html>

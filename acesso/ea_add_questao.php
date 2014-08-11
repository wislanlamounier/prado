<?php include 'menu/tabela.php'; 
include('includes/conectar.php');
if(isset($_GET["id_bq"])){
	$get_bq = $_GET["id_bq"];
} else {
	$get_bq = 0;
}


if( $_SERVER['REQUEST_METHOD'] == 'POST') {
	$post_banco = $_POST["banco"];
	$post_questao = $_POST["questao"];
	$sql_contador = mysql_query("select max(contador) as contador from ea_questao");
	$dados_contador = mysql_fetch_array($sql_contador);
	$contador = str_pad($dados_contador["contador"], 3,"0", STR_PAD_LEFT);
	if(trim($post_questao) != ""){
		$post_cod_questao = $post_banco."_".$contador;
		$contador_final = $dados_contador["contador"] +1;
		mysql_query("UPDATE ea_questao SET contador = $contador_final");
		//INSERE A PERGUNTA
		mysql_query("INSERT INTO ea_questao (id_questao, cod_questao, id_bq, tipo_questao, questao) VALUES (NULL,
		'$post_cod_questao', '$post_banco', '1', '$post_questao') ");
		//INSERE AS OPÇÕES
		for( $i = 0 , $x = count( $_POST[ 'valor' ] ) ; $i < $x ; ++ $i ) {
			if(trim($_POST[ 'opcao' ][$i]) != ""){
			mysql_query("INSERT INTO ea_resposta (id_resposta, cod_questao, resposta, valor) VALUES (NULL,
		'$post_cod_questao', '".$_POST[ 'opcao' ][$i]."', '".$_POST[ 'valor' ][$i]."')");
			}
		
		}
		echo "
		<script language=\"javascript\">alert('Quest&atilde;o inserida com sucesso!');
		</script>";
		
	} 
}
?>


<div class="conteudo">
<form action="#" method="post">
<table class="full_table_list" width="100%">
<tr>
	<td><b>Banco de Quest&atilde;o:</b></td>
    <td><?php 
	if($get_bq == 0){
		$sql = "SELECT * FROM ea_banco_questao ORDER BY nome_bq";
		$result = mysql_query($sql);
		echo "<select name=\"banco\" style=\"width:auto\" class=\"textBox\" id=\"banco\" onKeyPress=\"return arrumaEnter(this, event)\">";
		while ($row = mysql_fetch_array($result)) {
			echo "<option value='" . $row['id_bq'] . "'>" . $row['nome_bq'] ." | Grau: ".$row['grau'] . "</option>";
		}
		echo "</select>";
	} else {
		$sql_nome_bq = mysql_query("SELECT * FROM ea_banco_questao WHERE id_bq = $get_bq");
		$dados_bq = mysql_fetch_array($sql_nome_bq);
		$nome_bq = $dados_bq["nome_bq"];
		echo "<input name=\"banco2\" type=\"text\" readonly=\"readonly\" style=\"width:700px;\" value=\"$nome_bq\"/>
		<input name=\"banco\" type=\"hidden\" value=\"$get_bq\"/> ";	
	}
	
	?>
    </td>
</tr>
<tr>
	<td><b>Enunciado da Quest&atilde;o:</b></td>
    <td><textarea class="ckeditor" name="questao" id="questao"></textarea></td>
</tr>
<tr>
	<td  valign="top"><b>Op&ccedil;&atilde;o 1:<br />
    <select id="valor[]" name="valor[]" style="width:100px">
    <option value="100">100%</option>
 	<option value="90">90%</option>
    <option value="70">70%</option>
    <option value="50">50%</option>
    <option value="33.33">33%</option>
    <option value="25">25%</option>
    <option value="20">20%</option>
    <option value="15">15%</option>
    <option value="0" selected="selected">0%</option>
    </select></b></td>
    <td><textarea class="ckeditor" name="opcao[]" id="opcao[]"></textarea></td>
</tr>
<tr>
	<td  valign="top"><b>Op&ccedil;&atilde;o 2:<br />
    <select id="valor[]" name="valor[]" style="width:100px">
    <option value="100">100%</option>
 	<option value="90">90%</option>
    <option value="70">70%</option>
    <option value="50">50%</option>
    <option value="33.33">33%</option>
    <option value="25">25%</option>
    <option value="20">20%</option>
    <option value="15">15%</option>
    <option value="0" selected="selected">0%</option>
    </select></b></td>
    <td><textarea class="ckeditor" name="opcao[]" id="opcao[]"></textarea></td>
</tr>
<tr>
	<td  valign="top"><b>Op&ccedil;&atilde;o 3:<br />
    <select id="valor[]" name="valor[]" style="width:100px">
    <option value="100">100%</option>
 	<option value="90">90%</option>
    <option value="70">70%</option>
    <option value="50">50%</option>
    <option value="33.33">33%</option>
    <option value="25">25%</option>
    <option value="20">20%</option>
    <option value="15">15%</option>
    <option value="0" selected="selected">0%</option>
    </select></b></td>
    <td><textarea class="ckeditor" name="opcao[]" id="opcao[]"></textarea></td>
</tr>
<tr id="clonar" name="clonar">
	<td  valign="top"><b>Op&ccedil;&atilde;o 4:<br />
    <select id="valor[]" name="valor[]" style="width:100px">
    <option value="100">100%</option>
 	<option value="90">90%</option>
    <option value="70">70%</option>
    <option value="50">50%</option>
    <option value="33.33">33%</option>
    <option value="25">25%</option>
    <option value="20">20%</option>
    <option value="15">15%</option>
    <option value="0" selected="selected">0%</option>
    </select></b></td>
    <td><textarea class="ckeditor" name="opcao[]" id="opcao[]"></textarea></td>
</tr>
<tr id="clonar" name="clonar">
	<td  valign="top"><b>Op&ccedil;&atilde;o 5:<br />
    <select id="valor[]" name="valor[]" style="width:100px">
    <option value="100">100%</option>
 	<option value="90">90%</option>
    <option value="70">70%</option>
    <option value="50">50%</option>
    <option value="33.33">33%</option>
    <option value="25">25%</option>
    <option value="20">20%</option>
    <option value="15">15%</option>
    <option value="0" selected="selected">0%</option>
    </select></b></td>
    <td><textarea class="ckeditor" name="opcao[]" id="opcao[]"></textarea></td>
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


<?php

$n_aula = $_GET["n_aula"];
$data_aula = $_GET["data_aula"];
$turma_disc = $_GET["td"];
include('includes/conectar.php');
include 'menu/tabela.php';


$sql = mysql_query("
SELECT DISTINCT vad.matricula, vad.nome FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_disc 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");



//enviar post 
 if( isset ( $_POST[ 'Submit' ] ) ) {
		              for( $i = 0 , $x = count( $_POST[ 'id' ] ) ; $i < $x ; ++ $i ) {
						  $pesquisar = mysql_query("SELECT * FROM ced_falta_aluno WHERE  matricula = '".$_POST[ 'id' ][ $i ]."' AND n_aula = '$n_aula' AND turma_disc = '$turma_disc' AND data = '$data_aula' ;");
						  $total = mysql_num_rows($pesquisar);
						  $status = $_POST[ 'falta' ][ $i ];
						  if($total == 0&&$status != "P"){
							mysql_query("INSERT INTO ced_falta_aluno (matricula,turma_disc,data, n_aula,status) VALUES ('".$_POST[ 'id' ][ $i ]."','$turma_disc', '$data_aula','$n_aula','".$_POST[ 'falta' ][ $i ]."');");
						  } else {
							mysql_query("UPDATE ced_falta_aluno SET status = '".$_POST[ 'falta' ][ $i ]."' WHERE  matricula = '".$_POST[ 'id' ][ $i ]."' AND n_aula = '$n_aula' AND turma_disc = '$turma_disc' AND data = '$data_aula';");
						  }
						 
		              }
				echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Frequências registradas com sucesso!!');
						window.close();
						window.opener.location.reload();
						</SCRIPT>");	 
		       }

?>

<form id="form1" name="form1" method="post" action="#" onsubmit="return confirma(this)">

  <table width="430" border="0" align="center" class="full_table_list2">
          <td width="116" align="center"><b>NOME</b></td>
      <td width="304">&nbsp;</td>
    </tr>
    
<?php 
	while($dados = mysql_fetch_array($sql)){
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		$pesquisar = mysql_query("SELECT * FROM ced_falta_aluno WHERE  matricula = '$codigo' AND n_aula = '$n_aula' AND turma_disc = '$turma_disc' AND data = '$data_aula' ;");
		$total = mysql_num_rows($pesquisar);
		if($total == 1){
			$falta_dados = mysql_fetch_array($pesquisar);
			$exibir_falta = $falta_dados["status"];
		} else {
			$value = "P";
			$exibir_falta = "Presente";
		}
		if($exibir_falta == "F"){
			$value = "F";
			$exibir_falta = "Falta";
		}
		if($exibir_falta == "J"){
			$value = "J";
			$exibir_falta = "Justificado";
		}
		if($exibir_falta == "P"){
			$value = "P";
			$exibir_falta = "Presente";
		}
		echo "<tr><td>
			<input type=\"hidden\" name=\"id[]\" value=\"$codigo\" />$nome</td>
			<td>
			<select name=\"falta[]\">
			
  <option value=\"$value\" selected=\"selected\">$exibir_falta</option>
  <option value=\"P\">Presente</option>
  <option value=\"F\">Falta</option>
  <option value=\"J\">Justificativa</option>
</select></td></tr>";
		
	}
	



?>
  
    
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>
  </table>

</form>

  <script language="JavaScript">  
function FormataCpf(campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(campo.value);
				vr = vr.replace(".", "");
				vr = vr.replace("/", "");
				vr = vr.replace("-", "");
				tam = vr.length + 1;
				if (tecla != 14)
				{
					if (tam == 4)
						campo.value = vr.substr(0, 3) + '.';
					if (tam == 7)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 6) + '.';
					if (tam == 11)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(7, 3) + '-' + vr.substr(11, 2);
				}
			}   

function FormataData(campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(campo.value);
				vr = vr.replace(".", "");
				tam = vr.length + 1;
				if (tecla != 10)
				{
					if (tam == 3)
						campo.value = vr.substr(0, 2) + '/';
					if (tam == 6)
						campo.value = vr.substr(0, 2) + '/' + vr.substr(3, 6) + '/';
				}
			}   

  
  
function confirma()
{
var conta = form1.conta.value;
if (confirm('Deseja confirmar a baixa na conta: '+conta))
{
}
else
{
 return false;
}
}
//-->
</script>

    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
	    <script type="text/javascript">
		$(function(){
			$('#tipo').change(function(){
				if( $(this).val() ) {
					$('#curso').hide();
					$('.carregando').show();
					$.getJSON('a1.ajax.php?search=',{tipo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].curso + '">' + j[i].curso + '</option>';
						}	
						$('#curso').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso').html('<option value="selecione">– Selecione o Curso –</option>');
				}
			});
		});
		</script>
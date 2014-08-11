<script language="javascript">
function SomenteNumero()  
{  
 if (event.keyCode<48 || event.keyCode>57)  
 {  
  return false;  
 }  
}  
</script>


<?php

$turma_disc = $_GET["td"];
include('includes/conectar.php');
include 'menu/tabela.php';


$sql_td = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = $turma_disc");
$dados_td = mysql_fetch_array($sql_td);
$id_turma = $dados_td["id_turma"];

$sql = mysql_query("SELECT DISTINCT vad.matricula, vad.nome FROM v_aluno_disc vad
INNER JOIN ced_turma_aluno cta
ON vad.id_turma = cta.id_turma WHERE vad.turma_disc = $turma_disc 
AND vad.matricula
IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma = cta.id_turma)
ORDER BY vad.nome");
 
 
 //enviar post 
 if( isset ( $_POST[ 'Salvar' ] ) ) {
		              for( $i = 0 , $x = count( $_POST[ 'mat_aluno' ] ) ; $i < $x ; ++ $i ) {
						  $pesquisar = mysql_query("SELECT * FROM ced_notas WHERE  matricula = '".$_POST[ 'mat_aluno' ][ $i ]."' AND ref_ativ = '".$_POST[ 'ref_ativ' ][ $i ]."' AND turma_disc = '".$_POST[ 'cod_t_d' ][ $i ]."'");
						  $total = mysql_num_rows($pesquisar);
						  $status = str_replace(",",".",$_POST[ 'nota' ][ $i ]);
						  if(empty($status)){
							  $status = 0;
						  }
						  $maxnota = $_POST[ 'maxnota' ][ $i ];
						 
						  if($total == 0&&$status >0){
							mysql_query("INSERT INTO ced_notas (codnota, matricula, ref_ativ, turma_disc, grupo, nota) VALUES (NULL, '".$_POST[ 'mat_aluno' ][ $i ]."','".$_POST[ 'ref_ativ' ][ $i ]."', '$turma_disc','".$_POST[ 'grupoativ' ][ $i ]."','$status');");
						  } else {
							mysql_query("UPDATE ced_notas SET nota = '$status' WHERE  matricula = '".$_POST[ 'mat_aluno' ][ $i ]."' AND ref_ativ = '".$_POST[ 'ref_ativ' ][ $i ]."' AND turma_disc = '".$_POST[ 'cod_t_d' ][ $i ]."';");
						  }
							  
						 
		              }
				echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Notas atualizadas com sucesso');
						window.close();
						window.opener.location.reload();
						</SCRIPT>");	 
		       }
			   
			
				   

?>
<form id="form1" name="form1" method="post" >

  <table width="430" border="1" align="center" class="full_table_list2">
        
    <tr>
    <td><b>NOME</b></td>
   
    <?php
	//PEGA ATIVIDADES LANÇADAS PARA A TURMA DISCIPLINA
	$pesquisar = mysql_query("SELECT * FROM ced_turma_ativ WHERE  cod_turma_d = $turma_disc;");
	$total = mysql_num_rows($pesquisar);
		while($dados_ativ = mysql_fetch_array($pesquisar)){
			$ref_id = $dados_ativ["ref_id"];
			$cod_ativ = $dados_ativ["cod_ativ"];
			$desc_ativ = $dados_ativ["descricao"];
			$data_ativ = substr($dados_ativ["data"],8,2)."/".substr($dados_ativ["data"],5,2)."/".substr($dados_ativ["data"],0,4);
			$nome_ativ = mysql_query("SELECT * FROM ced_desc_nota WHERE  codigo = $cod_ativ;");
			$dados_atividade = mysql_fetch_array($nome_ativ);
			$nome_atividade = $dados_atividade["atividade"];
			echo "<td><a href=\"#\" title=\"$desc_ativ\"><center><b>$nome_atividade<br><font size='-1'>($data_ativ)</font></b></a><br><font-size='-2'><a href=\"excluir_atividade.php?id=$ref_id\">[EXCLUIR]</font></a></center></td>";
			}
	
	?>
    </tr>
<?php 
//PEGA MATRÍCULA E NOME DO ALUNO
	while($dados = mysql_fetch_array($sql)){
		$codigo = $dados["matricula"];
		$nome = $dados["nome"];
		
			
		
?>


<?php
			
		echo "<tr><td>$nome</td>";
		//PEGA CODIGO DE ATIVIDADES
		$pesquisar = mysql_query("SELECT * FROM ced_turma_ativ WHERE  cod_turma_d = $turma_disc;");
		$total = mysql_num_rows($pesquisar);
		while($dados_ativ = mysql_fetch_array($pesquisar)){
			$ref_id = $dados_ativ["ref_id"];
			$cod_ativ = $dados_ativ["cod_ativ"];
			$valor_ativ = $dados_ativ["valor"];
			$grupo_ativ = $dados_ativ["grupo_ativ"];
			$data_ativ = substr($dados_ativ["data"],8,2)."/".substr($dados_ativ["data"],5,2)."/".substr($dados_ativ["data"],0,4);
			$nome_ativ = mysql_query("SELECT * FROM ced_desc_nota WHERE  codigo = $cod_ativ;");
			$dados_atividade = mysql_fetch_array($nome_ativ);
			$nome_atividade = $dados_atividade["atividade"];
			//pesquisa notas anteriores
			$pesq_nota = mysql_query("SELECT * FROM ced_notas WHERE matricula = $codigo AND ref_ativ = $ref_id AND turma_disc = $turma_disc");
			$contar_nota = mysql_num_rows($pesq_nota);
			if($contar_nota == 0){
				$nota_aluno = 0;
			} else {
				$dados_nota = mysql_fetch_array($pesq_nota);
				$nota_aluno = $dados_nota["nota"];
			}
			
			
		echo "<td align=\"center\"><input type=\"text\" name=\"nota[]\" id=\"nota[]\" value=\"$nota_aluno\" style=\"width:50px\" /> <b> | <font color=\"red\">$valor_ativ</font></b>
			<input type=\"hidden\" name=\"mat_aluno[]\" id=\"mat_aluno[]\" value=\"$codigo\" />
			<input type=\"hidden\" name=\"ref_ativ[]\" id=\"ref_ativ[]\" value=\"$ref_id\" />
			<input type=\"hidden\" name=\"cod_t_d[]\" id=\"cod_t_d[]\" value=\"$turma_disc\" />
			<input type=\"hidden\" name=\"grupoativ[]\" id=\"grupoativ[]\" value=\"$grupo_ativ\" />
			<input type=\"hidden\" name=\"maxnota[]\" id=\"maxnota[]\" value=\"$valor_ativ\" />
			</td>";
		}
		
		
		
		"</tr>";
		
		
		
	}
	



?>
  
    
    <tr>
      <td colspan="<?php echo $total+1;?>" align="center"><input type="submit" name="Salvar" id="Salvar"  class="botao" value="Salvar"/></td>
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
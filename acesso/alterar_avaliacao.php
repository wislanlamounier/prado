
<?php

$id = $_GET["codigo"];

include 'menu/tabela.php';
include 'includes/conectar.php';

$sql_questionario = mysql_query("SELECT * FROM ea_questionario WHERE id_questionario = '$id'");
$dados_questionario = mysql_fetch_array($sql_questionario);
$turma_disc = $dados_questionario["turma_disc"];
$d_ini = substr($dados_questionario["data_inicio"],8,2);
$m_ini = substr($dados_questionario["data_inicio"],5,2);
$a_ini = substr($dados_questionario["data_inicio"],0,4);
$h_ini = substr($dados_questionario["data_inicio"],11,2);
$i_ini = substr($dados_questionario["data_inicio"],14,2);
$s_ini = substr($dados_questionario["data_inicio"],17,2);

$d_fin = substr($dados_questionario["data_fim"],8,2);
$m_fin = substr($dados_questionario["data_fim"],5,2);
$a_fin = substr($dados_questionario["data_fim"],0,4);
$h_fin = substr($dados_questionario["data_fim"],11,2);
$i_fin = substr($dados_questionario["data_fim"],14,2);
$s_fin = substr($dados_questionario["data_fim"],17,2);

//POST DE ATIVIDADE E QUESTION�RIO
 if( $_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$valor = $_POST["valor"];
	$valor_anterior = $_POST["valor_anterior"];
	$id_questionario = $_POST["id"];
	$turma_disc = $_POST["turma_disc"];
	$data_hora_inicio = $_POST["a_ini"]."-".$_POST["m_ini"]."-".$_POST["d_ini"]." ".$_POST["hh_ini"].":".$_POST["mm_ini"].":".$_POST["ss_ini"];
	$data_hora_fin = $_POST["a_fin"]."-".$_POST["m_fin"]."-".$_POST["d_fin"]." ".$_POST["hh_fin"].":".$_POST["mm_fin"].":".$_POST["ss_fin"];
	if(trim($id_questionario) != ""){
		mysql_query("UPDATE ea_questionario SET valor = '$valor', data_inicio = '$data_hora_inicio', data_fim = '$data_hora_fin' WHERE id_questionario = $id_questionario");
		
		//recalcula a nota dos alunos que ja fizeram
		if($valor_anterior <> $valor){
			//PEGA DADOS DA ATIVIDADE AVALIA��O ONLINE
			$sql_turma_atividade = mysql_query("SELECT * FROM ced_turma_ativ WHERE cod_turma_d = '$turma_disc' AND cod_ativ = 1000 LIMIT 1");
			$dados_turma_ativ = mysql_fetch_array($sql_turma_atividade);
			$cod_turma_ativ = $dados_turma_ativ["ref_id"];
			mysql_query("UPDATE ced_turma_ativ SET valor= '$valor' WHERE ref_id = '$cod_turma_ativ'");
		
			$sql_alunos_turma = mysql_query("SELECT DISTINCT matricula FROM ced_aluno_disc WHERE turma_disc = $turma_disc");
			while($dados_alunos_turma = mysql_fetch_array($sql_alunos_turma)){
				$matricula_aluno = $dados_alunos_turma["matricula"];
				$sql_notas_alunos = mysql_query("SELECT * FROM ced_notas WHERE matricula = $matricula_aluno AND ref_ativ = '$cod_turma_ativ'");
				$dados_notas_alunos = mysql_fetch_array($sql_notas_alunos);
				//calculo de porcentagem da nota anterior
				$nota_anterior = $dados_notas_alunos["nota"];
				$percent_nota = ($nota_anterior * 100)/$valor_anterior;
				//calculo de nota nova
				$nova_nota = ($valor * $percent_nota)/100;
				mysql_query("UPDATE ced_notas SET nota = '$nova_nota' WHERE matricula = '$matricula_aluno' AND ref_ativ = '$cod_turma_ativ'");
				
			}
			
		}

		echo ("<SCRIPT LANGUAGE='JavaScript'>
				window.alert('Atividade atualizada com sucesso!!');
				window.location.href='abrir_avaliacao.php?turma_disc=$turma_disc';
			</SCRIPT>");	
	} 
}



?>

<form id="form1" name="form1" method="POST" action="alterar_avaliacao.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<input type="hidden" name="turma_disc" value="<?php echo $turma_disc; ?>" />
<input type="hidden" name="valor_anterior" value="<?php echo $dados_questionario["valor"]; ?>" />
  <table width="430" border="0" align="center" class="full_table_cad">
   <tr>
      <td>N&ordm; Quest&otilde;es (Grau: Baixo)</td>
      <td><input name="n_questoes1_exib" type="number" readonly id="n_questoes1_exib" value="5" maxlength="3"/>
      <input name="n_questoes1" type="hidden" id="n_questoes1" value="5" maxlength="5"/></td>
    </tr>
      <tr>
      <td>N&ordm; Quest&otilde;es (Grau: M&eacute;dio)</td>
      <td><input name="n_questoes2_exib" type="number" readonly id="n_questoes2_exib" value="3" maxlength="3"/>
      <input name="n_questoes2" type="hidden" id="n_questoes2" value="3" maxlength="5"/></td>
    </tr>
    </tr>
    <tr>
      <td>N&ordm; Quest&otilde;es (Grau: Alto)</td>
      <td><input name="n_questoes3_exib" type="number" readonly id="n_questoes3_exib" value="2" maxlength="3"/>
      <input name="n_questoes3" type="hidden" id="n_questoes3" value="2" maxlength="5"/></td>
    </tr>
    <tr>
      <td>N&ordm; de Tentativas</td>
      <td><input name="tentativas_exib" type="number" readonly id="tentativas_exib" value="1" maxlength="3"/>
      <input name="tentativas" type="hidden" id="tentativas" value="1" maxlength="5"/></td>
    </tr>
    <tr>
      <td>Valor</td>
      <td><input name="valor" type="number" id="valor" required value="<?php echo $dados_questionario["valor"];?>" maxlength="10"/></td>
    </tr>
<tr>
    <td align="right">                   
     <b>Data de In&iacute;cio: </b>
     </td>
     <td> 
     <select name="d_ini" style="width:auto;" id="d_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $d_ini;?>"><?php echo $d_ini;?></option>
     <?php $dia = 1;
while($dia<=31){
	$dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
   echo "<option value='$dia'>$dia</option>";
   $dia++;
}?>
	</select>    
    
    
    <select  name="m_ini" style="width:auto;" id="m_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $m_ini;?>"><?php echo $m_ini;?></option>
     <?php $mes = 1;
while($mes<=12){
	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mes'>$mes</option>";
   $mes++;
}?>
	</select>
    
    <select  name="a_ini" style="width:auto;" id="a_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $a_ini;?>"><?php echo $a_ini;?></option>
     <?php $ano = date('Y');
  $anoatual = date('Y');
while($ano<($anoatual+10)){
   echo "<option value='$ano'>$ano</option>";
   $ano++;
}?>
	</select></td>
    </tr>
    <tr>
    <td align="right"> 
	<b>Hor&aacute;rio de In&iacute;cio: </b>
    </td>
    <td>
     <select name="hh_ini" style="width:auto;" id="hh_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $h_ini;?>"><?php echo $h_ini;?></option>
     <?php $hh = 0;
while($hh<=23){
	$hh = str_pad($hh, 2, "0", STR_PAD_LEFT);
   echo "<option value='$hh'>$hh</option>";
   $hh++;
}?>
	</select>    
    
    
    <select  name="mm_ini" style="width:auto;" id="mm_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $i_ini;?>"><?php echo $i_ini;?></option>
     <?php $mm = 0;
while($mm<=59){
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mm'>$mm</option>";
   $mm++;
}?>
	</select>
    
    <select name="ss_ini" style="width:auto;" id="ss_ini" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $s_ini;?>"><?php echo $s_ini;?></option>
     <?php $ss = 0;
while($ss<=59){
	$ss = str_pad($ss, 2, "0", STR_PAD_LEFT);
   echo "<option value='$ss'>$ss</option>";
   $ss++;
}?>
	</select>
    </td>
    
</tr>

<tr>
    <td align="right">                   
     <b>Data Final: </b>
     </td>
     <td> 
     <select name="d_fin" style="width:auto;" id="d_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $d_fin;?>"><?php echo $d_fin;?></option>
     <?php $dia = 1;
while($dia<=31){
	$dia = str_pad($dia, 2, "0", STR_PAD_LEFT);
   echo "<option value='$dia'>$dia</option>";
   $dia++;
}?>
	</select>    
    
    
    <select name="m_fin" style="width:auto;" id="m_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $m_fin;?>"><?php echo $m_fin;?></option>
     <?php $mes = 1;
while($mes<=12){
	$mes = str_pad($mes, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mes'>$mes</option>";
   $mes++;
}?>
	</select>
    
    <select name="a_fin" style="width:auto;" id="a_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $a_fin;?>"><?php echo $a_fin;?></option>
     <?php $ano = date('Y');
  $anoatual = date('Y');
while($ano<($anoatual+10)){
   echo "<option value='$ano'>$ano</option>";
   $ano++;
}?>
	</select></td>
    </tr>
    <tr>
    <td align="right"> 
	<b>Hor&aacute;rio de T&eacute;rmino: </b>
    </td>
    <td>
     <select name="hh_fin" style="width:auto;" id="hh_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $h_fin;?>"><?php echo $h_fin;?></option>
     <?php $hh = 0;
while($hh<=23){
	$hh = str_pad($hh, 2, "0", STR_PAD_LEFT);
   echo "<option value='$hh'>$hh</option>";
   $hh++;
}?>
	</select>    
    
    
    <select name="mm_fin" style="width:auto;" id="mm_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $i_fin;?>"><?php echo $i_fin;?></option>
     <?php $mm = 0;
while($mm<=59){
	$mm = str_pad($mm, 2, "0", STR_PAD_LEFT);
   echo "<option value='$mm'>$mm</option>";
   $mm++;
}?>
	</select>
    
    <select name="ss_fin" style="width:auto;" id="ss_fin" onkeypress="return arrumaEnter(this, event)">
     <option value="<?php echo $s_fin;?>"><?php echo $s_fin;?></option>
     <?php $ss = 0;
while($ss<=59){
	$ss = str_pad($ss, 2, "0", STR_PAD_LEFT);
   echo "<option value='$ss'>$ss</option>";
   $ss++;
}?>
	</select>
    </td>
    
</tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>
  </table>

</form>

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
					$('#curso').html('<option value="selecione">� Selecione o Curso �</option>');
				}
			});
		});
		</script>

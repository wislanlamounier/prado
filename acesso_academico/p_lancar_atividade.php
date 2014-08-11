
<?php

$grupo_ativ = $_GET["ativ"];
$turma_disc = $_GET["turma"];
$grupo = $_GET["grupo"];

include('includes/conectar.php');
include 'menu/tabela.php';

//enviar post 
 if( $_SERVER['REQUEST_METHOD'] == 'POST') {
	$data = $_POST["data"];
	$atividade = $_POST["atividade"];
	$valor = str_replace(",",".",$_POST["valor"]);
	$descricao = $_POST["descricao"];
	
	
	if($data == ""){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
	window.alert('Você deve lançar a data para salvar a atividade');
	history.back();
	</SCRIPT>");
	return;
	} else {
		
		
	
	mysql_query("INSERT INTO ced_turma_ativ (ref_id,cod_turma_d,grupo_ativ, cod_ativ,data, descricao,valor) VALUES (NULL, '$turma_disc','$grupo_ativ','$atividade','$data','$descricao','$valor');");
				
	echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Atividade registrada com sucesso!!');
						window.close();
						</SCRIPT>");	 
		       }
 }

?>

<form id="form1" name="form1" method="post" action="#" onsubmit="return confirma(this)">

  <table width="430" border="0" align="center" class="full_table_list2">
  <tr>
    <td align="center" valign="top"><b>Data</b></td>
    <td><input name="data" type="date" class="textBox" id="" value="" /></td>
    </tr>
  <tr>
          <td width="116" align="center"><b>Atividade</b></td>
      <td><select name="atividade" style="width:auto" class="textBox" id="atividade" onKeyPress="return arrumaEnter(this, event)">
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT * FROM ced_desc_nota WHERE subgrupo like '%$grupo_ativ%' AND codigo != '1000' ORDER BY atividade ";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['codigo'] . "'>" . $row['atividade'] . "</option>";
}
?>
      </select></td>
    </tr>
    <tr>
    <td width="116" align="center"><b>Valor</b></td>
  <td>
    <input type="text" class="textBox"  name="valor" id="valor" value="0" onKeyPress="return arrumaEnter(this, event)"/>
    
    <input type="hidden" class="textBox"  name="turma" id="turma" value="<?php echo $turma_disc;?>" onKeyPress="return arrumaEnter(this, event)"/>
    
    <input type="hidden" class="textBox"  name="grupoativ" id="grupoativ" value="<?php echo $grupo_ativ;?>" onKeyPress="return arrumaEnter(this, event)"/>
    
    <input type="hidden" class="textBox"  name="grupo" id="grupo" value="<?php echo $grupo;?>" onKeyPress="return arrumaEnter(this, event)"/></td>
    </tr>
    <tr>
    <td align="center" valign="top"><b>Descri&ccedil;&atilde;o</b></td>
    <td><textarea name="descricao" style="width:350px; height:200px;" class="textBox" id="descricao" onkeypress="return arrumaEnter(this, event)"></textarea></td>
    </tr>
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
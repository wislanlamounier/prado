<?php include 'menu/menu.php' ;?>


<div class="conteudo">
<?php
include('includes/conectar.php');
$id = $user_usuario;

$re    = mysql_query("select count(*) as total from curso_aluno WHERE matricula = $id" );	
$total = 1;

if($total == 1) {
	$re2    = mysql_query("select * from curso_aluno WHERE matricula = $id ORDER BY modulo DESC LIMIT 1");
	$dados = mysql_fetch_array($re);	
	$pesq = mysql_query("select * from curso_aluno WHERE matricula = $id  ORDER BY modulo DESC LIMIT 1" );
}
?>

  
    
	    <script type="text/javascript">
		$(function(){
			$('#modal').change(function(){
				if( $(this).val() ) {
					$('#unidade').hide();
					$('#curso2').html('');
					$('.carregando').show();
					$.getJSON('unidade.ajax.php?search=',{modal: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="selecione">– Escolha o Polo –</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].sigla + '">' + j[i].unidade + '</option>';
						}	
						$('#unidade').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#unidade').html('<option value="selecione">– Escolha o Polo –</option>');
				}
			});
		});
		</script>
       
        <script type="text/javascript">
		$(function(){
			$('#unidade').change(function(){
				if( $(this).val() ) {
					$('#curso2').hide();
					$('.carregando').show();
					$.getJSON('curso.ajax.php?search=',{unidade: $(this).val(), ajax: 'true'}, function(j){
						var options = '';
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].curso + '">'+ j[i].tipo + ': ' + j[i].curso + '</option>';
						}	
						$('#curso2').html(options).show();
						$('.carregando').hide();

					});
				} else {
					$('#curso2').html('<option value="selecione">– Escolha o Curso –</option>');
				}
			});
		});
		</script>
        





<div class="container_12">

  	
         <br>                   
<table width="100%" border="0" class="full_table_list2" align="center">
  <tr> 
  <td colspan="4" bgcolor="#CCCCCC"><center>
    <strong>Cursos Contratados</strong>
  </center></td>
  </tr>
  <tr>
    <td align="center"><b>ANO / GRUPO</b></td>
    <td align="center"><b>CURSO</b></td>
    <td align="center"><b>A&Ccedil;&Atilde;O</b></td>
  </tr>
<tr>
<?php 
while($l = mysql_fetch_array($re2)){
	$codigo = $l["matricula"];
	$grupo =  ($l["grupo"]);
	$curso =  strtoupper(($l["nivel"].": ".$l["curso"]));	
	$modulo =  $l["modulo"];	
	$ref_curso =  $l["ref_id"];	
	$unidade = trim($l["unidade"]);
	if($unidade == "EAD"){
		$link = "a_aditivo.php?id=$codigo&ref=$ref_curso";	
	} else {
		$link = "a_rematricular2.php?id=$codigo&ref=$ref_curso";}
	echo "
	<td align=\"center\">$grupo</td>
	<td align=\"center\">$curso</td>
	<td align=\"center\"><a href=\"$link\" target=\"_blank\">[REMATRICULAR]</a></td><tr>";
}
?>

</table>
                        </div>

                        <div class="grid_7 map" id="map1"></div>
                    </div>

                </form>      
		</div>
           
           </div>
           
<?php include 'menu/footer.php' ;?>
<script language="javascript">
function arrumaEnter (field, event) {
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode == 13) {
var i;
for (i = 0; i < field.form.elements.length; i++)
if (field == field.form.elements[i])
break;
i = (i + 1) % field.form.elements.length;
field.form.elements[i].focus();
return false;
}
else
return true;
}
</script>



<?php
include('menu/tabela.php');
include('includes/conectar.php');
if( isset ( $_POST[ 'Enviar' ] )){
	$post_empresa = $_POST["empresa"];
	$post_unidade = $_POST["unidade"];
	$post_setor = $_POST["setor"];
	$post_usuario = $_POST["usuario"];
	$post_mensagem = $_POST["mensagem"];
	$post_dataenvio = date("Y-m-d h:i:s");
	$post_datahora = date("Y-m-d");
if($post_usuario != "0"){
	$post_unidade = "0";
	$post_empresa = "0";
	$post_setor = "0";
}

	
if(mysql_query("INSERT INTO msgs (id_msg, nivel,empresa,unidade, id_pessoa, enviado, data_envio, datahora, texto,visto) VALUES (NULL,'$post_setor','$post_empresa','$post_unidade','$post_usuario','$user_usuario','$post_dataenvio','$post_datahora','$post_mensagem','1')")){
	if(mysql_affected_rows()==1){
		echo "<script language=\"javascript\">
		alert('Mensagem enviada com sucesso!');
		window.close();
		</script>";
	} else {
		echo "<script language=\"javascript\">
		alert('Mensagem n&atilde;o enviada!');
		window.close();
		</script>";
	}
}
	
}


?>

<form id="form1" name="form1" method="post" >
<table class="full_table_list">
<tr>
    <td>Empresa:</td>
    <td><select name="empresa" width="auto" id="empresa">
    <option value="0">- Selecione a Empresa</option>
<?php
include("menu/config_drop.php");?>
      <?php
	  if($user_unidade == ""){
		$sql = "SELECT * FROM cc1 ORDER BY nome_cc1";
	  } else {
		$sql = "SELECT * FROM cc1 WHERE id_empresa LIKE '%$user_empresa%' ORDER BY nome_cc1";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_empresa'] . "'>" . $row['nome_cc1'] . "</option>";
}
?>
      </select></td>
  </tr>
    <tr>
      <td>Unidade:</td>
      <td><select name="unidade" class="textBox" id="unidade">
      <option value="0">- Selecione a Unidade - </option>
      </select></td>
    </tr>
<tr>
    <td>Setores:</td>
    <td><select name="setor" width="auto" id="setor">
    <option value="0">- Selecione o Setor - </option>
<?php
include("menu/config_drop.php");?>
      <?php

		$sql = "SELECT * FROM nivel_user ORDER BY funcao";

$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['acessos'] . "'>" . $row['funcao'] . "</option>";
}
?>
      </select></td>
  </tr>
  <tr>
    <td>Usu&aacute;rio:</td>
    <td><select name="usuario" width="auto" id="usuario">
    <option value="0">- Selecione o Usu&aacute;rio - </option>
<?php
include("menu/config_drop.php");?>
      <?php
	if($user_unidade == ""){
		$sql = "SELECT * FROM users ORDER BY usuario";
	  } else {
		$sql = "SELECT * FROM users WHERE unidade LIKE '%$user_unidade%' ORDER BY usuario";;
	  }
		

$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_user'] . "'>" . $row['usuario'] . "</option>";
}
?>
      </select></td>
  </tr>

      <td valign="top">Mensagem:</td>
      <td><textarea name="mensagem" rows="5" class="ckeditor" id="mensagem"></textarea></td>
    </tr>
<tr>
	<td colspan="2" align="center"><input name="Enviar" type="submit" value="Enviar" /></td>
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
			$('#empresa').change(function(){
				if( $(this).val() ) {
					$('#unidade').hide();
					$('.carregando').show();
					$.getJSON('unidade.ajax.php?search=',{empresa: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="">- Selecione a Unidade -</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].unidade + '">' + j[i].unidade + '</option>';
						}	
						$('#unidade').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#unidade').html('<option value="">– Selecione a Unidade –</option>');
				}
			});
		});
		</script>
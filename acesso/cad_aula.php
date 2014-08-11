<?php
include 'menu/tabela.php';
include 'includes/conectar.php';
$td = $_GET["td"];
$n_aula = $_GET["aula"];
$get_anograde = $_GET["anograde"];
$get_cod_disc = $_GET["cod_disc"];
$get_aula = $_GET["aula"];
$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc LIKE '%$get_cod_disc%' AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'");
if(mysql_num_rows($sql_verificar_previsto)==1){
	$dados_previsto=mysql_fetch_array($sql_verificar_previsto);
} else {
	$sql_nome_disciplina = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '%$get_cod_disc%' AND anograde LIKE '%$get_anograde%' LIMIT 1");
	$dados_disciplina = mysql_fetch_array($sql_nome_disciplina);
	$nome_disciplina = $dados_disciplina["disciplina"];
	
	$sql_cod_disc = mysql_query("SELECT * FROM disciplinas WHERE disciplina LIKE '%$nome_disciplina%' AND anograde LIKE '%$get_anograde%'");
	$codigos_disciplinas = "";
	$contar_codigos = mysql_num_rows($sql_cod_disc);
while($dados_disc = mysql_fetch_array($sql_cod_disc)){
		if($contar_codigos >=2){
			$codigos_disciplinas.="'".$dados_disc["cod_disciplina"]."',";
		} else {
			$codigos_disciplinas.="'".$dados_disc["cod_disciplina"]."'";
		}
		$contar_codigos -=1;
}
$sql_verificar_previsto = mysql_query("SELECT * FROM conteudo_previsto WHERE cod_disc IN ($codigos_disciplinas) AND ano_grade LIKE '%$get_anograde%' AND n_aula LIKE '$get_aula'");
$dados_previsto=mysql_fetch_array($sql_verificar_previsto);
}
?>
<?php

$aula = $_GET["aula"];
$turma_disc = $_GET["td"];
$prof = $_GET["prof"];
$disciplina1=$_GET["disciplina"];
$curso=$_GET["curso"];


//PEGA A UNIDADE/NIVEL DA TURMA.
$sql_turma = mysql_query("SELECT DISTINCT ct.unidade,ct.nivel FROM ced_turma_disc ctd INNER JOIN ced_turma ct 
ON ctd.id_turma = ct.id_turma WHERE ctd.codigo = $turma_disc");
$dados_turma = mysql_fetch_array($sql_turma);
$unidade_disc = $dados_turma["unidade"];
$nivel_disc = $dados_turma["nivel"];

//PEGA OS DIRETORES PEDAGÓGICOS DAS UNIDADES.
$sql_diretor = mysql_query("SELECT * FROM users WHERE dir_unidade LIKE '%$unidade_disc%' AND dir_nivel LIKE '%$nivel_disc%' LIMIT 1");
$dados_diretor = mysql_fetch_array($sql_diretor);
$email_dir = $dados_diretor["email"];

 if( isset ( $_POST[ 'Salvar' ] ) ) {
//PEGA AULA SE EXISTIR
$sql = mysql_query("SELECT * FROM ced_data_aula WHERE n_aula = $aula AND turma_disc = $turma_disc");
$verificar = mysql_num_rows($sql);

$n_aula = $_POST["aula"];
$turma_disciplina = $_POST["td"];
$realizado = $_POST["realizado"];
$data_aula2 = $_POST["data"];
if(strstr($data_aula2, '/')==TRUE){
	$data_aula = substr($data_aula2,6,4)."-".substr($data_aula2,3,2)."-".substr($data_aula2,0,2);
} else {
	$data_aula = $data_aula2;
}




$atev_extra = $_POST['atividade'];
$material= $_POST['material'];
$equipamento= $_POST['equipamento'];


if($verificar >= 1){
// inicio de envio de mensagem
// Diretoria Pedagógica



	
//ATUALIZA AULA
mysql_query("UPDATE ced_data_aula SET n_aula = '$n_aula', turma_disc = '$turma_disciplina', realizado = '$realizado', data_aula = '$data_aula', status1 = '$status1', status2 = '$status2', status3 = '$status3', status4 = '$status4', status5 = '$status5', status6 = '$status6', status7 = '$status7', status8 = '$status8', status9 = '$status9', status10 = '$status10',  ativ_extra = '$atev_extra',  material = '$material', equipamento = '$equipamento'   WHERE n_aula = $aula AND turma_disc = $turma_disc");


 echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('AULA ATUALIZADA COM SUCESSOS')
	window.close();
	window.opener.location.reload();    
	</SCRIPT>");
} else {

//fim de envio de mensagem	
//INSERE AULA   n_aula, turma_disc,realizado,data_aula, status1,status2,status3,status4,status5,status6,status7,status8,	status9,status10, status12, status13, ativ_extra, tempo_extra
// inicio de envio de mensagem

mysql_query("INSERT INTO ced_data_aula (n_aula, turma_disc, realizado,	data_aula,	status1,status2,status3,status4,status5,status6,status7,status8,status9,status10,  ativ_extra,	 material, equipamento )                                      
VALUES ('$n_aula', '$turma_disciplina', '$realizado', '$data_aula', '$status1', '$status2', '$status3', '$status4', '$status5', '$status6', '$status7', '$status8', '$status9', '$status10',  '$atev_extra' ,  '$material', '$equipamento' )");
//***********************************************************************************************************

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		 
//endereço do remitente
$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";		 
//endereço de resposta, se queremos que seja diferente a do remitente
$headers .= "Reply-To: patryky@cedtec.com.br". "\r\n";			 
//endereços que receberão uma copia oculta
$headers .= "Bcc: cob.cedtec@gmail.com". "\r\n";

if (trim($atev_extra) <> "" ) {	
$mesagem1 = "<table width=\"100%\" border=\"1\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#424242\" style=\"color:#FFF\"><b>Registro de Aula</b></td>
  </tr>
  <tr>
    <td width=\"27%\"><b>Curso / Disciplina:</b></td>
    <td width=\"73%\">$curso / $disciplina1 - <b>Nº aula:</b> $aula</td>
  </tr>
  <tr>
    <td><b>Professor:</b></td>
    <td>$prof</td>
  </tr>
  <tr>
    <td valign=\"top\"><b>Conteúdo:</b></td>
    <td valign=\"top\">$atev_extra</td>
  </tr>
</table>";

$assunto = "Atividades Relacionadas à Atividade Extra - Pincel Atômico";
$destinatario ="marcos@cedtec.com.br, erivelton@cedtec.com.br,".$email_dir;
mail($destinatario,$assunto,$mesagem1,$headers);


}

if (trim($material) <> "" ) {	
$mesagem2 = "<table width=\"100%\" border=\"1\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#424242\" style=\"color:#FFF\"><b>Registro de Aula - Material Didático</b></td>
  </tr>
  <tr>
    <td width=\"27%\"><b>Curso / Disciplina:</b></td>
    <td width=\"73%\">$curso / $disciplina1 - <b>Nº aula:</b> $aula</td>
  </tr>
  <tr>
    <td><b>Professor:</b></td>
    <td>$prof</td>
  </tr>
  <tr>
    <td valign=\"top\"><b>Conteúdo:</b></td>
    <td valign=\"top\">$material</td>
  </tr>
</table>";

$assunto2 = "Atividades Relacionadas à Atividade Material Didático - Pincel Atômico";
$destinatario2 ="marcos@cedtec.com.br, erivelton@cedtec.com.br, livraria.tecnica@cedtec.com.br,wemerson.prof@gmail.com";
mail($destinatario2,$assunto2,$mesagem2,$headers);


}

if (trim($equipamento) <> "" ) {
$mesagem3 = "<table width=\"100%\" border=\"1\">
  <tr>
    <td colspan=\"2\" align=\"center\" bgcolor=\"#424242\" style=\"color:#FFF\"><b>Registro de Aula - Estrutura Física</b></td>
  </tr>
  <tr>
    <td width=\"27%\"><b>Curso / Disciplina:</b></td>
    <td width=\"73%\">$curso / $disciplina1 - <b>Nº aula:</b> $aula</td>
  </tr>
  <tr>
    <td><b>Professor:</b></td>
    <td>$prof</td>
  </tr>
  <tr>
    <td valign=\"top\"><b>Comentários:</b></td>
    <td valign=\"top\">$equipamento</td>
  </tr>
</table>";

$assunto3 = "Atividades Relacionadas à Estrutura Física - Pincel Atômico";
$destinatario3 ="marcos@cedtec.com.br, erivelton@cedtec.com.br,".$email_dir;
mail($destinatario3,$assunto3,$mesagem3,$headers);


}


 echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('AULA CADASTRADA COM SUCESSO!')
	window.opener.location.reload();
	window.close();
	
    </SCRIPT>");

}	        
}


?>
<?php



//PEGA AULA SE EXISTIR
$sql = mysql_query("SELECT * FROM ced_data_aula WHERE n_aula = $aula AND turma_disc = $turma_disc");
$verificar = mysql_num_rows($sql);
if($verificar >= 1){
$dados = mysql_fetch_array($sql);
$data = $dados["data_aula"];
$realizado = $dados["realizado"];
$atev_extra = $dados["ativ_extra"];
$material = $dados["material"];
$equipamento  = $dados["equipamento"];

}

?>

<form id="form1" name="form1" method="post" action="#" onsubmit="return confirma(this)">
<input type="hidden" name="aula" value="<?php echo $aula; ?>" />
<input type="hidden" name="td" value="<?php echo $turma_disc; ?>" />
  <table width="100%" border="1" align="center" class="full_table_list">
          <tr>
            <td colspan="2"><strong>Aula N&uacute;mero:</strong><?php echo $aula; ?></td>
            <td align="center" colspan="2"><strong>Data da Aula </strong>
              <input onKeyPress="return arrumaEnter(this, event)" name="data" type="text" id="data" onKeyUp="Mascara('DATA',this,event)" value="<?php 
			  if($data == "//"){
			  	echo "";  
			  } else {
				echo substr($data,8,2)."/".substr($data,5,2)."/".substr($data,0,4); 
			  }
			  ?>" maxlength="10"/>
             
           </td>
    </tr>
<tr>
 <td colspan="4" align="center" ><img src="<?php echo $dados_previsto["arquivo"];?>" width="700" />
</td>
 </tr>
<tr>
	<td colspan="2" align="center" bgcolor="#6C6C6C"><font color="#FFFFFF"><b>Atividades Extras</b></font></td>
    <td colspan="2" align="center" bgcolor="#6C6C6C"><font color="#FFFFFF"><b></b>Observações da Aula</font></td>
</tr>
<tr>
	<td colspan="2" align="center" ><font color="#FFFFFF"><b><textarea name="atividade" onKeyPress="return arrumaEnter(this, event)" style="width:200px; height:100px;"class="textBox" id="atividade" ><?php echo $atev_extra; ?></textarea></b></font></td>
    <td colspan="2" align="center" ><font color="#FFFFFF"><b></b><textarea name="realizado" onKeyPress="return arrumaEnter(this, event)" style="width:200px; height:100px;"class="textBox" id="realizado" ><?php echo $realizado; ?></textarea></font></td>
</tr>

<tr>
	<td colspan="2" align="center" bgcolor="#6C6C6C"><font color="#FFFFFF"><b>Comentários Sobre Material Didático</b></font></td>
    <td colspan="2" align="center" bgcolor="#6C6C6C"><font color="#FFFFFF"><b></b>Comentários Sobre Equipamentos e Estrutura Física</font></td>
</tr>
<tr>
	<td colspan="2" align="center" ><font color="#FFFFFF"><b><textarea name="material" onKeyPress="return arrumaEnter(this, event)" style="width:200px; height:100px;"class="textBox" id="material" ><?php echo $material; ?></textarea></b></font></td>
    <td colspan="2" align="center" ><font color="#FFFFFF"><b></b><textarea name="equipamento" onKeyPress="return arrumaEnter(this, event)" style="width:200px; height:100px;"class="textBox" id="equipamento" ><?php echo $equipamento; ?></textarea></font></td>
</tr>
 
  </table>

  <p align="center">
    <input type="submit" name="Salvar" class="textBox" value="SALVAR" style="cursor:pointer;"/>
  </p>
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

<script>

//--->Função para a formatação dos campos...<---
function Mascara(tipo, campo, teclaPress) {
	if (window.event)
	{
		var tecla = teclaPress.keyCode;
	} else {
		tecla = teclaPress.which;
	}
 
	var s = new String(campo.value);
	// Remove todos os caracteres à seguir: ( ) / - . e espaço, para tratar a string denovo.
	s = s.replace(/(\.|\(|\)|\/|\-| )+/g,'');
 
	tam = s.length + 1;
 
	if ( tecla != 9 && tecla != 8 ) {
		switch (tipo)
		{
		case 'CPF' :
			if (tam > 3 && tam < 7)
				campo.value = s.substr(0,3) + '.' + s.substr(3, tam);
			if (tam >= 7 && tam < 10)
				campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,tam-6);
			if (tam >= 10 && tam < 12)
				campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,3) + '-' + s.substr(9,tam-9);
		break;
 
		case 'CNPJ' :
 
			if (tam > 2 && tam < 6)
				campo.value = s.substr(0,2) + '.' + s.substr(2, tam);
			if (tam >= 6 && tam < 9)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,tam-5);
			if (tam >= 9 && tam < 13)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,tam-8);
			if (tam >= 13 && tam < 15)
				campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,4)+ '-' + s.substr(12,tam-12);
		break;
 
		case 'TEL' :
			if (tam > 2 && tam < 4)
				campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,tam);
			if (tam >= 7 && tam < 11)
				campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,4) + '-' + s.substr(6,tam-6);
		break;
 
		case 'DATA' :
			if (tam > 2 && tam < 4)
				campo.value = s.substr(0,2) + '/' + s.substr(2, tam);
			if (tam > 4 && tam < 11)
				campo.value = s.substr(0,2) + '/' + s.substr(2,2) + '/' + s.substr(4,tam-4);
		break;
		
		case 'CEP' :
			if (tam > 5 && tam < 7)
				campo.value = s.substr(0,5) + '-' + s.substr(5, tam);
		break;
		}
	}
}

//--->Função para verificar se o valor digitado é número...<---
function digitos(event){
	if (window.event) {
		// IE
		key = event.keyCode;
	} else if ( event.which ) {
		// netscape
		key = event.which;
	}
	if ( key != 8 || key != 13 || key < 48 || key > 57 )
		return ( ( ( key > 47 ) && ( key < 58 ) ) || ( key == 8 ) || ( key == 13 ) );
	return true;
}
</script>
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
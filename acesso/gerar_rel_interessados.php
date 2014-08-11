<?php
include ('menu/menu.php');// inclui o menu
//GET DADOS DO FORMULARIO
$get_curso = $_GET["curso"];
$get_nivel = $_GET["nivel"];
$get_unidade = $_GET["unidade"];
$get_layout = $_GET["modelo"];
$get_modalidade = $_GET["modalidade"];
$get_inicio = $_GET["data_inicio"];
$get_fim = $_GET["data_fim"];
$get_confirmado = $_GET["confirmado"];

if(strstr($get_inicio, '/')==TRUE){
	$get_inicio = substr($get_inicio,6,4)."-".substr($get_inicio,3,2)."-".substr($get_inicio,0,2);
} else {
	$get_inicio = $get_inicio;
}

if(strstr($get_fim, '/')==TRUE){
	$get_fim = substr($get_fim,6,4)."-".substr($get_fim,3,2)."-".substr($get_fim,0,2);
} else {
	$get_fim = $get_fim;
}


if(trim($get_inicio)=="" || trim($get_fim)==""){
	echo "<script language=\"javascript\">
	alert('VOC&Ecirc; DEVE ESCOLHER UM PER&Iacute;ODO');
	history.back();
	</script>";
}
if($get_modalidade == 1){
	$modalidade = "PRESENCIAL";
}
if($get_modalidade == 2){
	$modalidade = "EAD";
}
if($get_modalidade == ""){
	$modalidade = "GERAL";
}

//começa a fazer os filtros
if($get_inicio == ""){
	$filtro_data = "WHERE ";
} else {
	$filtro_data = "WHERE (data_matricula BETWEEN '$get_inicio' AND '$get_fim') ";
}

if($get_curso == ""){
	$filtro_curso = "";
} else {
	$filtro_curso = "AND nome_curso LIKE '%$get_curso%' ";
}

if($get_nivel == ""){
	$filtro_nivel = "";
} else {
	$filtro_nivel = "AND curso_nivel LIKE '%$get_nivel%' ";
}

if($get_modalidade == ""){
	$filtro_modalidade = "";
} else {
	$filtro_modalidade = "AND modalidade LIKE '%$get_modalidade%' ";
}

if($get_unidade == ""){
	$filtro_unidade = "";
} else {
	$filtro_unidade = "AND unidade LIKE '%$get_unidade%' ";
}


if($get_confirmado == "N"){
	$filtro_pagos = "AND cpf NOT IN (select cpf FROM alunos) ";
} else {
	$filtro_pagos = "";
}


//GERA O WHERE DO FILTRO COMPLETO
$filtro_completo = $filtro_data.$filtro_curso.$filtro_nivel.$filtro_modalidade.$filtro_unidade.$filtro_pagos;
//PEGA DADOS DO FILTRO
$sql_filtro = mysql_query("SELECT * FROM ced_filtro WHERE id_filtro = $get_layout");
$dados_filtro = mysql_fetch_array($sql_filtro);
$filtro_tabela = $dados_filtro["tabela"];
$filtro_campos = $dados_filtro["campos"];
$filtro_cabecalho = $dados_filtro["cabecalho"];
$filtro_nome = $dados_filtro["layout"];
$filtro_ordem = $dados_filtro["ordem"];

//MONTA O FILTRO
$sql_query = "SELECT $filtro_campos FROM $filtro_tabela $filtro_completo $filtro_ordem";
$sql_relatorio = mysql_query($sql_query);
$total_resultados = mysql_num_rows($sql_relatorio);
$total_span=mysql_num_fields($sql_relatorio);


?>
<div class="conteudo_ficha">
<div class="filtro"><center><a href="rel_interessados.php">[NOVA CONSULTA]</a> | <a href="javascript:window.print();">[IMPRIMIR]</a></center></div>
<table class="full_table_list" width="100%" border="1">
<tr>
    <td valign="middle" align="center"><img src="images/logo-color.png"/></font></td>
    <td colspan="<?php echo $total_span-1;?>"><b><?php echo $get_nivel."</b>: ".$get_curso;?></b> <br />
        <b>Unidade:</b> <?php echo $get_unidade." / ".$get_polo; ?><br />
         <b>Modalidade:</b> <?php echo $modalidade ?><br />
    </td>
    </tr>
<tr> 
<td align="center" colspan="<?php echo $total_span;?>"><b style="font-size:14px"> <?php echo $filtro_nome;?><br />Esse relatóriio possui apenas inscrições não confirmadas.</b>
</td></tr>
<?php //campo de texto livre
if($get_digitacao == 1){
	echo "<tr>
	<td align=\"center\" colspan=\"$total_span\"><textarea style=\"width:90%;line-height:20px;\" ></textarea></td>
	</tr>";
}
?>

<tr>
<?php //colunas

$i = 0;
while ($i < mysql_num_fields($sql_relatorio)){
	 $meta = mysql_fetch_field($sql_relatorio, $i);
	 
	 echo 
	 "<td align=\"center\" bgcolor=\"#C0C0C0\"><b>".$meta->name."</b></td>";
	 $i++;

}
?>
</tr>

<?php //dados das linhas

$sql_relatorio2 = mysql_query($sql_query);
while($dados_relatorio = mysql_fetch_array($sql_relatorio2)){
	echo "<tr>";
	$i2 =0;
	while ($i2 < mysql_num_fields($sql_relatorio2)){
	 $meta2 = mysql_fetch_field($sql_relatorio2, $i2);
	 //configurações do campo
	 $campo_width="auto";
	 $campo_align="";
	 $campo_funcao="not";
	 $sql_campo=mysql_query(("SELECT * FROM config_campos WHERE campo LIKE '%".$meta2->name."%'"));
	 if(mysql_num_rows($sql_campo)==1){
	 	$dados_campo = mysql_fetch_array($sql_campo);
	 	$campo_width = $dados_campo["width"];
		$campo_align= $dados_campo["align"];
		$campo_funcao= $dados_campo["funcao"];
	 }
	 
	 echo 
	 "<td width=\"$campo_width\" align=\"$campo_align\">".$campo_funcao($dados_relatorio[$meta2->name])."</td>";
	 $i2++;
	}
	echo "</tr>";
}
?>
<tr>
<td colspan="<?php echo $total_span;?>"><?php echo $total_resultados;?> alunos encontrados.</td>
</tr>
</table>
</div>
<?php
include ('menu/footer.php');?>
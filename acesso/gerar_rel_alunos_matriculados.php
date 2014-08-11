<?php
include ('menu/menu.php');// inclui o menu
//GET DADOS DO FORMULARIO
$get_nivel = $_GET["nivel"];
$get_curso = $_GET["curso"];
$get_modulo = $_GET["modulo"];
$get_grupo = $_GET["grupo"];
$get_turno = $_GET["turno"];
$get_unidade = $_GET["unidade"];
$get_polo = $_GET["polo"];
$get_layout = $_GET["modelo"];
$get_digitacao = $_GET["digitacao"];
$get_desistentes = $_GET["desistentes"];

if(trim($get_grupo=="")){
	echo "<script language=\"javascript\">
	alert('VOC&Ecirc; DEVE SELECIONAR O GRUPO');
	history.back();
	</script>";
}

//come�a a fazer os filtros
if($get_grupo == ""){
	$filtro_grupo = "WHERE ";
} else {
	$filtro_grupo = "WHERE grupo LIKE '$get_grupo' ";
}

if($get_modulo == ""){
	$filtro_modulo = " ";
} else {
	$filtro_modulo = "AND modulo = $get_modulo ";
}

if($get_nivel == ""){
	$filtro_nivel = " ";
} else {
	$filtro_nivel = "AND nivel LIKE '%$get_nivel%' ";
}

if($get_curso == ""){
	$filtro_curso = " ";
} else {
	$filtro_curso = "AND curso LIKE '%$get_curso%' ";
}

if($get_turno == ""){
	$filtro_turno = " ";
} else {
	$filtro_turno = "AND turno LIKE '%$get_turno%' ";
}

if($get_unidade == ""){
	if($user_unidade == ""){
		$filtro_unidade = "";
	} else {
		$filtro_unidade = " AND unidade LIKE '%$user_unidade%' ";
	}
} else {
	$filtro_unidade = "AND unidade LIKE '%$get_unidade%' ";
}

if($get_polo == ""){
	$filtro_polo = " ";
} else {
	$filtro_polo = "AND polo LIKE '%$get_polo%' ";
}

if($get_desistentes == "S"){
	$filtro_desistentes = " ";
} else {
	$filtro_desistentes = "AND codigo NOT IN (SELECT matricula FROM ocorrencias WHERE n_ocorrencia = 1 OR n_ocorrencia = 2) ";
}

//GERA O WHERE DO FILTRO COMPLETO
$filtro_completo = $filtro_grupo.$filtro_modulo.$filtro_nivel.$filtro_curso.$filtro_turno.$filtro_unidade.$filtro_polo.$filtro_desistentes;
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
<div class="filtro"><center><a href="rel_alunos_matriculados.php">[NOVA CONSULTA]</a> | <a href="javascript:window.print();">[IMPRIMIR]</a></center></div>
<table class="full_table_list" style="font-size:10px; line-height:20px;" width="100%" border="1">
<tr>
    <td valign="middle" align="center"><img src="images/logo-color.png"/></font></td>
    <td colspan="<?php echo $total_span-1;?>"><b><?php echo $get_nivel."</b>: ".$get_curso;?></b> <br />
    	<b>Ano / M&oacute;dulo: </b><?php echo $get_modulo; ?>&ordm;<br />
    	<b>Turno:</b> <?php echo $get_turno; ?><br />
        <b>Grupo:</b> <?php echo $get_grupo; ?><br />
        <b>Unidade:</b> <?php echo $get_unidade." / ".$get_polo; ?><br />
    </td>
    </tr>
<tr> 
<td align="center" colspan="<?php echo $total_span;?>"><b style="font-size:14px"> <?php echo $filtro_nome;?></b>
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
	 //configura��es do campo
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
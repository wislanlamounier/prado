<?php
include ('menu/menu.php');// inclui o menu

if($user_unidade == ""){
	$select_where = "";
} else {
	$select_where = " WHERE t1.unidade LIKE '%$user_unidade%'";
}

//GERA O WHERE DO FILTRO COMPLETO
$filtro_completo = $select_where;
//PEGA DADOS DO FILTRO
$sql_filtro = mysql_query("SELECT * FROM ced_filtro WHERE id_filtro = 9");
$dados_filtro = mysql_fetch_array($sql_filtro);
$filtro_tabela = $dados_filtro["tabela"];
$filtro_campos = $dados_filtro["campos"];
$filtro_cabecalho = $dados_filtro["cabecalho"];
$filtro_nome = $dados_filtro["layout"];
$filtro_ordem = $dados_filtro["ordem"];

//MONTA O FILTRO  
$final_query  = "FROM $filtro_tabela $filtro_completo $filtro_ordem";


// Declara��o da pagina inicial  
$pagina = $_GET["pagina"];  
if($pagina == "") {  
    $pagina = "1";  
} 
$orderby = $_GET["orderby"];  
if($orderby == "") {  
    $orderby = "";  
} else {
	$orderby = " ORDER BY $orderby";
}

// Maximo de registros por pagina  
$maximo = 200;

// Calculando o registro inicial  
$inicio = $pagina - 1;  
$inicio = $maximo * $inicio;

$sql_query = "SELECT $filtro_campos FROM $filtro_tabela $filtro_completo $orderby LIMIT $inicio,$maximo";
$sql_relatorio = mysql_query($sql_query);

$sql_query_max = "SELECT $filtro_campos FROM $filtro_tabela $filtro_completo $orderby";
$sql_relatorio_max = mysql_query($sql_query_max);

$total_resultados = mysql_num_rows($sql_relatorio);
$max_resultados = mysql_num_rows($sql_relatorio_max);
$total_span=mysql_num_fields($sql_relatorio);

// Conta os resultados no total da minha query  
$strCount = "SELECT COUNT(*) AS 'num_registros' $final_query";  
$query    = mysql_query($strCount);  
$row      = mysql_fetch_array($query);  
$total    = $row["num_registros"];  

if($total<=0) {  
    echo "<center>Nenhum registro encontrado.</center>";  
} else {  

// Calculando pagina anterior  
    $menos = $pagina - 1;  

// Calculando pagina posterior  
    $mais = $pagina + 1;


?>
<div class="conteudo_ficha">
<div class="filtro"><center><a href="javascript:window.print();">[IMPRIMIR]</a></center></div>
<table class="full_table_list" style="font-size:10px; line-height:20px;" width="100%" border="1">
<tr>
    <td valign="middle" align="center"><img src="images/logo-color.png"/></font></td>

<td align="center" valign="middle" colspan="<?php echo $total_span - 1;?>"><b style="font-size:14px"> <?php echo $filtro_nome;?></b>
</td></tr>


<tr>
<?php //colunas

$i = 0;
while ($i < mysql_num_fields($sql_relatorio)){
	 $meta = mysql_fetch_field($sql_relatorio, $i);
	 $exib_topo_coluna = str_replace("_"," ", $meta->name);
	 
	 echo 
	 "<td align=\"center\" bgcolor=\"#C0C0C0\"><b><a href=\"?orderby=".$meta->name."\">".$exib_topo_coluna."</a></b></td>";
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
<td colspan="<?php echo $total_span;?>"><?php echo $total_resultados;?> resultados na pagina.<br />
<?php echo $max_resultados;?> resultados encontrados.
</td>

</tr>
</table>
<?php
$pgs = ceil($total / $maximo);  
    if($pgs > 1 ) {  
        // Mostragem de pagina  
        if($menos > 0) {  
           echo "<a href=\"?pagina=$menos&\" class='texto_paginacao'>anterior</a> ";  
        }  
        // Listando as paginas  
        for($i=1;$i <= $pgs;$i++) {  
            if($i != $pagina) {  
               echo "  <a href=\"?pagina=".($i)."\" class='texto_paginacao'>$i</a>";  
            } else {  
                echo "  <strong lass='texto_paginacao_pgatual'>".$i."</strong>";  
            }  
        }  
        if($mais <= $pgs) {  
           echo "   <a href=\"?pagina=$mais\" class='texto_paginacao'>pr�xima</a>";  
        }  
    }  
}  
?>
</div>
<?php
include ('menu/footer.php');?>